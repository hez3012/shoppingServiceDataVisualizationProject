<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping Service ScaleView</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

    <style>
    /* ════════════════════════════════════════════════
       TOKEN SYSTEM
    ════════════════════════════════════════════════ */
    :root {
        --font: 'Plus Jakarta Sans', system-ui, sans-serif;

        /* Forest-green palette (Tailwind green, not emerald) */
        --g50:  #F0FDF4;
        --g100: #DCFCE7;
        --g200: #BBF7D0;
        --g300: #86EFAC;
        --g400: #4ADE80;
        --g500: #22C55E;
        --g600: #16A34A;
        --g700: #15803D;
        --g800: #166534;
        --g900: #14532D;
        --g950: #052E16;

        /* Light-mode semantics */
        --bg-gradient: linear-gradient(150deg, #F0FDF4 0%, #DCFCE7 40%, #BBF7D0 75%, #86EFAC 100%);
        --glass-bg:    rgba(255, 255, 255, 0.72);
        --glass-bg-h:  rgba(255, 255, 255, 0.88);
        --glass-bdr:   rgba(22, 163, 74, 0.28);
        --glass-bdr-h: rgba(22, 163, 74, 0.55);
        --nav-bg:      rgba(255, 255, 255, 0.88);
        --nav-bdr:     rgba(22, 163, 74, 0.22);
        --txt-h:       #14532D;
        --txt-b:       #166534;
        --txt-s:       #16A34A;
        --txt-m:       rgba(20, 83, 45, 0.60);
        --shadow-card: 0 8px 32px rgba(22, 163, 74, 0.14), 0 2px 8px rgba(0,0,0,0.06);
        --shadow-h:    0 16px 48px rgba(22, 163, 74, 0.26), 0 4px 12px rgba(0,0,0,0.09);
        --orb-op:      0.20;
        --chart-grid:  rgba(22, 163, 74, 0.09);
        --chart-text:  #15803D;
        --chart-tip-bg:#14532D;
        --filter-bg:   rgba(255, 255, 255, 0.80);
        --filter-bdr:  rgba(22, 163, 74, 0.30);
        --filter-txt:  #14532D;
        --btn-active-bg: rgba(22, 163, 74, 0.12);
        --btn-active-txt:#14532D;
        --empty-op:    0.45;
        --about-item-bg: rgba(255, 255, 255, 0.85);
        --about-item-bdr: rgba(22, 163, 74, 0.20);

        /* Transition */
        --speed: 0.3s;
    }

    [data-theme="dark"] {
        --bg-gradient: linear-gradient(150deg, #052E16 0%, #14532D 35%, #166534 70%, #15803D 100%);
        --glass-bg:    rgba(22, 101, 52, 0.30);
        --glass-bg-h:  rgba(22, 101, 52, 0.46);
        --glass-bdr:   rgba(134, 239, 172, 0.16);
        --glass-bdr-h: rgba(134, 239, 172, 0.34);
        --nav-bg:      rgba(5, 46, 22, 0.92);
        --nav-bdr:     rgba(134, 239, 172, 0.14);
        --txt-h:       #F0FDF4;
        --txt-b:       #DCFCE7;
        --txt-s:       #86EFAC;
        --txt-m:       rgba(220, 252, 231, 0.50);
        --shadow-card: 0 8px 32px rgba(0, 0, 0, 0.40), 0 2px 8px rgba(0,0,0,0.22);
        --shadow-h:    0 16px 48px rgba(0, 0, 0, 0.55), 0 4px 12px rgba(0,0,0,0.28);
        --orb-op:      0.13;
        --chart-grid:  rgba(134, 239, 172, 0.08);
        --chart-text:  #86EFAC;
        --chart-tip-bg:#052E16;
        --filter-bg:   rgba(22, 101, 52, 0.45);
        --filter-bdr:  rgba(134, 239, 172, 0.22);
        --filter-txt:  #DCFCE7;
        --btn-active-bg: rgba(74, 222, 128, 0.18);
        --btn-active-txt:#F0FDF4;
        --empty-op:    0.32;
        --about-item-bg: rgba(22, 101, 52, 0.45);
        --about-item-bdr: rgba(134, 239, 172, 0.18);
    }

    /* ════════════════════════════════════════════════
       BASE
    ════════════════════════════════════════════════ */
    *, *::before, *::after { box-sizing: border-box; }

    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: var(--font);
        margin: 0; padding: 0;
        min-height: 100vh;
        background: var(--bg-gradient);
        background-attachment: fixed;
        color: var(--txt-b);
        -webkit-font-smoothing: antialiased;
        overflow-x: hidden;
        transition: background var(--speed) ease, color var(--speed) ease;
    }

    /* ── Ambient orbs ─────────────────────────────── */
    .bg-orb {
        position: fixed;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
        filter: blur(80px);
        opacity: var(--orb-op);
        transition: opacity var(--speed) ease;
    }
    .orb-a {
        width: 700px; height: 700px;
        background: radial-gradient(circle, var(--g400) 0%, transparent 70%);
        top: -250px; right: -150px;
        animation: orb-drift 10s ease-in-out infinite;
    }
    .orb-b {
        width: 500px; height: 500px;
        background: radial-gradient(circle, var(--g500) 0%, transparent 70%);
        bottom: -100px; left: -180px;
        animation: orb-drift 12s ease-in-out infinite reverse;
        animation-delay: -5s;
    }
    .orb-c {
        width: 350px; height: 350px;
        background: radial-gradient(circle, var(--g300) 0%, transparent 70%);
        top: 45%; left: 55%;
        animation: orb-drift 15s ease-in-out infinite;
        animation-delay: -8s;
    }
    @keyframes orb-drift {
        0%, 100% { transform: translate(0,0) scale(1); }
        33%       { transform: translate(30px,-25px) scale(1.07); }
        66%       { transform: translate(-22px, 18px) scale(0.94); }
    }

    /* ════════════════════════════════════════════════
       NAVBAR
    ════════════════════════════════════════════════ */
    .sv-topnav {
        position: sticky;
        top: 0;
        z-index: 500;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: .875rem 2rem;
        background: var(--nav-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--nav-bdr);
        transition: background var(--speed) ease, border-color var(--speed) ease;
    }

    .sv-brand {
        display: flex;
        align-items: center;
        gap: .625rem;
        text-decoration: none;
    }
    .sv-brand-icon {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, var(--g600) 0%, var(--g500) 100%);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 2px 8px rgba(22, 163, 74, 0.40);
        transition: transform .2s, box-shadow .2s;
    }
    .sv-brand-icon:hover { transform: scale(1.08); box-shadow: 0 4px 14px rgba(22, 163, 74, 0.55); }
    .sv-brand-icon i { color: #fff; font-size: 1rem; }

    .sv-brand-name {
        font-size: .9375rem;
        font-weight: 800;
        color: var(--txt-h);
        letter-spacing: -.025em;
        line-height: 1.2;
        transition: color var(--speed) ease;
    }

    .sv-nav-actions {
        display: flex;
        align-items: center;
        gap: .625rem;
    }

    .sv-btn-glass {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-family: var(--font);
        font-size: .8125rem;
        font-weight: 600;
        color: var(--txt-b);
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--glass-bdr);
        border-radius: 9px;
        padding: .4375rem .875rem;
        cursor: pointer;
        transition: background .18s, border-color .18s, transform .18s, color var(--speed) ease;
    }
    .sv-btn-glass:hover {
        background: var(--glass-bg-h);
        border-color: var(--glass-bdr-h);
        transform: translateY(-1px);
    }
    .sv-btn-glass i { font-size: .875rem; color: var(--g500); }

    .sv-theme-toggle {
        width: 38px; height: 38px;
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--glass-bdr);
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: background .18s, border-color .18s, transform .18s;
        color: var(--txt-b);
        font-size: 1rem;
    }
    .sv-theme-toggle:hover {
        background: var(--glass-bg-h);
        border-color: var(--glass-bdr-h);
        transform: translateY(-1px) rotate(15deg);
    }

    /* ════════════════════════════════════════════════
       GLASS CARD
    ════════════════════════════════════════════════ */
    .sv-glass {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-bdr);
        border-radius: 16px;
        box-shadow: var(--shadow-card);
        transition:
            background var(--speed) ease,
            border-color var(--speed) ease,
            box-shadow var(--speed) ease,
            transform .22s cubic-bezier(.34,1.56,.64,1);
        position: relative;
        overflow: hidden;
    }
    .sv-glass::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: linear-gradient(135deg, rgba(255,255,255,.12) 0%, transparent 55%);
        pointer-events: none;
    }
    .sv-glass:hover {
        border-color: var(--glass-bdr-h);
        box-shadow: var(--shadow-h);
        transform: translateY(-4px);
    }

    /* ════════════════════════════════════════════════
       EMPTY STATE
    ════════════════════════════════════════════════ */
    .sv-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3.5rem 1.5rem;
        gap: .625rem;
        text-align: center;
    }
    .sv-empty i {
        font-size: 2.25rem;
        color: var(--g500);
        opacity: var(--empty-op);
    }
    .sv-empty-title {
        font-size: .875rem;
        font-weight: 600;
        color: var(--txt-b);
        opacity: .55;
        margin: 0;
    }
    .sv-empty-sub {
        font-size: .75rem;
        color: var(--txt-m);
        margin: 0;
    }

    /* ════════════════════════════════════════════════
       CHART WRAP
    ════════════════════════════════════════════════ */
    .ch-wrap { position: relative; width: 100%; }
    .ch-200  { height: 200px; }
    .ch-220  { height: 220px; }
    .ch-260  { height: 260px; }
    .ch-320  { height: 320px; }

    /* ════════════════════════════════════════════════
       SCROLL-REVEAL ANIMATION
    ════════════════════════════════════════════════ */
    .sr {
        opacity: 0;
        transform: translateY(28px);
        transition: opacity .55s cubic-bezier(.25,.46,.45,.94),
                    transform .55s cubic-bezier(.25,.46,.45,.94);
    }
    .sr.sr-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Page entrance animation */
    @keyframes fade-down {
        from { opacity:0; transform:translateY(-16px); }
        to   { opacity:1; transform:translateY(0); }
    }
    @keyframes fade-up {
        from { opacity:0; transform:translateY(20px); }
        to   { opacity:1; transform:translateY(0); }
    }
    @keyframes fade-in {
        from { opacity:0; }
        to   { opacity:1; }
    }

    .anim-nav  { animation: fade-down .45s cubic-bezier(.25,.46,.45,.94) both; }
    .anim-hero { animation: fade-up  .55s cubic-bezier(.25,.46,.45,.94) .15s both; }
    .anim-filter { animation: fade-up .5s cubic-bezier(.25,.46,.45,.94) .28s both; }
    .anim-kpi-1 { animation: fade-up .5s cubic-bezier(.25,.46,.45,.94) .38s both; }
    .anim-kpi-2 { animation: fade-up .5s cubic-bezier(.25,.46,.45,.94) .46s both; }
    .anim-kpi-3 { animation: fade-up .5s cubic-bezier(.25,.46,.45,.94) .54s both; }
    .anim-kpi-4 { animation: fade-up .5s cubic-bezier(.25,.46,.45,.94) .62s both; }

    @media (prefers-reduced-motion: reduce) {
        .sr, .sr.sr-visible,
        .anim-nav, .anim-hero, .anim-filter,
        .anim-kpi-1, .anim-kpi-2, .anim-kpi-3, .anim-kpi-4 {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }
    }

    /* ════════════════════════════════════════════════
       FILTER BAR
    ════════════════════════════════════════════════ */
    .sv-filter-bar {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: .625rem;
        background: var(--filter-bg);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid var(--filter-bdr);
        border-radius: 14px;
        padding: .625rem .875rem;
        transition: background var(--speed) ease, border-color var(--speed) ease;
    }
    .sv-filter-group {
        display: flex;
        align-items: center;
        gap: .25rem;
    }
    .sv-filter-label {
        font-size: .6875rem;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: var(--txt-s);
        padding: 0 .25rem;
        opacity: .7;
        transition: color var(--speed) ease;
    }
    .sv-filter-sep {
        width: 1px;
        height: 20px;
        background: var(--glass-bdr-h);
        opacity: .5;
    }
    .sv-period-btn {
        font-family: var(--font);
        font-size: .75rem;
        font-weight: 600;
        color: var(--filter-txt);
        background: transparent;
        border: 1px solid transparent;
        border-radius: 7px;
        padding: .3125rem .625rem;
        cursor: pointer;
        transition: all .16s;
        line-height: 1;
    }
    .sv-period-btn:hover:not(.active) {
        background: var(--btn-active-bg);
        color: var(--btn-active-txt);
    }
    .sv-period-btn.active {
        background: var(--g600);
        border-color: var(--g600);
        color: #fff;
        box-shadow: 0 2px 8px rgba(22,163,74,.40);
    }
    .sv-city-select {
        font-family: var(--font);
        font-size: .75rem;
        font-weight: 600;
        color: var(--filter-txt);
        background: var(--btn-active-bg);
        border: 1px solid var(--glass-bdr);
        border-radius: 7px;
        padding: .3125rem .75rem .3125rem .5rem;
        cursor: pointer;
        outline: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%2310B981' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .5rem center;
        padding-right: 1.5rem;
        transition: all .16s;
    }
    .sv-city-select:focus {
        border-color: var(--g400);
        box-shadow: 0 0 0 3px rgba(52,211,153,.18);
    }
    .sv-city-select option {
        background: #14532D;
        color: #F0FDF4;
    }

    /* ════════════════════════════════════════════════
       CARD SECTION HEADER
    ════════════════════════════════════════════════ */
    .sv-card-header {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: 1rem 1.25rem .875rem;
        border-bottom: 1px solid var(--glass-bdr);
        transition: border-color var(--speed) ease;
    }
    .sv-card-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .sv-card-label {
        font-size: .6875rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--txt-s);
        transition: color var(--speed) ease;
    }
    .sv-card-body { padding: 1.25rem; }

    /* ════════════════════════════════════════════════
       KPI CARDS
    ════════════════════════════════════════════════ */
    .sv-kpi {
        padding: 1.375rem 1.5rem 1.25rem;
        position: relative;
    }
    .sv-kpi::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: var(--kpi-grad, linear-gradient(90deg, var(--g500), var(--g400)));
        border-radius: 16px 16px 0 0;
    }
    .sv-kpi-shine {
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: linear-gradient(135deg, rgba(255,255,255,.14) 0%, transparent 50%);
        opacity: 0;
        transition: opacity .22s;
        pointer-events: none;
    }
    .sv-glass.sv-kpi:hover .sv-kpi-shine { opacity: 1; }

    .sv-kpi-icon {
        font-size: 1.375rem;
        color: var(--g500);
        margin-bottom: .5rem;
        display: block;
        transition: color var(--speed) ease;
    }
    .sv-kpi-value {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        color: var(--txt-h);
        line-height: 1.05;
        letter-spacing: -.04em;
        margin-bottom: .3rem;
        font-variant-numeric: tabular-nums;
        transition: color var(--speed) ease;
    }
    .sv-kpi-label {
        display: block;
        font-size: .6875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--txt-s);
        transition: color var(--speed) ease;
    }
    /* ghost numbers removed */

    /* ════════════════════════════════════════════════
       PAGE BODY LOADING STATE
    ════════════════════════════════════════════════ */
    .sv-content.loading {
        opacity: .5;
        pointer-events: none;
        transition: opacity .15s ease;
    }
    .sv-content { transition: opacity .22s ease; }

    /* ════════════════════════════════════════════════
       ABOUT MODAL
    ════════════════════════════════════════════════ */
    .about-overlay {
        position: fixed;
        inset: 0;
        background: rgba(5, 46, 22, 0.65);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 900;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        opacity: 0;
        pointer-events: none;
        transition: opacity .3s ease;
    }
    .about-overlay.open {
        opacity: 1;
        pointer-events: all;
    }
    .about-modal {
        width: 100%;
        max-width: 580px;
        max-height: 90vh;
        overflow-y: auto;
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(28px);
        -webkit-backdrop-filter: blur(28px);
        border: 1px solid rgba(22, 163, 74, 0.30);
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(20, 83, 45, 0.22), 0 4px 16px rgba(0,0,0,0.10);
        padding: 2rem;
        transform: scale(.92) translateY(24px);
        transition: transform .35s cubic-bezier(.34,1.56,.64,1), background var(--speed) ease, border-color var(--speed) ease;
        position: relative;
    }
    [data-theme="dark"] .about-modal {
        background: rgba(22, 101, 52, 0.55);
        border-color: rgba(134, 239, 172, 0.22);
        box-shadow: 0 20px 60px rgba(0,0,0,0.50), 0 4px 16px rgba(0,0,0,0.28);
    }
    .about-overlay.open .about-modal { transform: scale(1) translateY(0); }

    .about-close {
        position: absolute;
        top: 1rem; right: 1.25rem;
        font-size: 1.375rem;
        cursor: pointer;
        color: #166534;
        background: none;
        border: none;
        line-height: 1;
        padding: .25rem .375rem;
        border-radius: 7px;
        transition: color .15s, background .15s;
        font-family: var(--font);
        font-weight: 300;
    }
    [data-theme="dark"] .about-close { color: rgba(220,252,231,.65); }
    .about-close:hover { color: #14532D; background: rgba(22,163,74,.12); }
    [data-theme="dark"] .about-close:hover { color: #F0FDF4; background: rgba(134,239,172,.12); }

    .about-logo-wrap {
        display: flex;
        justify-content: center;
        margin-bottom: 1.25rem;
    }
    .about-logo {
        width: 80px;
        height: 80px;
        object-fit: contain;
        border-radius: 16px;
        border: 2px solid var(--glass-bdr-h);
        padding: .25rem;
        background: rgba(255,255,255,.6);
        box-shadow: 0 4px 16px rgba(16,185,129,.18);
    }
    .about-title {
        font-size: 1.125rem;
        font-weight: 800;
        color: #14532D;
        text-align: center;
        margin: 0 0 .25rem;
        letter-spacing: -.025em;
    }
    [data-theme="dark"] .about-title { color: #F0FDF4; }

    .about-school {
        font-size: .8125rem;
        color: #16A34A;
        text-align: center;
        margin: 0 0 1.5rem;
        font-weight: 600;
    }
    [data-theme="dark"] .about-school { color: #86EFAC; }

    .about-divider {
        height: 1px;
        background: rgba(22, 163, 74, 0.22);
        margin: 1rem 0;
        border: none;
    }
    [data-theme="dark"] .about-divider { background: rgba(134, 239, 172, 0.18); }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .75rem;
    }
    .about-item {
        background: var(--about-item-bg);
        border: 1px solid var(--about-item-bdr);
        border-radius: 10px;
        padding: .75rem 1rem;
    }
    .about-item.full { grid-column: 1 / -1; }
    .about-item-label {
        font-size: .6875rem;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: #16A34A;
        margin-bottom: .25rem;
    }
    [data-theme="dark"] .about-item-label { color: #86EFAC; }

    .about-item-value {
        font-size: .8125rem;
        font-weight: 600;
        color: #14532D;
        line-height: 1.4;
    }
    [data-theme="dark"] .about-item-value { color: #DCFCE7; }

    .about-creators {
        display: flex;
        flex-direction: column;
        gap: .2rem;
    }
    .about-creator {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .8125rem;
        font-weight: 600;
        color: #14532D;
    }
    [data-theme="dark"] .about-creator { color: #DCFCE7; }
    .about-creator::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #22C55E;
        flex-shrink: 0;
    }

    .tech-badges {
        display: flex;
        flex-wrap: wrap;
        gap: .375rem;
        margin-top: .25rem;
    }
    .tech-badge {
        font-size: .6875rem;
        font-weight: 600;
        background: rgba(22, 163, 74, 0.12);
        border: 1px solid rgba(22, 163, 74, 0.25);
        color: #15803D;
        border-radius: 5px;
        padding: .2rem .5rem;
    }
    [data-theme="dark"] .tech-badge {
        background: rgba(74, 222, 128, 0.14);
        border-color: rgba(134, 239, 172, 0.22);
        color: #86EFAC;
    }

    /* ════════════════════════════════════════════════
       MISC
    ════════════════════════════════════════════════ */
    * { position: relative; z-index: 1; }
    .bg-orb { z-index: 0; }
    canvas { display: block; }

    /* ════════════════════════════════════════════════
       MOBILE RESPONSIVE
    ════════════════════════════════════════════════ */
    @media (max-width: 599px) {
        .sv-topnav { padding: .625rem 1rem; gap: .5rem; }
        .sv-brand-name { display: none; }
        .btn-txt { display: none; }
        .sv-btn-glass { padding: .4375rem .6rem; }
        .sv-nav-actions { gap: .375rem; }

        .about-grid { grid-template-columns: 1fr; }
        .about-modal { padding: 1.25rem; border-radius: 16px; }

        .sv-kpi { padding: 1rem 1.125rem .875rem; }
        .sv-kpi-value { font-size: 1.375rem; letter-spacing: -.025em; }
    }

    @media (max-width: 399px) {
        .sv-kpi-value { font-size: 1.2rem; }
        .sv-kpi-label { font-size: .625rem; }
    }
    </style>

    @stack('styles')
</head>
<body>

{{-- Background orbs --}}
<div class="bg-orb orb-a" aria-hidden="true"></div>
<div class="bg-orb orb-b" aria-hidden="true"></div>
<div class="bg-orb orb-c" aria-hidden="true"></div>

{{-- Navbar --}}
<nav class="sv-topnav anim-nav" role="navigation">
    <a href="{{ route('dashboard') }}" class="sv-brand" style="text-decoration:none;">
        <div class="sv-brand-icon">
            <i class="bi bi-leaf-fill"></i>
        </div>
        <span class="sv-brand-name">Shopping Service ScaleView</span>
    </a>

    <div class="sv-nav-actions">
        <button class="sv-btn-glass" id="about-btn" type="button">
            <i class="bi bi-info-circle-fill"></i>
            <span class="btn-txt">About Us</span>
        </button>
        <button class="sv-theme-toggle" id="theme-toggle" type="button" title="Toggle dark mode" aria-label="Toggle dark mode">
            <i class="bi bi-moon-stars-fill" id="theme-icon"></i>
        </button>
    </div>
</nav>

{{-- Main content --}}
@yield('content')

{{-- ─── About Us Modal ───────────────────────────── --}}
<div class="about-overlay" id="about-overlay" role="dialog" aria-modal="true" aria-label="About Us">
    <div class="about-modal sv-glass">
        <button class="about-close" id="about-close" aria-label="Close">&times;</button>

        <div class="about-logo-wrap">
            <img src="{{ asset('PUP Logo - BI.png') }}" alt="Polytechnic University of the Philippines - Taguig" class="about-logo" onerror="this.style.display='none'">
        </div>

        <h2 class="about-title">Shopping Service ScaleView</h2>
        <p class="about-school">Polytechnic University of the Philippines – Taguig</p>

        <hr class="about-divider">

        <div class="about-grid">
            <div class="about-item full">
                <div class="about-item-label">Developers</div>
                <div class="about-creators">
                    <span class="about-creator">Hezekiah R. Mejilla</span>
                    <span class="about-creator">Mariane Andrea R. Ariba</span>
                </div>
            </div>
            <div class="about-item">
                <div class="about-item-label">Subject</div>
                <div class="about-item-value">Business Intelligence</div>
            </div>
            <div class="about-item">
                <div class="about-item-label">Year Level & Section</div>
                <div class="about-item-value">DIT 2-1</div>
            </div>
            <div class="about-item">
                <div class="about-item-label">Semester</div>
                <div class="about-item-value">2nd Semester</div>
            </div>
            <div class="about-item">
                <div class="about-item-label">School Campus</div>
                <div class="about-item-value">PUP – Taguig Campus</div>
            </div>
            <div class="about-item full">
                <div class="about-item-label">Tech Stack</div>
                <div class="tech-badges">
                    <span class="tech-badge">Laravel (PHP)</span>
                    <span class="tech-badge">Bootstrap 5</span>
                    <span class="tech-badge">Bootstrap Icons</span>
                    <span class="tech-badge">Chart.js 4</span>
                    <span class="tech-badge">MySQL</span>
                    <span class="tech-badge">Vite</span>
                    <span class="tech-badge">SASS</span>
                    <span class="tech-badge">Plus Jakarta Sans</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/* ── Theme ───────────────────────────────────────── */
(function () {
    const root   = document.documentElement;
    const icon   = document.getElementById('theme-icon');
    const toggle = document.getElementById('theme-toggle');

    const saved  = localStorage.getItem('sv-theme') || 'light';
    root.setAttribute('data-theme', saved);
    setIcon(saved);

    toggle.addEventListener('click', () => {
        const next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        root.setAttribute('data-theme', next);
        localStorage.setItem('sv-theme', next);
        setIcon(next);
        if (window.__chartThemeUpdate) window.__chartThemeUpdate(next);
    });

    function setIcon(theme) {
        if (!icon) return;
        icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
    }
})();

/* ── About modal ─────────────────────────────────── */
(function () {
    const overlay = document.getElementById('about-overlay');
    const openBtn = document.getElementById('about-btn');
    const closeBtn = document.getElementById('about-close');

    function open()  { overlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
    function close() { overlay.classList.remove('open'); document.body.style.overflow = ''; }

    openBtn.addEventListener('click', open);
    closeBtn.addEventListener('click', close);
    overlay.addEventListener('click', e => { if (e.target === overlay) close(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });
})();

/* ── Scroll-reveal ───────────────────────────────── */
(function () {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.querySelectorAll('.sr').forEach(el => el.classList.add('sr-visible'));
        return;
    }

    const io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('sr-visible');
            } else {
                entry.target.classList.remove('sr-visible');
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });

    document.querySelectorAll('.sr').forEach(el => io.observe(el));
})();
</script>

@stack('scripts')
</body>
</html>
