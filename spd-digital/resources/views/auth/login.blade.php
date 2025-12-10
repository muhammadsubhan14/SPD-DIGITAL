<!DOCTYPE html>
<html>
<head>
    <title>Login - SPD Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial; background: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin:0; }
        .card { background:white; padding:40px; border-radius:10px; box-shadow:0 4px 20px rgba(0,0,0,0.1); width:380px; }
        input, button { width:100%; padding:12px; margin:8px 0; border:1px solid #ddd; border-radius:5px; }
        button { background: #116e27; color:white; font-weight:bold; cursor:pointer; }
        a { color:#155724; text-decoration:none; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="text-align:center;">LOGIN</h2>
       <!-- login.blade.php -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email"    name="email"    autocomplete="username"     value="{{ old('email') }}" placeholder="Email" required autofocus>
            <input type="password" name="password" autocomplete="current-password" placeholder="Password" required>
            <button type="submit">LOGIN</button>
        </form>
        <p style="text-align:center; margin-top:20px;">
            did'nt have an account? <a href="{{ route('register') }}">Register here</a>
        </p>
        @if($errors->any())
            <div style="color:red; margin-top:10px;">{{ $errors->first() }}</div>
        @endif
    </div>

    <script>
        document.getElementById('loginButton').addEventListener('click', function() {
            setTimeout(function() {
                alert('Login successful!');
            }, 2000); 
        });
    </script>
</body>
</html>