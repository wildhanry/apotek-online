<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard based on user role.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        } elseif ($user->role === 'apoteker') {
            return $this->apotekerDashboard();
        } else {
            return $this->customerDashboard();
        }
    }

    /**
     * Admin dashboard.
     */
    private function adminDashboard()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_price'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'low_stock_products' => Product::where('stock', '<', 10)->count(),
        ];

        $recent_orders = Order::with('user')->latest()->take(5)->get();
        $low_stock_products = Product::where('stock', '<', 10)->get();

        return view('dashboard.admin', compact('stats', 'recent_orders', 'low_stock_products'));
    }

    /**
     * Apoteker dashboard.
     */
    private function apotekerDashboard()
    {
        $stats = [
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'completed_today' => Order::where('status', 'completed')
                ->whereDate('updated_at', today())->count(),
            'low_stock_products' => Product::where('stock', '<', 10)->count(),
        ];

        $pending_orders = Order::with('user')->where('status', 'pending')->latest()->take(10)->get();
        $low_stock_products = Product::where('stock', '<', 10)->get();

        return view('dashboard.apoteker', compact('stats', 'pending_orders', 'low_stock_products'));
    }

    /**
     * Customer dashboard.
     */
    private function customerDashboard()
    {
        $user = auth()->user();

        $stats = [
            'total_orders' => $user->orders()->count(),
            'pending_orders' => $user->orders()->where('status', 'pending')->count(),
            'completed_orders' => $user->orders()->where('status', 'completed')->count(),
        ];

        $recent_orders = $user->orders()->latest()->take(5)->get();

        return view('dashboard.customer', compact('stats', 'recent_orders'));
    }
}
