<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{

    public function index(): View
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'total_brands' => Brand::count(),
            'total_admins' => User::where('role', 'admin')->where('is_active', true)->count(),
            'total_super_admins' => User::where('role', 'super_admin')->count(),
            // Sprint 2 stats (with table existence check)
            'total_suppliers' => Schema::hasTable('suppliers') ? Supplier::count() : 0,
            'active_suppliers' => Schema::hasTable('suppliers') ? Supplier::where('is_active', true)->count() : 0,
            'total_purchase_orders' => Schema::hasTable('purchase_orders') ? PurchaseOrder::count() : 0,
            'draft_pos' => Schema::hasTable('purchase_orders') ? PurchaseOrder::where('status', 'Draft')->count() : 0,
            'approved_pos' => Schema::hasTable('purchase_orders') ? PurchaseOrder::where('status', 'Approved')->count() : 0,
            'sent_pos' => Schema::hasTable('purchase_orders') ? PurchaseOrder::where('status', 'Sent')->count() : 0,
            'received_pos' => Schema::hasTable('purchase_orders') ? PurchaseOrder::where('status', 'Received')->count() : 0,
            'low_stock_products' => Product::where('stock', '<', 10)->where('is_active', true)->count(),
        ];

        $recent_products = Product::with(['brand', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $recent_users = User::where('role', 'admin')
            ->latest()
            ->take(5)
            ->get();

        $recent_purchase_orders = Schema::hasTable('purchase_orders') 
            ? PurchaseOrder::with(['supplier', 'creator'])->latest()->take(5)->get()
            : collect();

        return view('admin.dashboard', compact('stats', 'recent_products', 'recent_users', 'recent_purchase_orders'));
    }
}
