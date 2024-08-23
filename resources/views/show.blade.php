@extends('layouts.master')

@section('content')
<div class="main-content mt-5">
    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4>Show Post</h4>
                </div>

                <div class="col-md-6 d-flex justify-content-end">
                    <a class="btn btn-success" href="{{ route('posts.create') }}">Create</a>
                    <a class="btn btn-warning" href="">Trashed</a>
                </div>

            </div>
        </div>

        <div class="card-body">
            <table class="table table-striped" >
                <tbody>
                    {{-- @foreach ($posts as $post)


                  <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td>
                        <img src="{{asset('./storage/app/'.$post->image)}}" alt="" width="80">
                    </td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->description }}</td>
                    <td>{{ $post->category_id}}</td>
                    <td>{{ date('d-m-Y',$post->create_at) }}</td>
                    <td>
                        <a class="btn-sm btn-primary" href="">Show</a>
                        <a class="btn-sm btn-primary" href="{{ route('posts.edit',$post->id) }}">Edit</a>
                        <a class="btn-sm btn-danger" href="">Delete</a>
                    </td>
                  </tr>
                  @endforeach--}}
                  <tr>
                    <td>ID</td>
                    <td>{{ $post->id }}</td>
                  </tr>
                  <tr>
                    <td>Imgae</td>
                    <td>{{ $post->image }}</td>
                  </tr>
                  <tr>
                    <td>Imgae</td>
                    <td><img src="{{ asset($post->image) }}" alt=""></td>
                  </tr>
                  <tr>
                    <td>Title</td>
                    <td>{{ $post->title }}</td>
                  </tr>
                  <tr>
                    <td>Description</td>
                    <td>{{ $post->description }}</td>
                  </tr>
                  <tr>
                    <td>Category</td>
                    <td>{{ $post->category_id }}</td>
                  </tr>
                  <tr>
                    <td>Publish Date</td>
                    <td>{{ date('d-m-Y',$post->create_at) }}</td>
                  </tr>
                </tbody>

              </table>
        </div>
    </div>
</div>

@endsection
