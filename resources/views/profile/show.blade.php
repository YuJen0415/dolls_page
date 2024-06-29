@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $user->name }}的個人資料</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="個人頭像" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" alt="預設頭像" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        @endif
                    </div>

                    <h4>用戶名: {{ $user->name }}</h4>
                    <p>電子郵件: {{ $user->email }}</p>
                    <p>個人簡介: {{ $user->bio ?? '尚未設置個人簡介' }}</p>

                    @if(Auth::id() == $user->id)
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">編輯個人資料</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection