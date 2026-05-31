@extends('layouts.admin')

@section('title', 'Dashboard Admin - YAPISDA')

@push('styles')
<style>
/* === DESIGN TOKENS — selaras dengan layouts.app === */
:root {
    /* Inherit dari parent layout */
    --primary:       #2E6B4F;
    --primary-dark:  #1E4535;
    --primary-light: #3D8B67;
    --gold:          #C9A84C;
    --gold-light:    #E8C97A;
    --gold-dark:     #A07830;
    --gold-pale:     #F5EDD8;
    --forest:        #0D2118;
    --forest-mid:    #163328;
    --forest-soft:   #1E4535;
    --moss:          #2E6B4F;
    --moss-light:    #3D8B67;
    --ivory:         #FAF7F0;
    --ivory-dark:    #EDE8DC;
    --cream:         #F0EAD6;
    --text-dark:     #1A1208;
    --text-mid:      #4A3F28;
    --text-muted:    #8A7A58;

    /* Dashboard-specific tokens */
    --primary-50:    #e8f5ef;
    --primary-glow:  rgba(46, 107, 79, 0.15);
    --success:       #10b981;
    --success-bg:    #ecfdf5;
    --success-text:  #065f46;
    --warning:       #f59e0b;
    --warning-bg:    #fffbeb;
    --warning-text:  #92400e;
    --danger:        #ef4444;
    --danger-bg:     #fef2f2;
    --danger-text:   #991b1b;
    --info:          #3b82f6;
    --info-bg:       #eff6ff;
    --info-text:     #1e40af;

    --bg-page:       var(--ivory);
    --bg-card:       #ffffff;
    --text-primary:  var(--text-dark);
    --text-secondary:var(--text-muted);
    --border:        var(--ivory-dark);
    --border-hover:  #D8D0BE;

    --shadow-xs: 0 1px 2px rgba(0,0,0,0.04);
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.07);
    --shadow-md: 0 6px 20px rgba(0,0,0,0.10);
    --shadow-lg: 0 12px 36px rgba(0,0,0,0.14);
    --shadow-gold: 0 8px 30px rgba(201,168,76,0.22);

    --radius:    14px;
    --radius-lg: 20px;
    --radius-xl: 28px;

    --transition:        all 0.2s ease-in-out;
    --transition-smooth: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);

    --ff-display: 'Playfair Display', Georgia, serif;
    --ff-body:    'DM Sans', 'Segoe UI', sans-serif;
}

/* === BASE === */
*, *::before, *::after { box-sizing: border-box; }
html { scroll-behavior: smooth; }

body {
    font-family: var(--ff-body);
    background: var(--bg-page);
    color: var(--text-primary);
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    font-size: 0.9375rem;
}

/* === LAYOUT === */
.dashboard-wrapper {
    max-width: 1440px;
    margin: 0 auto;
    padding: 2rem 2.5rem;
}

/* === HEADER === */
.dashboard-header {
    background: linear-gradient(135deg, var(--forest) 0%, var(--forest-soft) 100%);
    border-radius: var(--radius-lg);
    padding: 1.75rem 2rem;
    margin-bottom: 2rem;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(201,168,76,0.15);
}

/* Gold top accent line */
.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent 5%, var(--gold-dark) 30%, var(--gold-light) 50%, var(--gold-dark) 70%, transparent 95%);
}

/* Subtle radial glow */
.dashboard-header::after {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 240px; height: 240px; border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%);
    pointer-events: none;
}

.dashboard-header h4 {
    font-family: var(--ff-display);
    font-weight: 700;
    font-size: 1.35rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    z-index: 1;
}

.dashboard-header h4 i {
    font-size: 1.1rem;
    color: var(--gold-light);
}

.header-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.875rem;
    opacity: 0.85;
    position: relative;
    z-index: 1;
}

.header-meta .badge {
    background: rgba(201,168,76,0.2);
    border: 1px solid rgba(201,168,76,0.3);
    color: var(--gold-light);
    padding: 0.4rem 0.9rem;
    border-radius: 999px;
    font-weight: 600;
    font-size: 0.8rem;
}

/* === STATS GRID === */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-bottom: 1.75rem;
}

.stat-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.1rem;
    transition: var(--transition-smooth);
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--moss), var(--gold-dark));
    opacity: 0;
    transition: var(--transition);
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: rgba(46,107,79,0.2);
}

.stat-card:hover::before { opacity: 1; }

.stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}

.stat-icon.primary { background: var(--primary-50); color: var(--moss); }
.stat-icon.warning { background: var(--warning-bg); color: var(--warning); }
.stat-icon.success { background: var(--success-bg); color: var(--success); }
.stat-icon.danger  { background: var(--danger-bg);  color: var(--danger); }

.stat-content { flex: 1; min-width: 0; }

.stat-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 0.3rem;
}

.stat-value {
    font-family: var(--ff-display);
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--forest);
    line-height: 1.2;
}

/* === SECTION CARD === */
.section-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    margin-bottom: 1.75rem;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: var(--transition-smooth);
}

.section-card:hover {
    box-shadow: var(--shadow-md);
}

.section-header {
    padding: 1.1rem 1.75rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
    background: linear-gradient(to bottom, var(--ivory), white);
    position: relative;
}

/* Gold underline on header */
.section-header::before {
    content: '';
    position: absolute;
    bottom: -1px; left: 1.75rem;
    width: 36px; height: 2px;
    background: var(--gold);
    border-radius: 999px;
}

.section-header h5 {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1.05rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    color: var(--forest);
}

.section-header h5 i { color: var(--gold-dark); }

.section-badge {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 0.3rem 0.8rem;
    border-radius: 999px;
    background: var(--gold-pale);
    color: var(--gold-dark);
    border: 1px solid rgba(160,120,48,0.2);
    letter-spacing: 0.03em;
}

.section-body { padding: 1.75rem; }
.section-body.p-0 { padding: 0; }

/* === TABLES === */
.table-container { overflow-x: auto; }

.data-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.9rem;
}

.data-table thead th {
    position: sticky;
    top: 0;
    background: var(--forest);
    color: rgba(255,255,255,0.85);
    padding: 0.9rem 1.1rem;
    font-weight: 600;
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    border-bottom: 2px solid rgba(201,168,76,0.25);
    z-index: 5;
    white-space: nowrap;
}

.data-table thead th:first-child { border-radius: 0; }

.data-table tbody td {
    padding: 0.9rem 1.1rem;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
    color: var(--text-dark);
}

.data-table tbody tr { transition: background 0.2s; }

.data-table tbody tr:hover { background: var(--gold-pale); }

.data-table tbody tr:last-child td { border-bottom: none; }

/* Table Cells */
.reg-number {
    font-family: 'SF Mono', 'JetBrains Mono', monospace;
    font-weight: 700;
    color: var(--moss);
    background: var(--primary-50);
    padding: 0.25rem 0.6rem;
    border-radius: 8px;
    font-size: 0.82rem;
    border: 1px solid rgba(46,107,79,0.15);
}

/* === STATUS BADGES === */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.3rem 0.85rem;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 700;
    white-space: nowrap;
    letter-spacing: 0.02em;
}

.status-badge.pending  { background: var(--warning-bg);  color: var(--warning-text); }
.status-badge.verified { background: var(--success-bg);  color: var(--success-text); }
.status-badge.rejected { background: var(--danger-bg);   color: var(--danger-text);  }

.quota-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 48px;
    padding: 0.25rem 0.65rem;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 700;
}
.quota-badge.available { background: var(--success-bg); color: var(--success-text); }
.quota-badge.low       { background: var(--warning-bg); color: var(--warning-text); }
.quota-badge.full      { background: var(--danger-bg);  color: var(--danger-text);  }

/* === PROGRESS === */
.progress-bar {
    height: 6px;
    background: var(--ivory-dark);
    border-radius: 999px;
    overflow: hidden;
    width: 100px;
}
.progress-fill {
    height: 100%;
    border-radius: 999px;
    transition: width 0.4s ease;
}
.progress-fill.available { background: linear-gradient(90deg, var(--moss-light), var(--moss)); }
.progress-fill.low       { background: var(--warning); }
.progress-fill.full      { background: var(--danger);  }

/* === SEARCH BAR === */
.search-bar {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.search-form {
    flex: 1;
    min-width: 280px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 0.75rem;
}

.search-input, .search-select {
    padding: 0.65rem 1rem;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 0.9rem;
    font-family: var(--ff-body);
    background: white;
    color: var(--text-dark);
    transition: var(--transition);
    width: 100%;
}

.search-input:focus, .search-select:focus {
    outline: none;
    border-color: var(--gold-dark);
    box-shadow: 0 0 0 3px rgba(160,120,48,0.12);
}

.search-btn {
    padding: 0.65rem 1.5rem;
    background: linear-gradient(135deg, var(--moss-light), var(--forest-soft));
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.9rem;
    font-family: var(--ff-body);
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
    white-space: nowrap;
    box-shadow: 0 4px 15px rgba(46,107,79,0.3);
}

.search-btn:hover {
    background: linear-gradient(135deg, var(--moss), var(--forest-mid));
    transform: translateY(-1px);
    box-shadow: 0 8px 25px rgba(46,107,79,0.4);
}

.qr-scan-btn {
    padding: 0.65rem 1.25rem;
    background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
    color: var(--forest);
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.9rem;
    font-family: var(--ff-body);
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    transition: var(--transition);
    box-shadow: var(--shadow-gold);
}

.qr-scan-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(201,168,76,0.4);
}

/* === ACTION BAR === */
.action-bar {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    padding: 0 1.75rem 1rem;
    flex-wrap: wrap;
}

