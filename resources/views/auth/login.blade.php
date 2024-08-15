<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- Font awaesome CDN Link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Bulletin_Board_OJT</title>
</head>

<body>
    <div class="container">
        <div class="rounded  ">
            <div class="row">
                <div class="offset-2 col-md-8 bg-success my-5">
                    <h3>Login</h3>
                </div>
            </div>
            <div class="row">
                <div class="offset-2 col-md-8">
                    @if (session('success'))
                        <div class="">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-check"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <label for="">Email Address</label>
                        <input type="text" name="email" id="" placeholder="Enter Emial Address"
                            class="form-control">

                        <label for="">Password</label>
                        <input type="password" name="password" id="" placeholder="Enter Password"
                            class="form-control">

                        <div class="d-flex">
                            <input type="checkbox" name="remember">Remember Me
                            <a href="{{ route('password.forgot') }}" class="px-5 text-decoration-none">Forget
                                Password?</a>
                        </div>
                        <button class="btn btn-success form-control mt-md-3" type="submit">Login</button>
                    </form>
                    <a href="{{ route('registerPage') }}" class="text-decoration-none">Create an Account?<i
                            class="fa-solid fa-user-plus"></i></a>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- Bootstrap Js Link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>
