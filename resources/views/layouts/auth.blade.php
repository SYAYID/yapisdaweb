<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login - YAPISDA')</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-yapisda.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap" rel="stylesheet">

    <style>
    :root {
        --brand: #0f5f4a;
        --brand-700: #0b4537;
        --brand-800: #083229;
        --mint: #dff5ee;
        --aqua: #1f9aa5;
        --gold: #c89b3c;
        --gold-soft: #fff2cf;
        --ink: #14201d;
        --text: #263834;
        --muted: #687874;
        --line: #dce6e2;
        --paper: #f5f8f6;
        --danger: #dc2626;
        --ff-display: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
        --ff-body: 'Inter', 'Segoe UI', system-ui, sans-serif;
        --shadow-md: 0 18px 50px rgba(20, 32, 29, 0.12);
    }

    * { box-sizing: border-box; }

    body {
        min-height: 100vh;
        margin: 0;
        font-family: var(--ff-body);
        color: var(--text);
        background:
            radial-gradient(circle at 16% 10%, rgba(31, 154, 165, 0.24), transparent 24rem),
            radial-gradient(circle at 86% 8%, rgba(200, 155, 60, 0.18), transparent 22rem),
            linear-gradient(135deg, var(--brand-800), var(--brand));
        -webkit-font-smoothing: antialiased;
    }

    .auth-shell {
        min-height: 100vh;
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(340px, 460px);
        align-items: center;
        gap: clamp(1.5rem, 4vw, 4rem);
        width: min(1120px, 100%);
        margin: 0 auto;
        padding: clamp(1.25rem, 3vw, 2rem);
    }

    .auth-intro {
        color: white;
        display: grid;
        gap: 1.2rem;
    }

    .auth-brand {
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        color: white;
        text-decoration: none;
        width: max-content;
    }

    .auth-brand img {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        background: white;
        padding: 0.32rem;
    }

    .auth-brand strong {
        display: block;
        font-family: var(--ff-display);
        font-size: 1.3rem;
        font-weight: 900;
        line-height: 1.1;
    }

    .auth-brand span {
        display: block;
        color: rgba(255, 255, 255, 0.68);
        font-size: 0.74rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .auth-intro h1 {
        max-width: 620px;
        margin: 0;
        font-family: var(--ff-display);
        font-size: clamp(2rem, 4.8vw, 4.2rem);
        font-weight: 900;
        letter-spacing: 0;
        line-height: 1.02;
    }

    .auth-intro p {
        max-width: 560px;
        margin: 0;
        color: rgba(255, 255, 255, 0.76);
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.7;
    }

    .auth-panel-links {
        display: flex;
        flex-wrap: wrap;
        gap: 0.55rem;
        margin-top: 0.45rem;
    }

    .auth-panel-links a {
        min-height: 38px;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 999px;
        padding: 0.48rem 0.78rem;
        color: rgba(255, 255, 255, 0.82);
        background: rgba(255, 255, 255, 0.08);
        text-decoration: none;
        font-size: 0.82rem;
        font-weight: 900;
    }

    .auth-panel-links a.is-active {
        background: var(--gold-soft);
        color: var(--brand-800);
    }

    .auth-card {
        width: 100%;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.98);
        box-shadow: var(--shadow-md);
    }

    .auth-card-header {
        padding: 1.4rem 1.55rem;
        color: white;
        background:
            radial-gradient(circle at 92% 0%, rgba(31, 154, 165, 0.24), transparent 10rem),
            linear-gradient(135deg, var(--brand-800), var(--brand));
    }

    .auth-badge {
        width: max-content;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border-radius: 999px;
        padding: 0.36rem 0.72rem;
        background: rgba(255, 255, 255, 0.13);
        color: var(--gold-soft);
        font-size: 0.75rem;
        font-weight: 900;
        text-transform: uppercase;
    }

    .auth-card-header h2 {
        margin: 0.8rem 0 0.3rem;
        font-family: var(--ff-display);
        font-size: 1.35rem;
        font-weight: 900;
    }

    .auth-card-header p {
        margin: 0;
        color: rgba(255, 255, 255, 0.72);
        font-weight: 700;
    }

    .auth-card-body {
        display: grid;
        gap: 1rem;
        padding: 1.55rem;
    }

    .auth-alert {
        display: flex;
        gap: 0.65rem;
        border: 1px solid #fecaca;
        border-left: 4px solid var(--danger);
        border-radius: 12px;
        padding: 0.85rem 0.9rem;
        background: #fff5f5;
        color: #991b1b;
        font-weight: 700;
    }

    .auth-form {
        display: grid;
        gap: 1rem;
    }

    .auth-field label {
        display: block;
        margin-bottom: 0.35rem;
        color: var(--ink);
        font-size: 0.82rem;
        font-weight: 900;
    }

    .auth-input {
        display: grid;
        grid-template-columns: 44px minmax(0, 1fr);
        min-height: 48px;
        border: 1px solid var(--line);
        border-radius: 12px;
        background: #fff;
        overflow: hidden;
    }

    .auth-input span {
        display: grid;
        place-items: center;
        background: var(--mint);
        color: var(--brand);
    }

    .auth-input input {
        width: 100%;
        border: 0;
        padding: 0.72rem 0.85rem;
        color: var(--text);
        font-weight: 700;
        outline: none;
    }

    .auth-input:focus-within {
        border-color: var(--brand);
        box-shadow: 0 0 0 4px rgba(15, 95, 74, 0.12);
    }

    .auth-submit {
        min-height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        border: 0;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--brand), var(--aqua));
        color: white;
        font-weight: 900;
    }

    .auth-footnote {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        margin: 0;
        color: var(--muted);
        font-size: 0.84rem;
        font-weight: 800;
        text-align: center;
    }

    .invalid-feedback {
        display: block;
        margin-top: 0.35rem;
        color: var(--danger);
        font-weight: 700;
    }

    @media (max-width: 860px) {
        .auth-shell {
            grid-template-columns: 1fr;
            gap: 1.4rem;
        }

        .auth-intro h1 {
            font-size: 2.3rem;
        }
    }

    @media (max-width: 560px) {
        .auth-shell {
            padding: 1rem;
        }

        .auth-card-header,
        .auth-card-body {
            padding: 1.15rem;
        }
    }
    </style>

    @stack('styles')
</head>
<body>
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