.action-btn {
    padding: 0.6rem 1.1rem;
    border-radius: 10px;
    font-weight: 600;
    font-family: var(--ff-body);
    font-size: 0.875rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    transition: var(--transition);
    border: 1.5px solid var(--border);
    background: white;
    cursor: pointer;
    color: var(--text-dark);
}

.action-btn.export {
    background: linear-gradient(135deg, var(--moss-light), var(--moss));
    color: white;
    border: none;
    box-shadow: 0 4px 12px rgba(46,107,79,0.25);
}

.action-btn.print {
    background: white;
    color: var(--text-mid);
}

.action-btn:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
    border-color: var(--border-hover);
}

.action-btn.export:hover {
    box-shadow: 0 8px 20px rgba(46,107,79,0.35);
}

/* === ROW ACTIONS === */
.row-actions {
    display: flex;
    gap: 0.35rem;
    flex-wrap: wrap;
}

.action-icon-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    cursor: pointer;
    transition: var(--transition);
    color: white;
    text-decoration: none;
    position: relative;
}

.action-icon-btn::after {
    content: attr(title);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(6px);
    padding: 0.3rem 0.65rem;
    background: var(--forest);
    color: white;
    font-size: 0.7rem;
    font-family: var(--ff-body);
    border-radius: 6px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: var(--transition);
    z-index: 100;
}

.action-icon-btn:hover::after {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}

.action-icon-btn.view   { background: var(--moss); }
.action-icon-btn.detail { background: var(--info); }
.action-icon-btn.edit   { background: var(--gold-dark); }
.action-icon-btn.delete { background: var(--danger); }
.action-icon-btn.verify { background: var(--success); }
.action-icon-btn.reject { background: var(--text-muted); }
.action-icon-btn.status-save { background: var(--forest-soft); }

.action-icon-btn:hover { transform: scale(1.08); filter: brightness(1.08); }
.action-icon-btn form  { display: contents; }

.status-update-inline {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    min-width: 154px;
}

.status-update-inline select {
    height: 32px;
    max-width: 118px;
    border: 1px solid var(--border);
    border-radius: 8px;
    background: white;
    color: var(--text-dark);
    font-size: 0.78rem;
    font-weight: 700;
    padding: 0 0.45rem;
    outline: none;
}

.status-update-inline select:focus {
    border-color: var(--moss);
    box-shadow: 0 0 0 3px rgba(46,107,79,0.14);
}

/* === PAGINATION === */
.pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.75rem;
    border-top: 1px solid var(--border);
    background: var(--ivory);
    flex-wrap: wrap;
    gap: 1rem;
}

.pagination-info {
    font-size: 0.85rem;
    color: var(--text-muted);
}

.pagination { display: flex; gap: 0.25rem; list-style: none; margin: 0; }

.pagination .page-link {
    padding: 0.4rem 0.8rem;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    color: var(--text-mid);
    font-size: 0.875rem;
    font-weight: 600;
    font-family: var(--ff-body);
    transition: var(--transition);
    background: white;
    text-decoration: none;
}

.pagination .page-item.active .page-link {
    background: var(--forest);
    border-color: var(--forest);
    color: white;
    box-shadow: 0 4px 12px rgba(13,33,24,0.25);
}

.pagination .page-link:hover:not(.active) {
    background: var(--gold-pale);
    border-color: var(--gold-dark);
    color: var(--gold-dark);
}

.pagination .disabled .page-link {
    opacity: 0.4;
    cursor: not-allowed;
}

/* === EMPTY STATE === */
.empty-state {
    text-align: center;
    padding: 3.5rem 1.5rem;
    color: var(--text-muted);
}

.empty-state i {
    font-size: 3.5rem;
    margin-bottom: 1rem;
    opacity: 0.25;
    color: var(--moss);
    display: block;
}

.empty-state p {
    margin: 0;
    font-family: var(--ff-display);
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-mid);
}

.empty-state small {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.875rem;
}

/* === QR MODAL === */
.qr-modal .modal-content {
    border-radius: var(--radius-xl);
    border: none;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
}

.qr-modal .modal-header {
    border-bottom: 1px solid var(--border);
    padding: 1.25rem 1.75rem;
    background: var(--forest);
    position: relative;
}

.qr-modal .modal-header::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent 5%, var(--gold-dark) 30%, var(--gold-light) 50%, var(--gold-dark) 70%, transparent 95%);
}

.qr-modal .modal-title {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1.05rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
}

.qr-modal .modal-title i { color: var(--gold-light); }

.qr-modal .btn-close {
    filter: invert(1) brightness(0.8);
}

.qr-modal .modal-body {
    padding: 1.75rem;
    text-align: center;
    background: var(--ivory);
}

.qr-instruction {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin-bottom: 1.25rem;
}

#qr-reader {
    width: 100%;
    max-width: 400px;
    margin: 0 auto 1.5rem;
    border-radius: var(--radius-lg);
    overflow: hidden;
    border: 2px solid var(--border);
    background: white;
}

.qr-manual {
    max-width: 400px;
    margin: 0 auto;
    text-align: left;
}

.qr-manual .input-group {
    display: flex;
    gap: 0.5rem;
}

.qr-manual .form-control {
    flex: 1;
    padding: 0.65rem 1rem;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 0.9rem;
    font-family: var(--ff-body);
    background: white;
    color: var(--text-dark);
    transition: var(--transition);
}

.qr-manual .form-control:focus {
    outline: none;
    border-color: var(--gold-dark);
    box-shadow: 0 0 0 3px rgba(160,120,48,0.12);
}

.qr-manual .btn {
    padding: 0.65rem 1.1rem;
    background: linear-gradient(135deg, var(--moss-light), var(--forest-soft));
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-family: var(--ff-body);
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    transition: var(--transition);
    box-shadow: 0 4px 12px rgba(46,107,79,0.25);
}

.qr-manual .btn:hover {
    background: linear-gradient(135deg, var(--moss), var(--forest-mid));
    box-shadow: 0 8px 20px rgba(46,107,79,0.35);
}

.qr-status {
    margin-top: 1rem;
    padding: 0.85rem 1.1rem;
    border-radius: 12px;
    font-size: 0.85rem;
    font-family: var(--ff-body);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-weight: 600;
}

.qr-status.info    { background: var(--info-bg);    color: var(--info-text);    }
.qr-status.success { background: var(--success-bg); color: var(--success-text); }
.qr-status.warning { background: var(--warning-bg); color: var(--warning-text); }
.qr-status.danger  { background: var(--danger-bg);  color: var(--danger-text);  }

/* === SUMMARY CARDS === */
.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
}

.summary-card {
    background: linear-gradient(135deg, white, var(--ivory));
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.1rem 1.25rem;
    text-align: center;
    transition: var(--transition-smooth);
    position: relative;
    overflow: hidden;
}

.summary-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, var(--gold-dark), var(--gold-light));
    opacity: 0;
    transition: var(--transition);
}

.summary-card:hover {
    border-color: rgba(201,168,76,0.35);
    transform: translateY(-2px);
    box-shadow: var(--shadow-gold);
}

.summary-card:hover::before { opacity: 1; }

.summary-value {
    font-family: var(--ff-display);
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    line-height: 1.2;
}

.summary-value.primary { color: var(--moss); }
.summary-value.success { color: var(--success); }
.summary-value.warning { color: var(--warning); }

.summary-label {
    font-size: 0.78rem;
    color: var(--text-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* === ANIMATIONS === */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

.stat-card    { animation: fadeInUp 0.35s ease forwards; }
.section-card { animation: fadeInUp 0.35s ease forwards; }

.stat-card:nth-child(1) { animation-delay: 0.05s; }
.stat-card:nth-child(2) { animation-delay: 0.10s; }
.stat-card:nth-child(3) { animation-delay: 0.15s; }
.stat-card:nth-child(4) { animation-delay: 0.20s; }
.section-card           { animation-delay: 0.25s; }

/* === RESPONSIVE === */
@media (max-width: 992px) {
    .dashboard-wrapper { padding: 1.25rem 1.5rem; }
    .search-bar { flex-direction: column; align-items: stretch; }
    .search-form { min-width: 100%; }
    .action-bar { justify-content: center; }
}

@media (max-width: 768px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .data-table { font-size: 0.85rem; }
    .data-table thead th, .data-table tbody td { padding: 0.65rem 0.6rem; }
    .progress-bar { width: 80px; }
    .row-actions { justify-content: center; }
    .pagination-wrapper { flex-direction: column; text-align: center; }
    .dashboard-header h4 { font-size: 1.15rem; }
    .stat-value { font-size: 1.5rem; }
}

@media (max-width: 480px) {
    .stats-grid { grid-template-columns: 1fr; }
    .section-header { flex-direction: column; align-items: flex-start; }
    .qr-manual .input-group { flex-direction: column; }
    .qr-manual .btn { width: 100%; justify-content: center; }
}

/* === PRINT === */
@media print {
    .search-bar, .action-bar, .row-actions,
    .qr-scan-btn, .pagination-wrapper { display: none !important; }
    .section-card { break-inside: avoid; box-shadow: none; border: 1px solid #ccc; }
    body { background: white; }
}

/* === UTILITIES === */
.text-muted       { color: var(--text-muted)  !important; }
.text-small       { font-size: 0.8rem         !important; }
.fw-medium        { font-weight: 500          !important; }
.fw-semibold      { font-weight: 600          !important; }
.d-flex           { display: flex            !important; }
.align-items-center { align-items: center    !important; }
.gap-2            { gap: 0.5rem              !important; }
.mb-1             { margin-bottom: 0.25rem   !important; }
.mb-2             { margin-bottom: 0.5rem    !important; }
.d-none           { display: none            !important; }
.text-end         { text-align: right        !important; }

.stat-icon.primary i.fa-male { color: #3b82f6; }
.stat-icon.primary i.fa-female { color: #ec4899; }

.dashboard-home-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.2fr) minmax(320px, 0.8fr);
    gap: 1rem;
    margin-top: 1.4rem;
}

.dashboard-widget {
    min-width: 0;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    padding: 1.2rem;
}

.dashboard-widget-wide {
    grid-column: 1 / -1;
}

.dashboard-widget-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1rem;
}

.dashboard-widget-header h5 {
    margin: 0;
    color: var(--text-dark);
    font-family: var(--ff-display);
    font-size: 1rem;
    font-weight: 800;
}

.dashboard-widget-header small {
    color: var(--text-muted);
    font-weight: 700;
}

.dashboard-work-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.8rem;
}

.dashboard-work-item,
.dashboard-link-card,
.dashboard-list-item {
    border: 1px solid var(--border);
    border-radius: 14px;
    background: #fbfdfc;
}

.dashboard-work-item {
    padding: 1rem;
}

.dashboard-work-item span,
.dashboard-status-row span,
.dashboard-list-item span {
    color: var(--text-muted);
    font-size: 0.8rem;
    font-weight: 700;
}

.dashboard-work-item strong {
    display: block;
    margin-top: 0.35rem;
    color: var(--text-dark);
    font-family: var(--ff-display);
    font-size: 1.55rem;
    line-height: 1;
}

.dashboard-link-grid {
    display: grid;
    gap: 0.7rem;
}

.dashboard-link-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.85rem;
    color: var(--text-dark);
    text-decoration: none;
    transition: var(--transition);
}

