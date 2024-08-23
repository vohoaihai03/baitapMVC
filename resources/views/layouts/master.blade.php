<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>CRUD</title>
</head>

<body>
    {{-- @include('layouts.header') nhúng trang header vào --}}
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand">Navbar</a>
            {{ auth()->user()->name }}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn sm btn-primary">Logout</button>
            </form>

        </div>
    </nav>

    <div class="container">

        @yield('content')

    </div>




    {{-- @include('layouts.header') --}}

    {{-- @yield('content') là những dữ liệu trang khác khi dùng tên content thì show data đúng chỗ đó --}}
    {{-- @yield('content') --}}

    {{-- @include('layouts.footer') nhúng trang header vào --}}
    {{-- @include('layouts.footer') --}}


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>

</html>
