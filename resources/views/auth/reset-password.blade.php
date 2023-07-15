<html>
    <header>
        <title>reset password</title>
    </header>
    <body>
        <form method="POST" action="">
            @csrf
            <input type="password" name="password" placeholder="password">
            <input type="password" name="password_confirmation" placeholder="password again">
            <input type="text" name="email" placeholder="email">
            <input type="submit" name="submit" value="reset">
        </form>
    </body>
</html>
