@extends('layouts.app')

@section('admin_shell', 'true')

@php
    $isFinancePanel = request()->routeIs('admin.finance.*');
    $isOperationsPanel = request()->routeIs('admin.operations.*');
    $isSmpPanel = request()->routeIs('admin.smp.*');
    $panelLabel = $isOperationsPanel ? 'Operasional' : ($isFinancePanel ? 'Keuangan' : ($isSmpPanel ? 'Admin SMPS' : 'Admin SMKS'));
    $panelIcon = $isOperationsPanel ? 'fa-building-columns' : ($isFinancePanel ? 'fa-wallet' : ($isSmpPanel ? 'fa-school' : 'fa-industry'));
    $dashboardRoute = $isOperationsPanel ? 'admin.operations.dashboard' : ($isFinancePanel ? 'admin.finance.dashboard' : ($isSmpPanel ? 'admin.smp.dashboard' : 'admin.dashboard'));
    $exportRoute = $isOperationsPanel ? null : ($isSmpPanel ? 'admin.smp.export.excel' : 'admin.export.excel');
    $panelUser = $isOperationsPanel
        ? auth('operations')->user()
        : ($isFinancePanel ? auth('finance')->user() : ($isSmpPanel ? auth('admin_smp')->user() : auth('admin_smk')->user()));
    $panelUser = $panelUser ?: auth()->user();
    $logoutRoute = $isOperationsPanel ? 'admin.operations.logout' : ($isFinancePanel ? 'admin.finance.logout' : ($isSmpPanel ? 'admin.smp.logout' : 'admin.logout'));
    $dashboardUrl = route($dashboardRoute);
    $analyticsRoute = $isSmpPanel ? 'admin.smp.analytics' : 'admin.analytics';
    $quotasRoute = $isSmpPanel ? 'admin.smp.quotas' : 'admin.quotas';
    $applicantsRoute = $isSmpPanel ? 'admin.smp.applicants' : 'admin.applicants';
@endphp

@push('styles')
<style>
body.has-admin-sidebar {
    background:
        radial-gradient(circle at 92% 0%, rgba(31, 154, 165, 0.12), transparent 28rem),
        linear-gradient(180deg, #f8fbfa 0%, #eef5f2 48%, #ffffff 100%) !important;
}

body.has-admin-sidebar main {
    min-height: 100vh !important;
    padding: 0 !important;
}

body.has-admin-sidebar .back-to-top {
    display: none !important;
}

.admin-shell {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 288px minmax(0, 1fr);
    color: var(--text);
}

.admin-sidebar {
    position: sticky;
    top: 0;
    height: 100vh;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    padding: 1.25rem;
    background:
        radial-gradient(circle at 20% 0%, rgba(201, 168, 76, 0.18), transparent 15rem),
        linear-gradient(180deg, var(--brand-800), #06241e 100%);
    color: white;
    border-right: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 20px 0 60px rgba(8, 50, 41, 0.14);
    z-index: 5;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.18) transparent;
}

.admin-sidebar::-webkit-scrollbar {
    width: 6px;
}

.admin-sidebar::-webkit-scrollbar-track {
    background: transparent;
}

.admin-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.18);
    border-radius: 999px;
}

.admin-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
}

.admin-brand {
    display: grid;
    grid-template-columns: 48px 1fr;
    align-items: center;
    gap: 0.8rem;
    color: white;
    text-decoration: none;
    padding: 0.35rem;
}

.admin-brand-logo {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: white;
    display: grid;
    place-items: center;
    overflow: hidden;
}

.admin-brand-logo img {
    width: 38px;
    height: 38px;
    object-fit: contain;
}

.admin-brand-title {
    display: grid;
    line-height: 1.1;
}

.admin-brand-title strong {
    font-family: var(--ff-display);
    font-size: 1.08rem;
    font-weight: 900;
}

.admin-brand-title span {
    margin-top: 0.2rem;
    color: rgba(255, 255, 255, 0.62);
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.admin-panel-card {
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 16px;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.08);
}

