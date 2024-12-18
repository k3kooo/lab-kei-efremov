<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Детали товара') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">

                        <div class="flex flex-col md:flex-row">
                            <!-- Секция изображений -->
                            <div class="md:w-1/2 p-4">
                                <div class="product-images mb-4">
                                    @if ($product->main_image)
                                        <img src="{{ asset($product->main_image) }}"
                                            class="main-image w-full rounded-lg mb-4 shadow-lg"
                                            alt="{{ $product->name }}" style="max-height: 960px; object-fit: cover;">
                                    @endif

                                    @if ($product->gallery_images)
                                        <div class="gallery flex space-x-2 overflow-x-auto">
                                            @foreach (json_decode($product->gallery_images) as $image)
                                                <img src="{{ asset($image) }}"
                                                    class="gallery-image w-20 h-20 rounded-md cursor-pointer hover:border-2 hover:border-gray-500 transition duration-300 ease-in-out"
                                                    alt="gallery image" style="object-fit: cover;"
                                                    onclick="document.querySelector('.main-image').src='{{ asset($image) }}'">
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Секция информации о товаре -->
                            <div class="md:w-1/2 p-4">
                                <div class="product-info">
                                    <div class="product__category mb-2 text-sm text-gray-600">
                                        <span class="font-semibold">Категория:</span>
                                        @foreach ($product->category->getFullChain() as $index => $categoryName)
                                            {{ $categoryName }}
                                            @if (!$loop->last)
                                                <span class="text-gray-400"> > </span>
                                            @endif
                                        @endforeach
                                    </div>

                                    <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h2>
                                    <p class="text-gray-700 mb-4">{{ $product->description }}</p>
                                    <p class="text-xl font-semibold mb-2">
                                        Цена: <span
                                            class="text-green-600">{{ number_format($product->price, 2, ',', ' ') }}
                                            р.</span>
                                    </p>
                                    <a href="{{ route('products.index') }}"
                                        class="inline-block px-6 py-3 bg-indigo-600 rounded hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 transition duration-200">
                                        Назад к каталогу
                                    </a>
                                </div>
                            </div>
                        </div>


                        <!-- Секция комментариев -->
                        <div class="comments mt-8">
                            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Комментарии</h2>

                            <!-- Форма добавления комментария -->
                            <form action="{{ route('comments.store', $product->id) }}" method="POST" class="mb-4">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="content" class="form-control w-full" rows="3" placeholder="Добавьте комментарий..." required>{{ old('content') }}</textarea>
                                </div>
                                <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200">
                                    Отправить
                                </button>
                            </form>
                            <!-- Список комментариев -->
                            <div class="comments__list">
                                @foreach ($product->comments as $comment)
                                    @if (is_null($comment->parent_id))
                                        <div class="comment mb-4 p-4 border rounded shadow-sm bg-gray-100">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong class="comment__author">{{ $comment->user->name }}</strong>
                                                    <span
                                                        class="comment__date text-sm text-gray-500">({{ $comment->created_at->diffForHumans() }})</span>
                                                </div>
                                            </div>
                                            <p class="comment__content mt-2">{{ $comment->content }}</p>
                                            <!-- Кнопка "Ответить" и форма ответа -->
                                            <button
                                                class="reply-button mt-2 text-indigo-600 hover:text-indigo-800 cursor-pointer"
                                                data-comment-id="{{ $comment->id }}">Ответить</button>
                                            <form action="{{ route('comments.store', $product->id) }}" method="POST"
                                                class="reply-form mt-2" style="display: none;"
                                                data-comment-id="{{ $comment->id }}">
                                                @csrf
                                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                <div class="mb-2">
                                                    <textarea name="content" class="form-control form-control-sm" rows="2" placeholder="Ваш ответ..." required>{{ old('content') }}</textarea>
                                                </div>
                                                <button type="submit"
                                                    class="bg-indigo-600 hover:bg-indigo-700 font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline transition duration-200">
                                                    Отправить
                                                </button>
                                            </form>


                                            <!-- Отображение ответов на комментарий -->
                                            @include('partials.replies', [
                                                'comments' => $comment->replies,
                                                'level' => 1,
                                            ])
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .gallery-image:hover {
            border: 2px solid #4A90E2;
            transform: scale(1.05);
        }

        .gallery {
            gap: 8px;
        }

        .product-images {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .main-image {
            transition: transform 0.3s ease;
        }

        .main-image:hover {
            transform: scale(1.05);
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const replyButtons = document.querySelectorAll('.reply-button');

            replyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    const form = document.querySelector(
                        `.reply-form[data-comment-id="${commentId}"]`);

                    if (form) {
                        form.style.display = form.style.display === 'none' || !form.style.display ?
                            'block' : 'none';
                    }
                });
            });
        });
    </script>
    <style>
        .comment {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 15px;
            margin-bottom: 10px;

        }

        .comment__author {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .comment__date {
            font-size: 0.9em;
            color: #999;
            margin-bottom: 10px;
        }

        .comment__content {
            line-height: 1.6;
        }

        .reply-form {
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 0.25rem;
            background-color: #f8f9fa;
        }


        .reply-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .reply-button {
            cursor: pointer;
        }
    </style>
</x-app-layout>