.dashboard-link-card:hover {
    border-color: rgba(46, 107, 79, 0.28);
    background: var(--mint);
    transform: translateY(-1px);
}

.dashboard-link-card i {
    width: 2.2rem;
    height: 2.2rem;
    border-radius: 12px;
    display: grid;
    place-items: center;
    color: white;
    background: linear-gradient(135deg, var(--moss), var(--forest-soft));
}

.dashboard-link-card strong {
    display: block;
    font-size: 0.92rem;
}

.dashboard-link-card small {
    color: var(--text-muted);
    font-size: 0.76rem;
    font-weight: 700;
}

.dashboard-status-list,
.dashboard-list {
    display: grid;
    gap: 0.7rem;
}

.dashboard-status-row {
    display: grid;
    gap: 0.4rem;
}

.dashboard-status-meta {
    display: flex;
    justify-content: space-between;
    gap: 0.75rem;
    font-weight: 800;
}

.dashboard-status-bar {
    height: 0.6rem;
    border-radius: 999px;
    overflow: hidden;
    background: #edf3f0;
}

.dashboard-status-fill {
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, var(--moss), var(--gold));
}

.dashboard-list-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    padding: 0.8rem;
}

.dashboard-list-item strong {
    color: var(--text-dark);
    font-size: 0.9rem;
}

.dashboard-empty-note {
    padding: 1rem;
    color: var(--text-muted);
    border: 1px dashed var(--border);
    border-radius: 14px;
    background: #fbfdfc;
    font-weight: 700;
}

.insight-grid,
.chart-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 1rem;
    margin-bottom: 1.75rem;
}

.insight-card,
.chart-card,
.heatmap-card,
.activity-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
}

.insight-card {
    min-height: 126px;
    padding: 1.15rem;
    display: grid;
    align-content: space-between;
}

.insight-label {
    color: var(--text-muted);
    font-size: 0.78rem;
    font-weight: 800;
    text-transform: uppercase;
}

.insight-value {
    color: var(--text-dark);
    font-family: var(--ff-display);
    font-size: 1.9rem;
    font-weight: 800;
    line-height: 1;
}

.insight-note {
    color: var(--text-muted);
    font-size: 0.82rem;
    margin-top: 0.4rem;
}

.chart-grid {
    grid-template-columns: minmax(0, 1.35fr) minmax(0, 0.85fr);
}

.chart-card {
    padding: 1.25rem;
    min-width: 0;
}

.chart-card.wide {
    grid-column: span 1;
}

.chart-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1rem;
}

.chart-heading h5,
.analytics-title {
    margin: 0;
    color: var(--text-dark);
    font-family: var(--ff-display);
    font-size: 1rem;
    font-weight: 800;
}

.chart-box {
    position: relative;
    min-height: 300px;
}

.chart-box-native {
    display: grid;
    gap: 0.8rem;
}

.trend-chart {
    height: 230px;
    display: flex;
    align-items: end;
    gap: 0.38rem;
    padding: 0.75rem 0.4rem 0;
    border-bottom: 1px solid var(--border);
    background:
        linear-gradient(to top, rgba(220, 230, 226, 0.75) 1px, transparent 1px) 0 0 / 100% 25%,
        linear-gradient(to bottom, rgba(46, 107, 79, 0.04), rgba(201, 168, 76, 0.04));
    border-radius: 14px 14px 0 0;
}

.trend-bar-wrap {
    flex: 1;
    min-width: 5px;
    height: 100%;
    display: flex;
    align-items: end;
}

.trend-bar {
    width: 100%;
    min-height: 3px;
    border-radius: 999px 999px 0 0;
    background: linear-gradient(180deg, var(--moss-light), var(--forest-soft));
    box-shadow: 0 8px 18px rgba(46, 107, 79, 0.18);
}

.trend-axis,
.chart-legend {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.8rem;
    color: var(--text-muted);
    font-size: 0.75rem;
    font-weight: 800;
}

.chart-legend {
    justify-content: flex-start;
    flex-wrap: wrap;
    font-size: 0.78rem;
}

.legend-item {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}

.legend-swatch {
    width: 0.65rem;
    height: 0.65rem;
    border-radius: 999px;
    display: inline-block;
}

.status-chart {
    min-height: 250px;
    display: grid;
    place-items: center;
    gap: 1rem;
}

.status-donut {
    width: 176px;
    height: 176px;
    border-radius: 50%;
    position: relative;
    box-shadow: inset 0 0 0 1px rgba(13, 33, 24, 0.08), var(--shadow-sm);
}

.status-donut::after {
    content: '';
    position: absolute;
    inset: 28px;
    border-radius: 50%;
    background: white;
    box-shadow: inset 0 0 0 1px var(--border);
}

.donut-center {
    position: absolute;
    inset: 0;
    display: grid;
    place-content: center;
    text-align: center;
    z-index: 1;
}

.donut-value {
    color: var(--forest);
    font-family: var(--ff-display);
    font-size: 2rem;
    font-weight: 800;
    line-height: 1;
}

.donut-label {
    color: var(--text-muted);
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
}

.bar-chart-list,
.quota-chart-list {
    display: grid;
    gap: 0.9rem;
    padding-top: 0.25rem;
}

.bar-chart-row,
.quota-chart-row {
    display: grid;
    grid-template-columns: minmax(120px, 180px) 1fr auto;
    gap: 0.8rem;
    align-items: center;
}

.bar-label,
.quota-label {
    color: var(--text-dark);
    font-size: 0.82rem;
    font-weight: 800;
}

.bar-track,
.quota-stack {
    height: 0.85rem;
    overflow: hidden;
    border-radius: 999px;
    background: var(--ivory-dark);
}

.bar-fill {
    display: block;
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, var(--moss), #1f9aa5);
}

.quota-stack {
    display: flex;
}

.quota-used,
.quota-open {
    display: block;
    height: 100%;
}

.quota-used { background: var(--moss); }
.quota-open { background: var(--gold); }

.bar-value,
.quota-value {
    color: var(--text-muted);
    font-size: 0.78rem;
    font-weight: 800;
    white-space: nowrap;
}

.empty-chart {
    min-height: 220px;
    display: grid;
    place-items: center;
    color: var(--text-muted);
    font-size: 0.88rem;
    font-weight: 700;
}

.analytics-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.15fr) minmax(320px, 0.85fr);
    gap: 1rem;
    margin-bottom: 1.75rem;
}

.heatmap-card,
.activity-card {
    padding: 1.25rem;
}

.heatmap {
    display: grid;
    gap: 0.45rem;
    margin-top: 1rem;
    overflow-x: auto;
}

.heatmap-row,
.heatmap-header {
    display: grid;
    grid-template-columns: 3.2rem repeat(6, minmax(4rem, 1fr));
    gap: 0.45rem;
    min-width: 520px;
}

.heatmap-header {
    color: var(--text-muted);
    font-size: 0.75rem;
    font-weight: 800;
    text-align: center;
}

.heatmap-day {
    color: var(--text-muted);
    font-size: 0.78rem;
    font-weight: 800;
    display: flex;
    align-items: center;
}

.heatmap-cell {
    min-height: 42px;
    border: 1px solid rgba(15, 95, 74, 0.08);
    border-radius: 10px;
    display: grid;
    place-items: center;
    color: var(--text-dark);
    font-size: 0.84rem;
    font-weight: 800;
}

.quota-alerts {
    display: grid;
    gap: 0.55rem;
    margin-top: 1rem;
}

.quota-alert {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    border: 1px solid var(--warning-bg);
    border-radius: 12px;
    background: var(--warning-bg);
    color: var(--warning-text);
    padding: 0.7rem 0.85rem;
    font-size: 0.84rem;
    font-weight: 700;
}

.activity-list {
    display: grid;
    gap: 0.75rem;
    margin-top: 1rem;
}

.activity-item {
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 0.75rem;
    align-items: center;
    border-bottom: 1px solid var(--border);
    padding-bottom: 0.75rem;
}

.activity-item:last-child {
    border-bottom: 0;
    padding-bottom: 0;
}

