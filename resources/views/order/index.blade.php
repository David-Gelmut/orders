@extends('layouts.app')
@section('title','Заказы')
@section('content')
<div class="flex flex-col gap-4 items-center">
    <div class="flex flex-row gap-8 ">
        <a href="{{route('orders.create')}}"
           class="mx-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 md:px-5 md:py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Создать
            заказ</a>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg ml-10">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Номера заказа (ID)
                </th>
                <th scope="col" class="px-6 py-3">
                    Дату создания
                </th>
                <th scope="col" class="px-6 py-3">
                    ФИО покупателя
                </th>
                <th scope="col" class="px-6 py-3">
                    Статус заказа
                </th>
                <th scope="col" class="px-6 py-3">
                    Итоговоя цена
                </th>
                <th scope="col" class="px-6 py-3">
                </th>
                <th scope="col" class="px-6 py-3">
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{$order->id}}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{date("Y-m-d",strtotime($order->created_date))}}
                    </th>
                    <td class="px-6 py-4">
                        {{$order->name}}
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statuses = \App\Models\Enums\Status::cases();
                        @endphp
                        @foreach($statuses as $status)
                            <div
                                class="@if($status->value == 'red') text-green-500 @else text-green-500 @endif  ">@if($status->value == $order->status)
                                    {{$status->getStatusName()}}
                                @endif</div>
                        @endforeach
                    </td>
                    <td class="px-6 py-4">
                       {{$order->getTotalOrderPrice()}}
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{route('orders.show',compact('order'))}}"> Перейти к заказу</a>
                    </td>
                    <form action="{{route('orders.destroy',compact('order'))}}" method="post">
                        @method("DELETE")
                        @csrf
                        <td class="px-6 py-4">
                            <button type="submit"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline cursor-pointer">
                               Удалить
                            </button>
                        </td>
                    </form>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="my-4 mx-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
