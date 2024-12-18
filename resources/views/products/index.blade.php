<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Каталог') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach ($products as $product)
                                <div class="mb-4 ">
                                    <div class="card shadow-lg rounded-lg overflow-hidden p-6">
                                        <a href="{{ route('products.show', $product->id) }}" class="">
                                            @if ($product->main_image)
                                                <img src="{{ asset($product->main_image) }}" class="card-img-top"
                                                    alt="{{ $product->name }}"
                                                    style="height: 200px; object-fit: cover;">
                                            @endif

                                            <h5 class="card-title text-lg font-semibold text-gray-800 mb-2">
                                                {{ $product->name }}</h5>
                                            <p class="card-text text-gray-700 mb-2">
                                                <strong>Цена:</strong> <span
                                                    class="text-green-600">{{ number_format($product->price, 2, ',', ' ') }}
                                                    р.</span>
                                            </p>
                                            <p class="card-text text-gray-600 mb-3">
                                                <strong>Категория:</strong> {{ $product->category->name }}
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-img-top {
            transition: transform 0.3s ease;
        }

        .card-body {
            background-color: #f9fafb;
        }

        .btn:hover {
            transition: background-color 0.2s ease;
        }

        .btn:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(67, 56, 202, 0.5);
        }
    </style>
</x-app-layout>
