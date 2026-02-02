<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Adidas Steps</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('/images/bg3.jpeg') center/cover no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 45px 35px;
            width: 400px;
            border-radius: 20px;
            text-align: center;
            /* Efek Glassmorphism lebih halus */
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            transition: transform 0.3s ease;
        }

        .login-box:hover {
            transform: translateY(-5px);
        }

        .logo {
            width: 100px;
            margin-bottom: 15px;
            filter: brightness(0) invert(1) drop-shadow(0 4px 10px rgba(0,0,0,0.3));
        }

        .login-box h2 {
            font-size: 28px;
            font-weight: 900;
            margin-bottom: 35px;
            color: white;
            letter-spacing: 4px;
            text-transform: uppercase;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
        }

        .form-group {
            text-align: left;
            width: 90%;
            margin: 0 auto 20px auto;
        }

        label {
            display: block;
            color: rgba(255,255,255,0.9);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.2);
            font-size: 15px;
            background: rgba(255,255,255,0.9);
            box-sizing: border-box;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        input:focus {
            outline: none;
            background: white;
            box-shadow: 0 0 0 4px rgba(255,255,255,0.2);
            transform: scale(1.02);
        }

        .login-btn {
            width: 90%;
            padding: 15px;
            margin-top: 10px;
            border-radius: 8px;
            background: white;
            color: black;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .login-btn:hover {
            background: black;
            color: white;
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        .error {
            background: rgba(255, 77, 77, 0.2);
            color: #ff4d4d;
            padding: 10px;
            border-radius: 8px;
            margin-top: 20px;
            font-weight: 700;
            font-size: 13px;
            border: 1px solid rgba(255, 77, 77, 0.3);
            display: inline-block;
            width: 85%;
        }

        .adidas-stripes {
            position: absolute;
            bottom: 20px;
            right: 30px;
            opacity: 0.3;
        }
        .stripe {
            width: 40px;
            height: 4px;
            background: white;
            margin-bottom: 5px;
            transform: rotate(-45deg);
        }
    </style>
</head>
<body>

    <div class="login-box">
        <img src="/images/logo.png" class="logo" alt="Adidas Logo">

        <h2>ADIDAS STEPS</h2>

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required autocomplete="off">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="login-btn">MASUK SEKARANG</button>
        </form>

        @if(session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif
    </div>

    <div class="adidas-stripes">
        <div class="stripe" style="width: 60px;"></div>
        <div class="stripe" style="width: 50px;"></div>
        <div class="stripe" style="width: 40px;"></div>
    </div>

</body>
</html>