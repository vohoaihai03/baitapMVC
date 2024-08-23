@extends('layouts.master')

@section('content')
    <div class="main-content mt-5">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif

        <div class="card">

            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Edit Post</h4>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end">
                        <a class="btn btn-success" href="">Back</a>
                    </div>

                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="">
                        <img src="{{ $post->image }}" alt="">
                    </div>

                    <div class="form-group">
                        <lable for="" class="form-lable">Img</lable>
                        <input name="image" type="file" class="form-control">
                    </div>
                    <div class="form-group">
                        <lable for="" class="form-lable">Title</lable>
                        <input name="title" type="text" class="form-control" value="{{ $post->title }}">
                    </div>
                    <div class="form-group">
                        <lable for="" class="form-lable">Category</lable>
                        <select name="category_id" id="" class="form-control">
                            <option value="">Select</option>
                            @foreach($categories as $category)
                                <option {{$category->id == $post->category_id ? 'selected' : ''}} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <lable for="" class="form-lable">Desrciption</lable>
                        <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $post->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
