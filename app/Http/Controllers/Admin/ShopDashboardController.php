<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopOrder;
use App\Models\ShopOrderItem;
use App\Models\ShopProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopDashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Determine Date Range
        $filter = $request->input('filter', 'this_month');
        $startDate = null;
        $endDate = Carbon::now()->endOfDay();

        if ($filter === 'custom') {
            $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::now()->startOfMonth();
            $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfDay();
        } else {
            switch ($filter) {
                case 'today':
                    $startDate = Carbon::now()->startOfDay();
                    break;
                case 'last_7_days':
                    $startDate = Carbon::now()->subDays(6)->startOfDay();
                    break;
                case 'this_month':
                    $startDate = Carbon::now()->startOfMonth();
                    break;
                case 'this_year':
                    $startDate = Carbon::now()->startOfYear();
                    break;
                case 'all_time':
                default:
                    $startDate = Carbon::create(2020, 1, 1)->startOfDay(); // Far past
                    $filter = 'all_time';
                    break;
            }
        }

        // 2. Base Query (Filtered by Date & Status)
        // Count 'paid' and 'completed' and 'shipped' as valid revenue
        $validStatuses = ['paid', 'shipped', 'completed'];
        
        $baseQuery = ShopOrder::whereBetween('order_date', [$startDate, $endDate])
                              ->whereIn('status', $validStatuses);

        // 3. Key Metrics
        $totalRevenue = (clone $baseQuery)->sum('total_amount');
        $totalOrders = (clone $baseQuery)->count();
        
        // Total Items Sold requires joining
        $totalItemsSold = ShopOrderItem::whereHas('order', function($q) use ($startDate, $endDate, $validStatuses) {
            $q->whereBetween('order_date', [$startDate, $endDate])
              ->whereIn('status', $validStatuses);
        })->sum('quantity');

        // 4. Sales by Platform
        $platformData = (clone $baseQuery)
            ->select('platform', DB::raw('SUM(total_amount) as revenue'), DB::raw('COUNT(id) as total_orders'))
            ->groupBy('platform')
            ->get();
            
        $platformLabels = [];
        $platformRevenues = [];
        $platformColors = [
            'shopee'    => '#EE4D2D',
            'tiktok'    => '#000000',
            'tokopedia' => '#41B549',
            'whatsapp'  => '#25D366',
            'instagram' => '#E1306C',
            'other'     => '#6B7280'
        ];
        $bgColors = [];

        foreach ($platformData as $data) {
            $label = ShopOrder::platforms()[$data->platform] ?? $data->platform;
            $platformLabels[] = $label;
            $platformRevenues[] = $data->revenue;
            $bgColors[] = $platformColors[$data->platform] ?? '#6B7280';
        }

        // 5. Daily Trend (Chart)
        $trendData = (clone $baseQuery)
            ->select(DB::raw('DATE(order_date) as date'), DB::raw('SUM(total_amount) as revenue'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $trendLabels = [];
        $trendRevenues = [];
        
        // Fill missing days if range is small enough (e.g. <= 31 days)
        $daysDiff = $startDate->diffInDays($endDate);
        if ($filter !== 'all_time' && $daysDiff <= 31) {
            for ($i = 0; $i <= $daysDiff; $i++) {
                $dateString = (clone $startDate)->addDays($i)->format('Y-m-d');
                $trendLabels[] = (clone $startDate)->addDays($i)->format('d M');
                
                $found = $trendData->firstWhere('date', $dateString);
                $trendRevenues[] = $found ? $found->revenue : 0;
            }
        } else {
            // For longer ranges, just group by month or just show raw points
            foreach ($trendData as $data) {
                $trendLabels[] = Carbon::parse($data->date)->format('d M Y');
                $trendRevenues[] = $data->revenue;
            }
        }

        // 6. Top Products
        $topProducts = ShopProduct::withSum(['items as total_qty' => function($q) use ($startDate, $endDate, $validStatuses) {
            $q->whereHas('order', function($q2) use ($startDate, $endDate, $validStatuses) {
                $q2->whereBetween('order_date', [$startDate, $endDate])
                   ->whereIn('status', $validStatuses);
            });
        }], 'quantity')
        ->withSum(['items as total_revenue' => function($q) use ($startDate, $endDate, $validStatuses) {
            $q->whereHas('order', function($q2) use ($startDate, $endDate, $validStatuses) {
                $q2->whereBetween('order_date', [$startDate, $endDate])
                   ->whereIn('status', $validStatuses);
            });
        }], DB::raw('quantity * price_at_order'))
        ->orderByDesc('total_qty')
        ->take(5)
        ->get();

        // 7. Recent Orders (All statuses to give a general view)
        $recentOrders = ShopOrder::with('items')
            ->latest('order_date')
            ->take(5)
            ->get();

        return view('admin.shop.dashboard', compact(
            'filter', 'startDate', 'endDate',
            'totalRevenue', 'totalOrders', 'totalItemsSold',
            'platformLabels', 'platformRevenues', 'bgColors',
            'trendLabels', 'trendRevenues',
            'topProducts', 'recentOrders'
        ));
    }
}
