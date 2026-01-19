<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Adidas Steps Management')</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --sidebar-width: 270px;
            --topbar-height: 70px;
            --accent-color: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #1a1a1a;
            color: #fff;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .bg-system {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            padding-left: var(--sidebar-width);
        }

        .bg-image {
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('images/bg-admin2.jpeg') }}');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 100%);
            backdrop-filter: blur(2px);
        }

        /* ===== TOPBAR ===== */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            height: var(--topbar-height);
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            z-index: 90;
        }

        .page-title {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--accent-color);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }

        /* ===== CONTENT AREA ===== */
        .main-container {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            min-height: 100vh;
            width: calc(100% - var(--sidebar-width));
        }

        .content {
            padding: 40px;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            color: #333;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: #333;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            padding: 10px;
        }
    </style>
</head>

<body>

    <div class="bg-system">
        <div class="bg-image">
            <div class="bg-overlay"></div>
        </div>
    </div>

    @include('layouts.sidebar')

    <div class="topbar">
        <div class="page-title">
            <i data-lucide="chevron-right" style="width: 18px; vertical-align: middle; margin-right: 8px;"></i>
            @yield('page_title', 'Dashboard')
        </div>

        <div class="user-profile">
            <div style="text-align: right; margin-right: 12px;">
                {{-- Menampilkan Nama Asli (Contoh: Ahmad Dhani) --}}
                <div style="font-weight: 700; font-size: 14px; color: #fff; line-height: 1.2;">
                    {{ auth()->user()->name }}
                </div>
                
                {{-- Menampilkan Username Secara Otomatis (Contoh: KASIR: ADHANI) --}}
                <div style="font-size: 10px; color: #aaa; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">
                    @if(auth()->user()->role === 'admin')
                        ADMINISTRATOR ACCOUNT
                    @else
                         {{ auth()->user()->username }} Kasir
                    @endif
                </div>
            </div>
            
            <div style="width: 42px; height: 42px; background: #333; border: 2px solid rgba(255,255,255,0.2); border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                @if(auth()->user()->role === 'admin')
                    <img src="{{ asset('images/admin-avatar.jpeg') }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <img src="{{ asset('images/kasir-avatar.jpeg') }}" style="width: 100%; height: 100%; object-fit: cover;">
                @endif
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>