.admin-panel-card small {
    color: rgba(255, 255, 255, 0.62);
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.admin-panel-name {
    display: flex;
    align-items: center;
    gap: 0.55rem;
    margin-top: 0.35rem;
    font-family: var(--ff-display);
    font-size: 1.08rem;
    font-weight: 900;
}

.admin-nav {
    display: grid;
    gap: 0.35rem;
}

.admin-nav-label {
    margin: 0.3rem 0 0.15rem;
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.7rem;
    font-weight: 900;
    letter-spacing: 0.1em;
    text-transform: uppercase;
}

.admin-nav-link {
    min-height: 44px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.72rem 0.85rem;
    border-radius: 12px;
    color: rgba(255, 255, 255, 0.78);
    text-decoration: none;
    font-weight: 800;
    transition: background 180ms ease, color 180ms ease, transform 180ms ease;
}

button.admin-nav-link {
    width: 100%;
    border: 0;
    background: transparent;
    text-align: left;
    cursor: pointer;
}

.admin-nav-link i {
    width: 1.1rem;
    color: var(--gold-light, #e8c97a);
    text-align: center;
}

.admin-nav-link:hover,
.admin-nav-link.active {
    color: white;
    background: rgba(255, 255, 255, 0.12);
    transform: translateX(2px);
}

.admin-sidebar-footer {
    margin-top: auto;
    display: grid;
    gap: 0.75rem;
}

.admin-user-card {
    display: grid;
    grid-template-columns: 38px 1fr;
    gap: 0.7rem;
    align-items: center;
    padding: 0.75rem;
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.08);
}

.admin-user-avatar {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    display: grid;
    place-items: center;
    background: rgba(201, 168, 76, 0.22);
    color: var(--gold-light, #e8c97a);
}

.admin-user-copy {
    min-width: 0;
    display: grid;
    line-height: 1.2;
}

.admin-user-copy strong,
.admin-user-copy span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.admin-user-copy strong {
    color: white;
    font-size: 0.9rem;
    font-weight: 900;
}

.admin-user-copy span {
    color: rgba(255, 255, 255, 0.58);
    font-size: 0.74rem;
    font-weight: 700;
}

.admin-logout {
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.55rem;
    border-radius: 12px;
    background: #fee2e2;
    color: #991b1b;
    text-decoration: none;
    font-weight: 900;
}

.admin-main {
    min-width: 0;
    padding: clamp(1rem, 2vw, 1.6rem);
}

.admin-topbar {
    display: none;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1rem;
    padding: 0.9rem 1rem;
    border: 1px solid var(--line);
    border-radius: 16px;
    background: white;
    box-shadow: var(--shadow-sm);
}

.admin-menu-button,
.admin-sidebar-close {
    width: 40px;
    height: 40px;
    border: 0;
    border-radius: 10px;
    display: none;
    place-items: center;
    background: var(--mint);
    color: var(--brand);
}

.admin-topbar-title {
    display: flex;
    align-items: center;
    gap: 0.7rem;
    color: var(--brand-800);
    font-weight: 900;
}

.admin-topbar-actions {
    display: flex;
    gap: 0.5rem;
}

.admin-topbar-actions a {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: grid;
    place-items: center;
    color: var(--brand);
    background: var(--mint);
    text-decoration: none;
}

.admin-topbar-actions button {
    width: 40px;
    height: 40px;
    border: 0;
    border-radius: 10px;
    display: grid;
    place-items: center;
    color: var(--brand);
    background: var(--mint);
}

.admin-sidebar-overlay {
    display: none;
}

body.has-admin-sidebar .section-card,
body.has-admin-sidebar .finance-panel,
body.has-admin-sidebar .card {
    border-radius: 14px !important;
}

body.has-admin-sidebar .section-header,
body.has-admin-sidebar .finance-panel-header,
body.has-admin-sidebar .card-header {
    min-height: 58px;
}

body.has-admin-sidebar .table-container,
body.has-admin-sidebar .table-responsive,
body.has-admin-sidebar .finance-table-wrap {
    border-radius: 0 0 14px 14px;
    scrollbar-width: thin;
}

body.has-admin-sidebar .data-table thead th,
body.has-admin-sidebar .table thead th,
body.has-admin-sidebar .finance-table thead th,
body.has-admin-sidebar .finance-table th {
    position: sticky;
    top: 0;
    z-index: 2;
}

body.has-admin-sidebar .row-actions,
body.has-admin-sidebar .admin-row-actions,
body.has-admin-sidebar td form,
body.has-admin-sidebar .table td form {
    display: inline-flex;
    align-items: center;
    gap: 0.28rem;
    margin: 0;
}

body.has-admin-sidebar .row-actions,
body.has-admin-sidebar .admin-row-actions {
    flex-wrap: wrap;
}

body.has-admin-sidebar .btn-action,
body.has-admin-sidebar .action-icon-btn {
    flex: 0 0 auto;
}

body.has-admin-sidebar .search-bar,
body.has-admin-sidebar .action-bar,
body.has-admin-sidebar .finance-date-form {
    row-gap: 0.65rem;
}

body.has-admin-sidebar .search-form {
    align-items: end;
}

body.has-admin-sidebar .dashboard-wrapper,
body.has-admin-sidebar .container-fluid {
    width: 100% !important;
    max-width: none !important;
    margin: 0 !important;
    padding: 0 !important;
}

body.has-admin-sidebar .dashboard-header,
body.has-admin-sidebar .card.bg-primary {
    margin-bottom: 1.25rem !important;
}

.admin-activity-panel {
    display: grid;
    grid-template-columns: minmax(280px, 0.92fr) minmax(0, 1.35fr);
    gap: 1rem;
    margin-top: 1rem;
}

.admin-activity-card {
    min-width: 0;
    border: 1px solid var(--line);
    border-radius: 16px;
    background: #ffffff;
    box-shadow: var(--shadow-sm);
}

.admin-activity-card-head {
    display: grid;
    grid-template-columns: 44px 1fr;
    gap: 0.75rem;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid var(--line);
    background: linear-gradient(180deg, #ffffff, #f8fbfa);
}

.admin-activity-head-icon {
    width: 44px;
    height: 44px;
    display: grid;
    place-items: center;
    border-radius: 13px;
    background: var(--mint);
    color: var(--brand);
}

.admin-activity-card-head h3 {
    margin: 0;
    color: var(--brand-800);
    font-family: var(--ff-display);
    font-size: 1.08rem;
    font-weight: 900;
}

.admin-activity-card-head p {
    margin: 0.15rem 0 0;
    color: var(--muted);
    font-size: 0.84rem;
    font-weight: 700;
}

.admin-activity-form {
    display: grid;
    gap: 0.85rem;
    padding: 1rem;
}

.admin-activity-field {
    display: grid;
    gap: 0.35rem;
}

.admin-activity-field label {
    color: var(--text);
    font-size: 0.8rem;
    font-weight: 900;
}

.admin-activity-field select,
.admin-activity-field textarea,
.admin-activity-field input {
    width: 100%;
    border: 1px solid var(--line);
    border-radius: 11px;
    background: #ffffff;
    color: var(--text);
    font: inherit;
}

.admin-activity-field select,
.admin-activity-field input {
    min-height: 42px;
    padding: 0 0.75rem;
}

.admin-activity-field textarea {
    resize: vertical;
    min-height: 116px;
    padding: 0.75rem;
}

.admin-activity-field :is(select, textarea, input):focus {
    border-color: rgba(16, 92, 75, 0.42);
    box-shadow: 0 0 0 0.22rem rgba(16, 92, 75, 0.12);
    outline: none;
}

.admin-activity-inline {
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto;
    gap: 0.75rem;
    align-items: end;
}

.admin-activity-check {
    min-height: 42px;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
    padding: 0 0.75rem;
    border: 1px solid var(--line);
    border-radius: 11px;
    background: #f8fbfa;
    color: var(--text);
    font-size: 0.84rem;
    font-weight: 900;
    white-space: nowrap;
}

.admin-activity-submit {
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    border: 0;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--brand), var(--brand-800));
    color: #ffffff;
    font-weight: 900;
}

.admin-activity-error {
    color: #b91c1c;
    font-weight: 800;
}

.admin-activity-list {
    max-height: 520px;
    overflow: auto;
    padding: 1rem;
    scrollbar-width: thin;
}

.admin-activity-item {
    position: relative;
    display: grid;
    grid-template-columns: 38px 1fr;
    gap: 0.75rem;
    padding: 0.85rem;
    border: 1px solid var(--line);
    border-radius: 14px;
    background: #ffffff;
}

.admin-activity-item + .admin-activity-item {
    margin-top: 0.75rem;
}

.admin-activity-item.is-pinned {
    border-color: rgba(201, 168, 76, 0.5);
    background: linear-gradient(180deg, #fffdf5, #ffffff);
}

.admin-activity-dot {
    width: 38px;
    height: 38px;
    display: grid;
    place-items: center;
    border-radius: 12px;
    background: var(--mint);
    color: var(--brand);
}

.admin-activity-content {
    min-width: 0;
}

.admin-activity-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.45rem;
}

.admin-activity-badge,
.admin-activity-pin {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    min-height: 24px;
    padding: 0 0.55rem;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 900;
}

.admin-activity-badge {
    background: var(--mint);
    color: var(--brand-800);
}

.admin-activity-pin {
    background: #fef3c7;
    color: #92400e;
}

.admin-activity-meta time {
    color: var(--muted);
    font-size: 0.75rem;
    font-weight: 800;
}

.admin-activity-content h4 {
    margin: 0.45rem 0 0.2rem;
    color: var(--text);
    font-size: 0.95rem;
    font-weight: 900;
}

.admin-activity-content p {
    margin: 0;
    color: var(--text-mid, #4b5563);
    font-size: 0.9rem;
    line-height: 1.55;
}

.admin-activity-foot {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-top: 0.65rem;
    color: var(--muted);
    font-size: 0.78rem;
    font-weight: 800;
}

.admin-activity-foot span {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}

.admin-activity-empty {
    min-height: 220px;
    display: grid;
    place-items: center;
    align-content: center;
    gap: 0.35rem;
    border: 1px dashed rgba(16, 92, 75, 0.25);
    border-radius: 14px;
    color: var(--muted);
    text-align: center;
}

.admin-activity-empty i {
    font-size: 1.6rem;
    color: var(--brand);
}

.admin-activity-empty strong {
    color: var(--text);
}

.admin-document-modal {
    position: fixed;
    inset: 0;
    z-index: 2200;
    display: none;
    align-items: center;
    justify-content: center;
    padding: clamp(0.75rem, 2vw, 1.5rem);
}

.admin-document-modal.is-open {
    display: flex;
}

.admin-document-backdrop {
    position: absolute;
    inset: 0;
    border: 0;
    background: rgba(5, 31, 26, 0.68);
    backdrop-filter: blur(4px);
}

.admin-document-dialog {
    position: relative;
    z-index: 1;
    width: min(1120px, 100%);
    height: min(88vh, 820px);
    display: grid;
    grid-template-rows: auto minmax(0, 1fr);
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.24);
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 30px 90px rgba(5, 31, 26, 0.32);
}

.admin-document-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 0.95rem 1rem;
    border-bottom: 1px solid var(--line);
    background:
        linear-gradient(135deg, rgba(16, 92, 75, 0.08), rgba(201, 168, 76, 0.12)),
        #ffffff;
}

