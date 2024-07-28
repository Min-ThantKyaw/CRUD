<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- Font awaesome CDN Link --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <title>Bulletin Board OJT</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary my-2 sticky-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" disabled>Bulletin_Board</a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if (Auth::check() && Auth::user()->type == 1)
                        <li class="nav-item">
                            <a class="nav-link  active" href="{{ route('user.userlist') }}">User</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link  active" href="{{ route('post.postlist') }}">Posts</a>
                    </li>

                </ul>
                <ul class="navbar-nav me-5">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.userCreatePage') }}">Create User</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ Auth::user()->name }}<br>
                            <small class="text-success">{{ Auth::user()->type == 1 ? 'Admin' : 'User' }}</small>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('user.profilePage') }}">Profile</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <input type="submit" name="logout" value="Logout" class="dropdown-item">
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>
    <div class="container-fluid d-flex justify-content-between bg-light my-3">
        <h3><a href="http://seattleconsultingmyanmar.com" class=" text-decoration-none text-success">Seattle Consulting
                Myanmar</a></h3>
        <h3 class="text-success">Copyright © Seattle Consulting
            Myanmar Co., Ltd. All rights reserved.</h3>
    </div>
</body>
<!-- Bootstrap Js Link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>
