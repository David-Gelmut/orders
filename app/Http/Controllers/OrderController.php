<?php

namespace App\Http\Controllers;

use App\Http\Requests\BindProductRequest;
use App\Http\Requests\ChangeCountProductRequest;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\DeleteBindProductRequest;
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
            $orderItems = $order->orderItems();
            foreach ($productIds as $id) {
                $orderItems->create([
                    'product_id' => $id,
                ]);
            }
            return redirect()->route('orders.show', compact('order'))->with('success', 'Заказ создан!');
        }
        return redirect()->route('orders.index')->with('error', 'Ошибка создания заказа!');
    }

    public function show(Order $order): View
    {
        $products = $order->getProducts();
        return view('order.show', compact('order', 'products'));
    }

    public function destroy(Order $order): RedirectResponse
    {
        if ($order->delete()) {
            return redirect()->route('orders.index')->with('success', 'Заказ удалён!');
        }
        return redirect()->route('orders.index')->with('error', 'Ошибка удаления заказа!');
    }

    public function changeStatus(ChangeStatusRequest $request, Order $order): RedirectResponse
    {
        $data = $request->validated();
        $order->status = $data['status'];
        if ($order->save()) {
            return redirect()->route('orders.show', compact('order'))->with('success', 'Статус заказа изменен!');
        }
        return redirect()->route('orders.show', compact('order'))->with('error', 'Не удалось изменить статус заказа!');
    }

    public function bindProduct(BindProductRequest $request, Order $order): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['product_ids'])) {
            $productIds = $data['product_ids'];
            unset($data['product_ids']);
            $orderItems = $order->orderItems();
            foreach ($productIds as $id) {
                $orderItem = $orderItems->where('product_id', $id)->first();
                if ($orderItem) {
                    return back()->with('error', 'Ошибка привязки товаров!Товар в заказе уже есть!');
                } else {
                    $orderItems->create([
                        'product_id' => $id,
                        'oder_id' => $order->id,
                    ]);
                }
            }
            return back()->with('success', 'Товары привязаны!');
        }
        return back()->with('error', 'Ошибка привязки товаров!');
    }

    public function deleteBindProduct(DeleteBindProductRequest $request, Order $order): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['product_id'])) {
            $productOrderItem = $order->orderItems()->where('product_id', $data['product_id'])->first();;
            if($productOrderItem->delete()){
                return back()->with('success', 'Товар отвязан!');
            }
        }
        return back()->with('error', 'Ошибка отвязки товара!');
    }
}