.admin-document-kicker {
    display: block;
    color: var(--muted);
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.admin-document-title {
    margin: 0.12rem 0 0;
    color: var(--brand-800);
    font-family: var(--ff-display);
    font-size: clamp(1rem, 1.7vw, 1.35rem);
    font-weight: 900;
}

.admin-document-tools {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.admin-document-link,
.admin-document-close {
    min-height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    border-radius: 11px;
    font-size: 0.85rem;
    font-weight: 900;
    text-decoration: none;
}

.admin-document-link {
    padding: 0 0.85rem;
    border: 1px solid rgba(16, 92, 75, 0.16);
    background: var(--mint);
    color: var(--brand);
}

.admin-document-close {
    width: 40px;
    border: 0;
    background: #fee2e2;
    color: #991b1b;
}

.admin-document-body {
    min-height: 0;
    position: relative;
    display: grid;
    place-items: center;
    overflow: auto;
    padding: 1rem;
    background:
        linear-gradient(45deg, rgba(16, 92, 75, 0.035) 25%, transparent 25%),
        linear-gradient(-45deg, rgba(16, 92, 75, 0.035) 25%, transparent 25%),
        linear-gradient(45deg, transparent 75%, rgba(16, 92, 75, 0.035) 75%),
        linear-gradient(-45deg, transparent 75%, rgba(16, 92, 75, 0.035) 75%);
    background-color: #f8fbfa;
    background-position: 0 0, 0 10px, 10px -10px, -10px 0;
    background-size: 20px 20px;
}

.admin-document-frame,
.admin-document-image {
    display: none;
    border: 0;
}

.admin-document-frame {
    width: 100%;
    height: 100%;
    min-height: 560px;
    border-radius: 12px;
    background: #ffffff;
}

.admin-document-image {
    width: auto;
    height: auto;
    max-width: 100%;
    max-height: min(680px, calc(88vh - 7.5rem));
    object-fit: contain;
    border-radius: 12px;
    box-shadow: 0 20px 55px rgba(5, 31, 26, 0.18);
    background: white;
}

.admin-document-frame.is-active,
.admin-document-image.is-active {
    display: block;
}

.admin-document-fallback {
    display: none;
    max-width: 440px;
    margin: 1rem;
    padding: 1.2rem;
    border: 1px dashed rgba(16, 92, 75, 0.25);
    border-radius: 14px;
    background: white;
    color: var(--text-mid);
    text-align: center;
    font-weight: 700;
}

.admin-document-fallback.is-active {
    display: block;
}

body.admin-document-open {
    overflow: hidden;
}

.admin-print-source {
    position: relative;
}

.admin-print-button {
    position: absolute;
    top: 0.72rem;
    right: 0.72rem;
    z-index: 8;
    min-height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
    border: 1px solid rgba(15, 95, 74, 0.16);
    border-radius: 999px;
    padding: 0.36rem 0.7rem;
    background: rgba(255, 255, 255, 0.94);
    color: var(--brand);
    box-shadow: 0 8px 22px rgba(20, 32, 29, 0.08);
    font-size: 0.74rem;
    font-weight: 900;
}

.admin-print-source > .section-header,
.admin-print-source > .finance-panel-header,
.admin-print-source > .info-card-header,
.admin-print-source > .card-header {
    padding-right: 6.5rem !important;
}


.admin-print-button:hover {
    background: var(--mint);
}

#adminPrintRoot {
    display: none;
}

@media print {
    @page {
        size: A4 landscape;
        margin: 10mm;
    }

    body.has-admin-sidebar {
        background: #ffffff !important;
    }

    body.admin-printing-section .admin-shell,
    body.admin-printing-section .admin-document-modal,
    body.admin-printing-section .back-to-top {
        display: none !important;
    }

    body.admin-printing-section #adminPrintRoot {
        display: block !important;
    }

    body:not(.admin-printing-section) .admin-sidebar,
    body:not(.admin-printing-section) .admin-sidebar-overlay,
    body:not(.admin-printing-section) .admin-topbar,
    body:not(.admin-printing-section) .admin-print-button,
    body:not(.admin-printing-section) .admin-document-modal,
    body:not(.admin-printing-section) .back-to-top {
        display: none !important;
    }

    body:not(.admin-printing-section) .admin-shell {
        display: block !important;
        min-height: auto !important;
    }

    body:not(.admin-printing-section) .admin-main {
        padding: 0 !important;
    }

    body:not(.admin-printing-section) .section-card,
    body:not(.admin-printing-section) .finance-panel,
    body:not(.admin-printing-section) .card,
    body:not(.admin-printing-section) .info-card,
    body:not(.admin-printing-section) .card-minimal,
    body:not(.admin-printing-section) .chart-card,
    body:not(.admin-printing-section) .heatmap-card,
    body:not(.admin-printing-section) .activity-card,
    body:not(.admin-printing-section) .header-card,
    body:not(.admin-printing-section) .header-minimal,
    body:not(.admin-printing-section) .final-panel,
    body:not(.admin-printing-section) .audit-panel {
        break-inside: avoid;
        box-shadow: none !important;
        border: 1px solid #d1d5db !important;
    }

    #adminPrintRoot .admin-print-document {
        color: #111827;
        font-family: Arial, sans-serif;
    }

    #adminPrintRoot .admin-print-head {
        margin-bottom: 6mm;
    }

    #adminPrintRoot .admin-print-clone,
    #adminPrintRoot .admin-print-clone * {
        box-shadow: none !important;
    }

    #adminPrintRoot .admin-print-clone {
        width: 100% !important;
        overflow: visible !important;
        background: #ffffff !important;
    }

    #adminPrintRoot .table-responsive,
    #adminPrintRoot .table-container,
    #adminPrintRoot .finance-table-wrap,
    #adminPrintRoot .final-table-wrap,
    #adminPrintRoot .audit-table-wrap {
        overflow: visible !important;
    }

    #adminPrintRoot table {
        width: 100% !important;
        border-collapse: collapse !important;
        font-size: 8.5pt !important;
    }

    #adminPrintRoot th,
    #adminPrintRoot td {
        border: 1px solid #d1d5db !important;
        padding: 4px 5px !important;
        color: #111827 !important;
        background: #ffffff !important;
    }

    #adminPrintRoot th {
        background: #eef5f2 !important;
        color: #083229 !important;
    }

    #adminPrintRoot .tab-content {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    #adminPrintRoot .tab-navigation,
    #adminPrintRoot .nav-tabs,
    #adminPrintRoot button,
    #adminPrintRoot .btn,
    #adminPrintRoot .pagination,
    #adminPrintRoot .row-actions,
    #adminPrintRoot .admin-row-actions,
    #adminPrintRoot .action-buttons,
    #adminPrintRoot .doc-actions,
    #adminPrintRoot .action-icon-btn,
    #adminPrintRoot .btn-action,
    #adminPrintRoot .finance-action-link,
    #adminPrintRoot .final-link,
    #adminPrintRoot .admin-print-ignore {
        display: none !important;
    }
}

