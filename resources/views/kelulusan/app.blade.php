<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'YAPISDA - Sistem Penerimaan Murid Baru')</title>

    <!-- SEO Meta -->
    <meta name="description" content="@yield('meta_description', 'YAPISDA - Yayasan Pendidikan Islam Daar El Rohmah')">
    <meta property="og:title"       content="@yield('og_title', 'YAPISDA')">
    <meta property="og:description" content="@yield('og_description', '')">
    <meta property="og:image"       content="@yield('og_image', '')">
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('twitter_title', 'YAPISDA')">
    <meta name="twitter:description" content="@yield('twitter_description', '')">
    <meta name="twitter:image"       content="@yield('twitter_image', '')">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts: Playfair Display + DM Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,800;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">

    <style>
    /* ════════════════════════════════════════
       YAPISDA LAYOUT — Islamic Modern Luxury
       Palette: Forest Green × Warm Gold × Ivory
       Font: Playfair Display + DM Sans
    ════════════════════════════════════════ */

    :root {
        --gold:        #C9A84C;
        --gold-light:  #E8C97A;
        --gold-dark:   #A07830;
        --gold-pale:   #F5EDD8;
        --forest:      #0D2118;
        --forest-mid:  #163328;
        --forest-soft: #1E4535;
        --moss:        #2E6B4F;
        --moss-light:  #3D8B67;
        --ivory:       #FAF7F0;
        --ivory-dark:  #EDE8DC;
        --cream:       #F0EAD6;
        --text-dark:   #1A1208;
        --text-mid:    #4A3F28;
        --text-muted:  #8A7A58;
        --white:       #ffffff;

        /* Legacy aliases so child views still work */
        --primary:       #2E6B4F;
        --primary-dark:  #1E4535;
        --primary-light: #3D8B67;
        --secondary:     var(--moss-light);
        --secondary-dark:var(--moss);
        --accent:        var(--gold);
        --accent-dark:   var(--gold-dark);
        --danger:        #dc2626;
        --dark:          var(--forest);
        --dark-800:      var(--forest-mid);
        --dark-900:      var(--forest);
        --light:         var(--ivory);
        --gray:          var(--text-muted);
        --gray-100:      var(--ivory);
        --gray-200:      var(--ivory-dark);
        --gray-300:      #D8D0BE;

        --ff-display: 'Playfair Display', Georgia, serif;
        --ff-body:    'DM Sans', 'Segoe UI', sans-serif;

        --r-sm:   8px;
        --r-md:  14px;
        --r-lg:  20px;
        --r-xl:  28px;
        --r-pill:9999px;

        --ease-expo: cubic-bezier(0.16, 1, 0.3, 1);
        --ease-back: cubic-bezier(0.34, 1.56, 0.64, 1);

        --shadow-sm: 0 2px 8px rgba(0,0,0,0.07);
        --shadow-md: 0 6px 20px rgba(0,0,0,0.10);
        --shadow-lg: 0 12px 36px rgba(0,0,0,0.14);
        --shadow-xl: 0 24px 60px rgba(0,0,0,0.18);
        --shadow-gold: 0 8px 30px rgba(201,168,76,0.22);

        --transition: all 0.35s var(--ease-expo);
        --transition-fast: all 0.2s ease;
    }

    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
    html { scroll-behavior:smooth; scroll-padding-top:80px; }

    body {
        font-family: var(--ff-body);
        background: var(--ivory);
        color: var(--text-dark);
        line-height:1.7;
        overflow-x:hidden;
        -webkit-font-smoothing:antialiased;
    }

    /* ──────────────────────────────
       LOADING OVERLAY
    ────────────────────────────── */
    .loading-overlay {
        position:fixed; inset:0;
        background: var(--forest);
        display:flex; flex-direction:column;
        justify-content:center; align-items:center; gap:1rem;
        z-index:9999;
        opacity:0; visibility:hidden;
        transition: opacity 0.5s ease, visibility 0.5s;
    }
    .loading-overlay.active { opacity:1; visibility:visible; }

    .loading-ring {
        width:54px; height:54px; position:relative;
    }
    .loading-ring-track {
        position:absolute; inset:0; border-radius:50%;
        border:3px solid rgba(201,168,76,0.15);
    }
    .loading-ring-spin {
        position:absolute; inset:0; border-radius:50%;
        border:3px solid transparent;
        border-top-color: var(--gold-light);
        border-right-color: var(--gold);
        animation: spin 1s linear infinite;
    }
    @keyframes spin { to { transform:rotate(360deg); } }

    .loading-label {
        font-family: var(--ff-display);
        color: var(--gold-light);
        font-size:0.8rem;
        letter-spacing:0.2em;
        text-transform:uppercase;
        opacity:0.8;
    }

    /* ──────────────────────────────
       NAVBAR
    ────────────────────────────── */
    .navbar {
        background: var(--forest);
        padding:0;
        position:sticky; top:0; z-index:1000;
        border-bottom:1px solid rgba(201,168,76,0.12);
        transition: var(--transition);
    }

    /* Gold line top accent */
    .navbar::before {
        content:'';
        display:block; height:2px;
        background: linear-gradient(90deg, transparent 5%, var(--gold-dark) 30%, var(--gold-light) 50%, var(--gold-dark) 70%, transparent 95%);
    }

    .navbar.scrolled {
        background: rgba(13,33,24,0.97);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        box-shadow: 0 4px 30px rgba(0,0,0,0.3);
    }

    .navbar .container {
        max-width:1240px;
        display:flex; align-items:stretch;
    }

    /* Brand */
    .navbar-brand {
        display:flex; align-items:center; gap:0.75rem;
        padding:0.85rem 0;
        text-decoration:none;
        transition: var(--transition);
    }
    .brand-icon {
        width:42px; height:42px; border-radius:var(--r-md);
        background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
        display:flex; align-items:center; justify-content:center;
        font-size:1.1rem; color:white;
        flex-shrink:0;
        box-shadow: var(--shadow-gold);
        transition: transform 0.4s var(--ease-back);
    }
    .navbar-brand:hover .brand-icon { transform: scale(1.08) rotate(-5deg); }

    .brand-text { display:flex; flex-direction:column; line-height:1.2; }
    .brand-name {
        font-family: var(--ff-display);
        font-size:1.3rem; font-weight:800;
        color:white; letter-spacing:-0.01em;
    }
    .brand-tagline {
        font-size:0.65rem; color:rgba(255,255,255,0.45);
        letter-spacing:0.05em; text-transform:uppercase;
        font-weight:400;
    }

    /* Toggler */
    .navbar-toggler {
        border:1px solid rgba(201,168,76,0.3);
        border-radius:var(--r-sm);
        padding:0.4rem 0.65rem;
        transition: var(--transition-fast);
    }
    .navbar-toggler:hover { border-color:var(--gold-light); }
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(201,168,76,0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
    .navbar-toggler:focus { box-shadow:none; }

    /* Nav Links */
    .navbar-nav { gap:0.1rem; }

    .navbar-nav .nav-link {
        color: rgba(255,255,255,0.7) !important;
        font-weight:500; font-size:0.9rem;
        padding:0.65rem 1rem !important;
        border-radius:var(--r-sm);
        transition: var(--transition);
        display:flex; align-items:center; gap:0.45rem;
        position:relative; white-space:nowrap;
    }
    .navbar-nav .nav-link i { font-size:0.85rem; opacity:0.8; }
    .navbar-nav .nav-link:hover {
        color:white !important;
        background:rgba(201,168,76,0.08);
    }
    .navbar-nav .nav-link.active {
        color: var(--gold-light) !important;
        background:rgba(201,168,76,0.1);
    }
    .navbar-nav .nav-link.active i { opacity:1; color:var(--gold-light); }

    /* Admin label */
    .nav-admin-label {
        display:flex; align-items:center; gap:0.5rem;
        padding:0.5rem 1rem;
        font-size:0.78rem; font-weight:700;
        color: var(--gold-dark) !important;
        letter-spacing:0.12em; text-transform:uppercase;
        opacity:1 !important;
    }

    /* Dropdown */
    .navbar-nav .dropdown-menu {
        background: var(--forest-mid);
        border:1px solid rgba(201,168,76,0.2);
        border-radius:var(--r-lg);
        padding:0.6rem;
        margin-top:0.5rem !important;
        box-shadow: 0 20px 50px rgba(0,0,0,0.35);
        min-width:200px;
    }
    .dropdown-item {
        color:rgba(255,255,255,0.75);
        font-size:0.9rem; font-weight:500;
        padding:0.65rem 1rem;
        border-radius:var(--r-sm);
        display:flex; align-items:center; gap:0.6rem;
        transition: var(--transition-fast);
        text-decoration:none;
    }
    .dropdown-item:hover, .dropdown-item:focus {
        background:rgba(201,168,76,0.1);
        color:white;
        transform:translateX(4px);
    }
    .dropdown-item i { width:16px; font-size:0.85rem; }
    .dropdown-item .text-primary { color:var(--gold-light) !important; }
    .dropdown-item .text-success { color:#7ecca0 !important; }
    .dropdown-divider { border-color:rgba(255,255,255,0.07); margin:0.4rem 0; }

    /* Register CTA button in nav */
    .btn-nav-cta {
        display:inline-flex; align-items:center; gap:0.5rem;
        padding:0.6rem 1.4rem;
        background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
        color: var(--forest) !important;
        font-weight:700; font-size:0.88rem;
        border-radius:var(--r-sm);
        text-decoration:none;
        transition: var(--transition);
        box-shadow: var(--shadow-gold);
        border:none; cursor:pointer;
        white-space:nowrap;
    }
    .btn-nav-cta:hover {
        transform:translateY(-2px);
        box-shadow:0 12px 35px rgba(201,168,76,0.4);
        color: var(--forest) !important;
    }

    /* Logout danger */
    .btn-nav-danger {
        display:inline-flex; align-items:center; gap:0.5rem;
        padding:0.55rem 1.2rem;
        background:rgba(220,38,38,0.12);
        color:#fca5a5 !important;
        font-weight:600; font-size:0.88rem;
        border-radius:var(--r-sm);
        text-decoration:none; border:1px solid rgba(220,38,38,0.25);
        transition: var(--transition);
    }
    .btn-nav-danger:hover {
        background:rgba(220,38,38,0.22);
        color:white !important;
        border-color:rgba(220,38,38,0.5);
    }

    /* ──────────────────────────────
       ALERTS (session flash)
    ────────────────────────────── */
    .flash-alert {
        display:flex; align-items:center; gap:1rem;
        padding:1rem 1.5rem;
        border-radius:var(--r-lg);
        margin-bottom:1.5rem;
        font-weight:500; font-size:0.95rem;
        animation: slideDown 0.4s var(--ease-expo);
        border:none;
    }
    @keyframes slideDown {
        from { opacity:0; transform:translateY(-16px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .flash-success {
        background:#e8f5ef;
        color:#1a5c36;
        border-left:4px solid #3D8B67;
    }
    .flash-error {
        background:#fee2e2;
        color:#991b1b;
        border-left:4px solid #dc2626;
    }
    .flash-alert .flash-icon {
        width:36px; height:36px; border-radius:50%; flex-shrink:0;
        display:flex; align-items:center; justify-content:center; font-size:1rem;
    }
    .flash-success .flash-icon { background:#d1fae5; color:#059669; }
    .flash-error   .flash-icon { background:#fee2e2; color:#dc2626; }
    .flash-alert .btn-close { margin-left:auto; opacity:0.5; }

    /* ──────────────────────────────
       MAIN
    ────────────────────────────── */
    main { min-height:calc(100vh - 80px); }

    /* ──────────────────────────────
       CARDS (global override for inner pages)
    ────────────────────────────── */
    .card {
        border:1px solid var(--ivory-dark);
        border-radius:var(--r-xl);
        box-shadow:var(--shadow-sm);
        background:white;
        transition:var(--transition);
        overflow:hidden;
        margin-bottom:1.5rem;
    }
    .card:hover { box-shadow:var(--shadow-lg); }

    .card-header {
        background: var(--forest);
        color:white;
        font-family:var(--ff-display);
        font-weight:600; font-size:1.05rem;
        padding:1.1rem 1.5rem;
        border-bottom:2px solid rgba(201,168,76,0.2);
        position:relative; overflow:hidden;
    }
    .card-header::before {
        content:'';
        position:absolute; top:0; left:0; right:0; height:2px;
        background:linear-gradient(90deg, var(--gold-dark), var(--gold-light), var(--gold-dark));
    }
    .card-body { padding:1.75rem; }

    /* ──────────────────────────────
       BUTTONS (global override)
    ────────────────────────────── */
    .btn {
        border-radius:var(--r-sm);
        font-weight:600; font-size:0.9rem;
        padding:0.65rem 1.5rem;
        display:inline-flex; align-items:center; gap:0.5rem;
        transition:var(--transition);
        border:none;
    }
    .btn-primary {
        background: linear-gradient(135deg, var(--moss-light), var(--forest-soft));
        color:white;
        box-shadow:0 4px 15px rgba(46,107,79,0.3);
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, var(--moss), var(--forest-mid));
        transform:translateY(-2px);
        box-shadow:0 8px 25px rgba(46,107,79,0.4);
        color:white;
    }
    .btn-secondary {
        background:var(--ivory-dark); color:var(--text-dark);
        border:1px solid #cfc8b6;
    }
    .btn-secondary:hover { background:#e0d8c8; transform:translateY(-2px); }

    .btn-danger { background:#dc2626; color:white; }
    .btn-danger:hover { background:#b91c1c; transform:translateY(-2px); color:white; }

    .btn-success {
        background:linear-gradient(135deg, var(--moss-light), var(--moss));
        color:white;
    }
    .btn-success:hover { transform:translateY(-2px); color:white; }

    .btn-warning {
        background:linear-gradient(135deg, var(--gold-light), var(--gold-dark));
        color:var(--forest);
    }
    .btn-warning:hover { transform:translateY(-2px); color:var(--forest); }

    /* ──────────────────────────────
       FORMS (global override)
    ────────────────────────────── */
    .form-control, .form-select {
        border-radius:var(--r-sm);
        border:1.5px solid var(--ivory-dark);
        padding:0.7rem 1rem;
        font-family:var(--ff-body);
        font-size:0.92rem;
        background:white; color:var(--text-dark);
        transition:var(--transition-fast);
    }
    .form-control:focus, .form-select:focus {
        border-color:var(--gold-dark);
        box-shadow:0 0 0 3px rgba(160,120,48,0.12);
        outline:none;
    }
    .form-label {
        font-weight:600; font-size:0.88rem;
        color:var(--text-mid); margin-bottom:0.4rem;
        letter-spacing:0.02em;
    }
    .form-text { font-size:0.8rem; color:var(--text-muted); }
    .is-invalid { border-color:#dc2626 !important; }
    .invalid-feedback { font-size:0.8rem; color:#dc2626; }

    /* Flatpickr override */
    .flatpickr-input {
        background:white !important;
        border:1.5px solid var(--ivory-dark) !important;
        border-radius:var(--r-sm) !important;
        padding:0.7rem 1rem !important;
        font-family:var(--ff-body) !important;
        font-size:0.92rem !important;
        transition:var(--transition-fast);
    }
    .flatpickr-input:focus {
        border-color:var(--gold-dark) !important;
        box-shadow:0 0 0 3px rgba(160,120,48,0.12) !important;
    }

    /* ──────────────────────────────
       TABLES
    ────────────────────────────── */
    .table {
        background:white;
        border-radius:var(--r-lg);
        overflow:hidden;
        font-size:0.9rem;
    }
    .table thead {
        background: var(--forest);
        color:white;
    }
    .table thead th {
        font-weight:600; padding:1rem 1.25rem;
        border:none; letter-spacing:0.03em;
        font-size:0.85rem; text-transform:uppercase;
    }
    .table tbody tr { transition:background 0.2s; }
    .table tbody tr:hover { background:var(--gold-pale); }
    .table tbody td { padding:0.85rem 1.25rem; vertical-align:middle; border-color:var(--ivory-dark); }

    /* ──────────────────────────────
       BADGES
    ────────────────────────────── */
    .badge {
        padding:0.4rem 0.9rem;
        border-radius:var(--r-pill);
        font-weight:600; font-size:0.78rem;
        letter-spacing:0.03em;
    }
    .quota-badge { font-size:0.82rem; padding:0.38rem 0.85rem; border-radius:var(--r-pill); font-weight:700; display:inline-block; }
    .quota-available { background:#e8f5ef; color:#1a5c36; }
    .quota-low       { background:#fef3c7; color:#92400e; }
    .quota-full      { background:#fee2e2; color:#991b1b; }

    /* ──────────────────────────────
       ALERTS (Bootstrap override)
    ────────────────────────────── */
    .alert {
        border-radius:var(--r-md);
        border:none;
        font-weight:500; font-size:0.92rem;
        margin-bottom:1.5rem;
    }
    .alert-success { background:#e8f5ef; color:#1a5c36; border-left:4px solid #3D8B67; }
    .alert-danger  { background:#fee2e2; color:#991b1b; border-left:4px solid #dc2626; }
    .alert-warning { background:#fef3c7; color:#92400e; border-left:4px solid var(--gold); }
    .alert-info    { background:#e0f2fe; color:#075985; border-left:4px solid #0ea5e9; }

    /* ──────────────────────────────
       BACK TO TOP
    ────────────────────────────── */
    .back-to-top {
        position:fixed; bottom:2rem; right:2rem;
        width:46px; height:46px;
        background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
        color:var(--forest);
        border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        cursor:pointer;
        box-shadow:var(--shadow-gold);
        opacity:0; visibility:hidden;
        transition:var(--transition);
        z-index:900; border:none;
        font-size:0.9rem;
    }
    .back-to-top.show { opacity:1; visibility:visible; }
    .back-to-top:hover { transform:translateY(-4px); box-shadow:0 15px 40px rgba(201,168,76,0.4); }

    /* ──────────────────────────────
       FOOTER
    ────────────────────────────── */
    .footer {
        background: var(--forest);
        padding:5rem 0 0;
        margin-top:5rem;
        position:relative; overflow:hidden;
        border-top:1px solid rgba(201,168,76,0.15);
    }
    .footer::before {
        content:''; position:absolute;
        top:0; left:0; right:0; height:1px;
        background:linear-gradient(90deg, transparent 5%, var(--gold) 50%, transparent 95%);
    }
    .footer::after {
        content:'';
        position:absolute; top:-120px; right:-120px;
        width:400px; height:400px; border-radius:50%;
        background:radial-gradient(circle, rgba(201,168,76,0.05) 0%, transparent 70%);
        pointer-events:none;
    }

    .footer-grid {
        display:grid; grid-template-columns:2fr 1.2fr 1.2fr 1.2fr;
        gap:3rem; margin-bottom:3rem;
    }

    .footer-logo {
        display:flex; align-items:center; gap:0.85rem;
        margin-bottom:1.25rem;
    }
    .footer-logo-icon {
        width:46px; height:46px; border-radius:var(--r-md);
        background:linear-gradient(135deg, var(--gold-dark), var(--gold-light));
        display:flex; align-items:center; justify-content:center;
        font-size:1.15rem; color:white;
        box-shadow:var(--shadow-gold); flex-shrink:0;
    }
    .footer-logo-name {
        font-family:var(--ff-display);
        font-size:1.35rem; font-weight:800; color:white;
        line-height:1.1;
    }
    .footer-logo-sub {
        font-size:0.65rem; color:rgba(255,255,255,0.4);
        letter-spacing:0.08em; text-transform:uppercase;
    }

    .footer-about {
        color:rgba(255,255,255,0.5);
        font-size:0.88rem; line-height:1.85;
        margin-bottom:1.5rem;
    }

    .footer-contact-item {
        display:flex; align-items:flex-start; gap:0.75rem;
        color:rgba(255,255,255,0.55); font-size:0.85rem;
        margin-bottom:0.65rem; line-height:1.5;
        text-decoration:none; transition:color 0.3s;
    }
    .footer-contact-item:hover { color:var(--gold-light); }
    .footer-contact-icon {
        width:20px; flex-shrink:0; margin-top:2px;
        color:var(--gold-dark); font-size:0.8rem; text-align:center;
    }

    .footer-col-title {
        font-family:var(--ff-display);
        color:white; font-size:1rem; font-weight:600;
        margin-bottom:1.5rem;
        padding-bottom:0.75rem;
        position:relative;
    }
    .footer-col-title::after {
        content:''; position:absolute;
        bottom:0; left:0; width:28px; height:1.5px;
        background:var(--gold);
    }

    .footer-links { list-style:none; }
    .footer-links li { margin-bottom:0.6rem; }
    .footer-links a {
        color:rgba(255,255,255,0.5);
        text-decoration:none; font-size:0.88rem;
        display:flex; align-items:center; gap:0.6rem;
        padding:0.25rem 0;
        transition:all 0.3s;
    }
    .footer-links a i { color:var(--gold-dark); width:14px; font-size:0.75rem; transition:color 0.3s; }
    .footer-links a:hover { color:var(--gold-light); transform:translateX(5px); }
    .footer-links a:hover i { color:var(--gold-light); }

    .footer-hours-row {
        display:flex; justify-content:space-between; align-items:center;
        padding:0.55rem 0;
        border-bottom:1px solid rgba(255,255,255,0.05);
        font-size:0.84rem;
    }
    .footer-hours-row:last-child { border:none; }
    .footer-hours-day  { color:rgba(255,255,255,0.55); }
    .footer-hours-time { color:var(--gold-light); font-weight:500; font-size:0.8rem; }
    .footer-hours-time.closed { color:rgba(255,255,255,0.3); }

    .footer-socials {
        display:flex; gap:0.65rem; margin-top:1.25rem;
    }
    .footer-social-btn {
        width:36px; height:36px; border-radius:50%;
        background:rgba(255,255,255,0.06);
        border:1px solid rgba(255,255,255,0.1);
        display:flex; align-items:center; justify-content:center;
        color:rgba(255,255,255,0.5); font-size:0.85rem;
        text-decoration:none; transition:all 0.3s;
    }
    .footer-social-btn:hover {
        background:rgba(201,168,76,0.15);
        border-color:rgba(201,168,76,0.35);
        color:var(--gold-light);
        transform:translateY(-3px);
    }

    .footer-bottom {
        border-top:1px solid rgba(255,255,255,0.07);
        padding:1.5rem 0 2rem;
        display:flex; align-items:center; justify-content:space-between;
        gap:1rem; flex-wrap:wrap;
    }
    .footer-copyright {
        font-size:0.82rem; color:rgba(255,255,255,0.3);
    }
    .footer-copyright strong { color:rgba(255,255,255,0.5); }
    .footer-bottom-links {
        display:flex; gap:1.5rem;
    }
    .footer-bottom-links a {
        font-size:0.8rem; color:rgba(255,255,255,0.3);
        text-decoration:none; transition:color 0.3s;
    }
    .footer-bottom-links a:hover { color:var(--gold-light); }

    /* ──────────────────────────────
       UTILITIES
    ────────────────────────────── */
    .container { max-width:1240px; margin:0 auto; padding:0 2rem; }

    /* ──────────────────────────────
       RESPONSIVE
    ────────────────────────────── */
    @media (max-width:1024px) {
        .footer-grid { grid-template-columns:1fr 1fr; gap:2.5rem; }
    }
    @media (max-width:768px) {
        .container { padding:0 1.25rem; }
        .footer { padding:3.5rem 0 0; margin-top:3rem; }
        .footer-grid { grid-template-columns:1fr; gap:2rem; margin-bottom:2rem; }
        .footer-bottom { justify-content:center; text-align:center; }
        .footer-bottom-links { justify-content:center; }
        .card-body { padding:1.25rem; }
        .navbar-nav { padding:0.75rem 0; gap:0.25rem; }
        .navbar-nav .nav-link { padding:0.6rem 0.75rem !important; }
        .navbar-collapse {
            background:var(--forest-mid);
            border-top:1px solid rgba(201,168,76,0.1);
            border-radius:0 0 var(--r-lg) var(--r-lg);
            padding:0.5rem 0.75rem 0.75rem;
            margin-top:0.25rem;
        }
    }
    @media (max-width:480px) {
        .brand-tagline { display:none; }
        .back-to-top { bottom:1rem; right:1rem; width:42px; height:42px; }
    }

    /* Reduced motion */
    @media (prefers-reduced-motion:reduce) {
        *, *::before, *::after { animation-duration:0.01ms !important; transition-duration:0.01ms !important; }
    }
    </style>

    @stack('styles')
</head>
<body>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-ring">
        <div class="loading-ring-track"></div>
        <div class="loading-ring-spin"></div>
    </div>
    <span class="loading-label">Memuat...</span>
</div>

<!-- Back to Top -->
<button class="back-to-top" id="backToTop" aria-label="Kembali ke atas">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- ══ NAVBAR ══ -->
<nav class="navbar navbar-expand-lg navbar-dark" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <div class="brand-icon"><i class="fas fa-school"></i></div>
            <div class="brand-text">
                <span class="brand-name">YAPISDA</span>
                <span class="brand-tagline">Daar El Rohmah</span>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            @php
                $isSmpAdmin = request()->routeIs('admin.smp.*');
                $isSmkAdmin = request()->routeIs('admin.*') && !request()->routeIs('admin.smp.*');
                $isPublic   = !$isSmpAdmin && !$isSmkAdmin;
            @endphp

            @if($isPublic)
            {{-- ── PUBLIC NAV ── --}}
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <i class="fas fa-info-circle"></i> Profil
                    </a>
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
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('registration.form') }}">
                                <i class="fas fa-industry text-primary"></i> Daftar SMKS
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('registration.smp-form') }}">
                                <i class="fas fa-school text-success"></i> Daftar SMPS
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-bell" style="color:var(--gold-light)"></i> Pengumuman
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item ms-lg-2">
                    <a href="{{ route('registration.form') }}" class="btn-nav-cta">
                        <i class="fas fa-rocket"></i> Daftar Sekarang
                    </a>
                </li>
            </ul>

            @elseif($isSmkAdmin)
            {{-- ── SMK ADMIN NAV ── --}}
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <span class="nav-link nav-admin-label">
                        <i class="fas fa-industry"></i> Admin SMKS
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.export.excel') }}">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                </li>
                <li class="nav-item ms-lg-2">
                    <a class="btn-nav-danger" href="{{ route('admin.logout') }}">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>

            @elseif($isSmpAdmin)
            {{-- ── SMP ADMIN NAV ── --}}
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <span class="nav-link nav-admin-label">
                        <i class="fas fa-school"></i> Admin SMPS
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.smp.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.smp.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.smp.export.excel') }}">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                </li>
                <li class="nav-item ms-lg-2">
                    <a class="btn-nav-danger" href="{{ route('admin.smp.logout') }}">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
            @endif
        </div>
    </div>
</nav>

<!-- ══ MAIN ══ -->
<main>
    @if(session('success'))
    <div class="container" style="padding-top:1.5rem;">
        <div class="flash-alert flash-success alert-dismissible fade show" role="alert">
            <div class="flash-icon"><i class="fas fa-check"></i></div>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container" style="padding-top:1.5rem;">
        <div class="flash-alert flash-error alert-dismissible fade show" role="alert">
            <div class="flash-icon"><i class="fas fa-exclamation"></i></div>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @yield('content')
</main>

<!-- ══ FOOTER ══ -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">

            <!-- Brand & Contact -->
            <div>
                <div class="footer-logo">
                    <div class="footer-logo-icon"><i class="fas fa-school"></i></div>
                    <div>
                        <div class="footer-logo-name">YAPISDA</div>
                        <div class="footer-logo-sub">Daar El Rohmah</div>
                    </div>
                </div>
                <p class="footer-about">
                    Yayasan Pendidikan Islam Daar El Rohmah berkomitmen mencetak generasi unggul yang berakhlak, cerdas, dan kompetitif di era global.
                </p>
                <a href="#" class="footer-contact-item">
                    <i class="fas fa-map-marker-alt footer-contact-icon"></i>
                    <span>Jl. Raya Cisoka - Tigaraksa, Kp. Saga, Desa Caringin, Kecamatan Cisoka, Kabupaten Tangerang, Provinsi Banten 15730</span>
                </a>
                <a href="tel:02159751260" class="footer-contact-item">
                    <i class="fas fa-phone footer-contact-icon"></i>
                    <span>(021) 59751260</span>
                </a>
                <a href="https://wa.me/628128906113" class="footer-contact-item">
                    <i class="fab fa-whatsapp footer-contact-icon"></i>
                    <span>08128906113</span>
                </a>
                <a href="#" class="footer-contact-item">
                    <i class="fas fa-envelope footer-contact-icon"></i>
                    <span>info@yapisda.sch.id</span>
                </a>
                <div class="footer-socials">
                    <a href="#" class="footer-social-btn"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="footer-social-btn"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="footer-social-btn"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="footer-social-btn"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="footer-col-title">Navigasi</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right"></i> Beranda</a></li>
                    <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right"></i> Profil Sekolah</a></li>
                    <li><a href="{{ route('vision') }}"><i class="fas fa-chevron-right"></i> Visi & Misi</a></li>
                    <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right"></i> Kontak</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Pengumuman</a></li>
                </ul>
            </div>

            <!-- Registration -->
            <div>
                <h4 class="footer-col-title">Pendaftaran</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('registration.form') }}"><i class="fas fa-industry"></i> Daftar SMKS</a></li>
                    <li><a href="{{ route('registration.smp-form') }}"><i class="fas fa-school"></i> Daftar SMPS</a></li>
                    <li><a href="#"><i class="fas fa-bell"></i> Pengumuman</a></li>
                    <li><a href="#alur-pendaftaran"><i class="fas fa-list-ol"></i> Alur Daftar</a></li>
                </ul>
            </div>

            <!-- Jam Operasional -->
            <div>
                <h4 class="footer-col-title">Jam Operasional</h4>
                <div class="footer-hours-row">
                    <span class="footer-hours-day">Senin – Jumat</span>
                    <span class="footer-hours-time">07:00 – 16:00</span>
                </div>
                <div class="footer-hours-row">
                    <span class="footer-hours-day">Sabtu</span>
                    <span class="footer-hours-time">07:00 – 12:00</span>
                </div>
                <div class="footer-hours-row">
                    <span class="footer-hours-day">Minggu</span>
                    <span class="footer-hours-time closed">Libur</span>
                </div>
            </div>

        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p class="footer-copyright">
                &copy; {{ date('Y') }} <strong>YAPISDA</strong>. All rights reserved.
            </p>
            <div class="footer-bottom-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
// ── Navbar scroll ──
const navbar = document.getElementById('mainNavbar');
window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 60);
}, { passive:true });

// ── Back to Top ──
const btt = document.getElementById('backToTop');
window.addEventListener('scroll', () => {
    btt.classList.toggle('show', window.scrollY > 320);
}, { passive:true });
btt.addEventListener('click', () => window.scrollTo({ top:0, behavior:'smooth' }));

// ── Loading Overlay ──
window.addEventListener('load', () => {
    const lo = document.getElementById('loadingOverlay');
    lo.classList.add('active');
    setTimeout(() => lo.classList.remove('active'), 550);
});

// ── Auto-dismiss flash alerts after 5s ──
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.flash-alert').forEach(el => {
        setTimeout(() => {
            try { new bootstrap.Alert(el).close(); } catch(e) {}
        }, 5000);
    });
});
</script>

@stack('scripts')
</body>
</html>
