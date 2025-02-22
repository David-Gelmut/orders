@extends('layouts.app')
@section('title','Обновить продукт '.$product->title)
@section('content')
    <form action="{{route('products.update',compact('product'))}}" method="post" class="max-w-sm mx-auto">
        @csrf
        @method('patch')
        <div class="mb-5">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Название</label>
            <input value="{{$product->title}}" name="title" type="text" id="title"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('title') border-red-500 @enderror"
                   placeholder="Product"/>
            @error('title')<div class="text-red-900">{{ $message }}</div>@enderror
        </div>
        <div class="mb-5">
            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Цена</label>
            <input value="{{$product->price}}" name="price" type="text" id="price"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('price') border-red-500 @enderror"
                   placeholder="1000.45"/>
            @error('price')<div class="text-red-900">{{ $message }}</div>@enderror
        </div>
        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Описание</label>
        <textarea name="description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('description') border-red-500 @enderror" placeholder="Write your thoughts here...">{{$product->description}}</textarea>
        @error('description')<div class="text-red-900">{{ $message }}</div>@enderror
        <div class="mb-5">
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Категория</label>
            <select name="category_id" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @php
                   $categories = \App\Models\Category::query()->get();
                @endphp
                @foreach($categories as $category)
                    <option @if($category->id == $product->category->id) selected @endif value="{{$category->id}}">{{$category->title}}</option>
                @endforeach
            </select>
            @error('category')<div class="text-red-900">{{ $message }}</div>@enderror
        </div>
        <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Обновить
        </button>
    </form>
@endsection
