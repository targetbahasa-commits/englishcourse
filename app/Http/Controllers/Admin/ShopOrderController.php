<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopOrder;
use App\Models\ShopOrderItem;
use App\Models\ShopProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ShopOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = ShopOrder::with('items.product')->latest('order_date');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('customer_name', 'like', '%'.$request->search.'%')
                  ->orWhere('customer_whatsapp', 'like', '%'.$request->search.'%')
                  ->orWhere('platform_order_id', 'like', '%'.$request->search.'%');
            });
        }

        $orders = $query->paginate(15)->withQueryString();
        $statuses = ShopOrder::statuses();
        $platforms = ShopOrder::platforms();

        return view('admin.shop.orders.index', compact('orders', 'statuses', 'platforms'));
    }

    public function create()
    {
        $products = ShopProduct::where('is_active', true)->orderBy('name')->get();
        $platforms = ShopOrder::platforms();

        return view('admin.shop.orders.create', compact('products', 'platforms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_date'        => 'required|date',
            'customer_name'     => 'required|string|max:200',
            'customer_whatsapp' => 'nullable|string|max:20',
            'platform'          => 'required|in:' . implode(',', array_keys(ShopOrder::platforms())),
            'platform_order_id' => 'nullable|string|max:100',
            'status'            => 'required|in:' . implode(',', array_keys(ShopOrder::statuses())),
            'notes'             => 'nullable|string|max:1000',
            'product_ids'       => 'required|array|min:1',
            'product_ids.*'     => 'required|exists:shop_products,id',
            'quantities'        => 'required|array|min:1',
            'quantities.*'      => 'required|integer|min:1',
            'prices'            => 'required|array|min:1',
            'prices.*'          => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Calculate total
            $totalAmount = 0;
            foreach ($request->prices as $i => $price) {
                $qty = $request->quantities[$i] ?? 1;
                $totalAmount += ($price * $qty);
            }

            // Create Order
            $order = ShopOrder::create([
                'order_date'        => $request->order_date,
                'customer_name'     => $request->customer_name,
                'customer_whatsapp' => $request->customer_whatsapp,
                'platform'          => $request->platform,
                'platform_order_id' => $request->platform_order_id,
                'total_amount'      => $totalAmount,
                'status'            => $request->status,
                'notes'             => $request->notes,
            ]);

            // Create Items
            foreach ($request->product_ids as $i => $productId) {
                $qty = $request->quantities[$i] ?? 1;
                $price = $request->prices[$i] ?? 0;

                $order->items()->create([
                    'shop_product_id' => $productId,
                    'quantity'        => $qty,
                    'price_at_order'  => $price,
                ]);
            }

            // Handle completion logic if status is already completed on creation
            if ($order->status === 'completed') {
                $this->processCompletedOrder($order);
            }

            DB::commit();
            return redirect()->route('admin.shop.orders.index')
                ->with('success', 'Pesanan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan pesanan: ' . $e->getMessage());
        }
    }

    public function edit(ShopOrder $order)
    {
        $products = ShopProduct::where('is_active', true)->orderBy('name')->get();
        $platforms = ShopOrder::platforms();
        $statuses = ShopOrder::statuses();
        $order->load('items.product');

        return view('admin.shop.orders.edit', compact('order', 'products', 'platforms', 'statuses'));
    }

    public function update(Request $request, ShopOrder $order)
    {
        $request->validate([
            'order_date'        => 'required|date',
            'customer_name'     => 'required|string|max:200',
            'customer_whatsapp' => 'nullable|string|max:20',
            'platform'          => 'required|in:' . implode(',', array_keys(ShopOrder::platforms())),
            'platform_order_id' => 'nullable|string|max:100',
            'status'            => 'required|in:' . implode(',', array_keys(ShopOrder::statuses())),
            'notes'             => 'nullable|string|max:1000',
            'product_ids'       => 'required|array|min:1',
            'product_ids.*'     => 'required|exists:shop_products,id',
            'quantities'        => 'required|array|min:1',
            'quantities.*'      => 'required|integer|min:1',
            'prices'            => 'required|array|min:1',
            'prices.*'          => 'required|numeric|min:0',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        DB::beginTransaction();
        try {
            // Calculate total
            $totalAmount = 0;
            foreach ($request->prices as $i => $price) {
                $qty = $request->quantities[$i] ?? 1;
                $totalAmount += ($price * $qty);
            }

            $order->update([
                'order_date'        => $request->order_date,
                'customer_name'     => $request->customer_name,
                'customer_whatsapp' => $request->customer_whatsapp,
                'platform'          => $request->platform,
                'platform_order_id' => $request->platform_order_id,
                'total_amount'      => $totalAmount,
                'status'            => $newStatus,
                'notes'             => $request->notes,
            ]);

            // Re-sync items (Delete old, insert new)
            $order->items()->delete();
            foreach ($request->product_ids as $i => $productId) {
                $qty = $request->quantities[$i] ?? 1;
                $price = $request->prices[$i] ?? 0;

                $order->items()->create([
                    'shop_product_id' => $productId,
                    'quantity'        => $qty,
                    'price_at_order'  => $price,
                ]);
            }

            // Handle transition to completed
            if ($oldStatus !== 'completed' && $newStatus === 'completed') {
                $this->processCompletedOrder($order);
            }

            DB::commit();
            return redirect()->route('admin.shop.orders.index')
                ->with('success', 'Pesanan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui pesanan: ' . $e->getMessage());
        }
    }

    public function destroy(ShopOrder $order)
    {
        $order->delete();
        return back()->with('success', 'Pesanan berhasil dihapus.');
    }

    // ── Helper Logic ─────────────────────────────────────────

    private function processCompletedOrder(ShopOrder $order)
    {
        // 1. Reduce stock & increment sold count
        $hasDigital = false;
        $programIds = [];

        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product) {
                $product->increment('sold_count', $item->quantity);
                if (!is_null($product->stock)) {
                    $product->decrement('stock', $item->quantity);
                }

                if ($product->is_digital) {
                    $hasDigital = true;
                    if ($product->program_id) {
                        $programIds[] = $product->program_id;
                    }
                }
            }
        }

        // 2. Auto-create user if it has digital product (class/video) and no user linked
        if ($hasDigital && !$order->user_id) {
            // Find existing user by WA or email
            $phone = preg_replace('/[^0-9]/', '', $order->customer_whatsapp);
            $email = $phone ? "wa{$phone}@student.targetbahasa.com" : "user" . uniqid() . "@targetbahasa.com";

            if ($phone) {
                $user = User::where('phone_number', $phone)->orWhere('phone_number', '+'.$phone)->first();
            } else {
                $user = null;
            }

            if (!$user) {
                // Generate random referral code
                $newReferralCode = strtoupper(Str::random(6));
                while (User::where('referral_code', $newReferralCode)->exists()) {
                    $newReferralCode = strtoupper(Str::random(6));
                }

                $user = User::create([
                    'name'            => $order->customer_name,
                    'email'           => $email,
                    'phone_number'    => $phone ?? null,
                    'password'        => Hash::make('password123'), // Default password
                    'role'            => 'student',
                    'status'          => 'active',
                    'program_id'      => $programIds[0] ?? null, // Link to first program found
                    'referral_code'   => $newReferralCode,
                    'bio'             => "Dibuat otomatis dari Pesanan E-Commerce: " . $order->platform_order_id,
                ]);
            }

            $order->update(['user_id' => $user->id]);
        }
    }
}