@media (max-width: 1120px) {
    .admin-shell {
        grid-template-columns: 236px minmax(0, 1fr);
    }

    .admin-sidebar {
        padding: 1rem;
    }
}

@media (max-width: 860px) {
    .admin-shell {
        display: block;
    }

    .admin-sidebar {
        position: fixed;
        inset: 0 auto 0 0;
        width: min(86vw, 318px);
        height: 100vh;
        overflow-y: auto;
        transform: translateX(-104%);
        transition: transform 180ms ease;
        border-right: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 24px 0 58px rgba(8, 50, 41, 0.22);
        z-index: 1060;
    }

    body.admin-sidebar-open .admin-sidebar {
        transform: translateX(0);
    }

    .admin-sidebar-overlay {
        position: fixed;
        inset: 0;
        display: block;
        z-index: 1050;
        background: rgba(6, 31, 26, 0.48);
        opacity: 0;
        pointer-events: none;
        transition: opacity 180ms ease;
    }

    body.admin-sidebar-open .admin-sidebar-overlay {
        opacity: 1;
        pointer-events: auto;
    }

    .admin-sidebar-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        display: grid;
        background: rgba(255, 255, 255, 0.12);
        color: white;
    }

    .admin-topbar {
        display: flex;
        position: sticky;
        top: 0.75rem;
        z-index: 20;
    }

    .admin-menu-button {
        display: grid;
    }

    .admin-activity-panel {
        grid-template-columns: 1fr;
    }

    .admin-activity-inline {
        grid-template-columns: 1fr;
    }

    .admin-activity-check {
        justify-content: center;
        white-space: normal;
    }
}