.activity-dot {
    width: 0.75rem;
    height: 0.75rem;
    border-radius: 50%;
    background: var(--moss);
}

.activity-dot.pending { background: var(--warning); }
.activity-dot.verified { background: var(--success); }
.activity-dot.rejected { background: var(--danger); }

.activity-name {
    color: var(--text-dark);
    font-weight: 800;
    line-height: 1.2;
}

.activity-meta {
    color: var(--text-muted);
    font-size: 0.78rem;
}

@media (max-width: 1199px) {
    .dashboard-home-grid,
    .insight-grid { grid-template-columns: repeat(2, 1fr); }
    .chart-grid,
    .analytics-grid { grid-template-columns: 1fr; }
}

@media (max-width: 575px) {
    .dashboard-home-grid,
    .dashboard-work-grid,
    .insight-grid { grid-template-columns: 1fr; }
    .chart-box { height: 260px; }
}
</style>
@endpush

@section('admin_content')
@php
    $adminSection = $adminSection ?? 'dashboard';
    $showDashboard = $adminSection === 'dashboard';
    $showAnalytics = $adminSection === 'analytics';
    $showQuotas = $adminSection === 'quotas';
    $showApplicants = $adminSection === 'applicants' || ($search ?? false);
    $showGuide = $adminSection === 'guide';
