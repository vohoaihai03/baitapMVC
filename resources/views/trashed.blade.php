@extends('layouts.master')

@section('content')
    <div class="main-content mt-5">
        <div class="card">

            <div class="card-header">
                <div class="row">

                    <div class="col-md-6">
                        <h4>Trashed Post</h4>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end">
                        <a class="btn btn-success" href="">Back</a>
                    </div>

                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col width: 5%">#</th>
                            <th scope="col" style=" width: 10%">Img</th>
                            <th scope="col" style=" width: 20%">Title</th>
                            <th scope="col" style=" width: 30%">Desrciption</th>
                            <th scope="col" style=" width: 10%">Category</th>
                            <th scope="col" style=" width: 10%">Publish Date</th>
                            <th scope="col" style=" width: 20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <th scope="row">{{ $post->id }}</th>
                                <td>
                                    <img src="{{ asset('./storage/app/' . $post->image) }}" alt="" width="80">
                                </td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->description }}</td>
                                <td>{{ $post->category->name}}</td>
                                <td>{{ date('d-m-Y', $post->create_at) }}</td>
                                <td>
                                    <a class="btn-sm btn-success btn"
                                        href="{{ route('posts.restore', $post->id) }}">Restore</a>

                                    <div class="d-flex">
                                        <form action="{{ route('posts.force_delete', $post->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
