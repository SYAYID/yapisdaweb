<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>E-Graduation 2026 | SMKS YAPISDA CISOKA</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at 10% 20%, #0c0e23, #07091a);
            min-height: 100vh;
            color: #f0f3fa;
            overflow-x: hidden;
            line-height: 1.5;
        }

        ::selection {
            background: rgba(79, 126, 206, 0.4);
            color: white;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #12152b;
        }
        ::-webkit-scrollbar-thumb {
            background: #2d3e7c;
            border-radius: 10px;
        }

        /* Background Orbs */
        .bg-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(110px);
            opacity: 0.2;
            pointer-events: none;
            z-index: 0;
        }
        .orb-1 { width: 55vw; height: 55vw; background: #2a4b8c; top: -15vh; left: -20vw; }
        .orb-2 { width: 60vw; height: 60vw; background: #5f3b8c; bottom: -30vh; right: -20vw; }
        .orb-3 { width: 40vw; height: 40vw; background: #1f6d6d; top: 40%; left: 30%; opacity: 0.15; }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1100;
            padding: 18px 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(10, 14, 33, 0.75);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.3rem;
        }
        .logo-icon {
            background: linear-gradient(145deg, #3b82f6, #8b5cf6);
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        .logo-text {
            background: linear-gradient(135deg, #ffffff, #b3c7ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .nav-links {
            display: flex;
            gap: 12px;
        }
        .nav-links a {
            color: #cddcff;
            text-decoration: none;
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
        }
        .nav-links a.active {
            background: rgba(59, 130, 246, 0.2);
            color: white;
            backdrop-filter: blur(4px);
            border: 0.5px solid rgba(59, 130, 246, 0.4);
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 2;
        }

        /* Home Page */
        #home-page {
            display: block;
        }
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 140px 20px 60px;
            position: relative;
        }
        .hero-badge {
            background: rgba(59, 130, 246, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(59, 130, 246, 0.3);
            padding: 6px 18px;
            border-radius: 60px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 28px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .live-dot {
            width: 8px;
            height: 8px;
            background: #3b82f6;
            border-radius: 50%;
            box-shadow: 0 0 6px #3b82f6;
            animation: pulseLive 1.8s infinite;
        }
        @keyframes pulseLive {
            0% { opacity: 0.5; transform: scale(0.9);}
            100% { opacity: 1; transform: scale(1.4);}
        }

        .hero h1 {
            font-size: clamp(2.6rem, 7vw, 4.8rem);
            font-weight: 800;
            letter-spacing: -1px;
            line-height: 1.2;
            margin-bottom: 20px;
        }
        .gradient-text {
            background: linear-gradient(115deg, #b9e0ff, #7aa2f7, #c97eff);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: shimmer 3s infinite linear;
        }
        @keyframes shimmer {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }
        .hero p {
            font-size: 1.1rem;
            color: #b9c7e6;
            max-width: 560px;
            margin-bottom: 36px;
        }
        .btn-primary {
            background: linear-gradient(105deg, #2563eb, #6d28d9);
            border: none;
            padding: 14px 36px;
            border-radius: 44px;
            font-weight: 700;
            font-size: 1rem;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 30px rgba(37, 99, 235, 0.4);
        }

        .stats-row {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
            margin: 48px auto 20px;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(12px);
            border-radius: 60px;
            padding: 20px 40px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            width: fit-content;
        }
        .stat-item {
            text-align: center;
            padding: 0 24px;
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #e0e7ff, #a5c9ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #9aa9cf;
            margin-top: 6px;
        }

        .features {
            padding: 60px 0 80px;
        }
        .section-title {
            text-align: center;
            margin-bottom: 56px;
        }
        .section-title h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 12px;
        }
        .section-title p {
            color: #98a9d9;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }
        .feature-card {
            background: rgba(20, 27, 48, 0.6);
            backdrop-filter: blur(8px);
            border-radius: 32px;
            padding: 32px 28px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        .feature-card:hover {
            transform: translateY(-8px);
            background: rgba(30, 41, 75, 0.7);
            border-color: rgba(79, 126, 206, 0.4);
        }
        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 24px;
            background: rgba(59, 130, 246, 0.15);
        }

        /* Graduation Page */
        .graduation-page {
            display: none;
            min-height: 100vh;
            padding: 140px 20px 80px;
            z-index: 10;
        }
        .graduation-page.active {
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: fadeSlide 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .grad-container {
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
        }
        .grad-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .grad-icon {
            font-size: 3.6rem;
            margin-bottom: 10px;
            filter: drop-shadow(0 8px 12px rgba(0,0,0,0.2));
        }
        .nis-card {
            background: rgba(16, 22, 45, 0.65);
            backdrop-filter: blur(14px);
            border-radius: 48px;
            padding: 44px 40px;
            border: 1px solid rgba(255, 255, 255, 0.07);
            box-shadow: 0 25px 40px -20px rgba(0,0,0,0.5);
        }
        .form-group label {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #b4c6ff;
            margin-bottom: 12px;
            display: block;
        }
        .input-wrapper {
            position: relative;
        }
        .input-wrapper .icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.3rem;
            opacity: 0.5;
        }
        .form-group input {
            width: 100%;
            padding: 18px 20px 18px 56px;
            background: rgba(0, 0, 0, 0.3);
            border: 1.5px solid rgba(255, 255, 255, 0.1);
            border-radius: 34px;
            color: white;
            font-size: 1.1rem;
            font-weight: 500;
            letter-spacing: 2px;
            font-family: 'Inter', monospace;
            transition: all 0.2s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(37, 99, 235, 0.1);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
        }

        /* CAPTCHA styling */
        .captcha-container {
            margin: 20px 0 10px;
            padding: 16px;
            background: rgba(0, 0, 0, 0.25);
            border-radius: 28px;
            border: 1px solid rgba(255,255,255,0.06);
        }
        .captcha-question {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(0,0,0,0.4);
            padding: 12px 18px;
            border-radius: 60px;
            margin-bottom: 12px;
            gap: 12px;
            flex-wrap: wrap;
        }
        .captcha-text {
            font-size: 1.3rem;
            font-weight: 700;
            letter-spacing: 6px;
            background: linear-gradient(145deg, #e2e8f0, #94a3b8);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-family: monospace;
        }
        .captcha-input {
            flex: 1;
            padding: 12px 16px;
            background: #0f172acc;
            border: 1px solid #2d3a70;
            border-radius: 40px;
            color: white;
            font-size: 1rem;
            text-align: center;
            letter-spacing: 1px;
        }
        .captcha-input:focus {
            outline: none;
            border-color: #3b82f6;
        }
        .refresh-captcha {
            background: rgba(59,130,246,0.2);
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            font-size: 1.3rem;
            cursor: pointer;
            transition: 0.2s;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .refresh-captcha:hover {
            background: #3b82f6;
            transform: rotate(15deg);
        }
        .captcha-error {
            color: #f87171;
            font-size: 0.75rem;
            margin-top: 8px;
            display: block;
            text-align: center;
        }

        .btn-check {
            width: 100%;
            margin-top: 16px;
            background: linear-gradient(95deg, #2563eb, #6d28d9);
            border: none;
            border-radius: 44px;
            padding: 16px;
            font-weight: 700;
            font-size: 1rem;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-check:hover {
            transform: scale(0.98);
            background: linear-gradient(95deg, #3b82f6, #7c3aed);
        }
        .result-section {
            width: 100%;
            position: relative;
            z-index: 20;
        }

        /* Result Card */
        .result-card {
            border-radius: 40px;
            padding: 32px 28px;
            text-align: center;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 35px -12px rgba(0,0,0,0.4);
            margin-top: 28px;
        }
        .result-card.lulus {
            background: linear-gradient(125deg, rgba(34, 197, 94, 0.12), rgba(16, 85, 65, 0.2));
            border: 1px solid rgba(74, 222, 128, 0.5);
        }
        .result-card.tidak-lulus {
            background: linear-gradient(125deg, rgba(248,113,113,0.1), rgba(127,29,29,0.2));
            border: 1px solid rgba(248,113,113,0.4);
        }
        .result-card.not-found {
            background: rgba(251,191,36,0.08);
            border: 1px solid rgba(251,191,36,0.3);
        }
        .school-logo {
            width: 250px;
            height: 250px;
            margin: 0 auto 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            color: white;
            text-transform: uppercase;
            font-family: monospace;
            letter-spacing: 1px;
        }
        .result-status {
            font-size: 1.8rem;
            font-weight: 800;
            margin: 12px 0;
        }
        .lulus-text { color: #4ade80; text-shadow: 0 0 5px rgba(74,222,128,0.3);}
        .tidak-text { color: #f87171; }
        .notfound-text { color: #fbbf24; }
        .result-name {
            font-weight: 700;
            font-size: 1.4rem;
            margin-top: 8px;
        }
        .detail-item {
            background: rgba(0,0,0,0.3);
            border-radius: 28px;
            padding: 12px 20px;
            min-width: 120px;
        }
        .graduation-note {
            margin-top: 24px;
            padding: 16px 20px;
            background: rgba(74, 222, 128, 0.1);
            border-left: 4px solid #4ade80;
            border-radius: 20px;
            text-align: left;
            font-size: 0.85rem;
            color: #c6f7d2;
            backdrop-filter: blur(4px);
        }
        .graduation-note strong {
            color: #4ade80;
            display: block;
            margin-bottom: 6px;
            font-size: 0.9rem;
        }
        .btn-back {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 40px;
            padding: 12px 28px;
            margin-top: 28px;
            color: #ccd9ff;
            font-weight: 500;
            transition: 0.2s;
            cursor: pointer;
        }
        .footer {
            text-align: center;
            padding: 40px 20px;
            font-size: 0.8rem;
            color: #6f7fab;
            border-top: 1px solid rgba(255,255,255,0.05);
            margin-top: 60px;
        }

        /* Access Denied & Countdown Styles */
        #access-denied {
            display: none;
            position: fixed;
            inset: 0;
            background: #070b1a;
            z-index: 9999;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            backdrop-filter: blur(8px);
        }
        .countdown-container {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .time-box {
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 16px;
            padding: 15px 20px;
            min-width: 90px;
            display: flex;
            flex-direction: column;
            align-items: center;
            backdrop-filter: blur(10px);
        }
        .time-box span {
            font-size: 2.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            margin-bottom: 5px;
        }
        .time-box small {
            font-size: 0.8rem;
            color: #9ab3e6;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        /* Animation */
        .shake-animation {
            animation: shake 0.4s ease-in-out;
        }
        @keyframes shake {
            0%,100%{ transform: translateX(0);}
            25%{ transform: translateX(-8px);}
            75%{ transform: translateX(8px);}
        }
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s ease;
        }
        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }
        #confetti-canvas {
            position: fixed;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 10000;
        }
        .test-badge {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #f59e0bcc;
            backdrop-filter: blur(8px);
            padding: 6px 16px;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: bold;
            z-index: 2000;
            font-family: monospace;
            color: #000;
        }
        .particle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            animation: float linear infinite;
        }
        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            20% { opacity: 0.4; }
            80% { opacity: 0.3; }
            100% { transform: translateY(-20vh) rotate(360deg); opacity: 0; }
        }
        @media (max-width: 720px) {
            .navbar { padding: 14px 20px; }
            .nis-card { padding: 28px 22px; }
            .stats-row { padding: 12px 24px; gap: 20px; }
            .stat-number { font-size: 1.8rem; }
            .result-status { font-size: 1.3rem; }
            .school-logo { width: 150px; height: 150px; }
            .captcha-question { flex-direction: column; align-items: stretch; }
            .refresh-captcha { align-self: center; }
            .time-box { min-width: 75px; padding: 10px 15px; }
            .time-box span { font-size: 2rem; }
        }

        /* Unified YAPISDA theme override */
        :root {
            --brand: #0f5f4a;
            --brand-700: #0b4537;
            --brand-800: #083229;
            --mint: #dff5ee;
            --aqua: #1f9aa5;
            --gold: #c89b3c;
            --gold-light: #f4d890;
            --paper: #f5f8f6;
        }
        body {
            background:
                radial-gradient(circle at 12% 16%, rgba(31, 154, 165, 0.24), transparent 30rem),
                linear-gradient(135deg, var(--brand-800), var(--brand)) !important;
            font-family: 'Inter', system-ui, sans-serif !important;
        }
        .navbar {
            background: rgba(8, 50, 41, 0.9) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        .logo-icon,
        .feature-icon,
        .refresh-captcha {
            background: var(--mint) !important;
            color: var(--brand) !important;
        }
        .logo-text,
        .gradient-text,
        .stat-number {
            background: linear-gradient(135deg, #ffffff, var(--gold-light)) !important;
            -webkit-background-clip: text !important;
            background-clip: text !important;
        }
        .nav-links a.active,
        .hero-badge,
        .time-box {
            background: rgba(15, 95, 74, 0.28) !important;
            border-color: rgba(244, 216, 144, 0.28) !important;
        }
        .live-dot {
            background: var(--gold-light) !important;
            box-shadow: 0 0 8px var(--gold-light) !important;
        }
        .btn-primary,
        .btn-check {
            background: var(--brand) !important;
            border-radius: 10px !important;
            box-shadow: 0 14px 30px rgba(15, 95, 74, 0.28) !important;
        }
        .btn-primary:hover,
        .btn-check:hover {
            background: var(--brand-700) !important;
        }
        .stats-row,
        .feature-card,
        .nis-card,
        .captcha-container,
        .result-card,
        .detail-item {
            background: rgba(8, 50, 41, 0.62) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .form-group input,
        .captcha-input {
            border-color: rgba(255, 255, 255, 0.14) !important;
        }
        .form-group input:focus,
        .captcha-input:focus {
            border-color: var(--gold-light) !important;
            box-shadow: 0 0 0 3px rgba(244, 216, 144, 0.18) !important;
        }
    </style>
</head>
<body>
    <canvas id="confetti-canvas"></canvas>

    <!-- Access Denied & Countdown Overlay -->
    <div id="access-denied">
        <div style="font-size: 4rem; margin-bottom: 10px;">🔒</div>
        <h1 style="margin: 0 0 10px; font-size: 2.5rem; font-weight: 800;">Akses Terkunci</h1>
        <p style="color: #b9c7e6; max-width: 500px; line-height: 1.6; font-size: 1.1rem; padding: 0 20px;">
            Pengumuman kelulusan resmi hanya dapat diakses pada<br>
            <strong style="color: white;">Senin, 04 Mei 2026 (00:00 - 23:59 WIB)</strong>
        </p>

        <!-- Wrapper Countdown -->
        <div class="countdown-container" id="countdown-wrapper">
            <div class="time-box"><span id="cd-days">00</span><small>Hari</small></div>
            <div class="time-box"><span id="cd-hours">00</span><small>Jam</small></div>
            <div class="time-box"><span id="cd-minutes">00</span><small>Menit</small></div>
            <div class="time-box"><span id="cd-seconds">00</span><small>Detik</small></div>
        </div>

        <!-- Pesan jika waktu telah lewat -->
        <div id="closed-message" style="display:none; margin-top: 30px; background: rgba(248,113,113,0.15); padding: 15px 25px; border-radius: 12px; border: 1px solid rgba(248,113,113,0.3); color: #fca5a5;">
            Waktu pengumuman kelulusan telah berakhir.
        </div>
    </div>

    <div class="bg-orb orb-1"></div>
    <div class="bg-orb orb-2"></div>
    <div class="bg-orb orb-3"></div>

    <nav class="navbar" style="display: none;">
        <div class="logo">
            <div class="logo-icon">🎓</div>
            <span class="logo-text">SMKS YAPISDA CISOKA</span>
        </div>
        <div class="nav-links">
            <a href="#" class="active" onclick="showPage('home'); return false;">Beranda</a>
            <a href="#" onclick="showPage('graduation'); return false;">Kelulusan</a>
        </div>
    </nav>

    <div id="home-page" style="display: none;">
        <div class="hero">
            <div class="hero-badge"><span class="live-dot"></span> TAHUN AJARAN 2025/2026</div>
            <h1>Pengumuman <span class="gradient-text">Kelulusan</span><br>Kelas 12</h1>
            <p>Akses resmi hasil kelulusan siswa SMKS YAPISDA CISOKA. Masukkan NIS untuk mengetahui status terintegrasi.</p>
            <button class="btn-primary" onclick="showPage('graduation')">🔍 Cek Status Sekarang</button>

        </div>
        <div class="container">
            <div class="features">
                <div class="section-title animate-on-scroll"><h2>Sistem Informasi Terpercaya</h2><p>Akses cepat, akurat, dan bertanggung jawab</p></div>
                <div class="features-grid">
                    <div class="feature-card animate-on-scroll"><div class="feature-icon">🔐</div><h3>Verifikasi Individual</h3><p>Setiap NIS bersifat privat untuk memastikan keabsahan data kelulusan masing-masing siswa.</p></div>
                    <div class="feature-card animate-on-scroll"><div class="feature-icon">⚡</div><h3>Hasil Real-time</h3><p>Sistem langsung menampilkan status dilengkapi nilai akhir.</p></div>
                    <div class="feature-card animate-on-scroll"><div class="feature-icon">📜</div><h3>Dokumen Resmi Digital</h3><p>Informasi sesuai rapor dan keputusan kelulusan dari sekolah.</p></div>
                </div>
            </div>
        </div>
        <footer class="footer"><p>© 2026 SMKS YAPISDA CISOKA - Sistem Informasi Kelulusan Terintegrasi</p></footer>
    </div>

    <div id="graduation-page" class="graduation-page" style="display: none;">
        <div class="grad-container">
            <div class="grad-header"><div class="grad-icon">🎓</div><h2 style="font-weight:700;">Cek Kelulusan 2026</h2><p>Masukkan Nomor Induk Siswa (NIS) dengan benar</p></div>
            <div class="nis-card">
                <div class="form-group"><label>NOMOR INDUK SISWA</label><div class="input-wrapper"><span class="icon">🆔</span><input type="text" id="nis-input" placeholder="Contoh: 2324100001" maxlength="12" autocomplete="off" onkeypress="if(event.key==='Enter') checkGraduation()"></div></div>

                <!-- CAPTCHA SECTION -->
                <div class="captcha-container" id="captcha-container">
                    <div class="captcha-question">
                        <span class="captcha-text" id="captcha-question-text">5 + 3 = ?</span>
                        <input type="text" id="captcha-input" class="captcha-input" placeholder="Jawaban angka" autocomplete="off">
                        <button type="button" class="refresh-captcha" id="refresh-captcha" onclick="generateCaptcha()">⟳</button>
                    </div>
                    <div id="captcha-error" class="captcha-error"></div>
                </div>

                <button class="btn-check" id="btn-check" onclick="checkGraduation()"><span class="btn-text">🔍 Verifikasi Kelulusan</span><div class="spinner" style="display: none; width:20px; height:20px; border:2px solid white; border-top-color:transparent; border-radius:50%; animation:spin 0.7s linear infinite;"></div></button>
            </div>
            <div class="result-section" id="result-section" style="display: none;">
                <div class="result-card" id="result-card">
                    <div id="result-emoji"></div>
                    <div class="result-status" id="result-status"></div>
                    <div class="result-name" id="result-name"></div>
                    <div class="result-nis" id="result-nis" style="color:#a0b0da; margin:8px 0;"></div>
                    <div class="result-details" id="result-details" style="display:flex; flex-wrap:wrap; gap:12px; justify-content:center; margin:24px 0;"></div>
                    <div id="graduation-note-container"></div>
                    <button class="btn-back" onclick="resetForm()">⟳ Cek NIS Lain</button>
                </div>
            </div>
        </div>
        <footer class="footer"><p>© 2026 YAPISDA • Data resmi kelulusan</p></footer>
    </div>

    <div id="particles" style="position:fixed; top:0; left:0; width:100%; height:100%; pointer-events:none; z-index:1;"></div>

    <script>
        // ============== DATABASE SISWA (FINAL - 319 SISWA) ==============
        const studentsDB = {
            "2324100357": { name: "ALISYA PUTRI PRADANA", class: "12 DKV", gpa: 87.99, status: "LULUS" },
            "2324100358": { name: "AZZIRA TAHTA ASMARA", class: "12 DKV", gpa: 76.93, status: "LULUS" },
            "2324100360": { name: "DILLAH PRAMADHANI", class: "12 DKV", gpa: 85.48, status: "LULUS" },
            "2324100405": { name: "DIONNIEL CHANG", class: "12 DKV", gpa: 85.45, status: "LULUS" },
            "2324100361": { name: "EGI MAULANA", class: "12 DKV", gpa: 85.68, status: "LULUS" },
            "2324100362": { name: "ERIC ATMA WIJAYA", class: "12 DKV", gpa: 85.34, status: "LULUS" },
            "2324100363": { name: "FADILA SUSANTY", class: "12 DKV", gpa: 84.4, status: "LULUS" },
            "2324100364": { name: "FARINA NUGRAHINI PRIHANTARI", class: "12 DKV", gpa: 84.48, status: "LULUS" },
            "2324100365": { name: "GEBRIANA FRICILA", class: "12 DKV", gpa: 77.49, status: "LULUS" },
            "2324100366": { name: "GELNDY ANUGRAH MELKISEDIK KAMALO", class: "12 DKV", gpa: 82.64, status: "LULUS" },
            "2324100368": { name: "IBNU AL - MUHIBBU TOHARI", class: "12 DKV", gpa: 79.58, status: "LULUS" },
            "2324100369": { name: "IQBAL RAMADHAN", class: "12 DKV", gpa: 82.91, status: "LULUS" },
            "2324100370": { name: "LUDIA INDRIANI", class: "12 DKV", gpa: 83.65, status: "LULUS" },
            "2324100372": { name: "MARTIN ALEXANDER SELAN", class: "12 DKV", gpa: 81.14, status: "LULUS" },
            "2324100373": { name: "MIFTAHUL JANNAH", class: "12 DKV", gpa: 81.09, status: "LULUS" },
            "2324100375": { name: "MUHAMAD RIDWAN", class: "12 DKV", gpa: 79.56, status: "LULUS" },
            "2324100371": { name: "MUHAMAD RIZKY AL-QURSYAIRI", class: "12 DKV", gpa: 84.54, status: "LULUS" },
            "2324100376": { name: "MUHAMMAD FURQON", class: "12 DKV", gpa: 82.84, status: "LULUS" },
            "2324100379": { name: "MUHAMMAD SYAMSUL MA'ARIP", class: "12 DKV", gpa: 81.26, status: "LULUS" },
            "2324100380": { name: "NABILA NADA PAJRIAH", class: "12 DKV", gpa: 81.1, status: "LULUS" },
            "2324100381": { name: "NENG ZAHRA FAUZIYANTI", class: "12 DKV", gpa: 83.42, status: "LULUS" },
            "2324100383": { name: "OLIVIA KLIORISIA", class: "12 DKV", gpa: 82.04, status: "LULUS" },
            "2324100385": { name: "RAHMI DIAN WARI", class: "12 DKV", gpa: 81.83, status: "LULUS" },
            "2425110282": { name: "REYFAN REYNALDO", class: "12 DKV", gpa: 79.83, status: "LULUS" },
            "2324100386": { name: "REZA MAHENDRA", class: "12 DKV", gpa: 82.73, status: "LULUS" },
            "2324100387": { name: "SAFITRI HANDAYANI", class: "12 DKV", gpa: 86.78, status: "LULUS" },
            "2324100388": { name: "SHELA OCTAPIA", class: "12 DKV", gpa: 84.02, status: "LULUS" },
            "2324100389": { name: "SITI MAESAROH", class: "12 DKV", gpa: 85.92, status: "LULUS" },
            "2324100390": { name: "SITI NURFADILAH", class: "12 DKV", gpa: 83.17, status: "LULUS" },
            "2324100392": { name: "WIDIA SARI", class: "12 DKV", gpa: 84.7, status: "LULUS" },
            "2324100393": { name: "YOSSI FADIANESCHITA", class: "12 DKV", gpa: 81.29, status: "LULUS" },
            "2324100394": { name: "ZIDAN HAETAMI", class: "12 DKV", gpa: 85.89, status: "LULUS" },
            "2324100005": { name: "AKHMAD MUFADOL", class: "12 MP A", gpa: 81.12, status: "LULUS" },
            "2324100007": { name: "ALESIA PUTRI FREDLINA", class: "12 MP A", gpa: 82.4, status: "LULUS" },
            "2324100015": { name: "ANGGITA RAMADHANI", class: "12 MP A", gpa: 81.29, status: "LULUS" },
            "2324100016": { name: "ANISA NURAINI", class: "12 MP A", gpa: 89.01, status: "LULUS" },
            "2324100019": { name: "ARYA MALIK IBRAHIM", class: "12 MP A", gpa: 86.58, status: "LULUS" },
            "2324100022": { name: "ATIKA RAHMAWATI", class: "12 MP A", gpa: 85.22, status: "LULUS" },
            "2324100024": { name: "AURA SURYANI", class: "12 MP A", gpa: 84.91, status: "LULUS" },
            "2324100029": { name: "DEVY SUCI OKTAVIANI", class: "12 MP A", gpa: 79.58, status: "LULUS" },
            "2324100031": { name: "ELSA DIANY", class: "12 MP A", gpa: 83.08, status: "LULUS" },
            "2324100036": { name: "HILDA AINI SYIFA", class: "12 MP A", gpa: 82.48, status: "LULUS" },
            "2324100037": { name: "IDA ROSIDA", class: "12 MP A", gpa: 82.97, status: "LULUS" },
            "2324100040": { name: "JASMINE SYAPUTRI SULAIMAN", class: "12 MP A", gpa: 84.14, status: "LULUS" },
            "2324100042": { name: "JUWITA DARAPUSPITA", class: "12 MP A", gpa: 82.54, status: "LULUS" },
            "2324100044": { name: "KANIATUSSIPA", class: "12 MP A", gpa: 81.61, status: "LULUS" },
            "2324100045": { name: "KARTIKA WANDA SULISTYA", class: "12 MP A", gpa: 84.41, status: "LULUS" },
            "2324100051": { name: "LIA SEPTIANI", class: "12 MP A", gpa: 85.39, status: "LULUS" },
            "2324100053": { name: "MARSYA AULIA PRACINTA", class: "12 MP A", gpa: 84.23, status: "LULUS" },
            "2324100057": { name: "MILA YULIA NINGSIH", class: "12 MP A", gpa: 82.0, status: "LULUS" },
            "2324100062": { name: "NADYA SAFHIRA", class: "12 MP A", gpa: 83.35, status: "LULUS" },
            "2324100066": { name: "NASYWA AZAHRA", class: "12 MP A", gpa: 82.77, status: "LULUS" },
            "2324100069": { name: "NILA AMALIA ROSADI", class: "12 MP A", gpa: 85.71, status: "LULUS" },
            "2324100071": { name: "NOZA APRILIA", class: "12 MP A", gpa: 83.05, status: "LULUS" },
            "2324100073": { name: "PUTRI ANDINI", class: "12 MP A", gpa: 82.98, status: "LULUS" },
            "2324100075": { name: "PUTRI CAHAYA SPIRA", class: "12 MP A", gpa: 82.89, status: "LULUS" },
            "2324100079": { name: "REISYA AULIA", class: "12 MP A", gpa: 82.03, status: "LULUS" },
            "2324100085": { name: "SALWA AZZAHRA", class: "12 MP A", gpa: 85.76, status: "LULUS" },
            "2324100086": { name: "SEPTIANA RIRIN RAMADHANI SUPARNO", class: "12 MP A", gpa: 83.67, status: "LULUS" },
            "2324100092": { name: "SITI NADIA NURMALA", class: "12 MP A", gpa: 82.08, status: "LULUS" },
            "2324100096": { name: "SITI RISMAWATI", class: "12 MP A", gpa: 82.04, status: "LULUS" },
            "2324100102": { name: "TIRAY ANJANI", class: "12 MP A", gpa: 82.79, status: "LULUS" },
            "2324100105": { name: "VICKA AL MUSYA RIZQI", class: "12 MP A", gpa: 81.59, status: "LULUS" },
            "2324100106": { name: "VIKRI", class: "12 MP A", gpa: 82.52, status: "LULUS" },
            "2324100111": { name: "WULAN NISA", class: "12 MP A", gpa: 82.92, status: "LULUS" },
            "2324100002": { name: "ADITYA YULIYANTO", class: "12 MP B", gpa: 82.75, status: "LULUS" },
            "2324100009": { name: "ALVINA RAMADAN", class: "12 MP B", gpa: 82.94, status: "LULUS" },
            "2324100010": { name: "AMELDA", class: "12 MP B", gpa: 82.67, status: "LULUS" },
            "2324100018": { name: "ANNISAH FITRI FAUZIAH", class: "12 MP B", gpa: 83.64, status: "LULUS" },
            "2324100026": { name: "CHELSI ASKATALITA", class: "12 MP B", gpa: 83.4, status: "LULUS" },
            "2324100027": { name: "CLAURENCIA E.Y DOPO", class: "12 MP B", gpa: 87.02, status: "LULUS" },
            "2324100028": { name: "DEA AMELIA MOZZA", class: "12 MP B", gpa: 83.43, status: "LULUS" },
            "2324100395": { name: "DIANA SYIFA", class: "12 MP B", gpa: 83.23, status: "LULUS" },
            "2324100032": { name: "ERNASARI", class: "12 MP B", gpa: 82.68, status: "LULUS" },
            "2324100035": { name: "HANI MELANI", class: "12 MP B", gpa: 83.83, status: "LULUS" },
            "2324100039": { name: "INDRIYANI", class: "12 MP B", gpa: 82.84, status: "LULUS" },
            "2324100041": { name: "JELITA ULANDARI", class: "12 MP B", gpa: 83.72, status: "LULUS" },
            "2324100046": { name: "KESYA AYUDIA PUTRI", class: "12 MP B", gpa: 82.17, status: "LULUS" },
            "2324100049": { name: "LANA JAMEELA DE ONI", class: "12 MP B", gpa: 84.68, status: "LULUS" },
            "2324100054": { name: "MARSYA LEVIANA", class: "12 MP B", gpa: 82.62, status: "LULUS" },
            "2324100059": { name: "MUHAMMAD RAIHAN PRIYANDIKA", class: "12 MP B", gpa: 78.35, status: "LULUS" },
            "2324100067": { name: "NATALIA", class: "12 MP B", gpa: 82.95, status: "LULUS" },
            "2324100068": { name: "NIKEN AYU LESTARI", class: "12 MP B", gpa: 83.06, status: "LULUS" },
            "2324100074": { name: "PUTRI ANJANI", class: "12 MP B", gpa: 82.05, status: "LULUS" },
            "2324100076": { name: "PUTRI SHAFIRA RAMADHANI", class: "12 MP B", gpa: 84.23, status: "LULUS" },
            "2324100077": { name: "PUTRI YANTI", class: "12 MP B", gpa: 83.41, status: "LULUS" },
            "2324100081": { name: "RYAN HIDAYATULLAH", class: "12 MP B", gpa: 80.21, status: "LULUS" },
            "2425110281": { name: "SHENA NOFIANDINI", class: "12 MP B", gpa: 82.16, status: "LULUS" },
            "2324100090": { name: "SITI CC FAUZILLAH", class: "12 MP B", gpa: 83.53, status: "LULUS" },
            "2324100091": { name: "SITI FALISA MAULIDA", class: "12 MP B", gpa: 83.11, status: "LULUS" },
            "2324100094": { name: "SITI NURHODIJAH", class: "12 MP B", gpa: 85.54, status: "LULUS" },
            "2324100099": { name: "SRI WAHYUNI", class: "12 MP B", gpa: 82.88, status: "LULUS" },
            "2425110411": { name: "TRI RAHAYU", class: "12 MP B", gpa: 81.6, status: "LULUS" },
            "2324100107": { name: "VIONA DWI ARYANTI", class: "12 MP B", gpa: 83.26, status: "LULUS" },
            "2324100113": { name: "ZAHRA BILLAH", class: "12 MP B", gpa: 81.59, status: "LULUS" },
            "2324100004": { name: "AISYAH NUR HABIBAH", class: "12 MP C", gpa: 85.57, status: "LULUS" },
            "2324100006": { name: "AKHSAN HAIKAL PUTRA", class: "12 MP C", gpa: 84.38, status: "LULUS" },
            "2324100012": { name: "AMISHA PUTRI", class: "12 MP C", gpa: 82.59, status: "LULUS" },
            "2324100014": { name: "ANGGI", class: "12 MP C", gpa: 83.52, status: "LULUS" },
            "2324100017": { name: "ANITA", class: "12 MP C", gpa: 81.67, status: "LULUS" },
            "2324100021": { name: "ASTI ARUM MAHARANI", class: "12 MP C", gpa: 89.46, status: "LULUS" },
            "2324100023": { name: "AURA ALFIRA PRASETYO", class: "12 MP C", gpa: 83.27, status: "LULUS" },
            "2324100025": { name: "BELLA PERIYANI", class: "12 MP C", gpa: 82.8, status: "LULUS" },
            "2324100033": { name: "FEBRI SALSABILA", class: "12 MP C", gpa: 82.25, status: "LULUS" },
            "2324100038": { name: "INDAH SEPTIANTY", class: "12 MP C", gpa: 82.32, status: "LULUS" },
            "2324100043": { name: "JUWITA PUSPITA LESTARI", class: "12 MP C", gpa: 81.49, status: "LULUS" },
            "2324100047": { name: "KHARISA", class: "12 MP C", gpa: 83.28, status: "LULUS" },
            "2324100048": { name: "KIRAN AL PAH LIVI", class: "12 MP C", gpa: 83.68, status: "LULUS" },
            "2324100050": { name: "LAURA ANJANI", class: "12 MP C", gpa: 81.97, status: "LULUS" },
            "2324100055": { name: "MELLY DAMAYANTI", class: "12 MP C", gpa: 82.82, status: "LULUS" },
            "2324100056": { name: "MEYSA TIARA DEWI", class: "12 MP C", gpa: 84.03, status: "LULUS" },
            "2324100064": { name: "NADIA SAFIRA", class: "12 MP C", gpa: 82.17, status: "LULUS" },
            "2324100065": { name: "NARRANY JUNIELLE", class: "12 MP C", gpa: 83.36, status: "LULUS" },
            "2324100070": { name: "NISA AGUSTIN", class: "12 MP C", gpa: 82.7, status: "LULUS" },
            "2324100407": { name: "NUR ASIYAH", class: "12 MP C", gpa: 82.69, status: "LULUS" },
            "2324100072": { name: "NYIMAS AULIA AGUSTIN", class: "12 MP C", gpa: 84.6, status: "LULUS" },
            "2324100078": { name: "REHAN ANANDA SIDIQ", class: "12 MP C", gpa: 85.98, status: "LULUS" },
            "2324100080": { name: "REVINA", class: "12 MP C", gpa: 84.06, status: "LULUS" },
            "2324100083": { name: "RISKA DWI AULIA", class: "12 MP C", gpa: 83.69, status: "LULUS" },
            "2324100087": { name: "SERLINAH", class: "12 MP C", gpa: 83.01, status: "LULUS" },
            "2324100089": { name: "SILVA LIANA PUTRI", class: "12 MP C", gpa: 83.15, status: "LULUS" },
            "2324100095": { name: "SITI RISMAH RINDIYANI", class: "12 MP C", gpa: 82.49, status: "LULUS" },
            "2324100101": { name: "TARISTA PUTRI KIRANA", class: "12 MP C", gpa: 82.63, status: "LULUS" },
            "2324100258": { name: "USTAMA LIDA NAMIROH", class: "12 MP C", gpa: 82.55, status: "LULUS" },
            "2324100104": { name: "VERAIZKA CAHYA FAUZIAH", class: "12 MP C", gpa: 83.07, status: "LULUS" },
            "2324100110": { name: "WULAN DWI HAPSARI", class: "12 MP C", gpa: 83.97, status: "LULUS" },
            "2324100112": { name: "YENI LESTARI", class: "12 MP C", gpa: 82.7, status: "LULUS" },
            "2324100149": { name: "ABDUL FAHRI", class: "12 TKJ A", gpa: 81.57, status: "LULUS" },
            "2324100402": { name: "ADRIAN PUTRA PRAMULYA", class: "12 TKJ A", gpa: 83.76, status: "LULUS" },
            "2324100158": { name: "ALFA YUSUF ARRASYID", class: "12 TKJ A", gpa: 83.16, status: "LULUS" },
            "2324100162": { name: "ANGGI DHARMAWAN", class: "12 TKJ A", gpa: 84.49, status: "LULUS" },
            "2324100163": { name: "ARDIYANSAH", class: "12 TKJ A", gpa: 83.92, status: "LULUS" },
            "2324100165": { name: "ASSYFA MAHARANI", class: "12 TKJ A", gpa: 85.95, status: "LULUS" },
            "2324100169": { name: "BAGAS NUR RAMADHAN", class: "12 TKJ A", gpa: 85.26, status: "LULUS" },
            "2324100173": { name: "BINTANG PRAYUDHA", class: "12 TKJ A", gpa: 84.72, status: "LULUS" },
            "2324100174": { name: "BRINKMEN JANUAR ARDIANTO", class: "12 TKJ A", gpa: 84.25, status: "LULUS" },
            "2324100177": { name: "DARRUS DWI PUTRA", class: "12 TKJ A", gpa: 81.44, status: "LULUS" },
            "2324100178": { name: "DAVINA PUTRI", class: "12 TKJ A", gpa: 84.04, status: "LULUS" },
            "2324100187": { name: "FADIL RAMADAN", class: "12 TKJ A", gpa: 83.27, status: "LULUS" },
            "2324100188": { name: "FAZRI HARIANSYAH", class: "12 TKJ A", gpa: 81.0, status: "LULUS" },
            "2324100194": { name: "ILA", class: "12 TKJ A", gpa: 82.75, status: "LULUS" },
            "2324100195": { name: "IMANUEL SAPULETTE", class: "12 TKJ A", gpa: 83.66, status: "LULUS" },
            "2324100198": { name: "JIHAN RIZKY MAULIDINA", class: "12 TKJ A", gpa: 86.91, status: "LULUS" },
            "2324100199": { name: "KAFKA YAFI SAKHA", class: "12 TKJ A", gpa: 84.7, status: "LULUS" },
            "2324100201": { name: "KRISNA PUTRA FERDINAND", class: "12 TKJ A", gpa: 78.52, status: "LULUS" },
            "2324100209": { name: "MUHAMAD AFGAN", class: "12 TKJ A", gpa: 84.99, status: "LULUS" },
            "2324100211": { name: "MUHAMMAD AJI FAJRUROHIM", class: "12 TKJ A", gpa: 85.99, status: "LULUS" },
            "2324100224": { name: "MUHAMMAD IBNU", class: "12 TKJ A", gpa: 85.77, status: "LULUS" },
            "2324100216": { name: "MUHAMAD REFI", class: "12 TKJ A", gpa: 85.12, status: "LULUS" },
            "2425110410": { name: "MUHAMMAD ANTON PRABOWO", class: "12 TKJ A", gpa: 80.58, status: "LULUS" },
            "2324100226": { name: "NAY CILA PUSPITASARI", class: "12 TKJ A", gpa: 83.89, status: "LULUS" },
            "2324100234": { name: "PUTRI RAMADHANI", class: "12 TKJ A", gpa: 85.63, status: "LULUS" },
            "2324100235": { name: "RADIT MAULANA", class: "12 TKJ A", gpa: 84.67, status: "LULUS" },
            "2324100237": { name: "RAFFA PRASETYO", class: "12 TKJ A", gpa: 83.79, status: "LULUS" },
            "2324100399": { name: "RIFA ABIANSYACH", class: "12 TKJ A", gpa: 79.46, status: "LULUS" },
            "2324100406": { name: "RISKA PEBRIANI", class: "12 TKJ A", gpa: 83.52, status: "LULUS" },
            "2324100247": { name: "SARAH ERLITA", class: "12 TKJ A", gpa: 83.32, status: "LULUS" },
            "2324100398": { name: "SHANDY BANGKIT PUTRA", class: "12 TKJ A", gpa: 80.55, status: "LULUS" },
            "2324100259": { name: "WAHID FEBRIANSYAH", class: "12 TKJ A", gpa: 82.79, status: "LULUS" },
            "2324100151": { name: "ADE YUNIARTI", class: "12 TKJ B", gpa: 85.81, status: "LULUS" },
            "2324100154": { name: "AFIN MAULANA", class: "12 TKJ B", gpa: 84.5, status: "LULUS" },
            "2324100155": { name: "AJI RACHMAN", class: "12 TKJ B", gpa: 85.41, status: "LULUS" },
            "2324100156": { name: "AKBAR HAFID AULIA", class: "12 TKJ B", gpa: 84.0, status: "LULUS" },
            "2324100404": { name: "ALFIN ABI NURDIANSYAH", class: "12 TKJ B", gpa: 83.03, status: "LULUS" },
            "2324100270": { name: "ANJAR MAULANA UMAEDI", class: "12 TKJ B", gpa: 82.34, status: "LULUS" },
            "2324100164": { name: "ARI DWI ANDIKA", class: "12 TKJ B", gpa: 85.5, status: "LULUS" },
            "2324100170": { name: "BAYU RIZKI AFRILIO", class: "12 TKJ B", gpa: 81.67, status: "LULUS" },
            "2324100180": { name: "DEVIKA RAMADANI", class: "12 TKJ B", gpa: 86.8, status: "LULUS" },
            "2324100181": { name: "DIAN ANDITA", class: "12 TKJ B", gpa: 82.72, status: "LULUS" },
            "2324100183": { name: "EGA PRATAMA", class: "12 TKJ B", gpa: 83.19, status: "LULUS" },
            "2324100189": { name: "FETTY AFRIANTI", class: "12 TKJ B", gpa: 85.39, status: "LULUS" },
            "2324100190": { name: "GOLDY SHANDIKA RIZQIA", class: "12 TKJ B", gpa: 84.93, status: "LULUS" },
            "2324100191": { name: "HILAL FATTAH HIDAYAT", class: "12 TKJ B", gpa: 82.75, status: "LULUS" },
            "2324100196": { name: "INTAN PERMATASARI", class: "12 TKJ B", gpa: 81.62, status: "LULUS" },
            "2324100206": { name: "MARCELL AFRIZA DITYA", class: "12 TKJ B", gpa: 80.42, status: "LULUS" },
            "2324100207": { name: "MOHAMAD AMAR KADAFI", class: "12 TKJ B", gpa: 81.52, status: "LULUS" },
            "2324100213": { name: "MUHAMAD ALWAN FUDOLI", class: "12 TKJ B", gpa: 83.06, status: "LULUS" },
            "2324100220": { name: "MUHAMMAD AFRIJAL", class: "12 TKJ B", gpa: 86.1, status: "LULUS" },
            "2324100204": { name: "MUHAMMAD SUBHAN ALWANSYAH", class: "12 TKJ B", gpa: 80.28, status: "LULUS" },
            "2324100228": { name: "NOVAN SUGINA", class: "12 TKJ B", gpa: 81.17, status: "LULUS" },
            "2324100231": { name: "NURUL FITRIA", class: "12 TKJ B", gpa: 85.48, status: "LULUS" },
            "2324100233": { name: "PANDU SURYANATA", class: "12 TKJ B", gpa: 85.26, status: "LULUS" },
            "2324100238": { name: "RAHMAT FEBRIAN", class: "12 TKJ B", gpa: 80.58, status: "LULUS" },
            "2324100349": { name: "RIFKI AGUSTINO", class: "12 TKJ B", gpa: 81.4, status: "LULUS" },
            "2324100245": { name: "RO'UF JANUAR", class: "12 TKJ B", gpa: 81.69, status: "LULUS" },
            "2324100246": { name: "RULLY DWI ADESTIAN", class: "12 TKJ B", gpa: 77.72, status: "LULUS" },
            "2324100250": { name: "SEPTIA WULANDARI", class: "12 TKJ B", gpa: 82.62, status: "LULUS" },
            "2324100254": { name: "SITI ROHAYATI", class: "12 TKJ B", gpa: 83.62, status: "LULUS" },
            "2324100396": { name: "TALITA SALSABILA", class: "12 TKJ B", gpa: 83.16, status: "LULUS" },
            "2324100260": { name: "WAHYU PUTRA ROMADHONI", class: "12 TKJ B", gpa: 81.36, status: "LULUS" },
            "2324100261": { name: "WISNU SHODIK MAULANA ARRAHIM", class: "12 TKJ B", gpa: 85.09, status: "LULUS" },
            "2324100150": { name: "ADE LIA", class: "12 TKJ C", gpa: 85.5, status: "LULUS" },
            "2324100157": { name: "ALAMSYAH PANDU DEWANTORO", class: "12 TKJ C", gpa: 85.48, status: "LULUS" },
            "2324100160": { name: "ANANDA RIZKI", class: "12 TKJ C", gpa: 84.22, status: "LULUS" },
            "2324100161": { name: "ANGGARA SUCIPTO", class: "12 TKJ C", gpa: 82.57, status: "LULUS" },
            "2324100166": { name: "AUFAA ALFAREZI FEBRIANTO", class: "12 TKJ C", gpa: 83.14, status: "LULUS" },
            "2324100167": { name: "AZIZ NURHIDAYAT", class: "12 TKJ C", gpa: 83.79, status: "LULUS" },
            "2324100168": { name: "BAGAS ARIANTO", class: "12 TKJ C", gpa: 84.94, status: "LULUS" },
            "2324100172": { name: "BINTANG G PRATAMA", class: "12 TKJ C", gpa: 87.64, status: "LULUS" },
            "2324100176": { name: "CHAYO NUGRAHA", class: "12 TKJ C", gpa: 81.8, status: "LULUS" },
            "2425110409": { name: "DAPA SETIAWAN", class: "12 TKJ C", gpa: 82.45, status: "LULUS" },
            "2324100179": { name: "DECHA ALYA RAMADHAN", class: "12 TKJ C", gpa: 82.66, status: "LULUS" },
            "2324100403": { name: "EGI SUMAYADI", class: "12 TKJ C", gpa: 80.42, status: "LULUS" },
            "2324100184": { name: "ERTIAWATI", class: "12 TKJ C", gpa: 82.83, status: "LULUS" },
            "2324100192": { name: "IBNU ALVIAN", class: "12 TKJ C", gpa: 81.7, status: "LULUS" },
            "2324100193": { name: "IKSAN SETIAWAN", class: "12 TKJ C", gpa: 81.85, status: "LULUS" },
            "2324100197": { name: "IRA RAHMAWATI", class: "12 TKJ C", gpa: 81.61, status: "LULUS" },
            "2324100205": { name: "MADJID DJABAR", class: "12 TKJ C", gpa: 85.32, status: "LULUS" },
            "2324100214": { name: "MUHAMAD EFAN FAUJI", class: "12 TKJ C", gpa: 84.88, status: "LULUS" },
            "2324100223": { name: "MUHAMAD FAHRY FEBRIAN AL HUSAINI", class: "12 TKJ C", gpa: 79.34, status: "LULUS" },
            "2324100286": { name: "MUHAMAD ILHAM", class: "12 TKJ C", gpa: 81.86, status: "LULUS" },
            "2324100218": { name: "MUHAMAD RIDWAN", class: "12 TKJ C", gpa: 82.59, status: "LULUS" },
            "2324100219": { name: "MUHAMAD YUSUF BAHTIAR", class: "12 TKJ C", gpa: 86.55, status: "LULUS" },
            "2324100221": { name: "MUHAMMAD DIMAS AGUNG LAKSONO", class: "12 TKJ C", gpa: 85.09, status: "LULUS" },
            "2324100230": { name: "NURLITA AMELIA PUTRI", class: "12 TKJ C", gpa: 85.02, status: "LULUS" },
            "2324100186": { name: "FACHRY PEBRIAN", class: "12 TKJ C", gpa: 82.12, status: "LULUS" },
            "2324100232": { name: "PAJAR SARIP", class: "12 TKJ C", gpa: 81.47, status: "LULUS" },
            "2324100236": { name: "RADITYA ALFATTAH MARDIYUWANA", class: "12 TKJ C", gpa: 82.01, status: "LULUS" },
            "2324100240": { name: "REPAN RAMADANSYAH", class: "12 TKJ C", gpa: 82.74, status: "LULUS" },
            "2324100400": { name: "RISMA", class: "12 TKJ C", gpa: 84.27, status: "LULUS" },
            "2324100244": { name: "RIZKI", class: "12 TKJ C", gpa: 83.91, status: "LULUS" },
            "2324100256": { name: "SITI ULPIAH", class: "12 TKJ C", gpa: 82.88, status: "LULUS" },
            "2324100262": { name: "YUDIA RAHMAWATI", class: "12 TKJ C", gpa: 83.47, status: "LULUS" },
            "2324100114": { name: "ABDUL AZIZ PRATAMA", class: "12 TKR", gpa: 80.74, status: "LULUS" },

            "2324100116": { name: "AHMAD ZIDAN FAHREZI", class: "12 TKR", gpa: 79.72, status: "LULUS" },
            "2324100118": { name: "ALFIYANA WAHYUDIN", class: "12 TKR", gpa: 83.14, status: "LULUS" },
            "2324100119": { name: "ARGA VINCENT", class: "12 TKR", gpa: 80.52, status: "LULUS" },
            "2324100121": { name: "BAGUS SETIAWAN", class: "12 TKR", gpa: 83.65, status: "LULUS" },
            "2324100122": { name: "CECEP MUHYIDIN", class: "12 TKR", gpa: 80.61, status: "LULUS" },
            "2324100123": { name: "DAMAS AKRI WIJAYA", class: "12 TKR", gpa: 82.23, status: "LULUS" },
            "2324100359": { name: "DAVID MARCEL LORENZO ANGGARA PUTRA", class: "12 TKR", gpa: 77.7, status: "LULUS" },
            "2324100124": { name: "DUTA PERKASA SEPTIAWAN BAKKARA", class: "12 TKR", gpa: 82.19, status: "LULUS" },
            "2324100128": { name: "HUSRIYAL", class: "12 TKR", gpa: 80.28, status: "LULUS" },
            "2324100131": { name: "M.RIFAL", class: "12 TKR", gpa: 82.13, status: "LULUS" },
            "2324100397": { name: "MAIDIL PUTRA", class: "12 TKR", gpa: 81.57, status: "LULUS" },

            "232410460": { name: "MUHAMAD FAHRI ADITIA", class: "12 TKR", gpa: 81.58, status: "LULUS" },
            "2324100137": { name: "MUHAMAD RIANA", class: "12 TKR", gpa: 80.44, status: "LULUS" },
            "2324100401": { name: "MUHAMAD AGIL AL FARIZ", class: "12 TKR", gpa: 82.82, status: "LULUS" },
            "2324100142": { name: "MUHAMMAD RAUL SANJAYA", class: "12 TKR", gpa: 83.2, status: "LULUS" },
            "2324100143": { name: "MUHAMMAD RIFKY FABIAN", class: "12 TKR", gpa: 82.52, status: "LULUS" },
            "2324100144": { name: "OKI JULIANSYACH", class: "12 TKR", gpa: 84.1, status: "LULUS" },
            "2324100145": { name: "REHAN FERDIANSAH", class: "12 TKR", gpa: 81.75, status: "LULUS" },
            "2324100146": { name: "RICCO RICCARDO", class: "12 TKR", gpa: 79.63, status: "LULUS" },
            "2324100147": { name: "RIO EPENDI", class: "12 TKR", gpa: 80.74, status: "LULUS" },
            "2324100263": { name: "ABDAN FAJRI DAULANI", class: "12 TSM A", gpa: 81.63, status: "LULUS" },
            "2324100266": { name: "AHMAD FATHIR RIYANSYAH", class: "12 TSM A", gpa: 81.21, status: "LULUS" },
            "2324100268": { name: "AHMAD RIVALDI AL FARIZI", class: "12 TSM A", gpa: 86.29, status: "LULUS" },
            "2324100271": { name: "APIP APIYANSAH", class: "12 TSM A", gpa: 81.16, status: "LULUS" },
            "2324100314": { name: "ARYA FADILAH", class: "12 TSM A", gpa: 80.01, status: "LULUS" },
            "2324100272": { name: "CIKAL SAPUTRA", class: "12 TSM A", gpa: 82.44, status: "LULUS" },
            "2324100317": { name: "EVAN RIZQI PRAMUDIA SETIAWAN", class: "12 TSM A", gpa: 82.0, status: "LULUS" },
            "2324100318": { name: "FAJAR ALFIANSYAH", class: "12 TSM A", gpa: 80.02, status: "LULUS" },
            "2324100277": { name: "GUSMAN PULUNGAN", class: "12 TSM A", gpa: 81.61, status: "LULUS" },
            "2324100322": { name: "JONATHAN VEDRICO MANALU", class: "12 TSM A", gpa: 80.11, status: "LULUS" },
            "2324100289": { name: "M RAFI RAMADHAN", class: "12 TSM A", gpa: 79.54, status: "LULUS" },
            "2324100324": { name: "MIFTAH FAUZI", class: "12 TSM A", gpa: 81.34, status: "LULUS" },
            "2324100281": { name: "MOHAMAD REPAN ALDIANSAH", class: "12 TSM A", gpa: 80.29, status: "LULUS" },
            "2324100326": { name: "MUHAMAD ADITIA PERMANA", class: "12 TSM A", gpa: 80.02, status: "LULUS" },
            "2324100329": { name: "MUHAMAD ANANTA AJI", class: "12 TSM A", gpa: 80.94, status: "LULUS" },
            "2324100331": { name: "MUHAMAD DICKY FIRMANSYAH", class: "12 TSM A", gpa: 81.69, status: "LULUS" },
            "2324100284": { name: "MUHAMAD GILANG RAMADHAN", class: "12 TSM A", gpa: 82.02, status: "LULUS" },
            "2324100325": { name: "MUHAMAD IRPAN MAULANA", class: "12 TSM A", gpa: 80.83, status: "LULUS" },
            "2324100288": { name: "MUHAMAD MICO FERDIANSYAH", class: "12 TSM A", gpa: 82.39, status: "LULUS" },
            "2324100333": { name: "MUHAMAD MUNAWIR", class: "12 TSM A", gpa: 80.16, status: "LULUS" },
            "2324100337": { name: "MUHAMAD RIZKI FAHLEPI", class: "12 TSM A", gpa: 83.94, status: "LULUS" },
            "2324100292": { name: "MUHAMAD SAEPUL ANWAR", class: "12 TSM A", gpa: 80.4, status: "LULUS" },
            "2324100339": { name: "MUHAMAD WES RAMDANI", class: "12 TSM A", gpa: 82.12, status: "LULUS" },
            "2324100340": { name: "MUHAMMAD DEWA PURNAMA", class: "12 TSM A", gpa: 79.4, status: "LULUS" },
            "2324100296": { name: "MUHAMMAD IRVAN", class: "12 TSM A", gpa: 80.42, status: "LULUS" },
            "2324100298": { name: "PANJI SUHENDRA PUTRA", class: "12 TSM A", gpa: 82.29, status: "LULUS" },
            "2324100343": { name: "RAJIB IKDIYANA", class: "12 TSM A", gpa: 80.75, status: "LULUS" },
            "2324100344": { name: "RANGGA", class: "12 TSM A", gpa: 80.6, status: "LULUS" },
            "2324100345": { name: "RESTU BUMI RAMADHAN", class: "12 TSM A", gpa: 81.21, status: "LULUS" },
            "2324100347": { name: "RIDO ABDILLAH", class: "12 TSM A", gpa: 81.14, status: "LULUS" },
            "2324100348": { name: "RIFFA RAYAN QURAIS", class: "12 TSM A", gpa: 81.82, status: "LULUS" },
            "2324100306": { name: "SUKATMA", class: "12 TSM A", gpa: 82.61, status: "LULUS" },
            "2324100354": { name: "SULTAN RABBILHAQ", class: "12 TSM A", gpa: 86.03, status: "LULUS" },
            "2324100307": { name: "SULTHAN RAFIF DWI PRASETYA", class: "12 TSM A", gpa: 81.32, status: "LULUS" },
            "2324100356": { name: "WILDAN MAULANA DZIKRI", class: "12 TSM A", gpa: 83.88, status: "LULUS" },
            "2324100310": { name: "ABDUL MALIK AWALUDIN", class: "12 TSM B", gpa: 80.5, status: "LULUS" },
            "2324100311": { name: "ADJIE FEBRIANSYAH", class: "12 TSM B", gpa: 81.48, status: "LULUS" },
            "2324100312": { name: "AHMAD FAUZAN", class: "12 TSM B", gpa: 82.75, status: "LULUS" },
            "2324100313": { name: "ALFATH NURFADILLAH", class: "12 TSM B", gpa: 90.03, status: "LULUS" },
            "2425110287": { name: "CAHYA RIZKI WIDIYANA PUTRA", class: "12 TSM B", gpa: 80.86, status: "LULUS" },
            "2324100274": { name: "DENI SETIAWAN", class: "12 TSM B", gpa: 85.12, status: "LULUS" },
            "2324100275": { name: "ERVAN SETIAWAN", class: "12 TSM B", gpa: 81.95, status: "LULUS" },
            "2324100276": { name: "FAREL ADITYA", class: "12 TSM B", gpa: 83.24, status: "LULUS" },
            "2324100319": { name: "GHERY SATYA AFRIANSYAH", class: "12 TSM B", gpa: 82.5, status: "LULUS" },
            "2324100279": { name: "KIKI AFREZA", class: "12 TSM B", gpa: 81.89, status: "LULUS" },
            "2324100297": { name: "M. ERLANGGA DWI PUTRA", class: "12 TSM B", gpa: 83.85, status: "LULUS" },
            "2324100280": { name: "M. FARHAN", class: "12 TSM B", gpa: 81.99, status: "LULUS" },
            "2324100323": { name: "M.FAHREL PRATAMA", class: "12 TSM B", gpa: 83.02, status: "LULUS" },
            "2324100327": { name: "MUHAMAD ADLI FIRMANSYAH", class: "12 TSM B", gpa: 83.23, status: "LULUS" },
            "2324100282": { name: "MUHAMAD AJI MAULANA", class: "12 TSM B", gpa: 79.82, status: "LULUS" },
            "2324100328": { name: "MUHAMAD AL PAJRI", class: "12 TSM B", gpa: 81.03, status: "LULUS" },
            "2324100273": { name: "MUHAMAD DARUL ULUM", class: "12 TSM B", gpa: 84.3, status: "LULUS" },
            "2324100332": { name: "MUHAMAD FARHAN NAUVAL AL ISLAMI", class: "12 TSM B", gpa: 81.37, status: "LULUS" },
            "2324100285": { name: "MUHAMAD IKLIL RAVAEL", class: "12 TSM B", gpa: 82.49, status: "LULUS" },
            "2324100341": { name: "MUHAMAD MUDORI", class: "12 TSM B", gpa: 81.76, status: "LULUS" },
            "2324100290": { name: "MUHAMAD RAIHAN KHAIRUL ILHAM", class: "12 TSM B", gpa: 81.15, status: "LULUS" },
            "2324100335": { name: "MUHAMAD RAMADANI", class: "12 TSM B", gpa: 81.59, status: "LULUS" },
            "2324100291": { name: "MUHAMAD RIKI", class: "12 TSM B", gpa: 80.26, status: "LULUS" },
            "2324100293": { name: "MUHAMAD SARIPUDIN", class: "12 TSM B", gpa: 80.36, status: "LULUS" },
            "2324100338": { name: "MUHAMAD SUBANDI", class: "12 TSM B", gpa: 81.08, status: "LULUS" },
            "2324100334": { name: "MUHAMMAD NURUL HUDA", class: "12 TSM B", gpa: 82.47, status: "LULUS" },
            "2324100299": { name: "RAGA CAHYADI", class: "12 TSM B", gpa: 81.66, status: "LULUS" },
            "2324100301": { name: "REZA ADITYA PRATAMA", class: "12 TSM B", gpa: 82.01, status: "LULUS" },
            "2324100346": { name: "REZA APRIANSYAH", class: "12 TSM B", gpa: 80.56, status: "LULUS" },
            "2324100302": { name: "REZGA DEARDO TARIGAN", class: "12 TSM B", gpa: 83.3, status: "LULUS" },
            "2324100350": { name: "RIZKI MAULANA", class: "12 TSM B", gpa: 80.18, status: "LULUS" },
            "2324100304": { name: "SAKTI MORENO AGUSTA", class: "12 TSM B", gpa: 80.95, status: "LULUS" },
            "2324100305": { name: "SAWILA", class: "12 TSM B", gpa: 82.67, status: "LULUS" },
            "2324100355": { name: "VINO BAHARI", class: "12 TSM B", gpa: 80.09, status: "LULUS" },
            "2324100309": { name: "YANDI HERDIANSYAH", class: "12 TSM B", gpa: 80.3, status: "LULUS" }
        };

        // ========== VARIABEL CAPTCHA & WAKTU ==========
        let currentCaptchaAnswer = 0;
        let countdownInterval;

        // Waktu akses diatur pada zona Waktu Indonesia Barat (WIB / +07:00)
        const targetStart = new Date("2026-05-04T00:00:00+07:00").getTime();
        const targetEnd = new Date("2026-05-04T23:59:59+07:00").getTime();

        // ========== ACCESS CONTROL ==========
        function initAccessControl() {
            const TEST_MODE = false; // False berarti akan mengikuti waktu jadwal yang diatur

            if(TEST_MODE) {
                const badge = document.createElement('div');
                badge.className = 'test-badge';
                badge.innerText = '🧪 MODE UJI COBA';
                document.body.appendChild(badge);

                // Buka semua halaman
                document.getElementById('access-denied').style.display = 'none';
                document.getElementById('home-page').style.display = 'block';
                document.querySelector('.navbar').style.display = 'flex';
                return true;
            }

            checkAccess();
            countdownInterval = setInterval(checkAccess, 1000);
        }

        function checkAccess() {
    const now = new Date().getTime();
    const accessDeniedEl = document.getElementById('access-denied');

    if (now < targetStart) {
        showAccessDenied();
        updateCountdown(targetStart - now);
    } else if (now >= targetStart && now <= targetEnd) {
        // Hentikan interval agar tidak membebani memori
        clearInterval(countdownInterval);

        // Sembunyikan layar pengunci
        accessDeniedEl.style.display = 'none';

        // PAKSA TAMPIL: Tidak perlu cek kondisi display lagi
        document.getElementById('home-page').style.display = 'block';
        document.querySelector('.navbar').style.display = 'flex';

        // Pastikan partikel latar belakang tetap berjalan
        createParticles();
    } else {
        clearInterval(countdownInterval);
        showAccessDenied();
        document.getElementById('countdown-wrapper').style.display = 'none';
        document.getElementById('closed-message').style.display = 'block';
    }
}

        function showAccessDenied() {
            document.getElementById('home-page').style.display = 'none';
            document.getElementById('graduation-page').style.display = 'none';
            document.querySelector('.navbar').style.display = 'none';
            document.getElementById('access-denied').style.display = 'flex';
        }

        function updateCountdown(distance) {
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('cd-days').innerText = days.toString().padStart(2, '0');
            document.getElementById('cd-hours').innerText = hours.toString().padStart(2, '0');
            document.getElementById('cd-minutes').innerText = minutes.toString().padStart(2, '0');
            document.getElementById('cd-seconds').innerText = seconds.toString().padStart(2, '0');
        }

        // Fungsi generate captcha (penjumlahan acak)
        function generateCaptcha() {
            const num1 = Math.floor(Math.random() * 19) + 2; // 2-20
            const num2 = Math.floor(Math.random() * 19) + 2;
            currentCaptchaAnswer = num1 + num2;
            document.getElementById('captcha-question-text').innerHTML = `${num1} + ${num2} = ?`;
            document.getElementById('captcha-input').value = '';
            document.getElementById('captcha-error').innerHTML = '';
        }

        // Validasi captcha
        function isCaptchaValid() {
            const userAnswer = parseInt(document.getElementById('captcha-input').value.trim(), 10);
            if (isNaN(userAnswer)) {
                document.getElementById('captcha-error').innerHTML = '⚠️ Masukkan jawaban numerik!';
                return false;
            }
            if (userAnswer !== currentCaptchaAnswer) {
                document.getElementById('captcha-error').innerHTML = '❌ Jawaban CAPTCHA salah. Silakan refresh dan coba lagi.';
                return false;
            }
            document.getElementById('captcha-error').innerHTML = '';
            return true;
        }

        // ========== NAVIGATION ==========
        function showPage(page) {
    const home = document.getElementById('home-page');
    const grad = document.getElementById('graduation-page');
    const links = document.querySelectorAll('.nav-links a');

    if(page === 'home') {
        home.style.display = 'block';
        grad.style.display = 'none'; // Pastikan ini tertutup
        grad.classList.remove('active');
        links[0].classList.add('active');
        links[1].classList.remove('active');
    } else {
        home.style.display = 'none';
        grad.style.display = 'flex'; // Paksa tampil dengan Flex
        grad.classList.add('active');
        links[1].classList.add('active');
        links[0].classList.remove('active');
        document.getElementById('nis-input')?.focus();
        generateCaptcha();
    }
}

        // ========== CONFETTI ==========
        function fireConfetti() {
            const canvas = document.getElementById('confetti-canvas');
            if(!canvas) return;
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            const ctx = canvas.getContext('2d');
            let pieces = [];
            for(let i=0;i<180;i++) {
                pieces.push({
                    x: Math.random()*canvas.width, y: Math.random()*canvas.height - canvas.height,
                    w: 6+Math.random()*9, h: 4+Math.random()*6,
                    color: `hsl(${Math.random()*360}, 80%, 65%)`,
                    speed: 3+Math.random()*5, drift: (Math.random()-0.5)*2, spin: (Math.random()-0.5)*0.1, angle: Math.random()*6.28, opacity:1
                });
            }
            let frames=0;
            function animateConfetti(){
                if(frames>280){ ctx.clearRect(0,0,canvas.width,canvas.height); return; }
                ctx.clearRect(0,0,canvas.width,canvas.height);
                pieces.forEach(p=>{ p.y+=p.speed; p.x+=p.drift; p.angle+=p.spin; if(frames>200) p.opacity-=0.01;
                    ctx.save(); ctx.translate(p.x,p.y); ctx.rotate(p.angle); ctx.globalAlpha=Math.max(0,p.opacity);
                    ctx.fillStyle=p.color; ctx.fillRect(-p.w/2,-p.h/2,p.w,p.h); ctx.restore();
                }); frames++; requestAnimationFrame(animateConfetti);
            }
            animateConfetti();
        }

        // ========== SHOW RESULT ==========
        function showResult(student, nis){
            const section = document.getElementById('result-section');
            const card = document.getElementById('result-card');
            const emojiContainer = document.getElementById('result-emoji');
            const statusEl = document.getElementById('result-status');
            const nameEl = document.getElementById('result-name');
            const nisEl = document.getElementById('result-nis');
            const detailsDiv = document.getElementById('result-details');
            const noteContainer = document.getElementById('graduation-note-container');

            noteContainer.innerHTML = '';
            emojiContainer.innerHTML = '<div><img src="/images/logobaru.png" alt="Logo Sekolah" class="school-logo" onerror="this.style.display=\'none\'"></div>';
            card.className = 'result-card';

            if(student.status === 'LULUS') {
                card.classList.add('lulus');
                statusEl.innerHTML = 'Selamat anda dinyatakan LULUS 🎉';
                statusEl.className = 'result-status lulus-text';
                fireConfetti();

                const noteHTML = `
                    <div class="graduation-note">
                        <p style="margin-top:6px;">🎓 <em>“Kesuksesan adalah awal dari perjuangan baru. Tetap semangat!”</em></p>
                        <p style="margin-top:12px; font-size:0.8rem; color:#a0d9a0;">Pernyataan kelulusan ini berdasarkan Surat Keputusan Hasil Rapat Pleno Kelulusan oleh Dewan Guru pada tanggal 02 Mei 2026    </p>
                    </div>
                `;
                noteContainer.innerHTML = noteHTML;
            } else {
                card.classList.add('tidak-lulus');
                statusEl.innerHTML = 'Belum Lulus 😔';
                statusEl.className = 'result-status tidak-text';
            }
            nameEl.innerText = student.name;
            nisEl.innerText = `NIS: ${nis}  •  ${student.class}`;
            detailsDiv.innerHTML = `
                <div class="detail-item"><div class="label">Rata-rata nilai akhir</div><div class="value">${student.gpa.toFixed(2)}</div></div>
                <div class="detail-item"><div class="label">Status Final</div><div class="value">${student.status === 'LULUS' ? '✅ LULUS' : '❌ TIDAK LULUS'}</div></div>
            `;
            section.style.display = 'block';
            section.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function showNotFound(nis) {
            const section = document.getElementById('result-section');
            const card = document.getElementById('result-card');
            const emojiContainer = document.getElementById('result-emoji');
            const noteContainer = document.getElementById('graduation-note-container');
            noteContainer.innerHTML = '';
            emojiContainer.innerHTML = '<div><img src="/images/logobaru.png" alt="Logo Sekolah" class="school-logo" onerror="this.style.display=\'none\'"></div>';
            document.getElementById('result-status').innerHTML = 'DATA TIDAK DITEMUKAN';
            document.getElementById('result-status').className = 'result-status notfound-text';
            document.getElementById('result-name').innerText = 'DATA TIDAK DITEMUKAN';
            document.getElementById('result-nis').innerText = `NIS: ${nis}`;
            document.getElementById('result-details').innerHTML = `<div class="detail-item"><div class="label">Hubungi wali kelas jika terdapat masalah sistem</div></div>`;
            card.className = 'result-card not-found';
            section.style.display = 'block';
        }

        // ========== CEK KELULUSAN ==========
        function checkGraduation() {
            if (!isCaptchaValid()) {
                const captchaDiv = document.getElementById('captcha-container');
                captchaDiv.classList.add('shake-animation');
                setTimeout(() => captchaDiv.classList.remove('shake-animation'), 500);
                return;
            }

            const nis = document.getElementById('nis-input').value.trim();
            if(!nis) {
                document.getElementById('nis-input').classList.add('shake-animation');
                setTimeout(()=> document.getElementById('nis-input').classList.remove('shake-animation'), 500);
                return;
            }

            const btn = document.getElementById('btn-check');
            const spinner = document.querySelector('.btn-check .spinner');
            const btnText = document.querySelector('.btn-check .btn-text');
            spinner.style.display = 'inline-block'; btnText.style.display = 'none';

            setTimeout(()=>{
                spinner.style.display = 'none'; btnText.style.display = 'inline-block';
                const student = studentsDB[nis];
                if(student) showResult(student, nis);
                else showNotFound(nis);
                generateCaptcha();
            }, 700);
        }

        function resetForm() {
            document.getElementById('nis-input').value = '';
            document.getElementById('result-section').style.display = 'none';
            document.getElementById('nis-input').focus();
            generateCaptcha();
        }

        function createParticles() {
            const container = document.getElementById('particles');
            for(let i=0;i<40;i++) {
                const p = document.createElement('div');
                p.classList.add('particle');
                p.style.width = Math.random()*7+2+'px';
                p.style.height = p.style.width;
                p.style.left = Math.random()*100+'%';
                p.style.background = `hsl(${Math.random()*60 + 210}, 70%, 65%)`;
                p.style.animationDuration = 10+Math.random()*20+'s';
                p.style.animationDelay = Math.random()*15+'s';
                container.appendChild(p);
            }
        }

        // ========== INIT ==========
        window.addEventListener('DOMContentLoaded',() => {
            initAccessControl();
            createParticles();
            generateCaptcha();
            const observer = new IntersectionObserver((entries)=>{ entries.forEach(e=>{ if(e.isIntersecting) e.target.classList.add('visible'); }); },{threshold:0.1});
            document.querySelectorAll('.animate-on-scroll').forEach(el=>observer.observe(el));
            window.showPage = showPage;
            window.checkGraduation = checkGraduation;
            window.resetForm = resetForm;
            window.generateCaptcha = generateCaptcha;
        });
        window.addEventListener('resize',()=>{ let c=document.getElementById('confetti-canvas'); if(c) c.width=window.innerWidth,c.height=window.innerHeight; });
    </script>
</body>
</html>
