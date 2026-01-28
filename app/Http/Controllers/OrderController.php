<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display user's orders.
     */
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show checkout page.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Keranjang Anda kosong!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('orders.checkout', compact('cart', 'total'));
    }

    /**
     * Process checkout and create order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prescription_image' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Keranjang Anda kosong!');
        }

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Handle prescription image upload
            $prescriptionPath = null;
            if ($request->hasFile('prescription_image')) {
                $prescriptionPath = $request->file('prescription_image')->store('prescriptions', 'public');
            }

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $total,
                'status' => 'pending',
                'prescription_image' => $prescriptionPath,
            ]);

            // Create order items and update stock
            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception('Stok produk ' . $product->name . ' tidak mencukupi!');
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Reduce stock
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');

            return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Display all orders for admin/apoteker.
     */
    public function adminIndex()
    {
        $orders = Order::with('user')->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update order status (admin/apoteker only).
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan diperbarui!');
    }
}
