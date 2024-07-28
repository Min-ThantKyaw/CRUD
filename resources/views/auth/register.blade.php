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
    <div class="container my-5">
        <div class="row">
            <div class="col-6 mx-auto border border-dark py-3">
                <div class="bg-success rounded-top">
                    <h4>Register</h4>
                </div>
                <div class="bg-light">
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control">
                        @error('name')
                            <small class="alert text-danger">{{ $message }}</small><br>
                        @enderror
                        <label for="" class="my-2">Email Address</label>
                        <input type="text" name="email" class="form-control">
                        @error('email')
                            <small class="alert text-danger">{{ $message }}</small><br>
                        @enderror
                        <label for="" class="my-2">Password</label>
                        <input type="password" name="password" class="form-control">
                        @error('password')
                            <small class="alert text-danger">{{ $message }}</small><br>
                        @enderror
                        <label for="" class="my-2">Password Confirmation</label>
                        <input type="password" name="password_confirmation" class="form-control">
                        @error('password')
                            <small class="alert text-danger">{{ $message }}</small><br>
                        @enderror
                        <input type="text" hidden name="type">
                        <label for="" class="my-2">Phone</label>
                        <input type="text" name="phone" class="form-control">
                        @error('phone')
                            <small class="alert text-danger">{{ $message }}</small><br>
                        @enderror
                        <label for="">Address</label>
                        <input type="text" name="address" class="form-control">
                        @error('address')
                            <small class="alert text-danger">{{ $message }}</small><br>
                        @enderror
                        <input type="submit" value="Register" class="btn btn-success my-2">
                        <a href="{{ route('loginPage') }}">Do you have an account?LoginHere</a>
                    </form>
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
