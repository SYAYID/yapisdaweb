@extends('layouts.app')
@section('title', 'Home - YAPISDA')
@section('meta_title', 'YAPISDA - Pendaftaran Siswa Baru 2026/2027')
@section('meta_description', 'Daftar sekarang di SMKS & SMPS YAPISDA. Yayasan Pendidikan Islam Daar El Rohmah - Mencetak generasi berakhlak mulia, cerdas, dan berprestasi. Kuota terbatas!')
@section('og_title', 'YAPISDA - Pendaftaran Siswa Baru 2026/2027')
@section('og_description', 'Daftar sekarang di SMKS & SMPS YAPISDA. Kuota terbatas!')
@section('og_image', asset('images/brosur1.jpeg'))
@section('twitter_title', 'YAPISDA - Pendaftaran Siswa Baru 2026/2027')
@section('twitter_description', 'Daftar sekarang di SMKS & SMPS YAPISDA. Kuota terbatas!')
@section('twitter_image', asset('images/brosur1.jpeg'))

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,800;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
/* ══════════════════════════════════════════
   🏛️ YAPISDA — ISLAMIC MODERN LUXURY
   Theme: Deep Forest Green × Warm Gold × Ivory
   Font: Playfair Display + DM Sans
══════════════════════════════════════════ */

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

    --ff-display: 'Playfair Display', Georgia, serif;
    --ff-body:    'DM Sans', 'Segoe UI', sans-serif;

    --r-sm:   8px;
    --r-md:  16px;
    --r-lg:  24px;
    --r-xl:  36px;
    --r-pill:9999px;

    --ease-expo: cubic-bezier(0.16, 1, 0.3, 1);
    --ease-back: cubic-bezier(0.34, 1.56, 0.64, 1);

    --shadow-gold: 0 8px 40px rgba(201,168,76,0.25);
    --shadow-deep: 0 20px 60px rgba(0,0,0,0.35);
}

*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
html { scroll-behavior:smooth; scroll-padding-top:90px; }

body {
    font-family: var(--ff-body);
    background: var(--ivory);
    color: var(--text-dark);
    line-height: 1.7;
    overflow-x: hidden;
    -webkit-font-smoothing: antialiased;
}

/* ── KEYFRAMES ── */
@keyframes shimmer-gold {
    0%   { background-position: -200% center; }
    100% { background-position:  200% center; }
}
@keyframes float-up {
    0%,100% { transform: translateY(0); }
    50%      { transform: translateY(-14px); }
}
@keyframes spin { to { transform: rotate(360deg); } }
@keyframes fadeUp {
    from { opacity:0; transform:translateY(28px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes fadeScale {
    from { opacity:0; transform:scale(0.94); }
    to   { opacity:1; transform:scale(1); }
}
@keyframes reveal-line {
    from { transform: scaleX(0); }
    to   { transform: scaleX(1); }
}
@keyframes particle-rise {
    0%   { transform:translateY(0) scale(1); opacity:0; }
    10%  { opacity:1; }
    90%  { opacity:0.6; }
    100% { transform:translateY(-100vh) scale(0.3); opacity:0; }
}
@keyframes arabesque-spin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}
@keyframes pulse-ring {
    0%   { transform: scale(1); opacity:0.8; }
    100% { transform: scale(1.6); opacity:0; }
}

/* ══════════════════════════════
   LOADING
══════════════════════════════ */
.loading-screen {
    position:fixed; inset:0;
    background: var(--forest);
    display:flex; align-items:center; justify-content:center;
    z-index:9999;
    transition: opacity 0.7s var(--ease-expo), visibility 0.7s;
}
.loading-screen.hidden { opacity:0; visibility:hidden; pointer-events:none; }

.loading-inner { text-align:center; }

.loading-emblem {
    width:90px; height:90px;
    margin:0 auto 1.5rem;
    position:relative;
    animation: float-up 3s ease-in-out infinite;
}
.loading-emblem-ring {
    position:absolute; inset:0;
    border:2px solid transparent;
    border-top-color: var(--gold);
    border-right-color: var(--gold-light);
    border-radius:50%;
    animation: spin 1.8s linear infinite;
}
.loading-emblem-core {
    position:absolute; inset:10px;
    background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
    border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    font-size:1.8rem; color:white;
}
.loading-text {
    font-family: var(--ff-display);
    color: var(--gold-light);
    font-size:1.1rem; letter-spacing:0.15em;
    text-transform:uppercase;
    opacity:0.9;
}

/* ══════════════════════════════
   CONTAINER
══════════════════════════════ */
.container {
    max-width:1240px;
    margin:0 auto;
    padding:0 2rem;
}

/* ══════════════════════════════
   HERO
══════════════════════════════ */
.hero {
    min-height:94vh;
    background:
        linear-gradient(90deg, rgba(6, 31, 26, 0.94) 0%, rgba(8, 50, 41, 0.86) 48%, rgba(8, 50, 41, 0.52) 100%),
        url('{{ asset('images/brosur6.png') }}') center/cover;
    position:relative;
    overflow:hidden;
    display:flex; align-items:center;
}

.hero-bg-mesh {
    position: absolute;
    inset: 0;
    z-index: 0;
    width: 100%;
    height: 100%;
    background: var(--forest);
    overflow: hidden;
}

.mesh-glow {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.45;
    mix-blend-mode: screen;
    will-change: transform;
}

.mesh-glow-1 {
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, #105c4b 0%, rgba(16,92,75,0) 70%);
    top: -10%;
    left: -10%;
    animation: mesh-move-1 25s infinite alternate ease-in-out;
}

.mesh-glow-2 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, #1f9aa5 0%, rgba(31,154,165,0) 70%);
    bottom: -5%;
    right: -5%;
    animation: mesh-move-2 20s infinite alternate ease-in-out;
}

.mesh-glow-3 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, var(--gold) 0%, rgba(201,168,76,0) 70%);
    top: 30%;
    right: 20%;
    animation: mesh-move-3 30s infinite alternate ease-in-out;
}

@keyframes mesh-move-1 {
    0% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(80px, 60px) scale(1.1); }
    100% { transform: translate(-40px, 40px) scale(0.9); }
}

@keyframes mesh-move-2 {
    0% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(-60px, -80px) scale(0.95); }
    100% { transform: translate(40px, -30px) scale(1.05); }
}

@keyframes mesh-move-3 {
    0% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(60px, -40px) scale(1.05); }
    100% { transform: translate(-50px, 60px) scale(0.9); }
}

/* Geometric Islamic pattern overlay */
.hero-pattern {
    position:absolute; inset:0;
    background-image:
        linear-gradient(90deg, rgba(6,31,26,0.94) 0%, rgba(8,50,41,0.84) 47%, rgba(8,50,41,0.52) 100%),
        linear-gradient(180deg, rgba(6,31,26,0.1), rgba(6,31,26,0.44)),
        radial-gradient(circle at 18% 82%, rgba(201,168,76,0.18) 0%, transparent 34%);
    z-index:1;
}

/* Noise texture */
.hero-noise {
    position:absolute; inset:0; z-index:2;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
    opacity:0.4; pointer-events:none;
}

/* Arabesque decorative circles */
.arabesque {
    position:absolute;
    border-radius:50%;
    border:1px solid rgba(201,168,76,0.15);
    pointer-events:none; z-index:2;
}
.arabesque-1 { width:600px; height:600px; top:-200px; right:-150px; animation: arabesque-spin 80s linear infinite; }
.arabesque-1::before {
    content:'';
    position:absolute; inset:30px;
    border-radius:50%;
    border:1px dashed rgba(201,168,76,0.1);
}
.arabesque-2 { width:400px; height:400px; bottom:-100px; left:-100px; animation: arabesque-spin 60s linear infinite reverse; }
.arabesque-3 { width:200px; height:200px; top:30%; left:8%; border-color:rgba(201,168,76,0.2); }

/* Floating particles */
.hero-particles { position:absolute; inset:0; z-index:3; pointer-events:none; }
.particle {
    position:absolute;
    width:3px; height:3px;
    background:var(--gold);
    border-radius:50%;
    animation: particle-rise linear infinite;
    box-shadow: 0 0 6px var(--gold);
}

.hero-content {
    position:relative; z-index:10;
    width:100%; padding:120px 0 80px;
}

.hero-inner {
    display:grid;
    grid-template-columns: minmax(0, 860px);
    gap:2rem;
    align-items:center;
}

.hero-left { animation: fadeUp 0.9s var(--ease-expo) 0.1s both; }

.hero-eyebrow {
    display:inline-flex; align-items:center; gap:0.75rem;
    margin-bottom:2rem;
}
.eyebrow-line {
    width:40px; height:2px;
    background: linear-gradient(90deg, var(--gold), transparent);
}
.eyebrow-text {
    font-family: var(--ff-body);
    font-size:0.8rem; font-weight:600;
    letter-spacing:0.2em; text-transform:uppercase;
    color: var(--gold-light);
}

.hero-title {
    font-family: var(--ff-display);
    font-size: clamp(2.8rem, 5vw, 4.9rem);
    font-weight:800;
    color:white;
    line-height:1.04;
    letter-spacing:-0.02em;
    margin-bottom:1.5rem;
    max-width: 820px;
}
.hero-title em {
    font-style:italic;
    background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 50%, var(--gold-dark) 100%);
    background-size:200% auto;
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    animation: shimmer-gold 4s linear infinite;
}
.hero-mobile-break { display:none; }

.hero-subtitle {
    font-size:1.08rem; color:rgba(255,255,255,0.76);
    max-width:680px; line-height:1.85; margin-bottom:1.35rem;
    font-weight:300;
}
.hero-subtitle strong { color:rgba(255,255,255,0.9); font-weight:500; }

.hero-institution-strip {
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:0.75rem;
    margin:1.35rem 0 1.7rem;
}