@media (max-width: 560px) {
    .admin-main {
        padding: 0.85rem;
    }

    .admin-nav {
        grid-template-columns: 1fr;
    }

    .admin-brand {
        grid-template-columns: 42px 1fr;
    }

    .admin-brand-logo {
        width: 42px;
        height: 42px;
    }

    .admin-document-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .admin-document-tools {
        width: 100%;
    }

    .admin-document-link {
        flex: 1;
    }
}
</style>
@endpush

@section('content')
<div class="admin-shell">
    <button class="admin-sidebar-overlay" type="button" data-admin-sidebar-close aria-label="Tutup menu admin"></button>

    <aside class="admin-sidebar" aria-label="Navigasi admin">
        <button class="admin-sidebar-close" type="button" data-admin-sidebar-close aria-label="Tutup menu admin">
            <i class="fas fa-xmark"></i>
        </button>

        <a class="admin-brand" href="{{ $dashboardUrl }}">
            <span class="admin-brand-logo">
                <img src="{{ asset('images/' . ($isSmpPanel ? 'LOGO SMPS YAPISDA.svg' : 'logo-yapisda.svg')) }}" alt="Logo YAPISDA">
            </span>
            <span class="admin-brand-title">
                <strong>YAPISDA</strong>
                <span>Daar El Rohmah</span>
            </span>
        </a>

        <div class="admin-panel-card">
            <small>Panel Aktif</small>
            <div class="admin-panel-name">
                <i class="fas {{ $panelIcon }}"></i>
                <span>{{ $panelLabel }}</span>
            </div>
        </div>

        <nav class="admin-nav">
            @if($isOperationsPanel)
            <div class="admin-nav-label">Operasional</div>
            <a class="admin-nav-link {{ request()->routeIs('admin.operations.dashboard') ? 'active' : '' }}" href="{{ route('admin.operations.dashboard') }}">
                <i class="fas fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.operations.guide') ? 'active' : '' }}" href="{{ route('admin.operations.guide') }}">
                <i class="fas fa-book-open"></i>
                <span>Panduan Alur</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.operations.executive-dashboard') ? 'active' : '' }}" href="{{ route('admin.operations.executive-dashboard') }}">
                <i class="fas fa-chart-pie"></i>
                <span>Dashboard Yayasan</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.operations.active-students') ? 'active' : '' }}" href="{{ route('admin.operations.active-students') }}">
                <i class="fas fa-user-graduate"></i>
                <span>Siswa Aktif</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.operations.uniform-stock') ? 'active' : '' }}" href="{{ route('admin.operations.uniform-stock') }}">
                <i class="fas fa-boxes-stacked"></i>
                <span>Stok Seragam</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.operations.final-checklist') ? 'active' : '' }}" href="{{ route('admin.operations.final-checklist') }}">
                <i class="fas fa-list-check"></i>
                <span>Checklist Final</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.operations.official-exports') ? 'active' : '' }}" href="{{ route('admin.operations.official-exports') }}">
                <i class="fas fa-file-export"></i>
                <span>Export Resmi</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.operations.archive-center') ? 'active' : '' }}" href="{{ route('admin.operations.archive-center') }}">
                <i class="fas fa-folder-open"></i>
                <span>Arsip Dokumen</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.operations.health') ? 'active' : '' }}" href="{{ route('admin.operations.health') }}">
                <i class="fas fa-shield-heart"></i>
                <span>Backup & Health</span>
            </a>

            <div class="admin-nav-label">Aksi</div>
            <button class="admin-nav-link" type="button" data-admin-print-page>
                <i class="fas fa-print"></i>
                <span>Cetak Halaman</span>
            </button>
            <a class="admin-nav-link" href="{{ route('home') }}" target="_blank" rel="noopener">
                <i class="fas fa-globe"></i>
                <span>Lihat Website</span>
            </a>
            @elseif($isFinancePanel)
            <div class="admin-nav-label">Keuangan</div>
            <a class="admin-nav-link {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}" href="{{ $dashboardUrl }}">
                <i class="fas fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.finance.guide') ? 'active' : '' }}" href="{{ route('admin.finance.guide') }}">
                <i class="fas fa-book-open"></i>
                <span>Panduan Alur</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.finance.transactions.create') ? 'active' : '' }}" href="{{ route('admin.finance.transactions.create') }}">
                <i class="fas fa-cash-register"></i>
                <span>Catat Transaksi</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.finance.uniform-report') ? 'active' : '' }}" href="{{ route('admin.finance.uniform-report') }}">
                <i class="fas fa-shirt"></i>
                <span>Uang Seragam</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.finance.uniform-sizes') ? 'active' : '' }}" href="{{ route('admin.finance.uniform-sizes') }}">
                <i class="fas fa-ruler-combined"></i>
                <span>Ukuran Seragam</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.finance.final-progress') ? 'active' : '' }}" href="{{ route('admin.finance.final-progress') }}">
                <i class="fas fa-chart-line"></i>
                <span>Progress Final</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.finance.daily-report') ? 'active' : '' }}" href="{{ route('admin.finance.daily-report') }}">
                <i class="fas fa-calendar-day"></i>
                <span>Laporan Harian</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.finance.mutations') ? 'active' : '' }}" href="{{ route('admin.finance.mutations') }}">
                <i class="fas fa-arrow-right-arrow-left"></i>
                <span>Mutasi Kas</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.finance.final-report') ? 'active' : '' }}" href="{{ route('admin.finance.final-report') }}">
                <i class="fas fa-clipboard-check"></i>
                <span>Daftar Ulang Final</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.finance.payment-types') ? 'active' : '' }}" href="{{ route('admin.finance.payment-types') }}">
                <i class="fas fa-tags"></i>
                <span>Jenis Pembayaran</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.finance.audit-logs') ? 'active' : '' }}" href="{{ route('admin.finance.audit-logs') }}">
                <i class="fas fa-clock-rotate-left"></i>
                <span>Audit Log</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.operations.*') ? 'active' : '' }}" href="{{ route('admin.operations.dashboard') }}">
                <i class="fas fa-building-columns"></i>
                <span>Operasional</span>
            </a>

            <div class="admin-nav-label">Aksi</div>
            <button class="admin-nav-link" type="button" data-admin-print-page>
                <i class="fas fa-print"></i>
                <span>Cetak Halaman</span>
            </button>
            <a class="admin-nav-link" href="{{ route('home') }}" target="_blank" rel="noopener">
                <i class="fas fa-globe"></i>
                <span>Lihat Website</span>
            </a>
            @else
            <div class="admin-nav-label">Utama</div>
            <a class="admin-nav-link {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}" href="{{ $dashboardUrl }}">
                <i class="fas fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs($isSmpPanel ? 'admin.smp.guide' : 'admin.guide') ? 'active' : '' }}" href="{{ route($isSmpPanel ? 'admin.smp.guide' : 'admin.guide') }}">
                <i class="fas fa-book-open"></i>
                <span>Panduan Alur</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs($analyticsRoute) ? 'active' : '' }}" href="{{ route($analyticsRoute) }}">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs($quotasRoute) ? 'active' : '' }}" href="{{ route($quotasRoute) }}">
                <i class="fas fa-layer-group"></i>
                <span>Kuota</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs($applicantsRoute, $isSmpPanel ? 'admin.smp.search' : 'admin.search') ? 'active' : '' }}" href="{{ route($applicantsRoute) }}">
                <i class="fas fa-table"></i>
                <span>Data Pendaftar</span>
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.operations.*') ? 'active' : '' }}" href="{{ route('admin.operations.dashboard') }}">
                <i class="fas fa-building-columns"></i>
                <span>Operasional</span>
            </a>

            <div class="admin-nav-label">Aksi</div>
            <button class="admin-nav-link" type="button" data-admin-print-page>
                <i class="fas fa-print"></i>
                <span>Cetak Halaman</span>
            </button>
            <a class="admin-nav-link" href="{{ route($exportRoute) }}">
                <i class="fas fa-file-excel"></i>
                <span>Export Excel</span>
            </a>
            <a class="admin-nav-link" href="{{ route('home') }}" target="_blank" rel="noopener">
                <i class="fas fa-globe"></i>
                <span>Lihat Website</span>
            </a>
            @endif
        </nav>

        <div class="admin-sidebar-footer">
            <div class="admin-user-card">
                <span class="admin-user-avatar"><i class="fas fa-user-shield"></i></span>
                <span class="admin-user-copy">
                    <strong>{{ $panelUser?->name ?? 'Admin' }}</strong>
                    <span>{{ $panelUser?->email ?? $panelLabel }}</span>
                </span>
            </div>
            <a class="admin-logout" href="{{ route($logoutRoute) }}">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <section class="admin-main">
        <header class="admin-topbar">
            <div class="admin-topbar-title">
                <button class="admin-menu-button" type="button" data-admin-sidebar-open aria-label="Buka menu admin">
                    <i class="fas fa-bars"></i>
                </button>
                <i class="fas {{ $panelIcon }}"></i>
                <span>{{ $panelLabel }}</span>
            </div>
            <div class="admin-topbar-actions">
                <button type="button" data-admin-print-page title="Cetak Halaman" aria-label="Cetak Halaman">
                    <i class="fas fa-print"></i>
                </button>
                @if(!$isFinancePanel && !$isOperationsPanel)
                <a href="{{ route($exportRoute) }}" title="Export Excel" aria-label="Export Excel">
                    <i class="fas fa-file-excel"></i>
                </a>
                @endif
                <a href="{{ route($logoutRoute) }}" title="Logout" aria-label="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </header>

        @yield('admin_content')
    </section>
