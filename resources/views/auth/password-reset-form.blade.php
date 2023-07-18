<html>
    <header>
        <title>reset password</title>
    </header>
    <body>
        <h1>reset password</h1>
        <p>{{ url('password-reset') }}</p>
        <p>{{ $token }}</p>
        <p>{{ $email }}</p>
        <form method="POST" action="{{$token.'?email='.$email}}">
            @csrf
            <input type="password" name="password" placeholder="password">
            <input type="password" name="password_confirmation" placeholder="password again">
            <input type="submit">
        </form>
    </body>
</html>