.institution-chip {
    display:inline-flex;
    align-items:center;
    gap:0.85rem;
    min-height:64px;
    padding:0.6rem 1.1rem;
    border-radius:20px;
    color:white;
    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.15);
    backdrop-filter: blur(16px);
    box-shadow: 0 8px 32px rgba(13, 33, 24, 0.15);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.institution-chip:hover {
    background: rgba(255, 255, 255, 0.14);
    border-color: rgba(201, 168, 76, 0.4);
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(13, 33, 24, 0.25);
}

.institution-chip img {
    width:38px;
    height:38px;
    object-fit:contain;
    border-radius:10px;
    background:white;
    padding:0.2rem;
}

.institution-chip strong {
    display:block;
    font-size:0.86rem;
    line-height:1.1;
}

.institution-chip span {
    display:block;
    color:rgba(255,255,255,0.68);
    font-size:0.72rem;
    font-weight:600;
    line-height:1.1;
}

.hero-cta {
    display:flex; gap:1rem; flex-wrap:wrap; align-items:center;
}

/* BUTTONS */
.btn-gold {
    display:inline-flex; align-items:center; gap:0.75rem;
    padding:1rem 2.5rem;
    background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 50%, var(--gold-dark) 100%);
    background-size:200% auto;
    color: var(--forest);
    font-weight:700; font-size:0.95rem;
    text-decoration:none; border:none; cursor:pointer;
    border-radius: var(--r-sm);
    transition: all 0.4s var(--ease-expo);
    box-shadow: var(--shadow-gold);
    letter-spacing:0.02em;
    position:relative; overflow:hidden;
}
.btn-gold::before {
    content:''; position:absolute; inset:0;
    background:linear-gradient(135deg,rgba(255,255,255,0.3),transparent);
    opacity:0; transition:opacity 0.3s;
}
.btn-gold:hover { background-position:right center; transform:translateY(-3px); box-shadow:0 15px 50px rgba(201,168,76,0.4); }
.btn-gold:hover::before { opacity:1; }
.btn-gold i { transition:transform 0.3s; }
.btn-gold:hover i { transform:translateX(4px); }

.btn-ghost {
    display:inline-flex; align-items:center; gap:0.75rem;
    padding:1rem 2.5rem;
    background:transparent;
    color:rgba(255,255,255,0.8);
    border:1px solid rgba(255,255,255,0.25);
    font-weight:500; font-size:0.95rem;
    text-decoration:none; cursor:pointer;
    border-radius: var(--r-sm);
    transition: all 0.4s var(--ease-expo);
    letter-spacing:0.02em;
}
.btn-ghost:hover {
    background:rgba(255,255,255,0.08);
    border-color:rgba(255,255,255,0.5);
    color:white;
    transform:translateY(-3px);
}

/* Hero Right Visual */
.hero-right {
    display:none;
}

.hero-visual {
    position:relative; width:400px; height:400px;
}
.hero-visual-ring {
    position:absolute; inset:0;
    border-radius:50%;
    border:1px solid rgba(201,168,76,0.2);
    animation: arabesque-spin 20s linear infinite;
}
.hero-visual-ring::before, .hero-visual-ring::after {
    content:''; position:absolute; border-radius:50%;
    border:1px dashed rgba(201,168,76,0.15);
}
.hero-visual-ring::before { inset:-20px; }
.hero-visual-ring::after  { inset:20px; border-style:solid; border-color:rgba(201,168,76,0.1); }

.hero-visual-center {
    position:absolute; inset:40px;
    background: linear-gradient(135deg, var(--forest-soft), var(--forest-mid));
    border-radius:50%;
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    border:2px solid rgba(201,168,76,0.3);
    box-shadow: inset 0 0 60px rgba(0,0,0,0.4), 0 0 60px rgba(201,168,76,0.1);
}
.hero-visual-icon {
    font-size:4rem; margin-bottom:0.5rem;
    background: linear-gradient(135deg, var(--gold-light), var(--gold));
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    animation: float-up 4s ease-in-out infinite;
}
.hero-visual-label {
    font-family: var(--ff-display);
    font-size:1.2rem; color: var(--gold-light);
    letter-spacing:0.05em;
}

/* Stat pills floating */
.hero-stat-pill {
    position:absolute;
    background: rgba(255,255,255,0.95);
    border-radius:50px;
    padding:0.75rem 1.25rem;
    display:flex; align-items:center; gap:0.75rem;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    animation: float-up ease-in-out infinite;
}
.hero-stat-pill:nth-child(3) { top:20px; right:-20px; animation-duration:5s; }
.hero-stat-pill:nth-child(4) { bottom:40px; left:-20px; animation-duration:6s; animation-delay:-2s; }
.pill-icon {
    width:36px; height:36px; border-radius:50%;
    background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
    display:flex; align-items:center; justify-content:center;
    color:white; font-size:0.9rem;
}
.pill-text strong { display:block; font-size:1rem; font-weight:700; color:var(--text-dark); line-height:1.2; }
.pill-text span { font-size:0.75rem; color:var(--text-muted); }

/* Scroll hint */
.hero-scroll {
    position:absolute; bottom:2.5rem; left:50%; transform:translateX(-50%);
    z-index:10;
    display:flex; flex-direction:column; align-items:center; gap:0.5rem;
    color:rgba(255,255,255,0.4); font-size:0.75rem; letter-spacing:0.1em; text-transform:uppercase;
    text-decoration:none; transition:color 0.3s;
    animation: float-up 2.5s ease-in-out infinite;
}
.hero-scroll:hover { color:var(--gold-light); }
.scroll-line {
    width:1px; height:40px;
    background:linear-gradient(to bottom, rgba(201,168,76,0.6), transparent);
}

.hero-quick-stats {
    display:flex;
    flex-wrap:wrap;
    gap:1rem 1.5rem;
    margin-top:2.1rem;
    color:white;
}

.hero-quick-stat {
    min-width:130px;
    padding-left:1rem;
    border-left:2px solid rgba(201,168,76,0.65);
}

.hero-quick-stat strong {
    display:block;
    font-family:var(--ff-display);
    font-size:1.65rem;
    line-height:1;
}

.hero-quick-stat span {
    color:rgba(255,255,255,0.64);
    font-size:0.78rem;
    font-weight:700;
}

/* ══════════════════════════════
   PUBLIC QUICK ACTIONS
══════════════════════════════ */
.public-action-panel {
    position:relative;
    z-index:20;
    margin-top:-56px;
    padding:0 0 3rem;
}

.public-action-grid {
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:0.85rem;
    padding:1rem;
    background:rgba(255,255,255,0.92);
    border:1px solid rgba(201,168,76,0.24);
    border-radius:18px;
    box-shadow:0 22px 70px rgba(13,33,24,0.18);
    backdrop-filter:blur(18px);
}

.public-action-card {
    display:flex;
    align-items:center;
    gap:0.85rem;
    min-height:84px;
    padding:1rem;
    border-radius:12px;
    color:var(--text-dark);
    text-decoration:none;
    background:linear-gradient(135deg, white, var(--ivory));
    border:1px solid var(--ivory-dark);
    transition:all 0.28s var(--ease-expo);
}

.public-action-card:hover {
    color:var(--forest);
    transform:translateY(-4px);
    border-color:rgba(201,168,76,0.5);
    box-shadow:0 16px 36px rgba(13,33,24,0.11);
}

.public-action-icon {
    width:44px;
    height:44px;
    flex:0 0 44px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:12px;
    color:var(--forest);
    background:linear-gradient(135deg, var(--gold-light), var(--gold));
}

.public-action-card:nth-child(2) .public-action-icon {
    color:white;
    background:linear-gradient(135deg, var(--moss-light), var(--moss));
}

