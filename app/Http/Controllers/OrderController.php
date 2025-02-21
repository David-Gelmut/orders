<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\OrderCreateRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()->paginate(10);
        return view('order.index', compact('orders'));
    }

    public function create(): View
    {
        return view('order.create');
    }

    public function store(OrderCreateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['product_ids']) && isset($data['product_count'])) {

            $data['created_date'] = now();
            $productIds = $data['product_ids'];
            $productCount = $data['product_count'];
            unset($data['product_ids'], $data['product_count']);

            $order = Order::query()->create($data);
            foreach ($productIds as $id) {
                $order->orderItems()->create([
                    'product_id' => $id,
                    'product_count' => $productCount
                ]);
            }
        }
        return redirect()->route('orders.index');
    }

    public function show(Order $order): View
    {
        $products = $order->getProducts();
        return view('order.show', compact('order', 'products'));
    }



    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
        return redirect()->route('orders.index');
    }

    public function changeStatus(ChangeStatusRequest $request, Order $order): RedirectResponse
    {
        $data = $request->validated();
        $order->status = $data['status'];
        $order->save();
        return redirect()->route('orders.index');
    }
}
