<!DOCTYPE html>
<html>
<head>
    <title>Register - SPD Digital</title>
    <style>
        body { font-family: Arial; background: #f4f6f9; padding:50px; }
        .card { background:white; padding:40px; border-radius:10px; box-shadow:0 4px 20px rgba(0,0,0,0.1); max-width:400px; margin:auto; }
        input, button { width:100%; padding:12px; margin:8px 0; border:1px solid #ddd; border-radius:5px; }
        button { background:#116e27; color:white; font-weight:bold; }
        .alert { padding:15px; margin:20px 0; border-radius:5px; }
        .success { background:#d4edda; color:#116e27; border:1px solid #c3e6cb; }
        .error { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="text-align:center;">Register your account</h2>

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert error">
                <ul style="margin:0; padding-left:20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
          <input type="text"     name="name"      autocomplete="name"         placeholder="Nama Lengkap" required>
            <input type="email"    name="email"     autocomplete="email"        placeholder="Email" required>
            <input type="password" name="password"  autocomplete="new-password" placeholder="Password" required>
            
            <button type="submit">REGUSTER</button>
        </form>
        <p style="text-align:center; margin-top:20px;">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </p>
    </div>
</body>
</html>