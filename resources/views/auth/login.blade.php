<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Adidas Steps</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('/images/bg3.jpeg') center/cover no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.25);
            padding: 35px;
            width: 420px;
            border-radius: 15px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.35);
            box-shadow: 0 0 25px rgba(0,0,0,0.25);
        }

        .logo {
            width: 110px;
            margin-bottom: 10px;
            filter: drop-shadow(0 2px 5px rgba(0,0,0,0.5));
        }

        .login-box h2 {
            font-size: 34px;
            font-weight: bold;
            margin-bottom: 30px;
            color: white;
            letter-spacing: 2px;
            text-shadow: 0 0 5px black;
        }

        label {
            display: block;
            text-align: left;
            width: 90%;
            margin: auto;
            color: white;
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 5px;
            text-shadow: 0 0 3px black;
        }

        input {
            width: 90%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            margin-bottom: 18px;
            font-size: 16px;
            background: rgba(255,255,255,0.8);
        }

        .login-btn {
            width: 95%;
            padding: 12px;
            border-radius: 10px;
            background: black;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: 0.2s;
        }

        .login-btn:hover {
            background: rgb(30,30,30);
        }

        .error {
            color: #ff4d4d;
            margin-top: 10px;
            font-weight: bold;
            font-size: 15px;
        }
    </style>
</head>
<body>

    <div class="login-box">

        <!-- LOGO -->
        <img src="/images/logo.png" class="logo">

        <h2>ADIDAS STEPS</h2>

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button class="login-btn">LOGIN</button>
        </form>

        @if(session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif
    </div>

</body>
</html>
