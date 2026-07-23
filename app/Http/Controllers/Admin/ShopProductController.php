<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ShopProductController extends Controller
{
    public function index(Request $request)
    {
        $query = ShopProduct::with('program')->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(15)->withQueryString();
        $types    = ShopProduct::types();

        return view('admin.shop.products.index', compact('products', 'types'));
    }

    public function create()
    {
        $types    = ShopProduct::types();
        $programs = Program::where('is_active', true)->orderBy('name')->get();

        return view('admin.shop.products.create', compact('types', 'programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:200',
            'type'              => 'required|in:' . implode(',', array_keys(ShopProduct::types())),
            'description'       => 'nullable|string|max:5000',
            'price'             => 'required|integer|min:0',
            'price_discounted'  => 'nullable|integer|min:0|lt:price',
            'stock'             => 'nullable|integer|min:0',
            'is_active'         => 'boolean',
            'program_id'        => 'nullable|exists:programs,id',
            'file_url'          => 'nullable|url|max:500',
            'weight_gram'       => 'nullable|integer|min:0',
            'cover_image'       => 'nullable|image|max:2048',
            'platform_shopee'   => 'nullable|url|max:500',
            'platform_tokopedia'=> 'nullable|url|max:500',
            'platform_tiktok'   => 'nullable|url|max:500',
            'platform_whatsapp' => 'nullable|max:500',
            'platform_instagram'=> 'nullable|url|max:500',
        ]);

        // Build platform links JSON
        $platformLinks = array_filter([
            'shopee'    => $request->platform_shopee,
            'tokopedia' => $request->platform_tokopedia,
            'tiktok'    => $request->platform_tiktok,
            'whatsapp'  => $request->platform_whatsapp,
            'instagram' => $request->platform_instagram,
        ]);

        // Handle cover image upload
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('shop/products', 'public');
        }

        ShopProduct::create([
            'name'             => $validated['name'],
            'type'             => $validated['type'],
            'description'      => $validated['description'] ?? null,
            'price'            => $validated['price'],
            'price_discounted' => $validated['price_discounted'] ?? null,
            'stock'            => $request->boolean('unlimited_stock') ? null : ($validated['stock'] ?? null),
            'is_active'        => $request->boolean('is_active', true),
            'program_id'       => $validated['program_id'] ?? null,
            'file_url'         => $validated['file_url'] ?? null,
            'weight_gram'      => $validated['weight_gram'] ?? null,
            'cover_image'      => $coverPath,
            'platform_links'   => empty($platformLinks) ? null : $platformLinks,
        ]);

        return redirect()->route('admin.shop.products.index')
            ->with('success', 'Produk "' . $validated['name'] . '" berhasil ditambahkan!');
    }

    public function edit(ShopProduct $product)
    {
        $types    = ShopProduct::types();
        $programs = Program::where('is_active', true)->orderBy('name')->get();

        return view('admin.shop.products.edit', compact('product', 'types', 'programs'));
    }

    public function update(Request $request, ShopProduct $product)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:200',
            'type'              => 'required|in:' . implode(',', array_keys(ShopProduct::types())),
            'description'       => 'nullable|string|max:5000',
            'price'             => 'required|integer|min:0',
            'price_discounted'  => 'nullable|integer|min:0',
            'stock'             => 'nullable|integer|min:0',
            'is_active'         => 'boolean',
            'program_id'        => 'nullable|exists:programs,id',
            'file_url'          => 'nullable|url|max:500',
            'weight_gram'       => 'nullable|integer|min:0',
            'cover_image'       => 'nullable|image|max:2048',
            'platform_shopee'   => 'nullable|url|max:500',
            'platform_tokopedia'=> 'nullable|url|max:500',
            'platform_tiktok'   => 'nullable|url|max:500',
            'platform_whatsapp' => 'nullable|max:500',
            'platform_instagram'=> 'nullable|url|max:500',
        ]);

        $platformLinks = array_filter([
            'shopee'    => $request->platform_shopee,
            'tokopedia' => $request->platform_tokopedia,
            'tiktok'    => $request->platform_tiktok,
            'whatsapp'  => $request->platform_whatsapp,
            'instagram' => $request->platform_instagram,
        ]);

        $coverPath = $product->cover_image;
        if ($request->hasFile('cover_image')) {
            // Delete old cover
            if ($coverPath) Storage::disk('public')->delete($coverPath);
            $coverPath = $request->file('cover_image')->store('shop/products', 'public');
        }

        $product->update([
            'name'             => $validated['name'],
            'type'             => $validated['type'],
            'description'      => $validated['description'] ?? null,
            'price'            => $validated['price'],
            'price_discounted' => $validated['price_discounted'] ?? null,
            'stock'            => $request->boolean('unlimited_stock') ? null : ($validated['stock'] ?? null),
            'is_active'        => $request->boolean('is_active', true),
            'program_id'       => $validated['program_id'] ?? null,
            'file_url'         => $validated['file_url'] ?? null,
            'weight_gram'      => $validated['weight_gram'] ?? null,
            'cover_image'      => $coverPath,
            'platform_links'   => empty($platformLinks) ? null : $platformLinks,
        ]);

        return redirect()->route('admin.shop.products.index')
            ->with('success', 'Produk "' . $product->name . '" berhasil diperbarui!');
    }

    public function toggleActive(ShopProduct $product)
    {
        $product->update(['is_active' => ! $product->is_active]);

        $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', 'Produk "' . $product->name . '" berhasil ' . $status . '.');
    }

    public function destroy(ShopProduct $product)
    {
        if ($product->cover_image) {
            Storage::disk('public')->delete($product->cover_image);
        }

        $name = $product->name;
        $product->delete();

        return redirect()->route('admin.shop.products.index')
            ->with('success', 'Produk "' . $name . '" berhasil dihapus.');
    }
}