.public-action-card:nth-child(3) .public-action-icon {
    color:white;
    background:linear-gradient(135deg, #1f9aa5, #157782);
}

.public-action-card:nth-child(4) .public-action-icon {
    color:white;
    background:linear-gradient(135deg, #25D366, #128C7E);
}

.public-action-copy strong {
    display:block;
    font-size:0.94rem;
    line-height:1.2;
}

.public-action-copy span {
    display:block;
    margin-top:0.18rem;
    color:var(--text-muted);
    font-size:0.76rem;
    font-weight:600;
    line-height:1.35;
}

/* ══════════════════════════════
   SECTION BASE
══════════════════════════════ */
.section { padding:6rem 0; }

.section-eyebrow {
    display:flex; align-items:center; gap:1rem;
    margin-bottom:1.25rem;
}
.eyebrow-ornament {
    width:30px; height:1px;
    background: var(--gold);
}
.eyebrow-tag {
    font-size:0.75rem; font-weight:700;
    letter-spacing:0.2em; text-transform:uppercase;
    color: var(--gold-dark);
}

.section-title {
    font-family: var(--ff-display);
    font-size: clamp(1.9rem, 4vw, 3rem);
    font-weight:800; letter-spacing:-0.02em;
    color: var(--text-dark); line-height:1.15;
    margin-bottom:1rem;
}
.section-title em {
    font-style:italic;
    color: var(--gold-dark);
}

.section-subtitle {
    font-size:1.05rem; color:var(--text-muted);
    max-width:560px; line-height:1.8;
}

.section-header-block { margin-bottom:4rem; }

/* ══════════════════════════════
   STATS SECTION
══════════════════════════════ */
.stats-section { background: var(--ivory); }
.stats-section-smp { background: white; padding-top:0; }

.stats-grid {
    display:grid;
    grid-template-columns: repeat(4, 1fr);
    gap:1.5rem;
}

.stat-card {
    background:white;
    border-radius:var(--r-lg);
    padding:2.25rem 1.75rem;
    text-align:center;
    border:1px solid var(--ivory-dark);
    position:relative; overflow:hidden;
    transition: transform 0.4s var(--ease-expo), box-shadow 0.4s var(--ease-expo);
}
.stat-card::before {
    content:''; position:absolute;
    top:0; left:0; right:0; height:3px;
    background:linear-gradient(90deg, var(--gold-dark), var(--gold-light));
    transform:scaleX(0); transform-origin:left;
    transition: transform 0.5s var(--ease-expo);
}
.stat-card:hover { transform:translateY(-8px); box-shadow: var(--shadow-deep); }
.stat-card:hover::before { transform:scaleX(1); }

.stat-card.smp::before { background:linear-gradient(90deg, var(--moss), var(--moss-light)); }

.stat-icon-wrap {
    width:64px; height:64px; margin:0 auto 1.5rem;
    border-radius:var(--r-md);
    background: var(--gold-pale);
    display:flex; align-items:center; justify-content:center;
    font-size:1.6rem; color:var(--gold-dark);
    transition: transform 0.4s var(--ease-back);
}
.stat-card.smp .stat-icon-wrap { background:#e8f5ef; color:var(--moss); }
.stat-card:hover .stat-icon-wrap { transform:scale(1.12) rotate(6deg); }

.stat-value {
    font-family: var(--ff-display);
    font-size:2.8rem; font-weight:800; line-height:1;
    color: var(--text-dark); margin-bottom:0.4rem;
    letter-spacing:-0.03em;
}
.stat-label { font-size:0.88rem; color:var(--text-muted); font-weight:500; letter-spacing:0.02em; }

/* ══════════════════════════════
   ANNOUNCEMENT BANNER
══════════════════════════════ */
.announcement {
    margin:2rem 0;
    background: linear-gradient(135deg, var(--forest) 0%, var(--forest-soft) 100%);
    border-radius:var(--r-lg);
    padding:1.75rem 2.5rem;
    display:flex; align-items:center; gap:1.5rem;
    border:1px solid rgba(201,168,76,0.3);
    box-shadow: var(--shadow-gold);
    position:relative; overflow:hidden;
}
.announcement::before {
    content:''; position:absolute; inset:0;
    background: linear-gradient(135deg, rgba(201,168,76,0.08), transparent);
    pointer-events:none;
}
.announcement-icon {
    width:52px; height:52px; flex-shrink:0;
    background:rgba(201,168,76,0.15);
    border-radius:50%; display:flex; align-items:center; justify-content:center;
    font-size:1.4rem; color:var(--gold-light);
    border:1px solid rgba(201,168,76,0.3);
    position:relative;
}
.announcement-icon::after {
    content:''; position:absolute; inset:-4px;
    border-radius:50%; border:1px solid rgba(201,168,76,0.2);
    animation: pulse-ring 2.5s ease-out infinite;
}
.announcement-body { flex:1; text-align:center; position:relative; }
.announcement-title {
    font-family: var(--ff-display);
    font-size:1.2rem; font-weight:700;
    color:white; margin-bottom:0.25rem; display:block;
}
.announcement-body p { color:rgba(255,255,255,0.7); font-size:0.95rem; }
.announcement-body a {
    color: var(--gold-light); text-decoration:none; font-weight:600;
    border-bottom:1px solid rgba(201,168,76,0.4);
    transition:border-color 0.3s;
}
.announcement-body a:hover { border-color:var(--gold-light); }

/* ══════════════════════════════
   TRUST SECTION
══════════════════════════════ */
.trust-section {
    background:
        linear-gradient(180deg, white 0%, var(--ivory) 100%);
    position:relative;
    overflow:hidden;
}

.trust-layout {
    display:grid;
    grid-template-columns:minmax(0, 0.88fr) minmax(0, 1.12fr);
    gap:3rem;
    align-items:center;
}

.trust-copy {
    position:relative;
}

.trust-note {
    margin-top:1.5rem;
    padding:1rem 1.15rem;
    display:flex;
    gap:0.85rem;
    align-items:flex-start;
    border-radius:14px;
    background:var(--gold-pale);
    color:var(--text-mid);
    border:1px solid rgba(201,168,76,0.32);
}

.trust-note i {
    color:var(--gold-dark);
    margin-top:0.2rem;
}

.trust-note strong {
    color:var(--forest);
}

.trust-grid {
    display:grid;
    grid-template-columns:repeat(2, 1fr);
    gap:1rem;
}

.trust-item {
    min-height:190px;
    padding:1.35rem;
    border-radius:16px;
    background:white;
    border:1px solid var(--ivory-dark);
    box-shadow:0 12px 34px rgba(13,33,24,0.07);
    transition:all 0.28s var(--ease-expo);
}

.trust-item:hover {
    transform:translateY(-5px);
    border-color:rgba(201,168,76,0.42);
    box-shadow:0 20px 46px rgba(13,33,24,0.1);
}

.trust-icon {
    width:48px;
    height:48px;
    margin-bottom:1rem;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:14px;
    color:var(--forest);
    background:var(--gold-pale);
    font-size:1.25rem;
}

.trust-item:nth-child(2) .trust-icon { color:white; background:linear-gradient(135deg, var(--moss-light), var(--moss)); }
.trust-item:nth-child(3) .trust-icon { color:white; background:linear-gradient(135deg, #1f9aa5, #157782); }
.trust-item:nth-child(4) .trust-icon { color:white; background:linear-gradient(135deg, #334155, #0f172a); }

.trust-item h3 {
    font-family:var(--ff-display);
    font-size:1.12rem;
    font-weight:800;
    color:var(--text-dark);
    margin:0 0 0.55rem;
}

.trust-item p {
    margin:0;
    color:var(--text-muted);
    font-size:0.9rem;
    line-height:1.7;
}

/* ══════════════════════════════
   PROGRAMS SECTION
══════════════════════════════ */
.programs-section { background:white; }

.programs-grid {
    display:grid; grid-template-columns:1fr 1fr; gap:2rem;
}

.program-card {
    border-radius:var(--r-xl);
    overflow:hidden;
    background: var(--forest);
    border:1px solid rgba(201,168,76,0.2);
    transition: transform 0.5s var(--ease-expo), box-shadow 0.5s;
    position:relative;
}
.program-card:hover { transform:translateY(-10px); box-shadow: var(--shadow-deep); }

.program-card.smp { background: linear-gradient(160deg, var(--forest-mid), #0a2818); }

.program-card-bg {
    position:absolute; inset:0;
    background-image:
        radial-gradient(ellipse at top right, rgba(201,168,76,0.1), transparent 60%),
        radial-gradient(ellipse at bottom left, rgba(46,107,79,0.15), transparent 60%);
    pointer-events:none;
}

.program-header {
    padding:3rem 3rem 2rem;
    position:relative; z-index:1;
    border-bottom:1px solid rgba(255,255,255,0.06);
}
.program-icon-row {
    display:flex; align-items:center; gap:1rem; margin-bottom:1.5rem;
}
.program-icon {
    width:60px; height:60px;
    background:rgba(201,168,76,0.12);
    border:1px solid rgba(201,168,76,0.3);
    border-radius:var(--r-md);
    display:flex; align-items:center; justify-content:center;
    font-size:1.6rem; color:var(--gold-light);
}
.program-card.smp .program-icon { background:rgba(61,139,103,0.15); border-color:rgba(61,139,103,0.4); color:#7ecca0; }
.program-badge {
    padding:0.35rem 1rem; border-radius:var(--r-pill);
    background:rgba(201,168,76,0.1); border:1px solid rgba(201,168,76,0.25);
    font-size:0.75rem; color:var(--gold-light); font-weight:600; letter-spacing:0.1em; text-transform:uppercase;
}
.program-card.smp .program-badge { background:rgba(61,139,103,0.1); border-color:rgba(61,139,103,0.25); color:#7ecca0; }

.program-name {
    font-family: var(--ff-display);
    font-size:2rem; font-weight:800; color:white;
    margin-bottom:0.4rem; letter-spacing:-0.01em;
}
.program-tagline { font-size:0.9rem; color:rgba(255,255,255,0.5); font-style:italic; }

.program-body {
    padding:2rem 3rem 3rem;
    position:relative; z-index:1;
}
.program-desc {
    color:rgba(255,255,255,0.65); font-size:0.95rem;
    line-height:1.8; margin-bottom:1.75rem;
}

.program-features {
    list-style:none; margin-bottom:2.25rem;
}
.program-feature {
    display:flex; align-items:center; gap:0.9rem;
    padding:0.65rem 0;
    border-bottom:1px solid rgba(255,255,255,0.05);
    color:rgba(255,255,255,0.8); font-size:0.9rem;
    transition:transform 0.3s, color 0.3s;
}
.program-feature:last-child { border:none; }
.program-feature:hover { transform:translateX(6px); color:white; }
.feature-dot {
    width:22px; height:22px; flex-shrink:0;
    border-radius:50%; background:rgba(201,168,76,0.15);
    border:1px solid rgba(201,168,76,0.4);
    display:flex; align-items:center; justify-content:center;
    font-size:0.6rem; color:var(--gold-light);
}
.program-card.smp .feature-dot { background:rgba(61,139,103,0.15); border-color:rgba(61,139,103,0.4); color:#7ecca0; }

.btn-program-gold {
    display:inline-flex; align-items:center; gap:0.75rem;
    width:100%; padding:1rem 1.75rem;
    background:linear-gradient(135deg, var(--gold-light), var(--gold-dark));
    color: var(--forest); font-weight:700; font-size:0.95rem;
    text-decoration:none; border-radius:var(--r-sm);
    justify-content:center;
    transition: all 0.4s var(--ease-expo);
    box-shadow: var(--shadow-gold);
}
.btn-program-gold:hover { transform:translateY(-3px); box-shadow:0 15px 50px rgba(201,168,76,0.5); }
.btn-program-green {
    display:inline-flex; align-items:center; gap:0.75rem;
    width:100%; padding:1rem 1.75rem;
    background:linear-gradient(135deg, #3D8B67, #2E6B4F);
    color:white; font-weight:700; font-size:0.95rem;
    text-decoration:none; border-radius:var(--r-sm);
    justify-content:center;
    transition: all 0.4s var(--ease-expo);
    box-shadow:0 8px 30px rgba(46,107,79,0.35);
}
.btn-program-green:hover { transform:translateY(-3px); box-shadow:0 15px 50px rgba(46,107,79,0.45); }

/* ══════════════════════════════
   REGISTRATION FLOW
══════════════════════════════ */
.flow-section { background: var(--ivory); position:relative; overflow:hidden; }
.flow-section::before {
    content:''; position:absolute;
    top:50%; left:0; right:0; height:1px;
    background:linear-gradient(90deg, transparent 5%, var(--ivory-dark) 50%, transparent 95%);
    z-index:0;
}

.flow-grid {
    display:grid; grid-template-columns:repeat(3, 1fr);
    gap:2rem; position:relative; z-index:1;
}

.flow-card {
    background:white;
    border-radius:var(--r-lg);
    padding:2.5rem 2rem;
    text-align:center;
    border:1px solid var(--ivory-dark);
    transition: all 0.4s var(--ease-expo);
    position:relative; overflow:hidden;
}
.flow-card::after {
    content:''; position:absolute; inset:0;
    background:linear-gradient(135deg, rgba(201,168,76,0.03), transparent);
    opacity:0; transition:opacity 0.3s;
}
.flow-card:hover { transform:translateY(-8px); box-shadow: var(--shadow-deep); border-color:rgba(201,168,76,0.2); }
.flow-card:hover::after { opacity:1; }

.flow-number {
    font-family: var(--ff-display);
    font-size:4rem; font-weight:800; line-height:1;
    color: var(--ivory-dark);
    margin-bottom:1rem;
    transition:color 0.3s;
}
.flow-card:hover .flow-number { color: var(--gold-pale); }
.flow-icon-wrap {
    width:64px; height:64px; margin:0 auto 1.5rem;
    background:var(--gold-pale);
    border-radius:var(--r-md);
    display:flex; align-items:center; justify-content:center;
    font-size:1.6rem; color:var(--gold-dark);
    transition: transform 0.4s var(--ease-back), box-shadow 0.4s;
}
.flow-card:hover .flow-icon-wrap { transform:scale(1.12) rotate(-5deg); box-shadow: var(--shadow-gold); }
.flow-title {
    font-family: var(--ff-display);
    font-size:1.3rem; font-weight:700; color:var(--text-dark);
    margin-bottom:0.75rem;
}
.flow-desc { font-size:0.9rem; color:var(--text-muted); line-height:1.75; }

/* ══════════════════════════════
   CHECKLIST SECTION
══════════════════════════════ */
.checklist-section {
    background:white;
    padding-top:0;
}

.checklist-panel {
    display:grid;
    grid-template-columns:minmax(0, 0.78fr) minmax(0, 1.22fr);
    gap:2rem;
    align-items:stretch;
    background:var(--forest);
    border-radius:24px;
    padding:2rem;
    color:white;
    position:relative;
    overflow:hidden;
}

.checklist-panel::before {
    content:'';
    position:absolute;
    inset:0;
    background:
        radial-gradient(circle at 8% 10%, rgba(201,168,76,0.22), transparent 32%),
        radial-gradient(circle at 92% 80%, rgba(31,154,165,0.16), transparent 34%);
    pointer-events:none;
}

.checklist-intro,
.checklist-grid {
    position:relative;
    z-index:1;
}

.checklist-intro {
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.checklist-intro .section-eyebrow {
    margin-bottom:1rem;
}

.checklist-intro .section-title {
    color:white;
    margin-bottom:1rem;
}

.checklist-intro .section-subtitle {
    color:rgba(255,255,255,0.68);
}

.checklist-grid {
    display:grid;
    gap:0.85rem;
}

.checklist-item {
    display:flex;
    align-items:flex-start;
    gap:0.85rem;
    padding:1rem;
    border-radius:14px;
    background:rgba(255,255,255,0.07);
    border:1px solid rgba(255,255,255,0.12);
    backdrop-filter:blur(12px);
}

.checklist-item i {
    width:34px;
    height:34px;
    flex:0 0 34px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    color:var(--forest);
    background:var(--gold-light);
}

.checklist-item strong {
    display:block;
    margin-bottom:0.16rem;
    color:white;
    font-size:0.96rem;
}

.checklist-item span {
    display:block;
    color:rgba(255,255,255,0.62);
    font-size:0.84rem;
    line-height:1.55;
}

/* ══════════════════════════════
   QUOTA SECTION
══════════════════════════════ */
.quota-section { background:white; }
.quota-section-alt { background: var(--ivory); }

.quota-grid {
    display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));
    gap:1.5rem;
}

.quota-card {
    background: var(--ivory);
    border-radius:var(--r-lg);
    padding:1.75rem;
    border:1px solid var(--ivory-dark);
    transition: all 0.4s var(--ease-expo);
    position:relative; overflow:hidden;
}
.quota-section .quota-card { background:white; }
.quota-card:hover { transform:translateY(-5px); box-shadow:0 15px 40px rgba(0,0,0,0.08); border-color:rgba(201,168,76,0.25); }

.quota-card-header {
    display:flex; justify-content:space-between; align-items:flex-start;
    margin-bottom:1.25rem; gap:1rem;
}
.quota-name {
    font-weight:700; font-size:1rem; color:var(--text-dark); line-height:1.4;
}
.quota-chip {
    padding:0.35rem 0.85rem; border-radius:var(--r-pill);
    font-size:0.78rem; font-weight:700; white-space:nowrap; flex-shrink:0;
}
.quota-chip.available { background:#e8f5ef; color:#1a5c36; }
.quota-chip.low       { background:#fef3c7; color:#92400e; }
.quota-chip.full      { background:#fee2e2; color:#991b1b; }

.quota-track {
    height:6px; background:var(--ivory-dark);
    border-radius:var(--r-pill); overflow:hidden; margin-bottom:1rem;
}
.quota-fill {
    height:100%; border-radius:var(--r-pill);
    transition: width 1.2s var(--ease-expo);
}
.quota-fill.available { background:linear-gradient(90deg, #3D8B67, #7ecca0); }
.quota-fill.low       { background:linear-gradient(90deg, var(--gold-dark), var(--gold-light)); }
.quota-fill.full      { background:linear-gradient(90deg, #dc2626, #f87171); }

.quota-meta {
    display:flex; justify-content:space-between;
    font-size:0.82rem; color:var(--text-muted); font-weight:500;
}
.quota-meta strong { color:var(--text-dark); }

/* ══════════════════════════════
   SCHEDULE SECTION
══════════════════════════════ */
.schedule-section { background:var(--forest); position:relative; overflow:hidden; }
.schedule-section::before {
    content:''; position:absolute; inset:0;
    background:
        radial-gradient(circle at 10% 50%, rgba(201,168,76,0.1) 0%, transparent 45%),
        radial-gradient(circle at 90% 30%, rgba(46,107,79,0.2) 0%, transparent 45%);
    pointer-events:none;
}

.schedule-section .section-title { color:white; }
.schedule-section .section-subtitle { color:rgba(255,255,255,0.55); }
.schedule-section .eyebrow-tag { color:var(--gold-light); }
.schedule-section .eyebrow-ornament { background:var(--gold-light); }

.schedule-grid {
    display:grid; grid-template-columns:repeat(4, 1fr); gap:1.5rem;
    position:relative; z-index:1;
}

.schedule-card {
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(201,168,76,0.15);
    border-radius:var(--r-lg);
    padding:2rem 1.5rem;
    transition: all 0.4s var(--ease-expo);
    position:relative; overflow:hidden;
    backdrop-filter:blur(10px);
}
.schedule-card::before {
    content:''; position:absolute;
    bottom:0; left:0; right:0; height:3px;
    background:linear-gradient(90deg, var(--gold-dark), var(--gold-light));
    transform:scaleX(0); transform-origin:left;
    transition:transform 0.4s var(--ease-expo);
}
.schedule-card:hover { background:rgba(255,255,255,0.07); border-color:rgba(201,168,76,0.3); transform:translateY(-6px); }
.schedule-card:hover::before { transform:scaleX(1); }

.schedule-icon {
    width:52px; height:52px; margin-bottom:1.5rem;
    border-radius:var(--r-md);
    background:rgba(201,168,76,0.1); border:1px solid rgba(201,168,76,0.25);
    display:flex; align-items:center; justify-content:center;
    font-size:1.3rem; color:var(--gold-light);
    transition:transform 0.4s var(--ease-back);
}
.schedule-card:hover .schedule-icon { transform:scale(1.1) rotate(-8deg); }
.schedule-title { font-family:var(--ff-display); font-size:1.1rem; color:white; margin-bottom:0.4rem; }
.schedule-date  { font-size:0.85rem; color:rgba(255,255,255,0.45); }

/* ══════════════════════════════
   CAROUSEL / GALLERY
══════════════════════════════ */
.gallery-section { background: var(--ivory); }

.carousel-wrap { border-radius:var(--r-xl); overflow:hidden; box-shadow: var(--shadow-deep); }
.carousel-item { height:480px; }
.carousel-image { width:100%; height:100%; object-fit:cover; transition:transform 0.8s var(--ease-expo); }
.carousel-item:hover .carousel-image { transform:scale(1.05); }
.carousel-caption {
    position:absolute; bottom:0; left:0; right:0;
    padding:4rem 3rem 2.5rem;
    background:linear-gradient(transparent, rgba(13,33,24,0.92));
}
.carousel-caption h5 {
    font-family:var(--ff-display);
    font-size:1.6rem; color:white; margin-bottom:0.4rem;
}
.carousel-caption p { color:rgba(255,255,255,0.75); font-size:0.95rem; }
.carousel-control-prev, .carousel-control-next {
    width:50px; height:50px; border-radius:50%;
    background:rgba(201,168,76,0.2); backdrop-filter:blur(8px);
    border:1px solid rgba(201,168,76,0.3); opacity:0.9; transition:all 0.3s;
}
.carousel-control-prev:hover, .carousel-control-next:hover {
    opacity:1; background:rgba(201,168,76,0.4); transform:scale(1.1);
}
.carousel-indicators button {
    width:8px; height:8px; border-radius:50%; border:none;
    background:rgba(255,255,255,0.4); transition:all 0.3s; margin:0 4px;
}
.carousel-indicators button.active { background:var(--gold-light); transform:scale(1.3); }
.carousel-indicators { bottom:-35px !important; }

/* ══════════════════════════════
   FAQ AND HELP
══════════════════════════════ */
.faq-section {
    background:white;
}

.faq-layout {
    display:grid;
    grid-template-columns:minmax(0, 0.72fr) minmax(0, 1.28fr);
    gap:2rem;
    align-items:start;
}

.help-card {
    position:sticky;
    top:110px;
    padding:1.5rem;
    border-radius:18px;
    background:linear-gradient(160deg, var(--forest), var(--forest-soft));
    color:white;
    border:1px solid rgba(201,168,76,0.24);
    box-shadow:0 18px 48px rgba(13,33,24,0.22);
}

.help-card img {
    width:58px;
    height:58px;
    object-fit:contain;
    border-radius:14px;
    background:white;
    padding:0.35rem;
    margin-bottom:1rem;
}

.help-card h3 {
    font-family:var(--ff-display);
    font-size:1.35rem;
    font-weight:800;
    margin:0 0 0.65rem;
}

.help-card p {
    color:rgba(255,255,255,0.68);
    font-size:0.9rem;
    line-height:1.75;
    margin-bottom:1.25rem;
}

.help-actions {
    display:grid;
    gap:0.7rem;
}

.help-actions a {
    display:flex;
    align-items:center;
    justify-content:center;
    gap:0.6rem;
    min-height:44px;
    padding:0.75rem 1rem;
    border-radius:10px;
    text-decoration:none;
    font-weight:800;
    font-size:0.88rem;
    transition:all 0.25s var(--ease-expo);
}

.help-actions a:first-child {
    color:var(--forest);
    background:linear-gradient(135deg, var(--gold-light), var(--gold));
}

.help-actions a:last-child {
    color:white;
    border:1px solid rgba(255,255,255,0.22);
    background:rgba(255,255,255,0.08);
}

.help-actions a:hover {
    transform:translateY(-2px);
}

.faq-accordion {
    display:grid;
    gap:0.85rem;
}

.faq-accordion .accordion-item {
    border:1px solid var(--ivory-dark);
    border-radius:14px;
    overflow:hidden;
    background:var(--ivory);
}

.faq-accordion .accordion-button {
    min-height:62px;
    background:white;
    color:var(--text-dark);
    font-weight:800;
    box-shadow:none;
}

.faq-accordion .accordion-button:not(.collapsed) {
    color:var(--forest);
    background:var(--gold-pale);
}

.faq-accordion .accordion-button:focus {
    box-shadow:0 0 0 0.2rem rgba(201,168,76,0.2);
}

.faq-accordion .accordion-body {
    color:var(--text-muted);
    line-height:1.75;
    background:white;
}

/* ══════════════════════════════
   FOOTER
══════════════════════════════ */
/* Footer is rendered by the shared public layout. */

/* ══════════════════════════════
   SCROLL ANIMATIONS
══════════════════════════════ */
.aos {
    opacity:0; transform:translateY(28px);
    transition: opacity 0.7s var(--ease-expo), transform 0.7s var(--ease-expo);
}
.aos.d1 { transition-delay:0.1s; }
.aos.d2 { transition-delay:0.2s; }
.aos.d3 { transition-delay:0.3s; }
.aos.d4 { transition-delay:0.4s; }
.aos.visible { opacity:1; transform:translateY(0); }

/* ══════════════════════════════
   RESPONSIVE
══════════════════════════════ */
@media (max-width:1024px) {
    .hero-inner { grid-template-columns:1fr; text-align:center; }
    .hero-right  { display:none; }
    .hero-eyebrow, .hero-cta { justify-content:center; }
    .hero-subtitle { margin:0 auto 2.75rem; }
    .public-action-grid { grid-template-columns:repeat(2, 1fr); }
    .trust-layout,
    .faq-layout,
    .checklist-panel { grid-template-columns:1fr; }
    .help-card { position:relative; top:auto; }
    .stats-grid { grid-template-columns:repeat(2, 1fr); }
    .programs-grid { grid-template-columns:1fr; }
    .schedule-grid { grid-template-columns:repeat(2, 1fr); }
    .flow-grid { grid-template-columns:1fr; max-width:400px; margin:0 auto; }
}

@media (max-width:768px) {
    .section { padding:4.5rem 0; }
    .container { padding:0 1.25rem; }
    .hero { min-height:auto; }
    .hero-content { padding:96px 0 42px; }
    .hero-title {
        font-size:clamp(1.95rem, 5.8vw, 2.2rem);
        line-height:1.12;
        max-width:300px;
        margin-left:auto;
        margin-right:auto;
    }
    .hero-mobile-break { display:block; }
    .hero-subtitle {
        font-size:0.98rem;
        line-height:1.72;
        max-width:300px;
    }
    .eyebrow-text {
        font-size:0.7rem;
        letter-spacing:0.14em;
        white-space:normal;
    }
    .hero-eyebrow {
        max-width:300px;
        margin-left:auto;
        margin-right:auto;
    }
    .public-action-panel { margin-top:0; padding-top:1rem; }
    .public-action-grid { grid-template-columns:1fr; border-radius:14px; }
    .trust-grid { grid-template-columns:1fr; }
    .checklist-panel { border-radius:18px; padding:1.25rem; }
    .stats-grid { grid-template-columns:1fr 1fr; }
    .quota-grid  { grid-template-columns:1fr; }
    .schedule-grid { grid-template-columns:1fr 1fr; }
    .announcement { flex-direction:column; text-align:center; }
    .hero-cta { flex-direction:column; align-items:center; }
    .btn-gold, .btn-ghost { width:100%; max-width:320px; justify-content:center; }
    .carousel-item { height:300px; }
}

@media (max-width:480px) {
    .stats-grid, .schedule-grid { grid-template-columns:1fr; }
    .hero-title {
        font-size:2.05rem;
        max-width:340px;
    }
    .hero-subtitle {
        font-size:0.95rem;
        max-width:340px;
    }
    .hero-eyebrow {
        max-width:340px;
    }
    .institution-chip {
        width:100%;
        max-width:310px;
        justify-content:flex-start;
    }
}

/* Reduced motion */
@media (prefers-reduced-motion:reduce) {
    *, *::before, *::after {
        animation-duration:0.01ms !important;
        transition-duration:0.01ms !important;
    }
    .hero-bg-mesh { display:none; }
}
</style>
@endpush

@section('content')

<!-- ═══ HERO ═══ -->
<section class="hero">
    <div class="hero-bg-mesh">
        <div class="mesh-glow mesh-glow-1"></div>
        <div class="mesh-glow mesh-glow-2"></div>
        <div class="mesh-glow mesh-glow-3"></div>
    </div>
    <div class="hero-pattern"></div>
    <div class="hero-noise"></div>
    <div class="arabesque arabesque-1"></div>
    <div class="arabesque arabesque-2"></div>
    <div class="arabesque arabesque-3"></div>
    <div class="hero-particles" id="heroParticles"></div>
    <div class="container hero-content">
        <div class="hero-inner">
           
            <div class="hero-left">
                <div class="hero-eyebrow">
                    <div class="eyebrow-line"></div>
                    <span class="eyebrow-text">Penerimaan Siswa Baru 2026/2027</span>
                </div>
                <h1 class="hero-title">
                    Yayasan <br class="hero-mobile-break">Pendidikan<br>
                    Islam <em>Daar <br class="hero-mobile-break">El Rohmah</em>
                </h1>
                <p class="hero-subtitle">
                    Satu yayasan yang menaungi <strong>SMKS YAPISDA</strong> dan <strong>SMPS YAPISDA</strong>,
                    berfokus pada pendidikan berkarakter Islami, layanan pendaftaran yang tertata,
                    dan proses daftar ulang yang jelas.
                </p>
                <div class="hero-cta">
                    <a href="{{ route('registration.form') }}" class="btn-gold">
                        <i class="fas fa-industry"></i> Daftar SMKS
                    </a>
                    <a href="{{ route('registration.smp-form') }}" class="btn-ghost">
                        <i class="fas fa-school"></i> Daftar SMPS
                    </a>
                    <a href="{{ route('reenrollment.status') }}" class="btn-ghost">
                        <i class="fas fa-id-card"></i> Status Daftar Ulang
                    </a>
                </div>
                <div class="hero-institution-strip" aria-label="Unit pendidikan YAPISDA">
                    <div class="institution-chip">
                        <img src="{{ asset('images/logo-yapisda.svg') }}" alt="Logo SMKS YAPISDA">
                        <span><strong>SMKS YAPISDA</strong>6 Jurusan Kejuruan</span>
                    </div>
                    <div class="institution-chip">
                        <img src="{{ asset('images/LOGO SMPS YAPISDA.svg') }}" alt="Logo SMPS YAPISDA">
                        <span><strong>SMPS YAPISDA</strong>Reguler & Boarding</span>
                    </div>
                </div>
                <div class="hero-quick-stats" aria-label="Ringkasan pendaftaran">
                    <div class="hero-quick-stat">
                        <strong>{{ number_format($smkStats['total_applicants'] + $smpStats['total_applicants']) }}</strong>
                        <span>Total pendaftar</span>
                    </div>
                    <div class="hero-quick-stat">
                        <strong>6</strong>
                        <span>Jurusan SMKS</span>
                    </div>
                    <div class="hero-quick-stat">
                        <strong>2</strong>
                        <span>Program SMPS</span>
                    </div>
                </div>
            </div>

            <div class="hero-right">
                <div class="hero-visual">
                    <div class="hero-visual-ring"></div>
                    <div class="hero-visual-center">
                        <div class="hero-visual-icon"><i class="fas fa-solid fa-school "></i></div>
                        <div class="hero-visual-label">YAPISDA</div>
                    </div>
                    <!-- Floating stat pills -->
                    <div class="hero-stat-pill">
                        <div class="pill-icon"><i class="fas fa-users"></i></div>
                        <div class="pill-text">
                            <strong>{{ $smkStats['total_applicants'] + $smpStats['total_applicants'] }}</strong>
                            <span>Total Pendaftar</span>
                        </div>
                    </div>
                    <div class="hero-stat-pill">
                        <div class="pill-icon"><i class="fas fa-award"></i></div>
                        <div class="pill-text">
                            <strong>6 Jurusan</strong>
                            <span>SMKS Yapisda</span>
                        </div>
                    </div>
                    <div class="hero-stat-pill">
                        <div class="pill-icon"><i class="fas fa-award"></i></div>
                        <div class="pill-text">
                            <strong>2 Program</strong>
                            <span>SMPS Yapisda</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="#stats" class="hero-scroll">
        <div class="scroll-line"></div>
        <span>Scroll</span>
    </a>
</section>

<!-- ═══ AKSES CEPAT PUBLIK ═══ -->
<section class="public-action-panel" aria-label="Akses cepat pendaftaran">
    <div class="container">
        <div class="public-action-grid aos">
            <a href="{{ route('registration.form') }}" class="public-action-card">
                <span class="public-action-icon"><i class="fas fa-industry"></i></span>
                <span class="public-action-copy">
                    <strong>Formulir SMKS</strong>
                    <span>Untuk calon siswa kejuruan</span>
                </span>
            </a>
            <a href="{{ route('registration.smp-form') }}" class="public-action-card">
                <span class="public-action-icon"><i class="fas fa-school"></i></span>
                <span class="public-action-copy">
                    <strong>Formulir SMPS</strong>
                    <span>Reguler dan boarding</span>
                </span>
            </a>
            <a href="{{ route('reenrollment.status') }}" class="public-action-card">
                <span class="public-action-icon"><i class="fas fa-id-card"></i></span>
                <span class="public-action-copy">
                    <strong>Status Daftar Ulang</strong>
                    <span>Pantau administrasi atribut</span>
                </span>
            </a>
            <a href="https://wa.me/628128906113" target="_blank" rel="noopener" class="public-action-card">
                <span class="public-action-icon"><i class="fab fa-whatsapp"></i></span>
                <span class="public-action-copy">
                    <strong>Bantuan Panitia</strong>
                    <span>Konsultasi via WhatsApp</span>
                </span>
            </a>
        </div>
    </div>
</section>

<!-- ═══ STATS SMK ═══ -->
<section class="section stats-section" id="stats">
    <div class="container">
        <div class="section-header-block">
            <div class="section-eyebrow">
                <div class="eyebrow-ornament"></div>
                <span class="eyebrow-tag">Statistik Real-time</span>
            </div>
            <h2 class="section-title">Pendaftaran <em>SMKS</em> Yapisda</h2>
            <p class="section-subtitle">Data penerimaan tahun ajaran 2026/2027 real time</p>
        </div>
        <div class="stats-grid">
            <div class="stat-card aos">
                <div class="stat-icon-wrap"><i class="fas fa-users"></i></div>
                <div class="stat-value" data-count="{{ $smkStats['total_applicants'] }}">0</div>
                <div class="stat-label">Total Pendaftar</div>
            </div>
            <div class="stat-card aos d1">
                <div class="stat-icon-wrap"><i class="fas fa-id-card"></i></div>
                <div class="stat-value" data-count="{{ $smkQuotas->sum('quota') }}">0</div>
                <div class="stat-label">Total Kuota</div>
            </div>
            <div class="stat-card aos d2">
                <div class="stat-icon-wrap"><i class="fas fa-industry"></i></div>
                <div class="stat-value" data-count="6">6</div>
                <div class="stat-label">Jurusan Unggulan</div>
            </div>
            <div class="stat-card aos d3">
                <div class="stat-icon-wrap"><i class="fas fa-certificate"></i></div>
                <div class="stat-value" data-count="{{ $smkStats['verified_applicants'] ?? 0 }}">0</div>
                <div class="stat-label">Terverifikasi</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ STATS SMP ═══ -->
<section class="section stats-section-smp">
    <div class="container">
        <div class="section-header-block">
            <div class="section-eyebrow">
                <div class="eyebrow-ornament" style="background:var(--moss);"></div>
                <span class="eyebrow-tag" style="color:var(--moss);">Statistik Real-time</span>
            </div>
            <h2 class="section-title">Pendaftaran <em style="color:var(--moss);">SMPS</em> Yapisda</h2>
            <p class="section-subtitle">Data penerimaan tahun ajaran 2026/2027 diperbarui secara langsung</p>
        </div>
        <div class="stats-grid">
            <div class="stat-card smp aos">
                <div class="stat-icon-wrap"><i class="fas fa-users"></i></div>
                <div class="stat-value" data-count="{{ $smpStats['total_applicants'] }}">0</div>
                <div class="stat-label">Total Pendaftar</div>
            </div>
            <div class="stat-card smp aos d1">
                <div class="stat-icon-wrap"><i class="fas fa-id-card"></i></div>
                <div class="stat-value" data-count="{{ $smpQuotas->sum('quota') }}">0</div>
                <div class="stat-label">Total Kuota</div>
            </div>
            <div class="stat-card smp aos d2">
                <div class="stat-icon-wrap"><i class="fas fa-school"></i></div>
                <div class="stat-value" data-count="2">2</div>
                <div class="stat-label">Program Sekolah</div>
            </div>
            <div class="stat-card smp aos d3">
                <div class="stat-icon-wrap"><i class="fas fa-certificate"></i></div>
                <div class="stat-value" data-count="{{ $smpStats['verified_applicants'] ?? 0 }}">0</div>
                <div class="stat-label">Terverifikasi</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ KEPERCAYAAN PUBLIK ═══ -->
<section class="section trust-section" id="keunggulan">
    <div class="container">
        <div class="trust-layout">
            <div class="trust-copy aos">
                <div class="section-eyebrow">
                    <div class="eyebrow-ornament"></div>
                    <span class="eyebrow-tag">Mengapa YAPISDA</span>
                </div>
                <h2 class="section-title">Satu yayasan, dua jenjang, satu arah <em>pendidikan karakter</em></h2>
                <p class="section-subtitle">
                    Halaman publik dibuat untuk membantu calon siswa dan orang tua mengambil keputusan dengan cepat:
                    memilih jenjang, melihat kuota, memahami alur, lalu melanjutkan pendaftaran tanpa harus bertanya hal dasar berulang kali.
                </p>
                <div class="trust-note">
                    <i class="fas fa-circle-info"></i>
                    <div>
                        <strong>Status peserta didik aktif</strong> ditetapkan setelah kelengkapan administrasi daftar ulang dan atribut peserta didik tercatat pada sistem sekolah.
                        Tes kemampuan dasar menjadi data pemetaan sekolah, bukan satu-satunya penentu diterima.
                    </div>
                </div>
            </div>
            <div class="trust-grid">
                <div class="trust-item aos">
                    <div class="trust-icon"><i class="fas fa-mosque"></i></div>
                    <h3>Karakter Islami</h3>
                    <p>Pembiasaan akhlak, disiplin, ibadah, dan adab menjadi bagian dari pengalaman belajar harian.</p>
                </div>
                <div class="trust-item aos d1">
                    <div class="trust-icon"><i class="fas fa-layer-group"></i></div>
                    <h3>Jenjang Lengkap</h3>
                    <p>SMPS dan SMKS berada dalam satu ekosistem yayasan sehingga informasi pendaftaran lebih mudah dipahami.</p>
                </div>
                <div class="trust-item aos d2">
                    <div class="trust-icon"><i class="fas fa-chart-line"></i></div>
                    <h3>Data Transparan</h3>
                    <p>Kuota, status verifikasi, dan daftar ulang dibuat jelas agar panitia dan orang tua melihat informasi yang sama.</p>
                </div>
                <div class="trust-item aos d3">
                    <div class="trust-icon"><i class="fas fa-hands-helping"></i></div>
                    <h3>Pendampingan PPDB</h3>
                    <p>Akses cepat ke formulir, status, dan WhatsApp panitia mengurangi kebingungan saat proses pendaftaran.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ INFO DAFTAR ULANG ═══ -->
<div class="container">
    <div class="announcement aos">
        <div class="announcement-icon"><i class="fas fa-receipt"></i></div>
        <div class="announcement-body">
            <strong class="announcement-title">Daftar ulang final mengikuti kelengkapan administrasi atribut peserta didik</strong>
            <p>Calon peserta didik yang sudah diverifikasi dapat memantau status administrasi daftar ulang melalui <a href="{{ route('reenrollment.status') }}">halaman status daftar ulang</a>.</p>
        </div>
    </div>
</div>

<!-- ═══ PROGRAMS ═══ -->
<section class="section programs-section" id="programs">
    <div class="container">
        <div class="section-header-block">
            <div class="section-eyebrow">
                <div class="eyebrow-ornament"></div>
                <span class="eyebrow-tag">Program Pendidikan</span>
            </div>
            <h2 class="section-title">Pilih Jenjang <em>Pendidikan</em></h2>
            <p class="section-subtitle">Temukan program pendidikan terbaik untuk masa depan putra-putri Anda</p>
        </div>
        <div class="programs-grid">
            <!-- SMK -->
            <div class="program-card aos">
                <div class="program-card-bg"></div>
                <div class="program-header">
                    <div class="program-icon-row">
                        <div class="program-icon"><i class="fas fa-industry"></i></div>
                        <span class="program-badge">SMK Kejuruan</span>
                    </div>
                    <h3 class="program-name">SMKS YAPISDA</h3>
                    <p class="program-tagline">Sekolah Menengah Kejuruan — Siap Kerja, Siap Berprestasi</p>
                </div>
                <div class="program-body">
                    <p class="program-desc">Mencetak lulusan siap kerja dengan kompetensi profesional di 6 jurusan unggulan, didukung fasilitas modern dan kemitraan industri.</p>
                    <ul class="program-features">
                        <li class="program-feature"><div class="feature-dot"><i class="fas fa-check"></i></div>6 Jurusan Kejuruan Unggulan</li>
                        <li class="program-feature"><div class="feature-dot"><i class="fas fa-check"></i></div>Laboratorium & Workshop Modern</li>
                        <li class="program-feature"><div class="feature-dot"><i class="fas fa-check"></i></div>Praktik Kerja Industri (PKL)</li>
                        <li class="program-feature"><div class="feature-dot"><i class="fas fa-check"></i></div>Sertifikasi Kompetensi Nasional</li>
                    </ul>
                    <a href="{{ route('registration.form') }}" class="btn-program-gold">
                        <i class="fas fa-arrow-right"></i> Daftar ke SMKS
                    </a>
                </div>
            </div>

            <!-- SMP -->
            <div class="program-card smp aos d1">
                <div class="program-card-bg"></div>
                <div class="program-header">
                    <div class="program-icon-row">
                        <div class="program-icon"><i class="fas fa-school"></i></div>
                        <span class="program-badge">SMP Reguler & Boarding</span>
                    </div>
                    <h3 class="program-name">SMPS YAPISDA</h3>
                    <p class="program-tagline">Sekolah Menengah Pertama — Karakter Islami, Akademik Kuat</p>
                </div>
                <div class="program-body">
                    <p class="program-desc">Membentuk karakter Islami dan akademik yang kuat dengan dua pilihan program — reguler atau boarding school yang fleksibel.</p>
                    <ul class="program-features">
                        <li class="program-feature"><div class="feature-dot" style="border-color:rgba(61,139,103,0.4);color:#7ecca0;background:rgba(61,139,103,0.15)"><i class="fas fa-check"></i></div>2 Pilihan: Reguler & Boarding</li>
                        <li class="program-feature"><div class="feature-dot" style="border-color:rgba(61,139,103,0.4);color:#7ecca0;background:rgba(61,139,103,0.15)"><i class="fas fa-check"></i></div>Pendidikan Karakter Islami</li>
                        <li class="program-feature"><div class="feature-dot" style="border-color:rgba(61,139,103,0.4);color:#7ecca0;background:rgba(61,139,103,0.15)"><i class="fas fa-check"></i></div>Ekstrakurikuler Beragam</li>
                        <li class="program-feature"><div class="feature-dot" style="border-color:rgba(61,139,103,0.4);color:#7ecca0;background:rgba(61,139,103,0.15)"><i class="fas fa-check"></i></div>Pembinaan Tahfidz Qur'an</li>
                    </ul>
                    <a href="{{ route('registration.smp-form') }}" class="btn-program-green">
                        <i class="fas fa-arrow-right"></i> Daftar ke SMPS
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ FLOW ═══ -->
<section class="section flow-section" id="alur-pendaftaran">
    <div class="container">
        <div class="section-header-block" style="text-align:center;">
            <div class="section-eyebrow" style="justify-content:center;">
                <div class="eyebrow-ornament"></div>
                <span class="eyebrow-tag">Panduan Daftar</span>
                <div class="eyebrow-ornament" style="transform:scaleX(-1)"></div>
            </div>
            <h2 class="section-title">Alur <em>Pendaftaran</em></h2>
            <p class="section-subtitle" style="margin:0 auto;">Proses pendaftaran sampai daftar ulang final mengikuti verifikasi dan kelengkapan administrasi atribut peserta didik.</p>
        </div>
        <div class="flow-grid">
            <div class="flow-card aos">
                <div class="flow-number">01</div>
                <div class="flow-icon-wrap"><i class="fas fa-user-edit"></i></div>
                <h4 class="flow-title">Isi Formulir</h4>
                <p class="flow-desc">Lengkapi data diri calon siswa secara online melalui website pendaftaran ini dengan mudah dan cepat.</p>
            </div>
            <div class="flow-card aos d1">
                <div class="flow-number">02</div>
                <div class="flow-icon-wrap"><i class="fas fa-file-alt"></i></div>
                <h4 class="flow-title">Verifikasi & Tes Dasar</h4>
                <p class="flow-desc">Panitia memeriksa kelengkapan berkas dan mencatat kehadiran tes kemampuan dasar sebagai data sekolah.</p>
            </div>
            <div class="flow-card aos d2">
                <div class="flow-number">03</div>
                <div class="flow-icon-wrap"><i class="fas fa-id-card"></i></div>
                <h4 class="flow-title">Daftar Ulang Final</h4>
                <p class="flow-desc">Status peserta didik aktif ditetapkan setelah kelengkapan administrasi atribut peserta didik tercatat oleh petugas administrasi.</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ CHECKLIST PENDAFTARAN ═══ -->
<section class="section checklist-section" id="checklist">
    <div class="container">
        <div class="checklist-panel aos">
            <div class="checklist-intro">
                <div class="section-eyebrow">
                    <div class="eyebrow-ornament" style="background:var(--gold-light);"></div>
                    <span class="eyebrow-tag" style="color:var(--gold-light);">Siapkan Sebelum Daftar</span>
                </div>
                <h2 class="section-title">Checklist singkat agar pendaftaran tidak bolak-balik</h2>
                <p class="section-subtitle">
                    Informasi ini ditampilkan sejak awal supaya calon siswa dan orang tua tahu apa yang perlu disiapkan sebelum mengisi formulir.
                </p>
            </div>
            <div class="checklist-grid">
                <div class="checklist-item">
                    <i class="fas fa-user-check"></i>
                    <div>
                        <strong>Data calon siswa dan orang tua</strong>
                        <span>Pastikan nama, nomor HP aktif, alamat, dan pilihan program/jurusan sudah benar sebelum submit.</span>
                    </div>
                </div>
                <div class="checklist-item">
                    <i class="fas fa-file-image"></i>
                    <div>
                        <strong>Berkas dan pas foto</strong>
                        <span>Gunakan foto/scan yang jelas agar admin mudah melakukan verifikasi tanpa membuka komunikasi tambahan.</span>
                    </div>
                </div>
                <div class="checklist-item">
                    <i class="fas fa-receipt"></i>
                    <div>
                        <strong>Simpan bukti pendaftaran</strong>
                        <span>Bukti daftar berisi nomor pendaftaran dan waktu registrasi, sehingga mudah dicocokkan saat verifikasi.</span>
                    </div>
                </div>
                <div class="checklist-item">
                    <i class="fas fa-shirt"></i>
                    <div>
                        <strong>Daftar ulang setelah verifikasi</strong>
                        <span>Status peserta didik aktif mengikuti kelengkapan administrasi atribut yang tercatat pada sistem sekolah.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ QUOTA SMK ═══ -->
<section class="section quota-section">
    <div class="container">
        <div class="section-header-block">
            <div class="section-eyebrow">
                <div class="eyebrow-ornament"></div>
                <span class="eyebrow-tag">Ketersediaan Tempat</span>
            </div>
            <h2 class="section-title">Kuota <em>SMKS</em></h2>
            <p class="section-subtitle">Pantau ketersediaan kuota per jurusan secara real-time</p>
        </div>
        <div class="quota-grid">
            @forelse($smkQuotas as $quota)
            @php
                $quotaTotal = max(0, (int) $quota->quota);
                $quotaUsed = max(0, (int) $quota->used_quota);
                $quotaPercent = $quotaTotal > 0 ? min(100, ($quotaUsed / $quotaTotal) * 100) : 0;
            @endphp
            <div class="quota-card aos">
                <div class="quota-card-header">
                    <span class="quota-name">{{ $quota->major }}</span>
                    <span class="quota-chip {{ $quota->available_quota <= 10 ? ($quota->available_quota == 0 ? 'full' : 'low') : 'available' }}">
                        {{ $quota->available_quota }}/{{ $quota->quota }}
                    </span>
                </div>
                <div class="quota-track">
                    <div class="quota-fill {{ $quota->available_quota <= 10 ? ($quota->available_quota == 0 ? 'full' : 'low') : 'available' }}"
                         style="width:{{ $quotaPercent }}%"></div>
                </div>
                <div class="quota-meta">
                    <span><strong>{{ round($quotaPercent, 1) }}%</strong> terisi</span>
                    <span>{{ $quota->available_quota }} tersisa</span>
                </div>
            </div>
            @empty
            <p style="color:var(--text-muted); font-style:italic;">Data kuota SMKS belum tersedia.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- ═══ QUOTA SMP ═══ -->
<section class="section quota-section-alt" style="padding-top:0;">
    <div class="container">
        <div class="section-header-block">
            <div class="section-eyebrow">
                <div class="eyebrow-ornament" style="background:var(--moss);"></div>
                <span class="eyebrow-tag" style="color:var(--moss);">Ketersediaan Tempat</span>
            </div>
            <h2 class="section-title">Kuota <em style="color:var(--moss);">SMPS</em></h2>
            <p class="section-subtitle">Pantau ketersediaan kuota per program secara real-time</p>
        </div>
        <div class="quota-grid">
            @forelse($smpQuotas as $quota)
            @php
                $quotaTotal = max(0, (int) $quota->quota);
                $quotaUsed = max(0, (int) $quota->used_quota);
                $quotaPercent = $quotaTotal > 0 ? min(100, ($quotaUsed / $quotaTotal) * 100) : 0;
            @endphp
            <div class="quota-card aos">
                <div class="quota-card-header">
                    <span class="quota-name">{{ $quota->school_program }}</span>
                    <span class="quota-chip {{ $quota->available_quota <= 10 ? ($quota->available_quota == 0 ? 'full' : 'low') : 'available' }}">
                        {{ $quota->available_quota }}/{{ $quota->quota }}
                    </span>
                </div>
                <div class="quota-track">
                    <div class="quota-fill {{ $quota->available_quota <= 10 ? ($quota->available_quota == 0 ? 'full' : 'low') : 'available' }}"
                         style="width:{{ $quotaPercent }}%"></div>
                </div>
                <div class="quota-meta">
                    <span><strong>{{ round($quotaPercent, 1) }}%</strong> terisi</span>
                    <span>{{ $quota->available_quota }} tersisa</span>
                </div>
            </div>
            @empty
            <p style="color:var(--text-muted); font-style:italic;">Data kuota SMPS belum tersedia.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- ═══ SCHEDULE ═══ -->
<section class="section schedule-section">
    <div class="container">
        <div class="section-header-block">
            <div class="section-eyebrow">
                <div class="eyebrow-ornament" style="background:var(--gold-light);"></div>
                <span class="eyebrow-tag">Timeline Penting</span>
            </div>
            <h2 class="section-title" style="color:white;">Jadwal <em>Pendaftaran</em></h2>
            <p class="section-subtitle" style="color:rgba(255,255,255,0.5);">Catat tanggal-tanggal penting dalam proses penerimaan siswa baru</p>
        </div>
        <div class="schedule-grid">
            <div class="schedule-card aos">
                <div class="schedule-icon"><i class="fas fa-rocket"></i></div>
                <h4 class="schedule-title">Gelombang 1</h4>
                <p class="schedule-date">Februari – April 2026</p>
            </div>
            <div class="schedule-card aos d1">
                <div class="schedule-icon"><i class="fas fa-sync-alt"></i></div>
                <h4 class="schedule-title">Gelombang 2</h4>
                <p class="schedule-date">Mei – Juli 2026</p>
            </div>
            <div class="schedule-card aos d2">
                <div class="schedule-icon"><i class="fas fa-file-check"></i></div>
                <h4 class="schedule-title">Verifikasi Berkas</h4>
                <p class="schedule-date">1 – 15 Mei 2026</p>
            </div>
            <div class="schedule-card aos d3">
                <div class="schedule-icon"><i class="fas fa-shirt"></i></div>
                <h4 class="schedule-title">Daftar Ulang & Atribut</h4>
                <p class="schedule-date">Setelah verifikasi siswa</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ FAQ PUBLIK ═══ -->
<section class="section faq-section" id="faq">
    <div class="container">
        <div class="faq-layout">
            <div class="help-card aos">
                <img src="{{ asset('images/logo-yapisda.svg') }}" alt="Logo YAPISDA">
                <h3>Pusat Bantuan PPDB</h3>
                <p>
                    Jika masih ragu memilih jenjang atau ingin memastikan status daftar ulang, hubungi panitia.
                    Pertanyaan penting juga kami ringkas di sini agar orang tua bisa membaca tanpa menunggu balasan.
                </p>
                <div class="help-actions">
                    <a href="https://wa.me/628128906113" target="_blank" rel="noopener">
                        <i class="fab fa-whatsapp"></i> Chat Panitia
                    </a>
                    <a href="{{ route('contact') }}">
                        <i class="fas fa-location-dot"></i> Lihat Kontak
                    </a>
                </div>
            </div>

            <div>
                <div class="section-header-block" style="margin-bottom:1.5rem;">
                    <div class="section-eyebrow">
                        <div class="eyebrow-ornament"></div>
                        <span class="eyebrow-tag">Pertanyaan Umum</span>
                    </div>
                    <h2 class="section-title">Informasi penting sebelum <em>mendaftar</em></h2>
                    <p class="section-subtitle">Jawaban singkat untuk hal-hal yang paling sering ditanyakan calon siswa dan orang tua.</p>
                </div>
                <div class="accordion faq-accordion aos d1" id="faqAccordion">
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faqHeadingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne" aria-expanded="true" aria-controls="faqOne">
                                Apakah tes kemampuan dasar menentukan siswa diterima?
                            </button>
                        </h3>
                        <div id="faqOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Tes kemampuan dasar digunakan sebagai data pemetaan sekolah. Untuk status peserta didik aktif, sistem mengikuti verifikasi dan kelengkapan administrasi daftar ulang yang tercatat oleh petugas sekolah.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faqHeadingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
                                Kapan kartu pelajar dan NIS bisa dicetak?
                            </button>
                        </h3>
                        <div id="faqTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Kartu pelajar dan NIS otomatis tersedia setelah kelengkapan administrasi atribut peserta didik tercatat pada sistem sekolah. Jika belum muncul, pastikan konfirmasi administrasi sudah diproses petugas.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faqHeadingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
                                Apakah formulir SMKS dan SMPS berbeda?
                            </button>
                        </h3>
                        <div id="faqThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya. Calon siswa SMKS mengisi formulir SMKS sesuai pilihan jurusan, sedangkan calon siswa SMPS mengisi formulir SMPS sesuai pilihan program.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faqHeadingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqFour" aria-expanded="false" aria-controls="faqFour">
                                Bagaimana jika kuota program hampir penuh?
                            </button>
                        </h3>
                        <div id="faqFour" class="accordion-collapse collapse" aria-labelledby="faqHeadingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Segera hubungi panitia melalui WhatsApp atau datang ke sekolah. Kuota pada halaman ini membantu memberi gambaran awal, tetapi panitia tetap dapat memberi arahan pilihan terbaik.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ GALLERY ═══ -->
<section class="section gallery-section">
    <div class="container">
        <div class="section-header-block" style="text-align:center;">
            <div class="section-eyebrow" style="justify-content:center;">
                <div class="eyebrow-ornament"></div>
                <span class="eyebrow-tag">Galeri</span>
                <div class="eyebrow-ornament" style="transform:scaleX(-1)"></div>
            </div>
            <h2 class="section-title">Kegiatan & <em>Fasilitas</em></h2>
        </div>
        <div class="carousel-wrap">
            <div id="carouselMain" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5500">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="0" class="active" aria-current="true"></button>
                    <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="1"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/brosur1.jpeg') }}" class="carousel-image" alt="Aktivitas Belajar">
                        <div class="carousel-caption">
                            <h5>Aktivitas Belajar Mengajar</h5>
                            <p>Proses pembelajaran interaktif dengan metode modern dan pendekatan personal</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/brosur6.png') }}" class="carousel-image" alt="Fasilitas Sekolah">
                        <div class="carousel-caption">
                            <h5>Fasilitas Lengkap</h5>
                            <p>Laboratorium, perpustakaan, dan sarana pendukung belajar yang memadai</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselMain" data-bs-slide="prev" aria-label="Previous">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselMain" data-bs-slide="next" aria-label="Next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// ── Entrance animation ──
let aosBooted = false;
function bootAOS() {
    if (aosBooted) return;
    aosBooted = true;
    initAOS();
}
document.addEventListener('DOMContentLoaded', bootAOS);
window.addEventListener('load', bootAOS);

// ── Particles ──
(function createParticles() {
    const wrap = document.getElementById('heroParticles');
    if (!wrap) return;
    for (let i = 0; i < 45; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        p.style.cssText = `
            left:${Math.random()*100}%;
            top:${Math.random()*100}%;
            animation-delay:${Math.random()*20}s;
            animation-duration:${18+Math.random()*12}s;
            width:${2+Math.random()*3}px;
            height:${2+Math.random()*3}px;
            opacity:${0.2+Math.random()*0.5};
        `;
        wrap.appendChild(p);
    }
})();

// ── Counter Animation ──
function countUp(el, target, duration = 1400) {
    let start = 0;
    const step = target / (duration / 16);
    const tick = () => {
        start += step;
        if (start < target) {
            el.textContent = Math.floor(start).toLocaleString('id-ID');
            requestAnimationFrame(tick);
        } else {
            el.textContent = target.toLocaleString('id-ID');
        }
    };
    tick();
}

const counterObs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            const el = e.target;
            countUp(el, parseInt(el.dataset.count) || 0);
            counterObs.unobserve(el);
        }
    });
}, { threshold: 0.5 });
document.querySelectorAll('.stat-value').forEach(el => { el.textContent = '0'; counterObs.observe(el); });

// ── Progress Bar Animation ──
const barObs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            const bar = e.target;
            const w = bar.style.width;
            bar.style.width = '0';
            setTimeout(() => { bar.style.width = w; }, 100);
            barObs.unobserve(bar);
        }
    });
}, { threshold: 0.4 });
document.querySelectorAll('.quota-fill').forEach(bar => {
    const w = bar.style.width;
    bar.dataset.width = w;
    bar.style.width = '0';
    barObs.observe(bar);
});

// ── Scroll AOS ──
function initAOS() {
    const obs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.aos').forEach(el => obs.observe(el));
}

// ── Smooth Scroll ──
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', function(e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            e.preventDefault();
            window.scrollTo({ top: target.getBoundingClientRect().top + scrollY - 90, behavior: 'smooth' });
        }
    });
});
</script>
@endpush
