<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeCountProductRequest;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\OrderCreateRequest;
use App\Models\Order;
use App\Models\Product;
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
        if (isset($data['product_ids'])) {

            $data['created_date'] = now();
            $productIds = $data['product_ids'];
            unset($data['product_ids']);

            $order = Order::query()->create($data);
            foreach ($productIds as $id) {
                $order->orderItems()->create([
                    'product_id' => $id,
                ]);
            }
            return redirect()->route('orders.show', compact('order'))->with('success','Заказ создан!');
        }
        return redirect()->route('orders.index')->with('error','Ошибка создания заказа!');
    }

    public function show(Order $order): View
    {
        $products = $order->getProducts();
        return view('order.show', compact('order', 'products'));
    }


    public function destroy(Order $order): RedirectResponse
    {
        if($order->delete()){
            return redirect()->route('orders.index')->with('success','Заказ удалён!');
        }
        return redirect()->route('orders.index')->with('error','Ошибка удаления заказа!');
    }

    public function changeStatus(ChangeStatusRequest $request, Order $order): RedirectResponse
    {
        $data = $request->validated();
        $order->status = $data['status'];
        if($order->save()){
            return redirect()->route('orders.show',compact('order'))->with('success','Статус заказа изменен!');
        }
        return redirect()->route('orders.show',compact('order'))->with('error','Не удалось изменить статус заказа!');
    }
}
