@extends('layouts.master')

@section('content')
    <div class="row mt-5" justify-content-center>
        <div class="col-md-4">
            <h2 class="">Login</h2>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{$errors}}</div>
                @endforeach
            @endif
            <div class="card">
                <div class="card-body">
                    <form action="{{route('login.submit')}}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <lable for="" class="form-label">User Name</lable>
                            <input name="name" type="text" class="form-control">
                        </div>
                        <div class="mb-2">
                            <lable for="" class="form-label">User Email</lable>
                            <input name="email" type="text" class="form-control">
                        </div>
                        <div class="mb-2">
                            <lable for="" class="form-label">User Password</lable>
                            <input name="password" type="email" class="form-control">
                        </div>
                        <button class="btn btn-primary">Nút bấm</button>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