</div>

<div id="adminPrintRoot" aria-hidden="true"></div>

<div class="admin-document-modal" id="adminDocumentModal" aria-hidden="true">
    <button class="admin-document-backdrop" type="button" data-admin-preview-close aria-label="Tutup preview dokumen"></button>
    <section class="admin-document-dialog" role="dialog" aria-modal="true" aria-labelledby="adminDocumentTitle">
        <header class="admin-document-header">
            <div>
                <span class="admin-document-kicker">Preview Berkas</span>
                <h2 class="admin-document-title" id="adminDocumentTitle">Dokumen pendaftar</h2>
            </div>
            <div class="admin-document-tools">
                <a class="admin-document-link" id="adminDocumentOpenLink" href="#" target="_blank" rel="noopener">
                    <i class="fas fa-up-right-from-square"></i>
                    <span>Buka tab</span>
                </a>
                <button class="admin-document-close" type="button" data-admin-preview-close aria-label="Tutup preview">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
        </header>
        <div class="admin-document-body">
            <img class="admin-document-image" id="adminDocumentImage" alt="Preview dokumen">
            <iframe class="admin-document-frame" id="adminDocumentFrame" title="Preview dokumen"></iframe>
            <div class="admin-document-fallback" id="adminDocumentFallback">
                Preview berkas ini tidak bisa ditampilkan langsung. Gunakan tombol Buka tab untuk melihatnya.
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const openButtons = document.querySelectorAll('[data-admin-sidebar-open]');
    const closeButtons = document.querySelectorAll('[data-admin-sidebar-close]');
    const printRoot = document.getElementById('adminPrintRoot');

    function setSidebar(open) {
        document.body.classList.toggle('admin-sidebar-open', open);
    }

    openButtons.forEach((button) => button.addEventListener('click', () => setSidebar(true)));
    closeButtons.forEach((button) => button.addEventListener('click', () => setSidebar(false)));

    function cleanPrintRoot() {
        document.body.classList.remove('admin-printing-section');
        if (printRoot) {
            printRoot.innerHTML = '';
            printRoot.setAttribute('aria-hidden', 'true');
        }
    }

    function printableTitle(section) {
        const explicit = section.dataset.printTitle;

        if (explicit) {
            return explicit;
        }

        const heading = section.querySelector('h1, h2, h3, h4, h5, .card-header, .section-header, .finance-panel-header, .info-card-header, .analytics-title');

        return (heading?.innerText || document.title || 'Data Admin')
            .replace(/\s+/g, ' ')
            .trim();
    }

    function normalizePrintClone(clone) {
        clone.classList.add('admin-print-clone');
        clone.removeAttribute('id');
        clone.querySelectorAll('[id]').forEach((element) => element.removeAttribute('id'));
        clone.querySelectorAll('script, style, .admin-print-button, .admin-page-print').forEach((element) => element.remove());
        clone.querySelectorAll('input, textarea, select').forEach((field) => {
            if (field.type === 'hidden') {
                field.remove();
                return;
            }

            const value = field.tagName === 'SELECT'
                ? field.selectedOptions?.[0]?.textContent
                : field.value;
            const replacement = document.createElement('span');
            replacement.textContent = value || '-';
            replacement.className = 'admin-print-field-value';
            field.replaceWith(replacement);
        });
    }

    function printSection(section) {
        if (!section || !printRoot) {
            window.print();
            return;
        }

        const title = printableTitle(section);
        const clone = section.cloneNode(true);
        normalizePrintClone(clone);

        printRoot.innerHTML = '';
        printRoot.setAttribute('aria-hidden', 'false');

        const documentShell = document.createElement('section');
        const printHead = document.createElement('div');

        const schoolLogoUrl = "{{ asset($isSmpPanel ? 'images/LOGO SMPS YAPISDA.svg' : 'images/logo-yapisda.svg') }}";
        const provinceLogoUrl = "{{ asset('images/LOGO PROVINSI BANTEN.svg') }}";
        const isSmp = {{ $isSmpPanel ? 'true' : 'false' }};

        documentShell.className = 'admin-print-document';
        printHead.className = 'admin-print-head';
        printHead.innerHTML = `
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 3px double #000; padding-bottom: 8px; margin-bottom: 12px; width: 100%;">
                <div style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                    <img src="${schoolLogoUrl}" style="max-height: 60px; max-width: 60px; object-fit: contain;">
                </div>
                <div style="flex: 1; text-align: center; padding: 0 12px;">
                    <h3 style="margin: 0; font-size: 12pt; font-weight: bold; color: ${isSmp ? '#1e40af' : '#0b4537'}; font-family: 'Times New Roman', Times, serif; line-height: 1.2;">YAYASAN PENDIDIKAN ISLAM DAAR EL ROHMAH</h3>
                    <h2 style="margin: 2px 0; font-size: 14pt; font-weight: bold; color: ${isSmp ? '#2563eb' : '#0f5f4a'}; font-family: 'Times New Roman', Times, serif; line-height: 1.2;">${isSmp ? 'SMPS YAPISDA' : 'SMKS YAPISDA'}</h2>
                    <p style="margin: 0; font-size: 8pt; color: #374151; font-family: Arial, sans-serif; line-height: 1.3;">
                        Jl. Raya Cisoka - Tigaraksa, Kp. Saga, Desa Caringin, Kec. Cisoka, Kab. Tangerang, Banten 15730<br>
                        Telp: (021) 59751260 | WA: 0812-8906-113
                    </p>
                </div>
                <div style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                    <img src="${provinceLogoUrl}" style="max-height: 60px; max-width: 60px; object-fit: contain;">
                </div>
            </div>
            <div style="text-align: center; margin-top: 5px; margin-bottom: 10px;">
                <h4 style="margin: 0; font-size: 11pt; font-weight: bold; text-decoration: underline; text-transform: uppercase; font-family: 'Times New Roman', Times, serif;">${title}</h4>
                <small style="font-size: 7.5pt; color: #6b7280; font-family: Arial, sans-serif; display: block; margin-top: 2px;">
                    Dicetak via Panel Admin: ${new Date().toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' })} WIB
                </small>
            </div>
        `;
        documentShell.appendChild(printHead);
        documentShell.appendChild(clone);
        printRoot.appendChild(documentShell);

        document.body.classList.add('admin-printing-section');
        setTimeout(() => window.print(), 80);
    }

    window.addEventListener('afterprint', cleanPrintRoot);

    function addSectionPrintButtons() {
        const selectors = [
            '[data-print-section]',
            '.section-card',
            '.finance-panel',
            '.final-panel',
            '.audit-panel',
            '.info-card',
            '.card-minimal',
            '.chart-card',
            '.heatmap-card',
            '.activity-card',
            '.insight-card',
            '.header-card',
            '.header-minimal',
            '.card',
        ].join(',');
        const sections = Array.from(document.querySelectorAll(selectors))
            .filter((section) => !section.closest('.admin-sidebar, .admin-topbar, .admin-document-modal, #adminPrintRoot, .print-actions'))
            .filter((section, index, all) => !all.some((other) => other !== section && other.contains(section) && !section.matches('[data-print-section]')));

        sections.forEach((section) => {
            if (section.querySelector(':scope > .admin-print-button')) {
                return;
            }

            section.classList.add('admin-print-source');

            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'admin-print-button';
            button.innerHTML = '<i class="fas fa-print"></i><span>Cetak</span>';
            button.setAttribute('aria-label', 'Cetak bagian ini');
            button.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();
                printSection(section);
            });

            section.prepend(button);
        });
    }

    addSectionPrintButtons();

    document.querySelectorAll('[data-admin-print-page]').forEach((button) => {
        button.addEventListener('click', () => window.print());
    });

    const previewModal = document.getElementById('adminDocumentModal');
    const previewTitle = document.getElementById('adminDocumentTitle');
    const previewImage = document.getElementById('adminDocumentImage');
    const previewFrame = document.getElementById('adminDocumentFrame');
    const previewFallback = document.getElementById('adminDocumentFallback');
    const previewOpenLink = document.getElementById('adminDocumentOpenLink');
    const previewCloseButtons = document.querySelectorAll('[data-admin-preview-close]');

    function resetPreview() {
        previewImage.classList.remove('is-active');
        previewFrame.classList.remove('is-active');
        previewFallback.classList.remove('is-active');
        previewImage.removeAttribute('src');
        previewFrame.removeAttribute('src');
    }

    function getPreviewKind(url, kind) {
        if (kind) {
            return kind;
        }

        const cleanUrl = String(url || '').split('?')[0].toLowerCase();

        if (/\.(jpg|jpeg|png|gif|webp|bmp)$/i.test(cleanUrl)) {
            return 'image';
        }

        if (/\.pdf$/i.test(cleanUrl)) {
            return 'pdf';
        }

        return 'file';
    }

    function openPreview(trigger) {
        const url = trigger.dataset.adminPreviewUrl;

        if (!url || !previewModal) {
            return;
        }

        const title = trigger.dataset.adminPreviewTitle || trigger.getAttribute('aria-label') || 'Dokumen pendaftar';
        const kind = getPreviewKind(url, trigger.dataset.adminPreviewKind);

        resetPreview();
        previewTitle.textContent = title;
        previewOpenLink.href = url;

        if (kind === 'image') {
            previewImage.src = url;
            previewImage.alt = title;
            previewImage.classList.add('is-active');
        } else if (kind === 'pdf') {
            previewFrame.src = url;
            previewFrame.classList.add('is-active');
        } else {
            previewFallback.classList.add('is-active');
        }

        previewModal.classList.add('is-open');
        previewModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('admin-document-open');
    }

    function closePreview() {
        if (!previewModal) {
            return;
        }

        previewModal.classList.remove('is-open');
        previewModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('admin-document-open');
        resetPreview();
    }

    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-admin-preview-url]');

        if (!trigger) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();
        openPreview(trigger);
    });

    document.addEventListener('keydown', (event) => {
        if (!['Enter', ' '].includes(event.key)) {
            return;
        }

        const trigger = event.target.closest('[data-admin-preview-url]');

        if (!trigger) {
            return;
        }

        event.preventDefault();
        openPreview(trigger);
    });

    // Dynamic hidden iframe printing helper for print-related links
    document.addEventListener('click', (event) => {
        const printLink = event.target.closest('a[href*="/print/"], a[href*="/receipt/"], a[href*="/student-card/"], a[href*="/letters/"]');
        if (!printLink) return;

        event.preventDefault();
        event.stopPropagation();

        const url = printLink.href;
        
        // Show loading state on the button
        const originalContent = printLink.innerHTML;
        printLink.style.pointerEvents = 'none';
        printLink.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';

        // Create hidden iframe
        const iframe = document.createElement('iframe');
        iframe.style.position = 'fixed';
        iframe.style.right = '0';
        iframe.style.bottom = '0';
        iframe.style.width = '0';
        iframe.style.height = '0';
        iframe.style.border = 'none';
        iframe.src = url;

        // Focus and trigger printing once loaded
        iframe.onload = function() {
            printLink.style.pointerEvents = 'auto';
            printLink.innerHTML = originalContent;
            
            try {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            } catch (e) {
                console.error("Iframe printing failed, falling back to new window:", e);
                window.open(url, '_blank');
            }
            
            // Clean up the iframe after 60 seconds
            setTimeout(() => {
                if (iframe.parentNode) {
                    document.body.removeChild(iframe);
                }
            }, 60000);
        };

        document.body.appendChild(iframe);
    });

    previewCloseButtons.forEach((button) => button.addEventListener('click', closePreview));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setSidebar(false);
            closePreview();
        }
    });
});
</script>
@endpush
