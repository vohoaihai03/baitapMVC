@extends('layouts.main')

@section('title', 'Home Page')

@section('content')
    <h1>Welcome to the Home Page</h1>
    <p>This is the content of the home page.</p>
@endsection

@section('scripts')
    <script>
        console.log('Home Page');
    </script>
@endsection
