<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>


    <div class="container py-4">
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        @endif


        @if (Session::has('success'))
        <li>{{ Session::get('success') }}</li>
        @endif

        @if (Session::has('error'))
        <li>{{ Session::get('error') }}</li>
        @endif

        <form action="{{ route('admin.reset_password_submit') }}" method="POST">
            @csrf

            {{-- hidden --}}
            <input type="hidden" value="{{ $email }}" name="email">
            <input type="hidden" value="{{ $token }}" name="token">


            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                <input name="password_confirmation" type="password" class="form-control" id="exampleInputPassword1">
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>








    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>
</html>