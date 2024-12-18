@foreach ($comments as $reply)
    <div class="comment ms-{{ $level * 3 }} mt-3">
        <div class="d-flex align-items-center mb-2">
            <strong class="me-2">{{ $reply->user->name }}</strong>
            <span class="text-muted">({{ $reply->created_at->diffForHumans() }})</span>
        </div>
        <p class="mb-2">{{ $reply->content }}</p>
        <button class="reply-button mt-2 text-indigo-600 hover:text-indigo-800 cursor-pointer"
            data-comment-id="{{ $reply->id }}">Ответить</button>
        <form action="{{ route('comments.store', $reply->product_id) }}" method="POST" class="reply-form mt-2"
            style="display: none;" data-comment-id="{{ $reply->id }}">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $reply->id }}">
            <div class="mb-2">
                <textarea name="content" class="form-control form-control-sm" rows="2" placeholder="Ваш ответ..." required>{{ old('content') }}</textarea>
            </div>
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline transition duration-200">
                Отправить
            </button>
        </form>
        @if ($reply->replies)
            @include('partials.replies', ['comments' => $reply->replies, 'level' => $level + 1])
        @endif
    </div>
@endforeach
