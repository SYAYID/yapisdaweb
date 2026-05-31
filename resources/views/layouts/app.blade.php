<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'YAPISDA - Sekolah Islam Terpadu')</title>

    <meta name="description" content="@yield('meta_description', 'YAPISDA - Yayasan Pendidikan Islam Daar El Rohmah, sekolah Islam dengan jenjang SMPS dan SMKS di Cisoka, Tangerang.')">
    <meta property="og:title" content="@yield('og_title', 'YAPISDA')">
    <meta property="og:description" content="@yield('og_description', 'YAPISDA - Yayasan Pendidikan Islam Daar El Rohmah')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'YAPISDA')">
    <meta name="twitter:description" content="@yield('twitter_description', 'YAPISDA - Yayasan Pendidikan Islam Daar El Rohmah')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/og-image.jpg'))">

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-yapisda.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">

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
        --surface: #ffffff;
        --paper: #f5f8f6;
        --danger: #dc2626;
        --success: #16a34a;
        --warning: #d97706;

        --primary: var(--brand);
        --primary-dark: var(--brand-700);
        --primary-light: #188060;
        --secondary: var(--aqua);
        --secondary-dark: #147680;
        --accent: var(--gold);
        --accent-dark: #9f7629;
        --dark: var(--ink);
        --dark-800: var(--brand-700);
        --dark-900: var(--brand-800);
        --light: var(--paper);
        --gray: var(--muted);
        --gray-100: var(--paper);
        --gray-200: var(--line);
        --gray-300: #c7d4cf;

        --ff-display: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
        --ff-body: 'Inter', 'Segoe UI', system-ui, sans-serif;
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 18px;
        --shadow-sm: 0 8px 24px rgba(20, 32, 29, 0.08);
        --shadow-md: 0 18px 50px rgba(20, 32, 29, 0.12);
        --transition: 180ms ease;
    }

    *, *::before, *::after { box-sizing: border-box; }
    html { scroll-behavior: smooth; scroll-padding-top: 88px; }
    body {
        margin: 0;
        font-family: var(--ff-body);
        color: var(--text);
        background:
            radial-gradient(circle at 8% 0%, rgba(31, 154, 165, 0.08), transparent 28rem),
            linear-gradient(180deg, #fbfdfc 0%, var(--paper) 42%, #ffffff 100%);
        line-height: 1.65;
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
    }

    img { max-width: 100%; display: block; }
    a { color: inherit; }
    .container { max-width: 1180px; padding-left: 1.25rem; padding-right: 1.25rem; }

    .site-navbar {
        position: sticky;
        top: 0;
        z-index: 1000;
        background: rgba(255, 255, 255, 0.92);
        border-bottom: 1px solid rgba(220, 230, 226, 0.9);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        transition: box-shadow var(--transition), background var(--transition);
    }
    .site-navbar.scrolled {
        background: rgba(255, 255, 255, 0.98);
        box-shadow: 0 12px 36px rgba(20, 32, 29, 0.08);
    }
    .navbar-brand {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem 0;
        text-decoration: none;
    }
    .brand-logo-row {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .brand-mark {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: white;
        border: 2px solid #ffffff;
        display: grid;
        place-items: center;
        box-shadow: 0 4px 12px rgba(15, 95, 74, 0.12);
        overflow: hidden;
        position: relative;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .brand-mark:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 16px rgba(15, 95, 74, 0.22);
    }
    .brand-mark.school-logo {
        width: 46px;
        height: 46px;
        border: 2px solid #ffffff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }
    .brand-mark img {
        width: 100%;
        height: 100%;
        padding: 4px;
        object-fit: contain;
    }
    .brand-copy { display: grid; line-height: 1.1; }
    .brand-name {
        font-family: var(--ff-display);
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--brand-800);
        letter-spacing: 0;
    }
    .brand-tagline {
        margin-top: 0.18rem;
        color: var(--muted);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .navbar-toggler {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--line);
        padding: 0;
    }
    .navbar-toggler:focus { box-shadow: 0 0 0 4px rgba(15, 95, 74, 0.12); }
    .navbar-menu-icon {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
        color: var(--brand-800);
        font-size: 1.05rem;
    }
    .navbar-toggler-icon {
        width: 100%;
        height: 100%;
        background-image: none !important;
        display: grid;
        place-items: center;
    }
    .navbar-toggler-icon::before {
        content: "\f0c9";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        color: var(--brand-800);
        font-size: 1.05rem;
    }
    .navbar-nav { gap: 0.1rem; }
    .navbar-nav .nav-link {
        color: var(--text) !important;
        font-size: 0.92rem;
        font-weight: 700;
        padding: 0.62rem 0.66rem !important;
        border-radius: var(--radius-sm);
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        transition: background var(--transition), color var(--transition);
        white-space: nowrap;
    }
    .navbar-nav .nav-link i { color: var(--brand); font-size: 0.86rem; }
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
        color: var(--brand-800) !important;
        background: var(--mint);
    }
    .nav-admin-label {
        color: var(--brand) !important;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-size: 0.75rem !important;
    }
    .dropdown-menu {
        border: 1px solid var(--line);
        border-radius: var(--radius-md);
        padding: 0.45rem;
        box-shadow: var(--shadow-md);
    }
    .dropdown-item {
        border-radius: var(--radius-sm);
        padding: 0.65rem 0.8rem;
        font-weight: 700;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 0.55rem;
    }
    .dropdown-item:hover { background: var(--mint); color: var(--brand-800); }
    .btn-nav-cta,
    .btn-nav-danger,
    .btn,
    .btn-primary,
    .btn-success,
    .btn-warning,
    .btn-danger,
    .btn-secondary {
        border-radius: var(--radius-sm);
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        transition: transform var(--transition), box-shadow var(--transition), background var(--transition);
    }
    .btn-nav-cta {
        min-height: 42px;
        padding: 0.62rem 0.86rem;
        background: var(--brand);
        color: white !important;
        text-decoration: none;
        box-shadow: 0 12px 26px rgba(15, 95, 74, 0.22);
    }
    .btn-nav-cta:hover {
        background: var(--brand-700);
        transform: translateY(-1px);
        color: white !important;
    }
    .btn-nav-danger {
        min-height: 42px;
        padding: 0.62rem 1rem;
        color: #991b1b !important;
        background: #fee2e2;
        text-decoration: none;
    }
    .btn-nav-danger:hover { background: #fecaca; color: #7f1d1d !important; }

    main { min-height: calc(100vh - 74px); }

    .flash-shell { padding-top: 1rem; }
    .flash-alert {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        border: 1px solid var(--line);
        border-left: 4px solid var(--success);
        background: white;
        color: var(--text);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        padding: 1rem 1.1rem;
    }
    .flash-error { border-left-color: var(--danger); }
    .flash-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        background: var(--mint);
        color: var(--brand);
        flex: 0 0 auto;
    }
    .flash-error .flash-icon { background: #fee2e2; color: var(--danger); }

    .card {
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
    .card-header {
        background: var(--brand-800);
        color: white;
        font-family: var(--ff-display);
        font-weight: 800;
        border-bottom: 0;
    }
    .form-control,
    .form-select,
    .flatpickr-input {
        border: 1.5px solid var(--line) !important;
        border-radius: var(--radius-sm) !important;
        padding: 0.72rem 0.95rem !important;
        color: var(--text) !important;
        transition: border-color var(--transition), box-shadow var(--transition);
    }
    .form-control:focus,
    .form-select:focus,
    .flatpickr-input:focus {
        border-color: var(--brand) !important;
        box-shadow: 0 0 0 4px rgba(15, 95, 74, 0.12) !important;
    }
    .form-label { color: var(--text); font-weight: 800; }
    .table { border-color: var(--line); }
    .table thead { background: var(--brand-800); color: white; }
    .badge { border-radius: 999px; padding: 0.42rem 0.72rem; }
    .quota-badge { border-radius: 999px; padding: 0.35rem 0.75rem; font-weight: 800; }
    .quota-available { background: #dcfce7; color: #166534; }
    .quota-low { background: #fef3c7; color: #92400e; }
    .quota-full { background: #fee2e2; color: #991b1b; }

    .back-to-top {
        position: fixed;
        right: 1rem;
        bottom: 1rem;
        z-index: 900;
        width: 44px;
        height: 44px;
        border: 0;
        border-radius: 50%;
        background: var(--brand);
        color: white;
        box-shadow: var(--shadow-md);
        display: grid;
        place-items: center;
        opacity: 0;
        transform: translateY(12px);
        pointer-events: none;
        transition: opacity var(--transition), transform var(--transition);
    }
    .back-to-top.show { opacity: 1; transform: translateY(0); pointer-events: auto; }

    .public-action-dock {
        position: fixed;
        right: 1rem;
        bottom: 4.25rem;
        z-index: 910;
        display: grid;
        gap: 0.55rem;
        width: min(260px, calc(100vw - 2rem));
    }
    .dock-link {
        min-height: 52px;
        display: grid;
        grid-template-columns: 40px minmax(0, 1fr);
        align-items: center;
        gap: 0.75rem;
        padding: 0.55rem 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.24);
        border-radius: 14px;
        color: white;
        text-decoration: none;
        background: rgba(8, 50, 41, 0.92);
        box-shadow: 0 16px 40px rgba(8, 50, 41, 0.24);
        backdrop-filter: blur(16px);
        transition: transform var(--transition), box-shadow var(--transition), background var(--transition);
    }
    .dock-link:hover {
        color: white;
        background: var(--brand);
        transform: translateY(-2px);
        box-shadow: 0 20px 48px rgba(8, 50, 41, 0.3);
    }
    .dock-link span:first-child {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: var(--gold);
        color: var(--brand-800);
    }
    .dock-link.smp span:first-child { background: var(--aqua); color: white; }
    .dock-link.whatsapp span:first-child { background: #25d366; color: white; }
    .dock-copy strong {
        display: block;
        font-size: 0.88rem;
        line-height: 1.1;
    }
    .dock-copy small {
        display: block;
        margin-top: 0.18rem;
        color: rgba(255, 255, 255, 0.66);
        font-size: 0.72rem;
        font-weight: 700;
        line-height: 1.25;
    }

    .footer {
        margin-top: 4rem;
        background: #0b2f27;
        color: rgba(255, 255, 255, 0.76);
        position: relative;
        overflow: hidden;
    }
    .footer::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(90deg, rgba(200, 155, 60, 0.16), transparent 34%),
            radial-gradient(circle at 85% 15%, rgba(31, 154, 165, 0.18), transparent 28rem);
        pointer-events: none;
    }
    .footer-inner {
        position: relative;
        padding: 3.5rem 0 1.4rem;
    }
    .footer-grid {
        display: grid;
        grid-template-columns: 1.6fr 0.8fr 0.9fr 1fr;
        gap: 2rem;
    }
    .footer-brand {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    .footer-brand img {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: white;
        padding: 0.35rem;
    }
    .footer-brand strong {
        color: white;
        font-family: var(--ff-display);
        font-size: 1.25rem;
    }
    .footer-brand span { display: block; font-size: 0.78rem; color: rgba(255, 255, 255, 0.52); }
    .footer p { margin: 0; }
    .footer-title {
        color: white;
        font-family: var(--ff-display);
        font-size: 0.98rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }
    .footer-links {
        list-style: none;
        margin: 0;
        padding: 0;
        display: grid;
        gap: 0.65rem;
    }
    .footer-links a,
    .footer-contact {
        display: flex;
        align-items: flex-start;
        gap: 0.55rem;
        color: rgba(255, 255, 255, 0.72);
        text-decoration: none;
        font-size: 0.92rem;
    }
    .footer-links a:hover,
    .footer-contact:hover { color: white; }
    .footer-links i,
    .footer-contact i { color: var(--gold); margin-top: 0.18rem; }
    .footer-hours {
        display: grid;
        gap: 0.55rem;
        font-size: 0.9rem;
    }
    .footer-hours div {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        padding-bottom: 0.55rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    .footer-hours strong { color: white; font-weight: 700; }
    .footer-bottom {
        margin-top: 2rem;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.86rem;
    }

    @media (max-width: 1399.98px) {
        .site-navbar .brand-tagline { display: none; }
    }

    @media (max-width: 991.98px) {
        .navbar-collapse {
            border-top: 1px solid var(--line);
            padding: 0.8rem 0 1rem;
        }
        .navbar-nav { align-items: stretch !important; }
        .btn-nav-cta,
        .btn-nav-danger { width: 100%; margin-top: 0.4rem; }
        .footer-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 575.98px) {
        body.theme-public { padding-bottom: 76px; }
        .brand-tagline { display: none; }
        .brand-mark { width: 42px; height: 42px; }
        .brand-mark.school-logo { width: 34px; height: 34px; }
        .brand-mark.school-logo img { width: 27px; height: 27px; }
        .navbar-brand { gap: 0.55rem; }
        .public-action-dock {
            left: 0.75rem;
            right: 0.75rem;
            bottom: 0.75rem;
            width: auto;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.45rem;
            padding: 0.45rem;
            border: 1px solid rgba(220, 230, 226, 0.92);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.94);
            box-shadow: 0 18px 48px rgba(8, 50, 41, 0.22);
            backdrop-filter: blur(18px);
        }
        .dock-link {
            min-height: 56px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 0.28rem;
            padding: 0.45rem 0.35rem;
            text-align: center;
            color: var(--brand-800);
            background: transparent;
            border: 0;
            box-shadow: none;
        }
        .dock-link:hover { color: var(--brand-800); background: var(--mint); box-shadow: none; }
        .dock-link span:first-child {
            width: 28px;
            height: 28px;
            border-radius: 9px;
            margin: 0 auto;
            font-size: 0.8rem;
        }
        .dock-copy strong { font-size: 0.7rem; }
        .dock-copy small { display: none; }
        .back-to-top { bottom: 5.8rem; }
        .footer-grid { grid-template-columns: 1fr; }
        .footer-bottom { justify-content: center; text-align: center; }
    }
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            scroll-behavior: auto !important;
            transition-duration: 0.01ms !important;
        }
    }
    </style>

    @stack('styles')

    <style>
    :root {
        --brand: #0f5f4a;
        --brand-700: #0b4537;
        --brand-800: #083229;
        --mint: #dff5ee;
        --aqua: #1f9aa5;
        --gold: #c89b3c;
        --gold-light: #f4d890;
        --gold-dark: #9f7629;
        --gold-pale: #fff2cf;
        --forest: var(--brand-800);
        --forest-mid: var(--brand-700);
        --forest-soft: var(--brand);
        --moss: var(--brand);
        --moss-light: #188060;
        --ivory: #f5f8f6;
        --ivory-dark: #dce6e2;
        --cream: #eef6f2;
        --ink: #14201d;
        --text: #263834;
        --text-dark: var(--ink);
        --text-mid: var(--text);
        --text-muted: #687874;
        --line: #dce6e2;
        --surface: #ffffff;
        --paper: #f5f8f6;
        --primary: var(--brand);
        --primary-dark: var(--brand-700);
        --primary-light: #188060;
        --primary-50: var(--mint);
        --secondary: var(--aqua);
        --secondary-dark: #147680;
        --accent: var(--gold);
        --accent-dark: var(--gold-dark);
        --success: #16a34a;
        --success-bg: #dcfce7;
        --success-text: #166534;
        --warning: #d97706;
        --warning-bg: #fef3c7;
        --warning-text: #92400e;
        --danger: #dc2626;
        --danger-bg: #fee2e2;
        --danger-text: #991b1b;
        --info: var(--aqua);
        --info-bg: #e6f8fb;
        --info-text: #155e75;
        --bg-page: var(--paper);
        --bg-card: var(--surface);
        --border: var(--line);
        --border-hover: #b8cbc4;
        --radius: 10px;
        --radius-lg: 16px;
        --radius-xl: 22px;
        --shadow-xs: 0 2px 8px rgba(20, 32, 29, 0.05);
        --shadow-sm: 0 8px 24px rgba(20, 32, 29, 0.08);
        --shadow-md: 0 18px 50px rgba(20, 32, 29, 0.12);
        --shadow-lg: 0 24px 70px rgba(20, 32, 29, 0.16);
        --shadow-gold: 0 16px 34px rgba(200, 155, 60, 0.22);
        --ff-display: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
        --ff-body: 'Inter', 'Segoe UI', system-ui, sans-serif;
        --transition: 180ms ease;
        --transition-smooth: 240ms ease;
    }

    body {
        font-family: var(--ff-body) !important;
        color: var(--text) !important;
        background:
            radial-gradient(circle at 8% 0%, rgba(31, 154, 165, 0.08), transparent 28rem),
            linear-gradient(180deg, #fbfdfc 0%, var(--paper) 46%, #ffffff 100%) !important;
        letter-spacing: 0;
    }

    .site-navbar > .container,
    .footer > .container {
        max-width: 1180px;
    }

    h1, h2, h3, h4, h5, h6,
    .section-title,
    .profile-hero-text h1,
    .contact-hero h1,
    .dashboard-header h4,
    .section-header h5,
    .card-header,
    .login-header h4 {
        font-family: var(--ff-display) !important;
        letter-spacing: 0 !important;
    }

    .theme-admin main {
        min-height: calc(100vh - 74px);
        background:
            radial-gradient(circle at 95% 0%, rgba(31, 154, 165, 0.1), transparent 26rem),
            linear-gradient(180deg, #f8fbfa 0%, #eef5f2 100%);
        padding-bottom: 3rem;
    }

    .theme-admin .site-navbar {
        background: rgba(8, 50, 41, 0.96);
        border-bottom-color: rgba(255, 255, 255, 0.08);
    }
    .theme-admin .site-navbar.scrolled {
        background: rgba(8, 50, 41, 0.98);
        box-shadow: 0 16px 38px rgba(8, 50, 41, 0.18);
    }
    .theme-admin .brand-name,
    .theme-admin .navbar-nav .nav-link,
    .theme-admin .nav-admin-label {
        color: white !important;
    }
    .theme-admin .brand-tagline { color: rgba(255, 255, 255, 0.58); }
    .theme-admin .brand-mark { box-shadow: none; }
    .theme-admin .navbar-nav .nav-link i { color: var(--gold-light); }
    .theme-admin .navbar-nav .nav-link:hover,
    .theme-admin .navbar-nav .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: white !important;
    }

    .admin-shell {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 286px minmax(0, 1fr);
        background:
            radial-gradient(circle at 88% 8%, rgba(31, 154, 165, 0.12), transparent 24rem),
            linear-gradient(180deg, #f8fbfa 0%, #eef5f2 100%);
    }

    .admin-sidebar {
        position: sticky;
        top: 0;
        height: 100vh;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        padding: 1.15rem;
        background:
            radial-gradient(circle at 20% 0%, rgba(200, 155, 60, 0.17), transparent 17rem),
            linear-gradient(180deg, var(--brand-800) 0%, #061f1a 100%);
        color: white;
        border-right: 1px solid rgba(255, 255, 255, 0.08);
        z-index: 1050;
    }

    .admin-sidebar-brand {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        min-height: 58px;
        padding: 0.45rem;
        color: white;
        text-decoration: none;
    }

    .admin-sidebar-brand img {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        object-fit: contain;
        background: white;
        border: 1px solid rgba(255, 255, 255, 0.22);
        padding: 0.25rem;
    }

    .admin-sidebar-brand strong {
        display: block;
        font-family: var(--ff-display);
        font-size: 1.05rem;
        font-weight: 800;
        letter-spacing: 0;
    }

    .admin-sidebar-brand span {
        display: block;
        color: rgba(255, 255, 255, 0.62);
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .admin-sidebar-context {
        padding: 0.85rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.07);
    }

    .admin-context-label {
        color: rgba(255, 255, 255, 0.55);
        font-size: 0.68rem;
        font-weight: 900;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .admin-context-title {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        margin-top: 0.35rem;
        font-family: var(--ff-display);
        font-size: 1rem;
        font-weight: 800;
    }

    .admin-sidebar-nav {
        display: grid;
        gap: 0.35rem;
    }

    .admin-nav-group {
        margin: 0.6rem 0 0.25rem;
        padding: 0 0.7rem;
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.68rem;
        font-weight: 900;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .admin-nav-link {
        min-height: 44px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.72rem 0.8rem;
        color: rgba(255, 255, 255, 0.78);
        text-decoration: none;
        border-radius: 12px;
        font-weight: 800;
        transition: background var(--transition), color var(--transition), transform var(--transition);
    }

    .admin-nav-link i {
        width: 1.15rem;
        color: var(--gold);
        text-align: center;
    }

    .admin-nav-link:hover,
    .admin-nav-link.active {
        color: white;
        background: rgba(255, 255, 255, 0.11);
        transform: translateX(2px);
    }

    .admin-sidebar-footer {
        margin-top: auto;
        display: grid;
        gap: 0.65rem;
    }

    .admin-user-mini {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.75rem;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.07);
    }

    .admin-user-avatar {
        width: 38px;
        height: 38px;
        flex: 0 0 auto;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: var(--gold-soft);
        color: var(--brand-800);
        font-weight: 900;
    }

    .admin-user-mini strong {
        display: block;
        color: white;
        font-size: 0.86rem;
        line-height: 1.1;
    }

    .admin-user-mini span {
        display: block;
        color: rgba(255, 255, 255, 0.55);
        font-size: 0.72rem;
        font-weight: 700;
    }

    .admin-logout-link {
        min-height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        color: #ffe4e6;
        background: rgba(220, 38, 38, 0.15);
        border: 1px solid rgba(254, 202, 202, 0.16);
        border-radius: 12px;
        text-decoration: none;
        font-weight: 900;
    }

    .admin-main {
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .admin-topbar {
        position: sticky;
        top: 0;
        z-index: 950;
        min-height: 74px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 0.95rem clamp(1rem, 2vw, 1.6rem);
        background: rgba(248, 251, 250, 0.88);
        border-bottom: 1px solid rgba(220, 230, 226, 0.9);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    .admin-topbar-title {
        min-width: 0;
    }

    .admin-topbar-kicker {
        color: var(--muted);
        font-size: 0.72rem;
        font-weight: 900;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .admin-topbar-title h1 {
        margin: 0.12rem 0 0;
        color: var(--ink);
        font-size: clamp(1.05rem, 2vw, 1.35rem);
        font-weight: 900;
        line-height: 1.2;
    }

    .admin-topbar-actions {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        flex: 0 0 auto;
    }

    .admin-icon-button,
    .admin-topbar-link {
        min-width: 42px;
        min-height: 42px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: 1px solid var(--line);
        background: white;
        color: var(--brand-800);
        text-decoration: none;
        font-weight: 900;
        box-shadow: 0 8px 20px rgba(20, 32, 29, 0.06);
    }

    .admin-icon-button {
        display: none;
        cursor: pointer;
    }

    .admin-topbar-link span {
        display: inline-block;
    }

    .admin-content {
        flex: 1;
        min-width: 0;
        padding: clamp(1rem, 2vw, 1.6rem);
    }

    .admin-content .dashboard-wrapper,
    .admin-content > .container,
    .admin-content > .container-fluid {
        max-width: none !important;
        padding: 0 !important;
    }

    .admin-content .flash-shell {
        padding: 0 0 1rem !important;
    }

    .admin-sidebar-overlay {
        display: none;
    }

    .dashboard-wrapper,
    .theme-admin .container-fluid {
        max-width: 1440px !important;
        margin: 0 auto !important;
        padding: clamp(1rem, 3vw, 2rem) !important;
    }

    .dashboard-header,
    .profile-hero,
    .contact-hero,
    .login-header,
    .form-header,
    .card-header-yapisda,
    .modal-header,
    .qr-modal .modal-header,
    .theme-admin .card.bg-primary,
    .theme-admin .bg-primary {
        background:
            radial-gradient(circle at 92% 10%, rgba(31, 154, 165, 0.24), transparent 15rem),
            linear-gradient(135deg, var(--brand-800), var(--brand)) !important;
        color: white !important;
        border-color: rgba(255, 255, 255, 0.12) !important;
    }

    .section-card,
    .profile-section,
    .vision-card,
    .contact-card,
    .form-card,
    .login-card,
    .map-card,
    .schedule-card,
    .theme-admin .card,
    .card {
        border: 1px solid var(--line) !important;
        border-radius: var(--radius-lg) !important;
        background: var(--surface) !important;
        box-shadow: var(--shadow-sm) !important;
    }

    .dashboard-header,
    .login-header,
    .profile-hero,
    .contact-hero,
    .form-header {
        box-shadow: var(--shadow-md) !important;
    }

    .section-header,
    .map-header,
    .schedule-header,
    .form-header:not(.login-header),
    .theme-admin .card-header,
    .card-header {
        border-bottom: 1px solid var(--line) !important;
    }

    .section-header,
    .map-header,
    .schedule-header,
    .theme-admin .card-header:not(.bg-primary):not([class*="text-white"]) {
        background: linear-gradient(180deg, #ffffff, #f7fbf9) !important;
        color: var(--ink) !important;
    }

    .section-header h5,
    .card-header h4,
    .card-header h5,
    .section-header h3,
    .map-header h3,
    .schedule-header h3,
    .form-header h3 {
        color: inherit !important;
    }

    .stat-card,
    .summary-card,
    .facility-card,
    .value-card,
    .mission-card,
    .goal-card,
    .quota-card,
    .contact-item,
    .info-box,
    .location-item {
        border-color: var(--line) !important;
        border-radius: var(--radius-lg) !important;
        box-shadow: var(--shadow-xs) !important;
    }

    .stat-icon,
    .facility-icon,
    .value-icon,
    .contact-icon,
    .info-icon,
    .location-icon,
    .flow-icon-wrap {
        background: var(--mint) !important;
        color: var(--brand) !important;
        border-radius: 12px !important;
    }

    .stat-value,
    .summary-value,
    .profile-stat-value,
    .mission-title,
    .value-name,
    .facility-name,
    .unit-name,
    .section-title,
    .profile-section h3,
    .vision-card h4,
    .contact-card h3 {
        color: var(--ink) !important;
    }

    .text-primary,
    .theme-admin .text-primary,
    a.unit-link,
    .contact-value a,
    .login-footer a {
        color: var(--brand) !important;
    }
    .text-success { color: var(--success) !important; }
    .text-warning { color: var(--warning) !important; }
    .text-danger { color: var(--danger) !important; }
    .bg-success { background-color: var(--success) !important; }
    .bg-warning { background-color: var(--warning-bg) !important; color: var(--warning-text) !important; }
    .bg-danger { background-color: var(--danger) !important; }
    .bg-info { background-color: var(--info) !important; }

    .btn,
    .search-btn,
    .qr-scan-btn,
    .btn-submit,
    .btn-login,
    .action-btn,
    .program-link,
    .unit-link,
    .back-btn-minimal {
        border-radius: var(--radius) !important;
        font-family: var(--ff-body) !important;
        font-weight: 800 !important;
        letter-spacing: 0 !important;
        box-shadow: none;
    }

    .btn-primary,
    .btn-success,
    .search-btn,
    .btn-submit,
    .btn-login,
    .action-btn.export,
    .program-link.main,
    .unit-link:hover {
        background: var(--brand) !important;
        border-color: var(--brand) !important;
        color: white !important;
    }
    .btn-primary:hover,
    .btn-success:hover,
    .search-btn:hover,
    .btn-submit:hover,
    .btn-login:hover {
        background: var(--brand-700) !important;
        border-color: var(--brand-700) !important;
        transform: translateY(-1px);
    }
    .btn-warning,
    .qr-scan-btn,
    .action-icon-btn.edit {
        background: var(--gold) !important;
        border-color: var(--gold) !important;
        color: var(--brand-800) !important;
    }
    .btn-secondary,
    .action-btn.print {
        background: white !important;
        border: 1px solid var(--line) !important;
        color: var(--text) !important;
    }
    .btn-danger,
    .action-icon-btn.delete {
        background: var(--danger) !important;
        border-color: var(--danger) !important;
        color: white !important;
    }

    .action-icon-btn,
    .btn-action {
        min-width: 34px !important;
        min-height: 34px !important;
        border-radius: 9px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0.45rem !important;
    }
    .action-icon-btn.view,
    .btn-action.btn-primary { background: var(--brand) !important; border-color: var(--brand) !important; }
    .action-icon-btn.detail,
    .btn-action.btn-info { background: var(--aqua) !important; border-color: var(--aqua) !important; color: white !important; }
    .action-icon-btn.verify,
    .btn-action.btn-success { background: var(--success) !important; border-color: var(--success) !important; }
    .action-icon-btn.reject,
    .btn-action.btn-secondary { background: #64748b !important; border-color: #64748b !important; color: white !important; }

    .form-control,
    .form-select,
    .search-input,
    .search-select,
    .form-textarea,
    .flatpickr-input,
    input[type="text"],
    input[type="password"],
    input[type="email"],
    input[type="tel"],
    textarea,
    select {
        border-color: var(--line) !important;
        border-radius: var(--radius) !important;
        font-family: var(--ff-body) !important;
    }
    .form-control:focus,
    .form-select:focus,
    .search-input:focus,
    .search-select:focus,
    .form-textarea:focus,
    .flatpickr-input:focus,
    input:focus,
    textarea:focus,
    select:focus {
        border-color: var(--brand) !important;
        box-shadow: 0 0 0 4px rgba(15, 95, 74, 0.12) !important;
        outline: none !important;
    }
    .input-group,
    .file-upload-wrapper,
    .toggle-fields {
        border-color: var(--line) !important;
        border-radius: var(--radius-lg) !important;
        background: #f8fbfa !important;
    }
    .input-group-text {
        background: var(--mint) !important;
        color: var(--brand) !important;
        border-color: var(--line) !important;
    }

    .table,
    .data-table {
        color: var(--text) !important;
        border-color: var(--line) !important;
    }
    .table thead,
    .table thead.table-primary,
    .table thead.table-light,
    .data-table thead th {
        background: var(--brand-800) !important;
        color: white !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
    .table tbody tr:hover,
    .data-table tbody tr:hover {
        background: rgba(15, 95, 74, 0.055) !important;
    }
    .reg-number,
    .badge,
    .status-badge,
    .quota-badge,
    .section-badge {
        border-radius: 999px !important;
        font-weight: 800 !important;
    }
    .reg-number,
    .status-badge.verified,
    .quota-badge.available {
        background: var(--mint) !important;
        color: var(--brand) !important;
    }
    .status-badge.pending,
    .quota-badge.low {
        background: var(--warning-bg) !important;
        color: var(--warning-text) !important;
    }
    .status-badge.rejected,
    .quota-badge.full {
        background: var(--danger-bg) !important;
        color: var(--danger-text) !important;
    }
    .progress,
    .progress-bar {
        border-radius: 999px !important;
        overflow: hidden;
    }
    .progress-fill.available,
    .progress-bar.bg-success,
    .progress-bar {
        background: linear-gradient(90deg, var(--brand), var(--aqua)) !important;
    }

    .alert {
        border: 1px solid var(--line) !important;
        border-left: 4px solid var(--brand) !important;
        border-radius: var(--radius-lg) !important;
        box-shadow: none !important;
    }
    .alert-info {
        background: #e6f8fb !important;
        color: #155e75 !important;
        border-left-color: var(--aqua) !important;
    }
    .alert-warning {
        background: var(--gold-pale) !important;
        color: var(--gold-dark) !important;
        border-left-color: var(--gold) !important;
    }
    .alert-success {
        background: var(--mint) !important;
        color: var(--brand) !important;
        border-left-color: var(--brand) !important;
    }
    .alert-danger {
        background: var(--danger-bg) !important;
        color: var(--danger-text) !important;
        border-left-color: var(--danger) !important;
    }

    .border-left-primary,
    .border-left-success,
    .border-left-warning,
    .border-left-danger {
        border-left-width: 4px !important;
        border-left-style: solid !important;
    }
    .border-left-primary { border-left-color: var(--brand) !important; }
    .border-left-success { border-left-color: var(--success) !important; }
    .border-left-warning { border-left-color: var(--gold) !important; }
    .border-left-danger { border-left-color: var(--danger) !important; }
    .btn-scan-qr,
    .scan-qr-container {
        border-color: rgba(15, 95, 74, 0.24) !important;
    }
    .btn-scan-qr {
        background: var(--brand) !important;
        color: white !important;
        box-shadow: 0 14px 30px rgba(15, 95, 74, 0.22) !important;
    }
    .scan-qr-container {
        background: rgba(15, 95, 74, 0.06) !important;
    }

    .pagination .page-link {
        border-color: var(--line) !important;
        color: var(--brand) !important;
        border-radius: 9px !important;
        font-weight: 800 !important;
    }
    .pagination .active .page-link,
    .pagination .page-item.active .page-link {
        background: var(--brand) !important;
        border-color: var(--brand) !important;
        color: white !important;
    }

    /* === UX unifier: keeps legacy page CSS inside the current YAPISDA theme === */
    .theme-public main {
        background:
            radial-gradient(circle at 96% 4%, rgba(31, 154, 165, 0.08), transparent 26rem),
            linear-gradient(180deg, #fbfdfc 0%, var(--paper) 44%, #ffffff 100%);
    }

    .theme-public main > .container,
    .theme-public .form-wrapper,
    .theme-public .vision-wrapper,
    .theme-public .status-wrapper,
    .theme-public .announcement-wrapper {
        padding-top: clamp(1.25rem, 3vw, 2.2rem);
    }

    .theme-public :is(.vision-card, .profile-card, .contact-card, .info-card, .students-card, .status-card, .form-card, .card, .quota-card, .mission-card, .goal-card, .value-card) {
        border-color: var(--line) !important;
        border-radius: var(--radius-lg) !important;
        box-shadow: var(--shadow-sm) !important;
    }

    .theme-public :is(.vision-card, .profile-card, .contact-card, .info-card, .students-card, .status-card, .form-card, .card, .quota-card, .mission-card, .goal-card, .value-card):hover {
        box-shadow: var(--shadow-md) !important;
    }

    .theme-public :is(.card-header, .form-header, .card-header-yapisda, .students-card .card-header) {
        background:
            radial-gradient(circle at 90% 0%, rgba(31, 154, 165, 0.18), transparent 10rem),
            linear-gradient(135deg, var(--brand-800), var(--brand)) !important;
        color: white !important;
        border-bottom: 0 !important;
    }

    .theme-public :is(.form-header, .card-header-yapisda, .students-card .card-header)::after {
        background: var(--gold) !important;
    }

    .theme-public :is(.quota-card, .mission-card, .goal-card, .value-card)::before {
        background: linear-gradient(90deg, var(--brand), var(--aqua), var(--gold)) !important;
    }

    .theme-public :is(.form-section-title, .mission-title, .goal-title, .value-name, .vision-quote, .quota-card h6) {
        color: var(--brand-800) !important;
        font-family: var(--ff-display) !important;
        letter-spacing: 0 !important;
    }

    .theme-public :is(.alert-custom, .error-summary, .alert) {
        border-radius: var(--radius-lg) !important;
    }

    .theme-public :is(.form-wrapper, .vision-wrapper) .btn-submit,
    .theme-public :is(.btn-submit, .btn-primary, .program-link.main) {
        text-transform: none !important;
        letter-spacing: 0 !important;
    }

    .theme-public :is(input, select, textarea, .form-control, .form-select) {
        min-height: 42px;
    }

    .theme-public .table-responsive,
    .theme-public .table-container {
        border-radius: var(--radius-lg);
        border: 1px solid var(--line);
    }

    .theme-public .table-responsive .table {
        margin-bottom: 0;
    }

    .theme-public .table thead th {
        font-size: 0.74rem;
        font-weight: 900;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .theme-public .table td {
        vertical-align: middle;
    }

    @media (max-width: 767.98px) {
        .admin-shell {
            display: block;
        }

        .admin-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: min(84vw, 306px);
            transform: translateX(-100%);
            transition: transform var(--transition);
        }

        body.admin-sidebar-open .admin-sidebar {
            transform: translateX(0);
        }

        .admin-sidebar-overlay {
            position: fixed;
            inset: 0;
            display: block;
            z-index: 1040;
            background: rgba(6, 31, 26, 0.46);
            opacity: 0;
            pointer-events: none;
            transition: opacity var(--transition);
        }

        body.admin-sidebar-open .admin-sidebar-overlay {
            opacity: 1;
            pointer-events: auto;
        }

        .admin-icon-button {
            display: inline-flex;
        }

        .admin-topbar-link span {
            display: none;
        }

        .dashboard-wrapper,
        .theme-admin .container-fluid {
            padding: 1rem !important;
        }
        .dashboard-header,
        .section-header,
        .search-bar,
        .action-bar {
            align-items: stretch !important;
        }
        .search-form {
            grid-template-columns: 1fr !important;
            min-width: 100% !important;
        }
    }

    @media print {
        .site-navbar, .footer, .back-to-top, .navbar, #mainNavbar, #backToTop {
            display: none !important;
        }
        body {
            background: white !important;
        }
    }
    </style>
</head>
<body class="{{ request()->routeIs('admin.*') ? 'theme-admin' : 'theme-public' }} @hasSection('admin_shell') has-admin-sidebar @endif">
@php
    $isAdminLogin = request()->routeIs('admin.login', 'admin.login.post', 'admin.smp.login', 'admin.smp.login.post', 'admin.finance.login', 'admin.finance.login.post', 'admin.operations.login', 'admin.operations.login.post');
    $isFinanceAdmin = request()->routeIs('admin.finance.*') && !$isAdminLogin;
    $isSmpAdmin = request()->routeIs('admin.smp.*') && !$isAdminLogin;
    $isSmkAdmin = request()->routeIs('admin.*') && !request()->routeIs('admin.smp.*') && !request()->routeIs('admin.finance.*') && !$isAdminLogin;
    $isPublic = !$isAdminLogin && !$isSmpAdmin && !$isSmkAdmin && !$isFinanceAdmin;
@endphp

<button class="back-to-top" id="backToTop" aria-label="Kembali ke atas">
    <i class="fas fa-arrow-up"></i>
</button>

@hasSection('admin_shell')
@else
<nav class="navbar navbar-expand-lg site-navbar" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}" aria-label="YAPISDA Beranda">
            <span class="brand-logo-row" aria-hidden="true">
                <span class="brand-mark">
                    <img src="{{ asset('images/logo-yapisda.svg') }}" alt="Logo YAPISDA">
                </span>
                <span class="brand-mark school-logo">
                    <img src="{{ asset('images/LOGO SMPS YAPISDA.svg') }}" alt="Logo SMPS YAPISDA">
                </span>
            </span>
            <span class="brand-copy">
                <span class="brand-name">YAPISDA</span>
                <span class="brand-tagline">Yayasan Pendidikan Islam Daar El Rohmah</span>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-menu-icon"><i class="fas fa-bars"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            @if($isPublic)
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <i class="fas fa-building-columns"></i> Profil
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-compass"></i> Info PPDB
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}#programs">
                                <i class="fas fa-layer-group text-success"></i> Program Pendidikan
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}#alur-pendaftaran">
                                <i class="fas fa-route text-primary"></i> Alur Pendaftaran
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}#checklist">
                                <i class="fas fa-clipboard-check text-warning"></i> Checklist Berkas
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}#faq">
                                <i class="fas fa-circle-question text-success"></i> Informasi Daftar Ulang
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vision') ? 'active' : '' }}" href="{{ route('vision') }}">
                        <i class="fas fa-bullseye"></i> Visi & Misi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                        <i class="fas fa-phone"></i> Kontak
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-graduate"></i> Pendaftaran
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('registration.form') }}">
                                <i class="fas fa-industry text-success"></i> Daftar SMKS
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('registration.smp-form') }}">
                                <i class="fas fa-school text-primary"></i> Daftar SMPS
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('reenrollment.status') }}">
                                <i class="fas fa-id-card text-success"></i> Status Administrasi
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('contact') }}">
                                <i class="fab fa-whatsapp" style="color: var(--success);"></i> Tanya PPDB
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item ms-lg-2">
                    <a href="{{ route('home') }}#programs" class="btn-nav-cta">
                        <i class="fas fa-arrow-right"></i> Pilih Program
                    </a>
                </li>
            </ul>
            @elseif($isSmkAdmin)
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><span class="nav-link nav-admin-label"><i class="fas fa-industry"></i> Admin SMKS</span></li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.export.excel') }}"><i class="fas fa-file-excel"></i> Export Excel</a>
                </li>
                <li class="nav-item ms-lg-2">
                    <a class="btn-nav-danger" href="{{ route('admin.logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
            @elseif($isSmpAdmin)
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><span class="nav-link nav-admin-label"><i class="fas fa-school"></i> Admin SMPS</span></li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.smp.dashboard') ? 'active' : '' }}" href="{{ route('admin.smp.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.smp.export.excel') }}"><i class="fas fa-file-excel"></i> Export Excel</a>
                </li>
                <li class="nav-item ms-lg-2">
                    <a class="btn-nav-danger" href="{{ route('admin.smp.logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
            @endif
        </div>
    </div>
</nav>
@endif

<main>
    @if(session('success'))
    <div class="container flash-shell">
        <div class="flash-alert flash-success alert-dismissible fade show" role="alert">
            <span class="flash-icon"><i class="fas fa-check"></i></span>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container flash-shell">
        <div class="flash-alert flash-error alert-dismissible fade show" role="alert">
            <span class="flash-icon"><i class="fas fa-exclamation"></i></span>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @yield('content')
</main>

@if($isPublic && !request()->routeIs('home'))
<div class="public-action-dock" aria-label="Akses cepat publik">
    <a href="{{ route('registration.form') }}" class="dock-link">
        <span><i class="fas fa-industry"></i></span>
        <span class="dock-copy"><strong>Daftar SMKS</strong><small>6 jurusan kejuruan</small></span>
    </a>
    <a href="{{ route('registration.smp-form') }}" class="dock-link smp">
        <span><i class="fas fa-school"></i></span>
        <span class="dock-copy"><strong>Daftar SMPS</strong><small>Reguler dan boarding</small></span>
    </a>
    <a href="https://wa.me/628128906113" target="_blank" rel="noopener" class="dock-link whatsapp">
        <span><i class="fab fa-whatsapp"></i></span>
        <span class="dock-copy"><strong>Butuh Bantuan?</strong><small>Chat panitia PPDB</small></span>
    </a>
</div>
@endif

@if($isPublic)
<footer class="footer">
    <div class="container footer-inner">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">
                    <img src="{{ asset('images/logo-yapisda.svg') }}" alt="Logo YAPISDA">
                    <div>
                        <strong>YAPISDA</strong>
                        <span>Yayasan Pendidikan Islam Daar El Rohmah</span>
                    </div>
                </div>
                <p>Lingkungan belajar Islami untuk membangun karakter, kompetensi, dan kesiapan masa depan siswa.</p>
            </div>
            <div>
                <h4 class="footer-title">Navigasi</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right"></i> Beranda</a></li>
                    <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right"></i> Profil Sekolah</a></li>
                    <li><a href="{{ route('home') }}#programs"><i class="fas fa-chevron-right"></i> Program PPDB</a></li>
                    <li><a href="{{ route('home') }}#faq"><i class="fas fa-chevron-right"></i> FAQ Publik</a></li>
                    <li><a href="{{ route('vision') }}"><i class="fas fa-chevron-right"></i> Visi & Misi</a></li>
                    <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right"></i> Kontak</a></li>
                </ul>
            </div>
            <div>
                <h4 class="footer-title">Pendaftaran</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('registration.form') }}"><i class="fas fa-industry"></i> PPDB SMKS</a></li>
                    <li><a href="{{ route('registration.smp-form') }}"><i class="fas fa-school"></i> PPDB SMPS</a></li>
                    <li><a href="{{ route('reenrollment.status') }}"><i class="fas fa-id-card"></i> Status Administrasi</a></li>
                    <li><a href="{{ route('contact') }}"><i class="fab fa-whatsapp"></i> Konsultasi PPDB</a></li>
                </ul>
            </div>
            <div>
                <h4 class="footer-title">Kontak</h4>
                <a class="footer-contact" href="https://maps.google.com/?q=SMK%20Yapisda%20Cisoka" target="_blank" rel="noopener">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Jl. Raya Cisoka - Tigaraksa, Kp. Saga, Desa Caringin, Kecamatan Cisoka, Kabupaten Tangerang, Provinsi Banten 15730</span>
                </a>
                <a class="footer-contact mt-2" href="tel:02159751260"><i class="fas fa-phone"></i><span>(021) 59751260</span></a>
                <a class="footer-contact mt-2" href="https://wa.me/628128906113" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i><span>0812-8906-113</span></a>
                <div class="footer-hours mt-3">
                    <div><span>Senin - Jumat</span><strong>07.00 - 16.00</strong></div>
                    <div><span>Sabtu</span><strong>07.00 - 12.00</strong></div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} YAPISDA. All rights reserved.</span>
            <span>SPMB SMPS dan SMKS YAPISDA</span>
        </div>
    </div>
</footer>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script>
const navbar = document.getElementById('mainNavbar');
const backToTop = document.getElementById('backToTop');

function updateChrome() {
    const scrolled = window.scrollY > 24;
    navbar?.classList.toggle('scrolled', scrolled);
    backToTop?.classList.toggle('show', window.scrollY > 420);
}

window.addEventListener('scroll', updateChrome, { passive: true });
updateChrome();
backToTop?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.flash-alert').forEach((el) => {
        setTimeout(() => {
            try { bootstrap.Alert.getOrCreateInstance(el).close(); } catch (error) {}
        }, 5000);
    });
});
</script>

@stack('scripts')
</body>
</html>
