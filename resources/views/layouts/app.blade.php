<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('concert.name').' tickets')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,800&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --sky-top: #2a1747;
            --sky-mid: #8e2f6b;
            --sky-low: #f08a5d;
            --sun-hi: #ffd88a;
            --sun-lo: #f59e5b;
            --city: #1c1030;
            --ink: #20162f;
            --muted: #6e6480;
            --line: #e2dbea;
            --rose: #c2416e;
            --rose-dark: #a3345b;
            --peach-wash: #fff3ea;
            --danger: #b42318;
            --display: "Fraunces", Georgia, "Times New Roman", serif;
            --text: "Instrument Sans", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body { margin: 0; }

        body {
            min-height: 100vh;
            font-family: var(--text);
            font-size: 15px;
            line-height: 1.5;
            color: var(--ink);
            background: var(--city);
        }

        .shell {
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr);
            min-height: 100vh;
        }

        /* ---------- Poster: dusk sky, setting sun, city skyline ---------- */
        .poster {
            position: relative;
            overflow: hidden;
            padding: clamp(28px, 5vw, 64px);
            color: #fff;
            background: linear-gradient(180deg, var(--sky-top) 0%, #5a2263 38%, var(--sky-mid) 58%, var(--sky-low) 82%);
            isolation: isolate;
        }

        .poster h1 {
            margin: 0;
            max-width: 9ch;
            font-family: var(--display);
            font-weight: 800;
            font-size: clamp(48px, 7.2vw, 104px);
            line-height: 0.92;
            letter-spacing: -0.02em;
            font-variation-settings: "opsz" 144;
        }

        .poster .tagline {
            max-width: 32ch;
            margin: 18px 0 0;
            font-size: 17px;
            color: rgba(255, 255, 255, 0.82);
        }

        .sun {
            position: absolute;
            z-index: -1;
            left: 50%;
            bottom: 12%;
            width: min(54vw, 440px);
            aspect-ratio: 1;
            border-radius: 50%;
            translate: -50% 38%;
            background: linear-gradient(180deg, var(--sun-hi) 0%, var(--sun-lo) 100%);
            /* retro sunset stripes: gaps widen toward the horizon */
            -webkit-mask-image: linear-gradient(180deg,
                #000 0 50%, transparent 50% 52%, #000 52% 60%, transparent 60% 63%,
                #000 63% 70%, transparent 70% 74.5%, #000 74.5% 80%, transparent 80% 86%, #000 86%);
                    mask-image: linear-gradient(180deg,
                #000 0 50%, transparent 50% 52%, #000 52% 60%, transparent 60% 63%,
                #000 63% 70%, transparent 70% 74.5%, #000 74.5% 80%, transparent 80% 86%, #000 86%);
            animation: sunset 2.8s cubic-bezier(.2, .7, .2, 1) both;
        }

        @keyframes sunset {
            from { translate: -50% 4%; }
            to   { translate: -50% 38%; }
        }

        .skyline {
            position: absolute;
            z-index: -1;
            left: 0;
            right: 0;
            bottom: 0;
            height: 24%;
            background: var(--city);
            clip-path: polygon(
                0 38%, 6% 38%, 6% 22%, 11% 22%, 11% 46%, 15% 46%, 15% 8%, 17% 8%, 17% 4%, 19% 4%, 19% 8%,
                21% 8%, 21% 40%, 27% 40%, 27% 28%, 33% 28%, 33% 52%, 38% 52%, 38% 18%, 43% 18%, 43% 34%,
                49% 34%, 49% 48%, 55% 48%, 55% 14%, 57% 14%, 57% 0, 58.5% 0, 58.5% 14%, 61% 14%, 61% 42%,
                67% 42%, 67% 26%, 73% 26%, 73% 50%, 78% 50%, 78% 20%, 84% 20%, 84% 36%, 90% 36%, 90% 12%,
                95% 12%, 95% 44%, 100% 44%, 100% 100%, 0 100%);
        }

        .event-facts {
            display: grid;
            grid-template-columns: auto auto;
            justify-content: start;
            column-gap: 40px;
            margin: 28px 0 0;
            font-size: 15px;
        }

        .event-facts div { display: grid; gap: 2px; }
        .event-facts dt { grid-row: 1; color: rgba(255, 255, 255, 0.62); font-size: 13px; }
        .event-facts dd { margin: 0; font-weight: 500; }

        /* ---------- Panel ---------- */
        .panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(28px, 5vw, 64px) clamp(20px, 4vw, 56px);
            background: #fff;
        }

        .panel-inner { width: 100%; max-width: 460px; }

        .panel h2 {
            margin: 0 0 4px;
            font-family: var(--display);
            font-weight: 600;
            font-size: 30px;
            line-height: 1.15;
            font-variation-settings: "opsz" 48;
        }

        .lede { margin: 0 0 26px; color: var(--muted); }

        .field { margin-bottom: 16px; }
        .pair { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        label, .legend {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 600;
        }

        .hint { margin-top: 5px; font-size: 13px; color: var(--muted); }

        input[type="text"], input[type="email"], input[type="password"], input[type="date"] {
            width: 100%;
            height: 46px;
            padding: 0 14px;
            font: inherit;
            color: var(--ink);
            background: #fff;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            transition: border-color .15s, box-shadow .15s;
        }

        input::placeholder { color: #a39bb2; }

        input:focus-visible, button:focus-visible, .tier input:focus-visible + .stub {
            outline: none;
            border-color: var(--rose);
            box-shadow: 0 0 0 4px rgba(194, 65, 110, 0.18);
        }

        .is-invalid { border-color: var(--danger) !important; }
        .error { margin-top: 5px; font-size: 13px; color: var(--danger); }

        .alert {
            margin-bottom: 20px;
            padding: 12px 14px;
            font-size: 14px;
            color: var(--danger);
            background: #fef3f2;
            border-left: 3px solid var(--danger);
            border-radius: 4px;
        }

        /* ---------- Ticket stubs ---------- */
        fieldset { margin: 6px 0 16px; padding: 0; border: 0; min-width: 0; }
        legend.legend { padding: 0; }

        .tiers { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }

        .tier { position: relative; display: block; margin: 0; cursor: pointer; font-weight: 400; }

        .tier input { position: absolute; opacity: 0; pointer-events: none; }

        .stub {
            display: grid;
            gap: 2px;
            height: 100%;
            padding: 12px 14px;
            border: 1.5px dashed #cfc5dc;
            border-radius: 10px;
            background: #fbfafd;
            /* punched notches on both sides, like a torn ticket */
            -webkit-mask: radial-gradient(circle at 0 50%, transparent 7px, #000 7.5px) left / 51% 100% no-repeat,
                          radial-gradient(circle at 100% 50%, transparent 7px, #000 7.5px) right / 51% 100% no-repeat;
                    mask: radial-gradient(circle at 0 50%, transparent 7px, #000 7.5px) left / 51% 100% no-repeat,
                          radial-gradient(circle at 100% 50%, transparent 7px, #000 7.5px) right / 51% 100% no-repeat;
            transition: background .15s, border-color .15s;
        }

        .stub .name { font-weight: 600; font-size: 15px; }
        .stub .price { font-family: var(--display); font-weight: 600; font-size: 17px; }
        .stub .perk { font-size: 12.5px; line-height: 1.35; color: var(--muted); }

        .tier:hover .stub { border-color: #b9a9cc; }

        .tier input:checked + .stub {
            border-style: solid;
            border-color: var(--sky-low);
            background: var(--peach-wash);
        }

        .tier input:checked + .stub .price { color: var(--rose-dark); }

        /* ---------- Quantity + total ---------- */
        .order {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin: 4px 0 18px;
            padding: 14px 0;
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
        }

        .stepper { display: inline-flex; align-items: center; border: 1.5px solid var(--line); border-radius: 999px; }

        .stepper button {
            width: 38px;
            height: 38px;
            font: 600 18px/1 var(--text);
            color: var(--ink);
            background: none;
            border: 0;
            border-radius: 50%;
            cursor: pointer;
        }

        .stepper button:hover { background: #f3eff8; }
        .stepper button:disabled { color: #c9c2d4; cursor: default; background: none; }

        .stepper input {
            width: 34px;
            height: 38px;
            padding: 0;
            font: 600 16px var(--text);
            text-align: center;
            color: var(--ink);
            background: none;
            border: 0;
            -moz-appearance: textfield;
        }

        .stepper input::-webkit-outer-spin-button,
        .stepper input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

        .total { text-align: right; }
        .total small { display: block; font-size: 13px; color: var(--muted); }
        .total output { font-family: var(--display); font-weight: 800; font-size: 26px; line-height: 1.1; }

        .btn {
            display: block;
            width: 100%;
            height: 50px;
            padding: 0 18px;
            font: 600 16px/50px var(--text);
            text-align: center;
            text-decoration: none;
            color: #fff;
            background: var(--rose);
            border: 0;
            border-radius: 12px;
            cursor: pointer;
            transition: background .15s;
        }

        .btn:hover { background: var(--rose-dark); }

        .btn-quiet { color: var(--ink); background: #f3eff8; }
        .btn-quiet:hover { background: #e9e2f2; }

        .fine { margin: 12px 0 0; font-size: 13px; color: var(--muted); text-align: center; }

        /* ---------- Message pages ---------- */
        .notice h2 { margin-bottom: 10px; }
        .notice p { margin: 0 0 14px; color: #4a4058; }

        .code-stub {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin: 18px 0 22px;
            padding: 16px 18px;
            border: 1.5px dashed var(--sky-low);
            border-radius: 10px;
            background: var(--peach-wash);
        }

        .code-stub span { font-size: 13px; color: var(--muted); }
        .code-stub strong { font-family: var(--display); font-size: 24px; letter-spacing: 0.04em; }

        @media (max-width: 900px) {
            .shell { grid-template-columns: 1fr; }
            .poster { min-height: 560px; }
            .poster h1 { max-width: 12ch; }
            .sun { width: min(70vw, 360px); }
        }

        @media (max-width: 520px) {
            .pair { grid-template-columns: 1fr; gap: 0; }
            .tiers { grid-template-columns: 1fr; }
            .order { flex-wrap: wrap; }
            .poster { min-height: 600px; }
            .event-facts { grid-template-columns: 1fr; row-gap: 12px; }
            .sun { width: 300px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .sun { animation: none; }
        }
    </style>
</head>
<body>
    <div class="shell">
        <header class="poster">
            <h1>{{ config('concert.name') }}</h1>
            <p class="tagline">{{ config('concert.tagline') }}</p>

            <dl class="event-facts">
                <div><dt>When</dt><dd>{{ config('concert.date') }}</dd></div>
                <div><dt>Where</dt><dd>{{ config('concert.venue') }}</dd></div>
            </dl>

            <div class="sun" aria-hidden="true"></div>
            <div class="skyline" aria-hidden="true"></div>
        </header>

        <main class="panel">
            <div class="panel-inner">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