@endphp
<div class="dashboard-wrapper">

    <!-- Header -->
    <header class="dashboard-header">
        <h4>
            <i class="fas fa-tachometer-alt"></i>
            Dashboard Admin — SPMB 2026/2027
        </h4>
        <div class="header-meta">
            <span><i class="fas fa-calendar me-1"></i>{{ now()->format('d M Y') }}</span>
            <span class="badge">
                <i class="fas fa-user-shield me-1"></i>{{ Auth::user()->name ?? 'Admin' }}
            </span>
        </div>
    </header>

    <!-- Stats Overview -->
    @if($showDashboard)
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="fas fa-users"></i></div>
            <div class="stat-content">
                <div class="stat-label">Total Pendaftar</div>
                <div class="stat-value">{{ number_format($stats['total']) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon warning"><i class="fas fa-clock"></i></div>
            <div class="stat-content">
                <div class="stat-label">Menunggu Verifikasi</div>
                <div class="stat-value">{{ number_format($stats['pending']) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
            <div class="stat-content">
                <div class="stat-label">Terverifikasi</div>
                <div class="stat-value">{{ number_format($stats['verified']) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon danger"><i class="fas fa-times-circle"></i></div>
            <div class="stat-content">
                <div class="stat-label">Ditolak</div>
                <div class="stat-value">{{ number_format($stats['rejected']) }}</div>
            </div>
        </div>
    </div>

    @php
        $dashboardQuotaAlerts = collect($dashboard['quota_alerts']);
        $dashboardLatestItems = collect($dashboard['latest']);
        $dashboardStatusLabels = $dashboard['status']['labels'];
        $dashboardStatusData = $dashboard['status']['data'];
        $dashboardStatusTotal = max(array_sum($dashboardStatusData), 1);
    @endphp

    <div class="dashboard-home-grid">
        <section class="dashboard-widget dashboard-widget-wide">
            <div class="dashboard-widget-header">
                <h5><i class="fas fa-clipboard-list"></i> Peta Kerja Hari Ini</h5>
                <small>{{ now()->format('d M Y') }}</small>
            </div>
            <div class="dashboard-work-grid">
                <div class="dashboard-work-item">
                    <span>Pendaftar hari ini</span>
                    <strong>{{ number_format($dashboard['kpis']['today']) }}</strong>
                </div>
                <div class="dashboard-work-item">
                    <span>Perlu diverifikasi</span>
                    <strong>{{ number_format($stats['pending']) }}</strong>
                </div>
                <div class="dashboard-work-item">
                    <span>Kuota perlu perhatian</span>
                    <strong>{{ number_format($dashboardQuotaAlerts->count()) }}</strong>
                </div>
                <div class="dashboard-work-item">
                    <span>Pendaftar 7 hari</span>
                    <strong>{{ number_format($dashboard['kpis']['week']) }}</strong>
                </div>
            </div>
        </section>

        <section class="dashboard-widget">
            <div class="dashboard-widget-header">
                <h5><i class="fas fa-bolt"></i> Akses Cepat</h5>
                <small>Halaman kerja</small>
            </div>
            <div class="dashboard-link-grid">
                <a href="{{ route('admin.applicants') }}" class="dashboard-link-card">
                    <i class="fas fa-table"></i>
                    <span><strong>Data Pendaftar</strong><small>Cari, verifikasi, dan edit data.</small></span>
                </a>
                <a href="{{ route('admin.analytics') }}" class="dashboard-link-card">
                    <i class="fas fa-chart-line"></i>
                    <span><strong>Analytics</strong><small>Grafik tren dan heatmap.</small></span>
                </a>
                <a href="{{ route('admin.quotas') }}" class="dashboard-link-card">
                    <i class="fas fa-layer-group"></i>
                    <span><strong>Kuota Jurusan</strong><small>Pantau kapasitas pendaftaran.</small></span>
                </a>
                <a href="{{ route('admin.export.excel') }}" class="dashboard-link-card">
                    <i class="fas fa-file-excel"></i>
                    <span><strong>Export Excel</strong><small>Unduh data pendaftar.</small></span>
                </a>
            </div>
        </section>

        <section class="dashboard-widget">
            <div class="dashboard-widget-header">
                <h5><i class="fas fa-circle-nodes"></i> Status Pendaftaran</h5>
                <small>{{ number_format($stats['total']) }} total</small>
            </div>
            <div class="dashboard-status-list">
                @foreach($dashboardStatusLabels as $index => $label)
                    @php
                        $value = (int) ($dashboardStatusData[$index] ?? 0);
                        $percent = round(($value / $dashboardStatusTotal) * 100, 1);
                    @endphp
                    <div class="dashboard-status-row">
                        <div class="dashboard-status-meta">
                            <span>{{ $label }}</span>
                            <strong>{{ number_format($value) }} siswa</strong>
                        </div>
                        <div class="dashboard-status-bar">
                            <div class="dashboard-status-fill" style="width: {{ $percent }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="dashboard-widget">
            <div class="dashboard-widget-header">
                <h5><i class="fas fa-triangle-exclamation"></i> Kuota Perlu Perhatian</h5>
                <small>Sisa rendah</small>
            </div>
            <div class="dashboard-list">
                @forelse($dashboardQuotaAlerts as $alert)
                    <div class="dashboard-list-item">
                        <span>{{ $alert['label'] }}</span>
                        <strong>{{ $alert['available'] }} sisa</strong>
                    </div>
                @empty
                    <div class="dashboard-empty-note">Semua kuota masih aman.</div>
                @endforelse
            </div>
        </section>

        <section class="dashboard-widget dashboard-widget-wide">
            <div class="dashboard-widget-header">
                <h5><i class="fas fa-clock-rotate-left"></i> Aktivitas Terbaru</h5>
                <small>5 pendaftar terakhir</small>
            </div>
            <div class="dashboard-list">
                @forelse($dashboardLatestItems as $item)
                    <div class="dashboard-list-item">
                        <span>
                            <strong>{{ $item['name'] }}</strong><br>
                            {{ $item['registration_number'] }} - {{ $item['choice'] }}
                        </span>
                        <span class="status-badge {{ $item['status'] }}">{{ ucfirst($item['status']) }}</span>
                    </div>
                @empty
                    <div class="dashboard-empty-note">Belum ada aktivitas pendaftaran.</div>
                @endforelse
            </div>
        </section>
    </div>
    @endif

    <!-- Analytics Overview -->
    @if($showAnalytics)
    <div class="insight-grid" id="analytics">
        <div class="insight-card">
            <div>
                <div class="insight-label">Kapasitas Terpakai</div>
                <div class="insight-value">{{ $dashboard['kpis']['capacity_rate'] }}%</div>
            </div>
            <div class="insight-note">
                {{ number_format($dashboard['kpis']['capacity_used']) }} dari {{ number_format($dashboard['kpis']['capacity_total']) }} kursi
            </div>
        </div>
        <div class="insight-card">
            <div>
                <div class="insight-label">Pendaftar Hari Ini</div>
                <div class="insight-value">{{ number_format($dashboard['kpis']['today']) }}</div>
            </div>
            <div class="insight-note">{{ number_format($dashboard['kpis']['week']) }} pendaftar dalam 7 hari</div>
        </div>
        <div class="insight-card">
            <div>
                <div class="insight-label">Rata-rata Harian</div>
                <div class="insight-value">{{ $dashboard['kpis']['daily_average'] }}</div>
            </div>
            <div class="insight-note">Berdasarkan 7 hari terakhir</div>
        </div>
        <div class="insight-card">
            <div>
                <div class="insight-label">Jam Tersibuk</div>
                <div class="insight-value">{{ $dashboard['kpis']['busiest_slot']['label'] }}</div>
            </div>
            <div class="insight-note">{{ number_format($dashboard['kpis']['busiest_slot']['count']) }} pendaftaran dalam periode ini</div>
        </div>
    </div>

    <div class="chart-grid">
        <div class="chart-card wide">
            <div class="chart-heading">
                <h5><i class="fas fa-chart-line"></i> Tren Pendaftaran {{ $dashboard['period'] }} Hari</h5>
                <span class="section-badge">Harian</span>
            </div>
            <div id="registrationTrendChart" class="chart-box chart-box-native" role="img" aria-label="Grafik tren pendaftaran harian">
                @php
                    $trendLabels = $dashboard['trend']['labels'];
                    $trendTotals = $dashboard['trend']['total'];
                    $trendMax = max(array_merge($trendTotals, [1]));
                    $middleTrendIndex = max(0, (int) floor((count($trendLabels) - 1) / 2));
                @endphp
                <div class="trend-chart">
                    @foreach($trendTotals as $index => $value)
                        @php $height = max(3, ($value / $trendMax) * 100); @endphp
                        <span class="trend-bar-wrap" title="{{ $trendLabels[$index] ?? 'Hari' }}: {{ $value }} pendaftar">
                            <span class="trend-bar" style="height: {{ $height }}%;"></span>
                        </span>
                    @endforeach
                </div>
                <div class="trend-axis">
                    <span>{{ $trendLabels[0] ?? '-' }}</span>
                    <span>{{ $trendLabels[$middleTrendIndex] ?? '-' }}</span>
                    <span>{{ $trendLabels[count($trendLabels) - 1] ?? '-' }}</span>
                </div>
                <div class="chart-legend">
                    <span class="legend-item"><span class="legend-swatch" style="background: var(--moss);"></span>Total harian</span>
                    <span class="legend-item"><span class="legend-swatch" style="background: var(--gold);"></span>Puncak: {{ number_format($trendMax) }}</span>
                </div>
            </div>
        </div>
        <div class="chart-card">
            <div class="chart-heading">
                <h5><i class="fas fa-circle-notch"></i> Status Pendaftar</h5>
                <span class="section-badge">Total</span>
            </div>
            <div id="statusChart" class="chart-box status-chart" role="img" aria-label="Grafik komposisi status pendaftar">
                @php
                    $statusLabels = $dashboard['status']['labels'];
                    $statusData = $dashboard['status']['data'];
                    $statusColors = ['#d97706', '#16a34a', '#dc2626'];
                    $statusRawTotal = array_sum($statusData);
                    $statusTotal = max($statusRawTotal, 1);
                    $cursor = 0;
                    $segments = [];

                    foreach ($statusData as $statusIndex => $count) {
                        $next = $cursor + (($count / $statusTotal) * 100);
                        $segments[] = ($statusColors[$statusIndex] ?? '#0f5f4a') . " {$cursor}% {$next}%";
                        $cursor = $next;
                    }

                    $donutGradient = $statusRawTotal > 0
                        ? 'conic-gradient(' . implode(', ', $segments) . ')'
                        : '#edf3f0';
                @endphp
                <div class="status-donut" style="background: {{ $donutGradient }};">
                    <div class="donut-center">
                        <span class="donut-value">{{ number_format($statusRawTotal) }}</span>
                        <span class="donut-label">Pendaftar</span>
                    </div>
                </div>
                <div class="chart-legend">
                    @foreach($statusLabels as $index => $label)
                        <span class="legend-item">
                            <span class="legend-swatch" style="background: {{ $statusColors[$index] ?? '#0f5f4a' }};"></span>
                            {{ $label }} <strong>{{ number_format($statusData[$index] ?? 0) }}</strong>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="chart-grid">
        <div class="chart-card">
            <div class="chart-heading">
                <h5><i class="fas fa-layer-group"></i> Distribusi Jurusan</h5>
                <span class="section-badge">Peminat</span>
            </div>
            <div id="majorDistributionChart" class="chart-box chart-box-native" role="img" aria-label="Grafik distribusi jurusan">
                @php
                    $distributionLabels = $dashboard['distribution']['labels'];
                    $distributionData = $dashboard['distribution']['data'];
                    $distributionMax = max(array_merge($distributionData, [1]));
                @endphp
                <div class="bar-chart-list">
                    @forelse($distributionLabels as $index => $label)
                        @php
                            $value = $distributionData[$index] ?? 0;
                            $width = max(3, ($value / $distributionMax) * 100);
                        @endphp
                        <div class="bar-chart-row">
                            <span class="bar-label">{{ $label }}</span>
                            <span class="bar-track">
                                <span class="bar-fill" style="width: {{ $width }}%;"></span>
                            </span>
                            <span class="bar-value">{{ number_format($value) }}</span>
                        </div>
                    @empty
                        <div class="empty-chart">Belum ada distribusi jurusan.</div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="chart-card">
            <div class="chart-heading">
                <h5><i class="fas fa-gauge-high"></i> Penggunaan Kuota</h5>
                <span class="section-badge">Kursi</span>
            </div>
            <div id="quotaChart" class="chart-box chart-box-native" role="img" aria-label="Grafik penggunaan kuota">
                <div class="quota-chart-list">
                    @forelse($dashboard['quota']['labels'] as $index => $label)
                        @php
                            $used = $dashboard['quota']['used'][$index] ?? 0;
                            $available = $dashboard['quota']['available'][$index] ?? 0;
                            $totalQuota = max($used + $available, 1);
                            $usedWidth = ($used / $totalQuota) * 100;
                            $availableWidth = max(0, 100 - $usedWidth);
                        @endphp
                        <div class="quota-chart-row">
                            <span class="quota-label">{{ $label }}</span>
                            <span class="quota-stack" title="{{ $used }} terpakai, {{ $available }} tersisa">
                                <span class="quota-used" style="width: {{ $usedWidth }}%;"></span>
                                <span class="quota-open" style="width: {{ $availableWidth }}%;"></span>
                            </span>
                            <span class="quota-value">{{ number_format($used) }}/{{ number_format($totalQuota) }}</span>
                        </div>
                    @empty
                        <div class="empty-chart">Belum ada data kuota.</div>
                    @endforelse
                </div>
                <div class="chart-legend">
                    <span class="legend-item"><span class="legend-swatch" style="background: var(--moss);"></span>Terpakai</span>
                    <span class="legend-item"><span class="legend-swatch" style="background: var(--gold);"></span>Tersisa</span>
                </div>
            </div>
        </div>
    </div>

    <div class="analytics-grid">
        <div class="heatmap-card">
            <div class="chart-heading">
                <h5><i class="fas fa-table-cells"></i> Heatmap Waktu Pendaftaran</h5>
                <span class="section-badge">{{ $dashboard['period'] }} Hari</span>
            </div>
            <div class="heatmap" aria-label="Heatmap waktu pendaftaran">
                <div class="heatmap-header">
                    <span></span>
                    @foreach($dashboard['heatmap']['slots'] as $slot)
                        <span>{{ $slot }}</span>
                    @endforeach
                </div>
                @foreach($dashboard['heatmap']['rows'] as $row)
                    <div class="heatmap-row">
                        <span class="heatmap-day">{{ $row['label'] }}</span>
                        @foreach($row['cells'] as $cell)
                            @php
                                $alpha = 0.07 + ($cell['intensity'] * 0.78);
                                $textColor = $cell['intensity'] > 0.55 ? '#ffffff' : 'var(--text-dark)';
                            @endphp
                            <span class="heatmap-cell"
                                  title="{{ $row['label'] }} {{ $cell['label'] }}: {{ $cell['count'] }} pendaftaran"
                                  style="background: rgba(15, 95, 74, {{ $alpha }}); color: {{ $textColor }};">
                                {{ $cell['count'] }}
                            </span>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="activity-card">
            <h5 class="analytics-title"><i class="fas fa-bell"></i> Perlu Perhatian</h5>
            <div class="quota-alerts">
                @forelse($dashboard['quota_alerts'] as $alert)
                    <div class="quota-alert">
                        <span>{{ $alert['label'] }}</span>
                        <strong>{{ $alert['available'] }} sisa · {{ $alert['percentage'] }}%</strong>
                    </div>
                @empty
                    <div class="activity-meta">Semua kuota masih dalam kondisi aman.</div>
                @endforelse
            </div>

            <h5 class="analytics-title mt-4"><i class="fas fa-clock-rotate-left"></i> Aktivitas Terbaru</h5>
            <div class="activity-list">
                @forelse($dashboard['latest'] as $item)
                    <div class="activity-item">
                        <span class="activity-dot {{ $item['status'] }}"></span>
                        <div>
                            <div class="activity-name">{{ $item['name'] }}</div>
                            <div class="activity-meta">{{ $item['registration_number'] }} · {{ $item['choice'] }}</div>
                        </div>
                        <span class="activity-meta">{{ $item['time'] }}</span>
                    </div>
                @empty
                    <div class="activity-meta">Belum ada aktivitas pendaftaran.</div>
                @endforelse
            </div>
        </div>
    </div>
    @endif

    <!-- Kuota per Jurusan -->
    @if($showQuotas)
    <!-- Quota Modern UI Styles -->
    <style>
        .quota-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.75rem;
        }
        .quota-stat-mini {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }
        .quota-stat-mini:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        .quota-stat-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-size: 1.25rem;
        }
        .quota-stat-icon-wrap.smk-green {
            background: rgba(16, 92, 75, 0.1);
            color: var(--brand);
        }
        .quota-stat-icon-wrap.smk-gold {
            background: rgba(201, 168, 76, 0.1);
            color: var(--gold-dark);
        }
        .quota-stat-icon-wrap.smk-red {
            background: rgba(220, 38, 38, 0.1);
            color: #dc2626;
        }
        .quota-stat-info {
            display: flex;
            flex-direction: column;
        }
        .quota-stat-label {
            font-size: 0.78rem;
            font-weight: 800;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .quota-stat-number {
            font-size: 1.35rem;
            font-weight: 900;
            color: var(--brand-800);
            line-height: 1.2;
            margin-top: 0.15rem;
        }

        .quota-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(310px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }
        .quota-modern-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .quota-modern-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: rgba(16, 92, 75, 0.2);
        }
        .quota-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.25rem;
        }
        .quota-card-title {
            margin: 0;
            font-family: var(--ff-display);
            font-size: 1.15rem;
            font-weight: 900;
            color: var(--brand-800);
        }
        .quota-edit-btn {
            background: none;
            border: 0;
            color: var(--muted);
            font-size: 1rem;
            cursor: pointer;
            padding: 0.35rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .quota-edit-btn:hover {
            background: rgba(16, 92, 75, 0.08);
            color: var(--brand);
        }
        .quota-card-metric {
            margin-bottom: 0.85rem;
        }
        .quota-metric-sisa {
            font-size: 1.25rem;
            font-weight: 900;
            color: var(--text-dark);
            margin-bottom: 0.15rem;
        }
        .quota-metric-desc {
            font-size: 0.82rem;
            color: var(--muted);
            font-weight: 700;
        }
        .quota-progress-container {
            margin-bottom: 1rem;
        }
        .quota-progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.78rem;
            font-weight: 800;
            color: var(--muted);
            margin-bottom: 0.35rem;
        }
        .quota-progress-bar-wrap {
            height: 8px;
            background: var(--ivory-dark);
            border-radius: 999px;
            overflow: hidden;
        }
        .quota-progress-fill {
            height: 100%;
            border-radius: inherit;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .quota-progress-fill.available {
            background: linear-gradient(90deg, var(--brand), #1f9aa5);
        }
        .quota-progress-fill.low {
            background: #d97706;
        }
        .quota-progress-fill.full {
            background: #dc2626;
        }
        
        .quota-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.85rem;
            border-top: 1px solid var(--line);
            margin-top: auto;
        }
        .quota-pill {
            display: inline-flex;
            align-items: center;
            font-size: 0.72rem;
            font-weight: 900;
            padding: 0.25rem 0.65rem;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .quota-pill.available {
            background: #ecfdf5;
            color: #065f46;
        }
        .quota-pill.low {
            background: #fffbeb;
            color: #92400e;
        }
        .quota-pill.full {
            background: #fef2f2;
            color: #991b1b;
        }

        /* Timeline Styles */
        .timeline-card {
            border: 1px solid var(--line);
            border-radius: 18px;
            background: #ffffff;
            box-shadow: var(--shadow-sm);
            margin-top: 2rem;
            overflow: hidden;
        }
        .timeline-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--line);
            background: linear-gradient(180deg, #ffffff, #f8fbfa);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .timeline-header h5 {
            margin: 0;
            font-family: var(--ff-display);
            font-size: 1.1rem;
            font-weight: 900;
            color: var(--brand-800);
        }
        .timeline-body {
            padding: 1.5rem;
        }
        .timeline-list {
            position: relative;
            padding-left: 2rem;
        }
        .timeline-list::before {
            content: '';
            position: absolute;
            top: 4px;
            bottom: 4px;
            left: 7px;
            width: 2px;
            background: var(--line);
        }
        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .timeline-item:last-child {
            margin-bottom: 0;
        }
        .timeline-badge {
            position: absolute;
            left: -2rem;
            top: 2px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #ffffff;
            border: 3px solid var(--brand);
            z-index: 2;
            display: block;
        }
        .timeline-badge.verify { border-color: #10b981; }
        .timeline-badge.reject { border-color: #ef4444; }
        .timeline-badge.update { border-color: #3b82f6; }
        .timeline-badge.quota { border-color: #f59e0b; }
        
        .timeline-content-box {
            background: #f8fbfa;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 0.85rem 1.15rem;
            transition: all 0.2s ease;
        }
        .timeline-content-box:hover {
            background: #ffffff;
            border-color: rgba(16, 92, 75, 0.16);
            box-shadow: 0 4px 12px rgba(20, 32, 29, 0.04);
        }
        .timeline-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.78rem;
            color: var(--muted);
            font-weight: 800;
            margin-bottom: 0.25rem;
            flex-wrap: wrap;
            gap: 0.45rem;
        }
        .timeline-user {
            color: var(--brand-800);
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .timeline-date {
            font-weight: 700;
        }
        .timeline-title {
            font-size: 0.92rem;
            font-weight: 900;
            color: var(--text-dark);
            margin: 0 0 0.15rem;
        }
        .timeline-desc {
            font-size: 0.88rem;
            color: var(--text-mid, #4b5563);
            margin: 0;
            line-height: 1.45;
        }
        .timeline-properties {
            margin-top: 0.45rem;
            font-size: 0.78rem;
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid var(--line);
            padding: 0.35rem 0.55rem;
            border-radius: 6px;
            font-family: monospace;
            color: #0f766e;
        }
        .timeline-footer-meta {
            display: flex;
            gap: 0.75rem;
            font-size: 0.74rem;
            color: var(--muted);
            margin-top: 0.35rem;
            font-weight: 700;
        }
        .timeline-empty {
            padding: 2.5rem;
            text-align: center;
            color: var(--muted);
            font-weight: 800;
    </style>

    <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
        <h4 class="mb-0 fw-bold" style="color: var(--brand-800);"><i class="fas fa-chart-bar me-2"></i>Kuota Pendaftaran per Jurusan</h4>
        <span class="badge" style="background: rgba(16, 92, 75, 0.1); color: var(--brand); font-weight: 800; padding: 0.5rem 1rem;">Update Otomatis</span>
    </div>

    <!-- Quota Stats Panel -->
    <div class="quota-stats-grid">
        @php
            $totalQuotaVal = $quotas->sum('quota');
            $totalUsedVal = $quotas->sum('used_quota');
            $totalAvailableVal = max(0, $totalQuotaVal - $totalUsedVal);
            $globalPercentage = $totalQuotaVal > 0 ? round(($totalUsedVal / $totalQuotaVal) * 100) : 0;
        @endphp
        <div class="quota-stat-mini">
            <div class="quota-stat-icon-wrap smk-green"><i class="fas fa-layer-group"></i></div>
            <div class="quota-stat-info">
                <span class="quota-stat-label">Total Kuota</span>
                <span class="quota-stat-number">{{ number_format($totalQuotaVal) }} Kursi</span>
            </div>
        </div>
        <div class="quota-stat-mini">
            <div class="quota-stat-icon-wrap smk-gold"><i class="fas fa-user-check"></i></div>
            <div class="quota-stat-info">
                <span class="quota-stat-label">Total Terpakai</span>
                <span class="quota-stat-number">{{ number_format($totalUsedVal) }} ({{ $globalPercentage }}%)</span>
            </div>
        </div>
        <div class="quota-stat-mini">
            <div class="quota-stat-icon-wrap smk-red"><i class="fas fa-user-plus"></i></div>
            <div class="quota-stat-info">
                <span class="quota-stat-label">Sisa Kuota Kosong</span>
                <span class="quota-stat-number">{{ number_format($totalAvailableVal) }} Kursi</span>
            </div>
        </div>
    </div>

    <!-- Quota Cards Grid -->
    <div class="quota-cards-grid">
        @foreach($quotas as $quota)
        @php
            $status = $quota->status;
            $percent = min($quota->percentage, 100);
        @endphp
        <div class="quota-modern-card">
            <div class="quota-card-header">
                <h6 class="quota-card-title">{{ $quota->major }}</h6>
                <button type="button" class="quota-edit-btn" 
                        data-bs-toggle="modal" 
                        data-bs-target="#editQuotaModal"
                        data-major="{{ $quota->major }}"
                        data-quota="{{ $quota->quota }}"
                        data-used="{{ $quota->used_quota }}"
                        title="Edit Kuota {{ $quota->major }}">
                    <i class="fas fa-pencil-alt"></i>
                </button>
            </div>
            
            <div class="quota-card-metric">
                <div class="quota-metric-sisa">{{ $quota->available_quota }} Kursi</div>
                <div class="quota-metric-desc">Sisa kapasitas saat ini</div>
            </div>

            <div class="quota-progress-container">
                <div class="quota-progress-label">
                    <span>Terisi: {{ $quota->used_quota }}</span>
                    <span>{{ round($quota->percentage) }}%</span>
                </div>
                <div class="quota-progress-bar-wrap">
                    <div class="quota-progress-fill {{ $status }}" style="width: {{ $percent }}%"></div>
                </div>
            </div>

            <div class="quota-card-footer">
                <span class="text-small text-muted fw-bold">Kapasitas: {{ $quota->quota }}</span>
                <span class="quota-pill {{ $status }}">
                    @if($status === 'full')
                        Penuh
                    @elseif($status === 'low')
                        Sisa Sedikit
                    @else
                        Tersedia
                    @endif
                </span>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Statistik Verifikasi per Jurusan -->
    <div class="section-card">
        <div class="section-header">
            <h5><i class="fas fa-chart-pie"></i>Statistik Verifikasi per Jurusan</h5>
            <span class="section-badge">Real-time</span>
        </div>
        <div class="section-body">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Jurusan</th>
                            <th class="text-end">Pendaftar</th>
                            <th class="text-end">✅ Verified</th>
                            <th class="text-end">⏳ Pending</th>
                            <th class="text-end">❌ Rejected</th>
                            <th>Verifikasi Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($majorStats as $stat)
                        <tr>
                            <td class="fw-semibold">{{ $stat['major'] }}</td>
                            <td class="text-end fw-medium">
                                {{ number_format($stat['total_count']) }}
                                <small class="text-muted d-block">/ {{ $stat['quota'] }}</small>
                            </td>
                            <td class="text-end"><span class="quota-badge available">{{ $stat['verified_count'] }}</span></td>
                            <td class="text-end"><span class="quota-badge low">{{ $stat['pending_count'] }}</span></td>
                            <td class="text-end"><span class="quota-badge full">{{ $stat['rejected_count'] }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress-bar">
                                        <div class="progress-fill available"
                                             style="width: {{ $stat['verification_rate'] }}%"></div>
                                    </div>
                                    <span class="fw-semibold">{{ round($stat['verification_rate'], 1) }}%</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary Cards -->
            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-value success">{{ number_format($majorStats->sum('verified_count')) }}</div>
                    <div class="summary-label">Total Terverifikasi</div>
                </div>
                <div class="summary-card">
                    <div class="summary-value warning">{{ number_format($majorStats->sum('pending_count')) }}</div>
                    <div class="summary-label">Menunggu Verifikasi</div>
                </div>
                <div class="summary-card">
                    <div class="summary-value primary">
                        {{ $majorStats->avg('verification_rate') > 0 ? round($majorStats->avg('verification_rate'), 1) : 0 }}%
                    </div>
                    <div class="summary-label">Rata-rata Verifikasi</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Audit Log / Log Aktivitas Admin -->
    <div class="timeline-card">
        <div class="timeline-header">
            <h5><i class="fas fa-history me-1"></i>Log Aktivitas Admin Terbaru</h5>
            <span class="badge bg-secondary">Real-time</span>
        </div>
        <div class="timeline-body">
            @if(isset($auditLogs) && $auditLogs->count() > 0)
                <div class="timeline-list">
                    @foreach($auditLogs as $log)
                        @php
                            $badgeClass = 'update';
                            if (str_contains($log->event, 'verified')) $badgeClass = 'verify';
                            elseif (str_contains($log->event, 'rejected') || str_contains($log->event, 'deleted')) $badgeClass = 'reject';
                            elseif (str_contains($log->event, 'quota_updated')) $badgeClass = 'quota';
                        @endphp
                        <div class="timeline-item">
                            <span class="timeline-badge {{ $badgeClass }}"></span>
                            <div class="timeline-content-box">
                                <div class="timeline-meta">
                                    <span class="timeline-user">
                                        <i class="fas fa-user-shield"></i> {{ $log->user_name ?: 'System' }} 
                                        <small class="text-muted">({{ $log->user_role ?: 'User' }})</small>
                                    </span>
                                    <span class="timeline-date">
                                        {{ $log->occurred_at?->timezone('Asia/Jakarta')->format('d M Y - H:i') }} WIB
                                    </span>
                                </div>
                                <h6 class="timeline-title">{{ $log->description }}</h6>
                                @if($log->subject_label)
                                    <p class="timeline-desc"><strong>Subjek:</strong> {{ $log->subject_label }}</p>
                                @endif
                                @if($log->properties)
                                    <div class="timeline-properties">
                                        @foreach($log->properties as $key => $val)
                                            <div><strong>{{ $key }}:</strong> {{ is_array($val) ? json_encode($val) : $val }}</div>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="timeline-footer-meta">
                                    <span>IP: {{ $log->ip_address ?: 'local' }}</span>
                                    @if($log->user_agent)
                                        <span class="text-truncate d-inline-block" style="max-width: 320px;" title="{{ $log->user_agent }}">UA: {{ $log->user_agent }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($auditLogs->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $auditLogs->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                <div class="timeline-empty">
                    <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                    <p class="mb-0 text-muted">Belum ada aktivitas admin yang tercatat untuk panel ini.</p>
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Search & Filter -->
    @if($showApplicants)
    <div class="section-card">
        <div class="section-header">
            <h5><i class="fas fa-search"></i>Cari Pendaftar</h5>
            <button type="button" class="qr-scan-btn" data-bs-toggle="modal" data-bs-target="#qrScannerModal">
                <i class="fas fa-qrcode"></i> Scan QR
            </button>
        </div>
        <div class="section-body">
            <div class="search-bar">
                <form action="{{ route('admin.search') }}" method="GET" class="search-form" id="searchForm">
                    <input type="text" name="registration_number" id="searchRegNumber" class="search-input"
                           placeholder="No. Pendaftaran" value="{{ request('registration_number') }}">
                    <input type="text" name="nik" class="search-input" placeholder="NIK Siswa" value="{{ request('nik') }}">
                    <input type="text" name="full_name" class="search-input" placeholder="Nama Lengkap" value="{{ request('full_name') }}">
                    <select name="major" class="search-select">
                        <option value="">Semua Jurusan</option>
                        @foreach($quotas as $quota)
                            <option value="{{ $quota->major }}" {{ request('major') == $quota->major ? 'selected' : '' }}>
                                {{ $quota->major }}
                            </option>
                        @endforeach
                    </select>
                    <select name="status" class="search-select">
                        <option value="">Semua Status</option>
                        <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                        <option value="verified"  {{ request('status') == 'verified'  ? 'selected' : '' }}>Verified</option>
                        <option value="rejected"  {{ request('status') == 'rejected'  ? 'selected' : '' }}>Rejected</option>
                    </select>
                </form>
                <button type="submit" form="searchForm" class="search-btn">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </div>
    </div>

    <!-- Statistik Gender -->
<div class="section-card">
    <div class="section-header">
        <h5><i class="fas fa-venus-mars"></i>Statistik Pendaftar Berdasarkan Gender</h5>
        <span class="section-badge">Real-time</span>
    </div>
    <div class="section-body">
        @php
            // ✅ Gunakan case yang sesuai dengan validasi: 'Laki-laki' & 'Perempuan'
            $laki = $genderStats->firstWhere('gender', 'Laki-laki');
            $perempuan = $genderStats->firstWhere('gender', 'Perempuan');

            $lakiTotal = $laki?->total ?? 0;
            $lakiVerified = $laki?->verified ?? 0;
            $lakiPending = $laki?->pending ?? 0;

            $perempuanTotal = $perempuan?->total ?? 0;
            $perempuanVerified = $perempuan?->verified ?? 0;
            $perempuanPending = $perempuan?->pending ?? 0;

            $grandTotal = $lakiTotal + $perempuanTotal;
            $grandVerified = $lakiVerified + $perempuanVerified;
            $grandPending = $lakiPending + $perempuanPending;
            $verificationRate = $grandTotal > 0 ? round(($grandVerified / $grandTotal) * 100, 1) : 0;
        @endphp

        <div class="stats-grid">
            <!-- Laki-laki: Total -->
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-male"></i></div>
                <div class="stat-content">
                    <div class="stat-label">Total Laki-laki</div>
                    <div class="stat-value">{{ number_format($lakiTotal) }}</div>
                </div>
            </div>

            <!-- Laki-laki: Terverifikasi -->
            <div class="stat-card">
                <div class="stat-icon success"><i class="fas fa-check"></i></div>
                <div class="stat-content">
                    <div class="stat-label">Laki-laki Terverifikasi</div>
                    <div class="stat-value">{{ number_format($lakiVerified) }}</div>
                </div>
            </div>

            <!-- Laki-laki: Pending -->
            <div class="stat-card">
                <div class="stat-icon warning"><i class="fas fa-clock"></i></div>
                <div class="stat-content">
                    <div class="stat-label">Laki-laki Menunggu</div>
                    <div class="stat-value">{{ number_format($lakiPending) }}</div>
                </div>
            </div>

            <!-- Perempuan: Total -->
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-female"></i></div>
                <div class="stat-content">
                    <div class="stat-label">Total Perempuan</div>
                    <div class="stat-value">{{ number_format($perempuanTotal) }}</div>
                </div>
            </div>

            <!-- Perempuan: Terverifikasi -->
            <div class="stat-card">
                <div class="stat-icon success"><i class="fas fa-check"></i></div>
                <div class="stat-content">
                    <div class="stat-label">Perempuan Terverifikasi</div>
                    <div class="stat-value">{{ number_format($perempuanVerified) }}</div>
                </div>
            </div>

            <!-- Perempuan: Pending -->
            <div class="stat-card">
                <div class="stat-icon warning"><i class="fas fa-clock"></i></div>
                <div class="stat-content">
                    <div class="stat-label">Perempuan Menunggu</div>
                    <div class="stat-value">{{ number_format($perempuanPending) }}</div>
                </div>
            </div>
        </div>

        <!-- Ringkasan -->
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-value primary">{{ number_format($grandTotal) }}</div>
                <div class="summary-label">Total Keseluruhan</div>
            </div>
            <div class="summary-card">
                <div class="summary-value success">{{ number_format($grandVerified) }}</div>
                <div class="summary-label">Total Terverifikasi</div>
            </div>
            <div class="summary-card">
                <div class="summary-value warning">{{ number_format($grandPending) }}</div>
                <div class="summary-label">Total Menunggu</div>
            </div>
            <div class="summary-card">
                <div class="summary-value">{{ $verificationRate }}%</div>
                <div class="summary-label">Rate Verifikasi</div>
            </div>
        </div>
    </div>
</div>

    <!-- Data Table -->
    <div class="section-card" id="data-pendaftar">
        <div class="section-header">
            <h5><i class="fas fa-table"></i>Data Pendaftar</h5>
        </div>

        <div class="action-bar">
            <a href="{{ route('admin.export.excel') }}" class="action-btn export">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <button class="action-btn print" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>

        <div class="section-body p-0">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama Lengkap</th>
                            <th>NIK</th>
                            <th>Jurusan</th>
                            <th>No. HP</th>
                            <th>Waktu Daftar</th>
                            <th>Status</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applicants as $index => $applicant)
                        <tr>
                            <td>{{ $applicants->firstItem() + $index }}</td>
                            <td><span class="reg-number">{{ $applicant->registration_number }}</span></td>
                            <td class="fw-medium">{{ $applicant->full_name }}</td>
                            <td>{{ $applicant->nik }}</td>
                            <td>{{ $applicant->major_choice }}</td>
                            <td>{{ $applicant->phone }}</td>
                            <td>
                                <strong>{{ $applicant->registered_date_label }}</strong>
                                <div class="text-muted small">{{ $applicant->registered_time_label }}</div>
                            </td>
                            <td>
                                <span class="status-badge {{ $applicant->status }}">
                                    <i class="fas fa-{{ $applicant->status == 'pending' ? 'clock' : ($applicant->status == 'verified' ? 'check' : 'times') }}"></i>
                                    {{ ucfirst($applicant->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="row-actions">
                                    @php 
                                        $waPhone = preg_replace('/^08/', '628', preg_replace('/[^0-9]/', '', $applicant->phone)); 
                                    @endphp
                                    <a href="https://wa.me/{{ $waPhone }}" target="_blank" class="action-icon-btn" style="background: #25D366; color: white;" title="Hubungi via WA">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="{{ route('admin.documents', $applicant->id) }}" class="action-icon-btn view" title="Lihat Berkas">
                                        <i class="fas fa-folder"></i>
                                    </a>
                                    <a href="{{ route('admin.print', $applicant->id) }}" class="action-icon-btn detail" title="Detail" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.edit', $applicant->id) }}" class="action-icon-btn edit" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.delete', $applicant->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus data ini secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-icon-btn delete" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.status.update', $applicant->id) }}" method="POST" class="status-update-inline"
                                          onsubmit="return confirm('Ubah status pendaftar ini?\\n\\nJika status masuk atau keluar dari verified, kuota jurusan akan disesuaikan otomatis.')">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="note" value="Diubah melalui tabel data pendaftar admin SMKS.">
                                        <select name="status" aria-label="Ubah status {{ $applicant->full_name }}">
                                            <option value="pending" {{ $applicant->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="verified" {{ $applicant->status === 'verified' ? 'selected' : '' }}>Verified</option>
                                            <option value="rejected" {{ $applicant->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                        <button type="submit" class="action-icon-btn status-save" title="Simpan Status">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>Tidak ada data pendaftar</p>
                                    <small>Silakan gunakan filter atau tambah data baru</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($applicants->hasPages())
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Menampilkan {{ $applicants->firstItem() ?? 0 }} – {{ $applicants->lastItem() ?? 0 }}
                dari {{ $applicants->total() }} data
            </div>
            <nav>
                <ul class="pagination">
                    @if($applicants->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">← Prev</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $applicants->previousPageUrl() }}">← Prev</a></li>
                    @endif

                    @foreach($applicants->getUrlRange(1, $applicants->lastPage()) as $page => $url)
                        @if($page == $applicants->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    @if($applicants->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $applicants->nextPageUrl() }}">Next →</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next →</span></li>
                    @endif
                </ul>
            </nav>
        </div>
        @endif
    </div>

    @endif

    @if($showGuide)
        @include('admin.partials.guide-smk')
    @endif
</div>

<!-- QR Scanner Modal -->
@if($showApplicants)
<div class="modal fade qr-modal" id="qrScannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-qrcode"></i> Scan QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="qr-instruction">📷 Arahkan kamera ke QR Code pada bukti pendaftaran</p>
                <div id="qr-reader"></div>
                <div class="qr-manual">
                    <p class="text-small text-muted mb-2">Atau input manual:</p>
                    <div class="input-group">
                        <input type="text" id="manualRegNumber" class="form-control" placeholder="YP-2026-XXX">
                        <button type="button" class="btn" onclick="searchByManualInput()">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
                <div id="qrStatus" class="qr-status info d-none">
                    <i class="fas fa-spinner fa-spin"></i>
                    <span id="qrStatusText">Mendeteksi...</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal Edit Kuota (SMK) -->
<div class="modal fade" id="editQuotaModal" tabindex="-1" aria-labelledby="editQuotaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 18px; overflow: hidden; border: 1px solid var(--line); box-shadow: var(--shadow-lg);">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--brand-800), var(--brand)); color: white; border-bottom: 0;">
                <h5 class="modal-title" id="editQuotaModalLabel" style="font-family: var(--ff-display); font-weight: 900;">
                    <i class="fas fa-edit me-1"></i> Edit Kuota Jurusan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.quotas.update') }}" method="POST" id="editQuotaForm">
                @csrf
                @method('PATCH')
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 0.85rem; font-weight: 900; color: var(--muted);">JURUSAN</label>
                        <input type="text" class="form-control" id="modalQuotaMajor" name="major" readonly 
                               style="background-color: var(--ivory-dark); border-radius: 10px; font-weight: 800; color: var(--brand-800);">
                    </div>
                    <div class="mb-3">
                        <label for="modalQuotaInput" class="form-label" style="font-size: 0.85rem; font-weight: 900; color: var(--muted);">JUMLAH KUOTA BARU</label>
                        <input type="number" class="form-control" id="modalQuotaInput" name="quota" required min="0"
                               style="border-radius: 10px; padding: 0.6rem; border: 1px solid var(--line);">
                        <div class="form-text text-muted" id="modalQuotaHelp" style="font-size: 0.78rem; font-weight: 700; margin-top: 0.25rem;">
                            Kuota saat ini digunakan: <span id="modalQuotaUsed" class="badge bg-secondary">0</span>
                        </div>
                    </div>
                    <div class="alert alert-warning" style="border-radius: 12px; font-size: 0.82rem; font-weight: 700; display: flex; align-items: start; gap: 0.5rem; border: 1px solid #fef3c7; background: #fffbeb; color: #92400e;">
                        <i class="fas fa-exclamation-triangle mt-1"></i>
                        <span>Catatan: Segala perubahan kuota akan dicatat di log aktivitas admin PPDB. Pastikan jumlah kuota baru tidak lebih kecil dari kuota yang sudah terpakai.</span>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fbfa; border-top: 1px solid var(--line); padding: 1rem 1.5rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" 
                            style="border-radius: 10px; font-weight: 800; padding: 0.55rem 1rem;">Batal</button>
                    <button type="submit" class="btn btn-primary" 
                            style="background: linear-gradient(135deg, var(--brand), var(--brand-800)); border: 0; border-radius: 10px; font-weight: 800; padding: 0.55rem 1.25rem; color: white;">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
let html5QrCode;

function startQrScanner() {
    if (typeof Html5Qrcode === 'undefined') {
        showQrStatus("Scanner QR belum tersedia. Gunakan input manual.", "warning");
        return;
    }

    html5QrCode = new Html5Qrcode("qr-reader");
    const config = { fps: 10, qrbox: { width: 250, height: 250 } };

    if (typeof Html5Qrcode.getCameras === 'function') {
        Html5Qrcode.getCameras()
            .then(cameras => {
                if (cameras?.length) {
                    html5QrCode.start(cameras[0].id, config, onScanSuccess, onScanFailure)
                        .catch(err => showQrStatus("Kamera error: " + err.message, "danger"));
                } else {
                    showQrStatus("⚠️ Kamera tidak ditemukan. Gunakan input manual.", "warning");
                }
            })
            .catch(() =>
                html5QrCode.start({ facingMode: "user" }, config, onScanSuccess, onScanFailure)
                    .catch(() => showQrStatus("⚠️ Akses kamera ditolak. Gunakan input manual.", "warning"))
            );
    }
}

function onScanSuccess(decodedText) {
    html5QrCode?.stop();
    showQrStatus(`✅ Terdeteksi: ${decodedText}`, "success");
    searchByRegistrationNumber(decodedText);
    setTimeout(() => {
        bootstrap.Modal.getInstance(document.getElementById('qrScannerModal'))?.hide();
        resetQrScanner();
    }, 1200);
}

function onScanFailure() { /* Silent */ }

function searchByRegistrationNumber(reg) {
    const input = document.getElementById('searchRegNumber');
    if (input) input.value = reg.trim().toUpperCase();
    document.getElementById('searchForm')?.submit();
}

function searchByManualInput() {
    const val = document.getElementById('manualRegNumber')?.value.trim();
    if (val) searchByRegistrationNumber(val);
    else showQrStatus("⚠️ Masukkan nomor pendaftaran", "warning");
}

function showQrStatus(msg, type) {
    const el  = document.getElementById('qrStatus');
    const txt = document.getElementById('qrStatusText');
    if (el && txt) {
        el.className = `qr-status ${type}`;
        el.classList.remove('d-none');
        txt.textContent = msg;
    }
}

function resetQrScanner() {
    html5QrCode?.stop().catch(() => {});
    html5QrCode?.clear();
    document.getElementById('qrStatus')?.classList.add('d-none');
    const manual = document.getElementById('manualRegNumber');
    if (manual) manual.value = '';
}

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('qrScannerModal');
    modal?.addEventListener('shown.bs.modal', () => {
        navigator.permissions?.query({ name: 'camera' })
            .then(p => (p.state === 'granted' || p.state === 'prompt')
                ? startQrScanner()
                : showQrStatus("❌ Izinkan akses kamera", "danger"))
            .catch(startQrScanner);
    });
    modal?.addEventListener('hidden.bs.modal', resetQrScanner);

    document.getElementById('manualRegNumber')?.addEventListener('keypress', e => {
        if (e.key === 'Enter') { e.preventDefault(); searchByManualInput(); }
    });

    const editQuotaModal = document.getElementById('editQuotaModal');
    if (editQuotaModal) {
        editQuotaModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;
            const major = button.getAttribute('data-major');
            const quota = button.getAttribute('data-quota');
            const used = button.getAttribute('data-used');

            const modalMajor = editQuotaModal.querySelector('#modalQuotaMajor');
            const modalInput = editQuotaModal.querySelector('#modalQuotaInput');
            const modalUsed = editQuotaModal.querySelector('#modalQuotaUsed');

            if (modalMajor) modalMajor.value = major;
            if (modalInput) {
                modalInput.value = quota;
                modalInput.min = used;
            }
            if (modalUsed) modalUsed.textContent = used;
        });
    }
});
</script>
@endpush
