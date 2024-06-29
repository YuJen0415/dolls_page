@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach($posts as $post)
                <div class="card mb-4">
                    <div class="card-header">
                        {{ $post->user->name }}
                    </div>
                    <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="貼文圖片">
                    <div class="card-body">
                        <div class="mb-2">
                            <button class="btn btn-sm btn-outline-primary reaction-btn" data-post-id="{{ $post->id }}" data-type="like">👍</button>
                            <button class="btn btn-sm btn-outline-danger reaction-btn" data-post-id="{{ $post->id }}" data-type="love">❤️</button>
                            <button class="btn btn-sm btn-outline-warning reaction-btn" data-post-id="{{ $post->id }}" data-type="haha">😂</button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="toggleComments({{ $post->id }})">💬</button>
                        </div>
                        <p><span id="reaction-count-{{ $post->id }}">{{ $post->reactions->count() }}</span> 人對此貼文有反應</p>
                        <p class="card-text">{{ $post->caption }}</p>
                        <div id="comments-{{ $post->id }}" style="display: none;">
                            <div id="comment-list-{{ $post->id }}">
                                @foreach($post->comments as $comment)
                                    <div class="mb-2">
                                        <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                                    </div>
                                @endforeach
                            </div>
                            <form id="comment-form-{{ $post->id }}" class="comment-form" data-post-id="{{ $post->id }}">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="content" class="form-control" placeholder="添加評論...">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">發送</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <p class="card-text"><small class="text-muted">發佈於 {{ $post->created_at->diffForHumans() }}</small></p>
                    </div>
                </div>
            @endforeach

            {{ $posts->links() }}
        </div>
    </div>
</div>

<script>
function toggleComments(postId) {
    $('#comments-' + postId).toggle();
}

$(document).ready(function() {
    $('.reaction-btn').click(function() {
        var postId = $(this).data('post-id');
        var type = $(this).data('type');
        $.ajax({
            url: '/posts/' + postId + '/reactions',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                type: type
            },
            success: function(response) {
                $('#reaction-count-' + postId).text(response.reactionCount);
            }
        });
    });

    $('.comment-form').submit(function(e) {
        e.preventDefault();
        var postId = $(this).data('post-id');
        var content = $(this).find('input[name="content"]').val();
        $.ajax({
            url: '/posts/' + postId + '/comments',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                content: content
            },
            success: function(response) {
                $('#comment-list-' + postId).append('<div class="mb-2"><strong>' + response.userName + ':</strong> ' + response.content + '</div>');
                $('input[name="content"]').val('');
            }
        });
    });
});
</script>
@endsection