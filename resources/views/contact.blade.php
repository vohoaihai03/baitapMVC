@extends('layouts.master')

@section('content')
    <div class="row">
        @foreach ($posts as $post)
            <x-post.index>
                <x-slot name="title">
                    {{$post->title}}
                </x-slot>
                <x-slot name="description">
                    {{$post->description}}
                </x-slot>
            </x-post.index>
        @endforeach
    </div>
    {{-- cách dưới sử dụng ko được --}}
    {{-- <div class="row">
        @foreach ($posts as $post)
            <x-post.index :post ="$post" />
        @endforeach
    </div> --}}

    {{-- <x-button>
            <p>Submit aaaaaa</p>
    </x-button> --}}
@endsection
