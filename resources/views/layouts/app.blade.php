<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>@yield('title', config('concert.name').' tickets')</title>
    <style>
        /* Same design language as hdsh.mav.my.id */
        :root {
            --maroon: #800000;
            --maroon-dark: #5c0000;
            --green: #004d40;
            --bg: #ffffff;
            --bg-soft: #f6f2f2;
            --text: #231f1f;
            --muted: #6b6262;
            --line: #e4dcdc;
            --accent: var(--maroon);
            --field: #ffffff;
            --danger: #b42318;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #161212;
                --bg-soft: #201a1a;
                --text: #f0e9e9;
                --muted: #a89c9c;
                --line: #372d2d;
                --accent: #e8a0a0;
                --field: #1b1616;
                --danger: #f2948a;
            }
        }

        * { box-sizing: border-box; }

        html { scroll-behavior: smooth; scroll-padding-top: 4.5rem; }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.65;
        }

        h1, h2, h3 {
            font-family: "Iowan Old Style", "Palatino Linotype", Palatino, Georgia, serif;
            line-height: 1.15;
            margin: 0;
        }

        a { color: inherit; }
        a:focus-visible, button:focus-visible { outline: 3px solid var(--green); outline-offset: 3px; }

        .wrap { max-width: 960px; margin: 0 auto; padding: 0 1.5rem; }

        /* ---------- Header ---------- */
        header { position: sticky; top: 0; z-index: 10; background: var(--maroon); color: #fff; }

        header .wrap {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: .25rem 1.5rem;
            padding-top: .75rem;
            padding-bottom: .75rem;
        }

        .brand { font-weight: 700; text-decoration: none; }
        nav { display: flex; flex-wrap: wrap; gap: .25rem 1.25rem; }
        nav a { text-decoration: none; opacity: .9; font-size: .95rem; }
        nav a:hover { opacity: 1; text-decoration: underline; }

        /* ---------- Hero ---------- */
        .hero { background: var(--maroon); color: #fff; padding: 5rem 0 5.5rem; }
        .hero.compact { padding: 3.5rem 0 3.75rem; }
        .hero h1 { font-size: clamp(2.6rem, 8vw, 5rem); letter-spacing: -.02em; max-width: 14ch; }
        .hero.compact h1 { font-size: clamp(2.2rem, 6vw, 3.4rem); }
        .hero p { font-size: 1.2rem; max-width: 52ch; margin: 1.5rem 0 0; opacity: .92; }

        .facts { display: flex; flex-wrap: wrap; gap: .5rem 2.5rem; margin: 1.75rem 0 0; }
        .facts div { display: grid; }
        .facts dt { font-size: .9rem; opacity: .75; }
        .facts dd { margin: 0; font-weight: 600; }

        .button {
            display: inline-block;
            margin-top: 2rem;
            padding: .75rem 1.75rem;
            border: 0;
            border-radius: 999px;
            background: #fff;
            color: var(--maroon);
            font-family: inherit;
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.4;
            text-decoration: none;
            cursor: pointer;
        }

        .button:hover { background: #f1e3e3; }

        .button.solid { background: var(--maroon); color: #fff; }
        .button.solid:hover { background: var(--maroon-dark); }

        .stripe { height: 8px; background: var(--green); }

        /* ---------- Sections ---------- */
        section.block { padding: 4.5rem 0; }
        h2 { font-size: 2rem; color: var(--accent); margin-bottom: .5rem; }
        .intro { margin: 0 0 2rem; color: var(--muted); max-width: 62ch; }

        /* ---------- Form ---------- */
        form { max-width: 680px; }

        .row {
            display: grid;
            grid-template-columns: 11rem 1fr;
            gap: .25rem 2rem;
            padding: 1.25rem 0;
            border-top: 1px solid var(--line);
        }

        .row.last { border-bottom: 1px solid var(--line); }

        .row > label, .row > .label { padding-top: .55rem; color: var(--muted); font-size: .95rem; }

        .control { min-width: 0; }

        input[type="text"], input[type="email"], input[type="password"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: .6rem .85rem;
            font: inherit;
            color: var(--text);
            background: var(--field);
            border: 1px solid var(--line);
            border-radius: 6px;
        }

        input::placeholder { color: var(--muted); opacity: .8; }

        input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(128, 0, 0, .15); }

        .hint { margin: .35rem 0 0; color: var(--muted); font-size: .9rem; }
        .error { margin: .35rem 0 0; color: var(--danger); font-size: .9rem; }
        .is-invalid { border-color: var(--danger) !important; }

        .alert {
            max-width: 680px;
            margin: 0 0 1.5rem;
            padding: .85rem 1rem;
            border-left: 4px solid var(--danger);
            background: var(--bg-soft);
            color: var(--danger);
        }

        /* Ticket choice */
        .tiers { display: grid; gap: .5rem; margin: 0; padding: 0; border: 0; min-width: 0; }

        .tier { position: relative; display: block; cursor: pointer; }
        .tier input { position: absolute; opacity: 0; pointer-events: none; }

        .tier .box {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 1rem;
            padding: .7rem .95rem;
            border: 1px solid var(--line);
            border-left: 4px solid var(--line);
            border-radius: 6px;
            background: var(--field);
        }

        .tier .name { display: block; font-family: "Iowan Old Style", "Palatino Linotype", Palatino, Georgia, serif; font-size: 1.15rem; font-weight: 700; line-height: 1.3; }
        .tier .perk { display: block; color: var(--muted); font-size: .9rem; }
        .tier .price { white-space: nowrap; font-weight: 600; }

        .tier:hover .box { border-color: var(--muted); }
        .tier input:checked + .box { border-color: var(--accent); border-left-color: var(--accent); background: var(--bg-soft); }
        .tier input:checked + .box .price { color: var(--accent); }
        .tier input:focus-visible + .box { outline: 3px solid var(--green); outline-offset: 2px; }

        .qty { display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
        .qty input { width: 6rem; }
        .total { text-align: right; }
        .total small { display: block; color: var(--muted); font-size: .9rem; }
        .total output { font-family: "Iowan Old Style", "Palatino Linotype", Palatino, Georgia, serif; font-size: 1.6rem; font-weight: 700; }

        .fine { margin: 1rem 0 0; color: var(--muted); font-size: .9rem; max-width: 62ch; }

        /* ---------- Message pages ---------- */
        .notice { max-width: 62ch; }
        .notice p { margin: 0 0 1rem; }

        .details { max-width: 680px; margin: 1.5rem 0 1rem; }
        .details .row { padding: .9rem 0; }
        .details .row > .label { padding-top: 0; }

        /* ---------- Footer ---------- */
        footer { background: var(--maroon-dark); color: #fff; padding: 2.5rem 0; }
        footer .wrap { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 1rem; }
        footer a { text-decoration: none; }
        footer a:hover { text-decoration: underline; }
        footer small { opacity: .8; }

        @media (max-width: 640px) {
            .row { grid-template-columns: 1fr; }
            .row > label, .row > .label { padding-top: 0; }
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
        }
    </style>
</head>
<body>
    <header>
        <div class="wrap">
            <a class="brand" href="{{ route('registration.create') }}">{{ config('concert.name') }}</a>
            <nav aria-label="Main">
                <a href="{{ route('registration.create') }}#tickets">HALLOOOOOOO</a>
                <a href="mailto:{{ config('concert.contact_email') }}">Contact</a>
            </nav>
        </div>
    </header>

    @hasSection('hero')
        @yield('hero')
    @else
        <section class="hero compact">
            <div class="wrap">
                <h1>{{ config('concert.name') }}</h1>
            </div>
        </section>
    @endif

    <div class="stripe"></div>

    <main>
        <section class="block" id="tickets">
            <div class="wrap">
                @yield('content')
            </div>
        </section>
    </main>

    <footer>
        <div class="wrap">
            <a href="mailto:{{ config('concert.contact_email') }}">{{ config('concert.contact_email') }}</a>
            <small>All Rights Reserved © {{ now()->year }}</small>
        </div>
    </footer>
</body>
</html>
