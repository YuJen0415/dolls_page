@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">上傳新貼文</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="image">選擇圖片</label>
                            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image" required>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="caption">說明文字</label>
                            <textarea class="form-control @error('caption') is-invalid @enderror" id="caption" name="caption" rows="3">{{ old('caption') }}</textarea>
                            @error('caption')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">上傳貼文</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection