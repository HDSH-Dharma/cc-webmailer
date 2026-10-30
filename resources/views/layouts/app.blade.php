<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('concert.name').' - Ticket Registration')</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
            background: #f3f4f6;
            font-family: "Segoe UI", -apple-system, BlinkMacSystemFont, Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #1f2937;
        }

        .card {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08), 0 2px 6px rgba(15, 23, 42, 0.06);
        }

        .card-header {
            background: linear-gradient(135deg, #4338ca 0%, #7c3aed 100%);
            color: #ffffff;
            text-align: center;
            padding: 26px 20px 22px;
        }

        .card-header h1 {
            margin: 0;
            font-size: 21px;
            font-weight: 600;
            letter-spacing: 0.1px;
        }

        .card-header p {
            margin: 4px 0 0;
            font-size: 13px;
            opacity: 0.92;
        }

        .card-header .event-meta {
            margin-top: 10px;
            font-size: 12px;
            opacity: 0.85;
        }

        .card-body { padding: 22px 22px 24px; }

        .field { margin-bottom: 16px; }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #111827;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="number"],
        select {
            width: 100%;
            padding: 9px 11px;
            font-size: 14px;
            font-family: inherit;
            color: #111827;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            transition: border-color .15s, box-shadow .15s;
        }

        input::placeholder { color: #9ca3af; }

        input:focus {
            outline: none;
            border-color: #5b3fd9;
            box-shadow: 0 0 0 3px rgba(91, 63, 217, 0.18);
        }

        input.is-invalid { border-color: #dc2626; }

        .row { display: flex; gap: 12px; }
        .row .field { flex: 1; }
        .row .field.qty { flex: 0 0 96px; }

        .total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2px 0 14px;
            padding: 10px 12px;
            font-size: 13px;
            background: #f5f3ff;
            border: 1px solid #ddd6fe;
            border-radius: 5px;
        }
        .total strong { font-size: 15px; color: #4c1d95; }

        .error {
            margin-top: 5px;
            font-size: 12px;
            color: #dc2626;
        }

        .alert {
            margin-bottom: 16px;
            padding: 10px 12px;
            font-size: 13px;
            border-radius: 5px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .btn {
            display: block;
            width: 100%;
            margin-top: 6px;
            padding: 10px 14px;
            font-size: 14px;
            font-family: inherit;
            font-weight: 500;
            text-align: center;
            text-decoration: none;
            color: #ffffff;
            background: #5b3fd9;
            border: 0;
            border-radius: 5px;
            cursor: pointer;
            transition: background .15s;
        }

        .btn:hover { background: #4a2fc0; }

        .message { text-align: center; font-size: 14px; line-height: 1.6; color: #374151; }
        .message .icon { font-size: 40px; line-height: 1; margin-bottom: 10px; }
        .message h2 { margin: 0 0 8px; font-size: 18px; color: #111827; }
        .message p { margin: 0 0 10px; }
        .muted { font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    <main class="card">
        <div class="card-header">
            <h1>🎵 {{ config('concert.name') }}</h1>
            <p>@yield('subtitle', 'Ticket Registration Form')</p>
            <div class="event-meta">{{ config('concert.date') }}<br>{{ config('concert.venue') }}</div>
        </div>
        <div class="card-body">
            @yield('content')
        </div>
    </main>
</body>
</html>
