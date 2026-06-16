@extends('layouts.app')

@push('styles')
<style>
/* ── Layout grid ───────────────────────── */
.sv-hero {
    padding: 2.5rem 2rem 2rem;
}
.sv-hero-inner {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1.5rem;
    flex-wrap: wrap;
}
.sv-hero-text { flex: 1; min-width: 200px; }
.sv-hero-title {
    font-size: 1.625rem;
    font-weight: 800;
    color: var(--txt-h);
    letter-spacing: -.03em;
    margin: 0 0 .25rem;
    line-height: 1.2;
    transition: color var(--speed) ease;
}
.sv-hero-sub {
    font-size: .875rem;
    color: var(--txt-m);
    margin: 0;
    font-weight: 400;
    transition: color var(--speed) ease;
}
.sv-hero-filters { flex-shrink: 0; }

.sv-section {
    padding: 0 2rem 2rem;
}

/* KPI grid */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

/* Chart rows */
.chart-row { display: grid; gap: 1rem; margin-bottom: 1rem; }
.chart-2col { grid-template-columns: 3fr 2fr; }
.chart-2eq  { grid-template-columns: 1fr 1fr; }
.chart-1col { grid-template-columns: 1fr; }

/* Section label */
.sv-section-label {
    font-size: .6875rem;
    font-weight: 700;
    letter-spacing: .09em;
    text-transform: uppercase;
    color: var(--txt-s);
    opacity: .65;
    margin: 0 0 .75rem;
    padding-left: .125rem;
    transition: color var(--speed) ease;
}

/* Stagger delays on scroll-reveal items */
.sr-d1 { transition-delay: .05s; }
.sr-d2 { transition-delay: .12s; }
.sr-d3 { transition-delay: .19s; }
.sr-d4 { transition-delay: .26s; }
.sr-d5 { transition-delay: .08s; }
.sr-d6 { transition-delay: .16s; }

@media (max-width: 1199px) {
    .kpi-grid { grid-template-columns: repeat(2, 1fr); }
    .chart-2col, .chart-2eq { grid-template-columns: 1fr; }
}
@media (max-width: 599px) {
    .kpi-grid { grid-template-columns: repeat(2, 1fr); }
    .sv-hero { padding: 1.5rem 1rem 1.25rem; }
    .sv-section { padding: 0 1rem 1.5rem; }
    .sv-hero-filters { width: 100%; }
    .sv-filter-bar { justify-content: flex-start; }
    .ch-220 { height: 180px; }
    .ch-260 { height: 220px; }
    .ch-320 { height: 280px; }
    .sv-section-label { margin-top: .5rem; }
}
@media (max-width: 399px) {
    .sv-filter-bar { padding: .5rem .625rem; gap: .375rem; }
    .sv-period-btn { padding: .25rem .5rem; font-size: .6875rem; }
    .ch-220 { height: 160px; }
    .ch-260 { height: 200px; }
    .ch-320 { height: 260px; }
}
</style>
@endpush

@section('content')

{{-- ── Hero + Filters ─────────────────────────────── --}}
<section class="sv-hero">
    <div class="sv-hero-inner">
        <div class="sv-hero-text anim-hero">
            <h1 class="sv-hero-title">Sales Performance Overview</h1>
            <p class="sv-hero-sub">Real-time insights · Scale Model Retail · Philippines · 2025</p>
        </div>
        <div class="sv-hero-filters anim-filter">
            <div class="sv-filter-bar">
                <div class="sv-filter-group">
                    <span class="sv-filter-label">Quarter</span>
                    <button type="button" class="sv-period-btn" data-period="Q1">Q1</button>
                    <button type="button" class="sv-period-btn" data-period="Q2">Q2</button>
                    <button type="button" class="sv-period-btn" data-period="Q3">Q3</button>
                    <button type="button" class="sv-period-btn" data-period="Q4">Q4</button>
                </div>
                <div class="sv-filter-sep"></div>
                <div class="sv-filter-group">
                    <span class="sv-filter-label">Half</span>
                    <button type="button" class="sv-period-btn" data-period="H1">H1</button>
                    <button type="button" class="sv-period-btn" data-period="H2">H2</button>
                </div>
                <div class="sv-filter-sep"></div>
                <button type="button" class="sv-period-btn active" data-period="annual">2025</button>
                <div class="sv-filter-sep"></div>
                <select class="sv-city-select" id="city-filter" aria-label="Filter by city">
                    <option value="all">All Cities</option>
                    <option value="Quezon City">Quezon City</option>
                    <option value="Davao City">Davao City</option>
                    <option value="Taguig">Taguig</option>
                    <option value="Pasig">Pasig</option>
                    <option value="Cebu City">Cebu City</option>
                </select>
            </div>
        </div>
    </div>
</section>

{{-- ── Main Content ────────────────────────────────── --}}
<div class="sv-content sv-section" id="sv-content">

    {{-- ─ KPI Cards ─────────────────────────────────── --}}
    <p class="sv-section-label sr sr-d1">Key Performance Indicators</p>
    <div class="kpi-grid">
        <div class="sv-glass sv-kpi anim-kpi-1" style="--kpi-grad: linear-gradient(90deg,#16A34A,#22C55E)">
            <div class="sv-kpi-shine"></div>
            <i class="bi bi-currency-exchange sv-kpi-icon"></i>
            <span class="sv-kpi-value" id="kpi-revenue" data-raw="0">₱0</span>
            <span class="sv-kpi-label">Total Revenue</span>
        </div>
        <div class="sv-glass sv-kpi anim-kpi-2" style="--kpi-grad: linear-gradient(90deg,#15803D,#16A34A)">
            <div class="sv-kpi-shine"></div>
            <i class="bi bi-bag-check sv-kpi-icon"></i>
            <span class="sv-kpi-value" id="kpi-orders" data-raw="0">0</span>
            <span class="sv-kpi-label">Total Orders</span>
        </div>
        <div class="sv-glass sv-kpi anim-kpi-3" style="--kpi-grad: linear-gradient(90deg,#166534,#15803D)">
            <div class="sv-kpi-shine"></div>
            <i class="bi bi-people sv-kpi-icon"></i>
            <span class="sv-kpi-value" id="kpi-customers" data-raw="0">0</span>
            <span class="sv-kpi-label">Total Customers</span>
        </div>
        <div class="sv-glass sv-kpi anim-kpi-4" style="--kpi-grad: linear-gradient(90deg,#22C55E,#4ADE80)">
            <div class="sv-kpi-shine"></div>
            <i class="bi bi-box-seam sv-kpi-icon"></i>
            <span class="sv-kpi-value" id="kpi-products" data-raw="0">0</span>
            <span class="sv-kpi-label">Total Products</span>
        </div>
    </div>

    {{-- ─ Row 1: Q1 City Sales | Q3 Office ──────────── --}}
    <p class="sv-section-label sr sr-d1">Market Analysis</p>
    <div class="chart-row chart-2col sr sr-d2" style="margin-bottom:1rem;">
        <div class="sv-glass">
            <div class="sv-card-header">
                <span class="sv-card-dot" style="background:var(--g500)"></span>
                <span class="sv-card-label">Q1 — Best Market City by Revenue</span>
            </div>
            <div class="sv-card-body">
                <div class="ch-wrap ch-220">
                    <canvas id="q1-chart"></canvas>
                </div>
                <div class="sv-empty d-none" id="q1-empty">
                    <i class="bi bi-bar-chart-line"></i>
                    <p class="sv-empty-title">No data for this period</p>
                    <p class="sv-empty-sub">Try a different filter above</p>
                </div>
            </div>
        </div>
        <div class="sv-glass">
            <div class="sv-card-header">
                <span class="sv-card-dot" style="background:var(--g400)"></span>
                <span class="sv-card-label">Q3 — Office Sales Support</span>
            </div>
            <div class="sv-card-body">
                <div class="ch-wrap ch-220">
                    <canvas id="q3-chart"></canvas>
                </div>
                <div class="sv-empty d-none" id="q3-empty">
                    <i class="bi bi-building"></i>
                    <p class="sv-empty-title">No data for this period</p>
                    <p class="sv-empty-sub">Q3 office data not available</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ─ Row 2: Q2 Top Products (full) ──────────────── --}}
    <p class="sv-section-label sr sr-d3">Product Performance</p>
    <div class="chart-row chart-1col sr sr-d4" style="margin-bottom:1rem;">
        <div class="sv-glass">
            <div class="sv-card-header">
                <span class="sv-card-dot" style="background:var(--g600)"></span>
                <span class="sv-card-label">Q2 — Top 10 Products by Sales Revenue</span>
            </div>
            <div class="sv-card-body">
                <div class="ch-wrap ch-320">
                    <canvas id="q2-chart"></canvas>
                </div>
                <div class="sv-empty d-none" id="q2-empty">
                    <i class="bi bi-box-seam"></i>
                    <p class="sv-empty-title">No data for this period</p>
                    <p class="sv-empty-sub">Try a different filter above</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ─ Row 3: Q4 Product Lines | Q5 Sales Reps ───── --}}
    <p class="sv-section-label sr sr-d5">Revenue & Team</p>
    <div class="chart-row chart-2eq sr sr-d6" style="margin-bottom:1rem;">
        <div class="sv-glass">
            <div class="sv-card-header">
                <span class="sv-card-dot" style="background:var(--g700)"></span>
                <span class="sv-card-label">Q4 — Product Line Revenue</span>
            </div>
            <div class="sv-card-body">
                <div class="ch-wrap ch-260">
                    <canvas id="q4-chart"></canvas>
                </div>
                <div class="sv-empty d-none" id="q4-empty">
                    <i class="bi bi-tags"></i>
                    <p class="sv-empty-title">No data for this period</p>
                    <p class="sv-empty-sub">Q4 data not yet available</p>
                </div>
            </div>
        </div>
        <div class="sv-glass">
            <div class="sv-card-header">
                <span class="sv-card-dot" style="background:var(--g400)"></span>
                <span class="sv-card-label">Q5 — Sales Rep Performance</span>
            </div>
            <div class="sv-card-body">
                <div class="ch-wrap ch-260">
                    <canvas id="q5-chart"></canvas>
                </div>
                <div class="sv-empty d-none" id="q5-empty">
                    <i class="bi bi-person-badge"></i>
                    <p class="sv-empty-title">No data for this period</p>
                    <p class="sv-empty-sub">Try a different filter above</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ─ Row 4: Monthly Trend (full) ─────────────────── --}}
    <p class="sv-section-label sr sr-d1">Sales Trend</p>
    <div class="chart-row chart-1col sr sr-d2">
        <div class="sv-glass">
            <div class="sv-card-header">
                <span class="sv-card-dot" style="background:var(--g300)"></span>
                <span class="sv-card-label">Monthly Sales Trend — 2025</span>
            </div>
            <div class="sv-card-body">
                <div class="ch-wrap ch-200">
                    <canvas id="trend-chart"></canvas>
                </div>
                <div class="sv-empty d-none" id="trend-empty">
                    <i class="bi bi-graph-up-arrow"></i>
                    <p class="sv-empty-title">No data for this period</p>
                    <p class="sv-empty-sub">Try a different filter above</p>
                </div>
            </div>
        </div>
    </div>

</div>{{-- /sv-content --}}
@endsection

@push('scripts')
<script>
(function () {
'use strict';

/* ── State ──────────────────────────────────────────── */
const state = { period: 'annual', city: 'all' };

/* ── Forest-green palette (Tailwind green, not emerald) ── */
const G = {
    g300: '#86EFAC',
    g400: '#4ADE80',
    g500: '#22C55E',
    g600: '#16A34A',
    g700: '#15803D',
    g800: '#166534',
};

function hex(c, a) {
    const r = parseInt(c.slice(1,3),16), g = parseInt(c.slice(3,5),16), b = parseInt(c.slice(5,7),16);
    return `rgba(${r},${g},${b},${a})`;
}

function greenGradient(n) {
    const stops = [G.g700, G.g600, G.g500, G.g400, G.g300];
    return Array.from({length: n}, (_, i) => {
        const t  = n > 1 ? i / (n - 1) : 0;
        const si = Math.min(Math.floor(t * (stops.length - 1)), stops.length - 2);
        const st = t * (stops.length - 1) - si;
        const lerp = (a, b) => Math.round(a + (b - a) * st);
        const c1 = stops[si], c2 = stops[si + 1];
        const r1 = parseInt(c1.slice(1,3),16), g1 = parseInt(c1.slice(3,5),16), b1 = parseInt(c1.slice(5,7),16);
        const r2 = parseInt(c2.slice(1,3),16), g2 = parseInt(c2.slice(3,5),16), b2 = parseInt(c2.slice(5,7),16);
        return `rgb(${lerp(r1,r2)},${lerp(g1,g2)},${lerp(b1,b2)})`;
    });
}

/* ── Chart theme helpers ──────────────────────────────── */
function isDark() {
    return document.documentElement.getAttribute('data-theme') === 'dark';
}

function chartTextColor() { return isDark() ? G.g300 : G.g800; }
function chartGridColor() { return isDark() ? 'rgba(134,239,172,.08)' : 'rgba(22,163,74,.09)'; }
function chartTipBg()     { return isDark() ? '#052E16' : '#14532D'; }

/* ── Chart.js defaults ────────────────────────────────── */
function applyChartDefaults() {
    Chart.defaults.font.family = "'Plus Jakarta Sans', system-ui, sans-serif";
    Chart.defaults.font.size   = 11.5;
    Chart.defaults.color       = chartTextColor();
    Chart.defaults.plugins.tooltip.backgroundColor = chartTipBg();
    Chart.defaults.plugins.tooltip.titleColor      = '#ECFDF5';
    Chart.defaults.plugins.tooltip.bodyColor       = 'rgba(209,250,229,.85)';
    Chart.defaults.plugins.tooltip.padding         = 10;
    Chart.defaults.plugins.tooltip.cornerRadius    = 9;
    Chart.defaults.plugins.tooltip.boxPadding      = 4;
    Chart.defaults.animation.duration              = 600;
    Chart.defaults.animation.easing               = 'easeOutQuart';
}
applyChartDefaults();

const ticksCfg = () => ({ color: chartTextColor(), font: { size: 10.5, family: "'Plus Jakarta Sans', sans-serif" } });
const gridCfg  = () => ({ color: chartGridColor(), drawBorder: false });

/* ── Format numbers ─────────────────────────────────── */
function fmtK(v) {
    if (v >= 1_000_000) return '₱' + (v/1_000_000).toFixed(1) + 'M';
    if (v >= 1_000)     return '₱' + (v/1_000).toFixed(0) + 'K';
    return '₱' + v.toFixed(0);
}
function fmtPeso(v) { return '₱' + new Intl.NumberFormat('en-PH').format(Math.round(v)); }
function fmtInt(v)  { return new Intl.NumberFormat('en-PH').format(Math.round(v)); }

/* ── KPI Count-up ────────────────────────────────────── */
const _af = {};
function countUp(id, target, isRevenue) {
    const el = document.getElementById(id);
    if (!el) return;
    if (_af[id]) cancelAnimationFrame(_af[id]);
    const from = parseFloat(el.dataset.raw) || 0;
    const t0   = performance.now();
    const dur  = 750;

    function tick(now) {
        const p = Math.min((now - t0) / dur, 1);
        const e = 1 - Math.pow(1 - p, 3);
        const v = from + (target - from) * e;
        el.dataset.raw = v;
        el.textContent = isRevenue ? fmtPeso(v) : fmtInt(v);
        if (p < 1) _af[id] = requestAnimationFrame(tick);
        else { el.dataset.raw = target; el.textContent = isRevenue ? fmtPeso(target) : fmtInt(target); }
    }
    _af[id] = requestAnimationFrame(tick);
}

/* ── Empty state helpers ─────────────────────────────── */
function showEmpty(k) {
    const c = document.getElementById(k + '-chart');
    const e = document.getElementById(k + '-empty');
    if (c) c.classList.add('d-none');
    if (e) e.classList.remove('d-none');
}
function showChart(k) {
    const c = document.getElementById(k + '-chart');
    const e = document.getElementById(k + '-empty');
    if (c) c.classList.remove('d-none');
    if (e) e.classList.add('d-none');
}

/* ── Chart instances ─────────────────────────────────── */
const charts = {};
const DOUGHNUT_COLORS = [G.g500, G.g600, G.g400, G.g700, G.g300];

function initCharts() {
    /* Q1 — City bar */
    charts.q1 = new Chart(document.getElementById('q1-chart'), {
        type: 'bar',
        data: { labels: [], datasets: [{ label: 'Revenue', data: [], backgroundColor: hex(G.g500, .75), hoverBackgroundColor: hex(G.g400, .9), borderRadius: 6, borderSkipped: false }] },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => fmtPeso(c.parsed.y) } } },
            scales: {
                x: { ticks: ticksCfg(), grid: { display: false } },
                y: { ticks: { ...ticksCfg(), callback: fmtK }, grid: gridCfg(), border: { display: false } }
            }
        }
    });

    /* Q3 — Doughnut */
    charts.q3 = new Chart(document.getElementById('q3-chart'), {
        type: 'doughnut',
        data: { labels: [], datasets: [{ data: [], backgroundColor: DOUGHNUT_COLORS, borderWidth: 2, borderColor: 'transparent', hoverOffset: 8 }] },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '65%',
            plugins: {
                legend: { position: 'right', labels: { usePointStyle: true, pointStyle: 'circle', padding: 14, color: chartTextColor(), font: { size: 11 } } },
                tooltip: { callbacks: { label: c => `${c.label}: ${fmtInt(c.parsed)} orders` } }
            }
        }
    });

    /* Q2 — Horizontal bar (full-width) */
    charts.q2 = new Chart(document.getElementById('q2-chart'), {
        type: 'bar',
        data: { labels: [], datasets: [{ label: 'Revenue', data: [], backgroundColor: [], hoverBackgroundColor: [], borderRadius: 4, borderSkipped: false }] },
        options: {
            indexAxis: 'y',
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => fmtPeso(c.parsed.x) } } },
            scales: {
                x: { ticks: { ...ticksCfg(), callback: fmtK }, grid: gridCfg(), border: { display: false } },
                y: { ticks: { ...ticksCfg(), font: { size: 10 } }, grid: { display: false } }
            }
        }
    });

    /* Q4 — Product line bar */
    charts.q4 = new Chart(document.getElementById('q4-chart'), {
        type: 'bar',
        data: { labels: [], datasets: [{ label: 'Revenue', data: [], backgroundColor: hex(G.g600, .75), hoverBackgroundColor: hex(G.g500, .9), borderRadius: 6, borderSkipped: false }] },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => fmtPeso(c.parsed.y) } } },
            scales: {
                x: { ticks: { ...ticksCfg(), font: { size: 9.5 }, maxRotation: 20 }, grid: { display: false } },
                y: { ticks: { ...ticksCfg(), callback: fmtK }, grid: gridCfg(), border: { display: false } }
            }
        }
    });

    /* Q5 — Dual axis */
    charts.q5 = new Chart(document.getElementById('q5-chart'), {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                { type: 'bar',  label: 'Orders',  data: [], backgroundColor: hex(G.g500,.75), hoverBackgroundColor: hex(G.g400,.9), borderRadius: 4, borderSkipped: false, yAxisID: 'y' },
                { type: 'line', label: 'Revenue', data: [], borderColor: G.g300, backgroundColor: 'transparent', borderWidth: 2.5, pointRadius: 4, pointBackgroundColor: G.g300, pointBorderColor: 'transparent', tension: .4, yAxisID: 'y1' }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', align: 'end', labels: { usePointStyle: true, pointStyle: 'circle', padding: 12, color: chartTextColor(), font: { size: 11 } } },
                tooltip: { callbacks: { label: c => c.datasetIndex === 0 ? `Orders: ${fmtInt(c.parsed.y)}` : `Revenue: ${fmtPeso(c.parsed.y)}` } }
            },
            scales: {
                x:  { ticks: { ...ticksCfg(), font: { size: 9.5 }, maxRotation: 25 }, grid: { display: false } },
                y:  { type: 'linear', position: 'left',  ticks: ticksCfg(), grid: gridCfg(), border: { display: false } },
                y1: { type: 'linear', position: 'right', ticks: { ...ticksCfg(), callback: fmtK }, grid: { drawOnChartArea: false }, border: { display: false } }
            }
        }
    });

    /* Trend — Line with gradient fill */
    charts.trend = new Chart(document.getElementById('trend-chart'), {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Revenue',
                data: [],
                borderColor: G.g400,
                borderWidth: 2.5,
                backgroundColor: (ctx) => {
                    const { chart } = ctx;
                    const { chartArea } = chart;
                    if (!chartArea) return hex(G.g400, .08);
                    const g = chart.ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                    g.addColorStop(0, hex(G.g400, .22));
                    g.addColorStop(1, hex(G.g500, .01));
                    return g;
                },
                fill: true,
                tension: .4,
                pointRadius: 5,
                pointBackgroundColor: G.g400,
                pointBorderColor: 'transparent',
                pointHoverRadius: 8,
                pointHoverBackgroundColor: G.g300,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => fmtPeso(c.parsed.y) } } },
            scales: {
                x: { ticks: ticksCfg(), grid: { display: false } },
                y: { ticks: { ...ticksCfg(), callback: fmtK }, grid: gridCfg(), border: { display: false } }
            }
        }
    });
}

/* ── Update charts ───────────────────────────────────── */
function updateCharts(d) {
    function set(key, fn) {
        if (!d[key].labels.length) { showEmpty(key); return; }
        showChart(key); fn();
    }

    set('q1', () => {
        charts.q1.data.labels = d.q1.labels;
        charts.q1.data.datasets[0].data = d.q1.values;
        charts.q1.update();
    });

    set('q3', () => {
        charts.q3.data.labels = d.q3.labels;
        charts.q3.data.datasets[0].data = d.q3.values;
        charts.q3.update();
    });

    set('q2', () => {
        const colors = greenGradient(d.q2.labels.length);
        charts.q2.data.labels = d.q2.labels;
        charts.q2.data.datasets[0].data = d.q2.values;
        charts.q2.data.datasets[0].backgroundColor = colors.map(c => c);
        charts.q2.data.datasets[0].hoverBackgroundColor = colors.map(c => c.replace('rgb', 'rgba').replace(')', ', .85)') || c);
        charts.q2.update();
    });

    set('q4', () => {
        charts.q4.data.labels = d.q4.labels;
        charts.q4.data.datasets[0].data = d.q4.values;
        charts.q4.update();
    });

    set('q5', () => {
        charts.q5.data.labels = d.q5.labels;
        charts.q5.data.datasets[0].data = d.q5.orders;
        charts.q5.data.datasets[1].data = d.q5.revenue;
        charts.q5.update();
    });

    set('trend', () => {
        charts.trend.data.labels = d.trend.labels;
        charts.trend.data.datasets[0].data = d.trend.values;
        charts.trend.update();
    });
}

/* ── Update KPIs ─────────────────────────────────────── */
function updateKPIs(kpis) {
    countUp('kpi-revenue',   kpis.revenue,   true);
    countUp('kpi-orders',    kpis.orders,    false);
    countUp('kpi-customers', kpis.customers, false);
    countUp('kpi-products',  kpis.products,  false);
}

/* ── Fetch data ──────────────────────────────────────── */
async function loadData() {
    const el = document.getElementById('sv-content');
    el.classList.add('loading');
    try {
        const r = await fetch(`/dashboard/data?${new URLSearchParams(state)}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await r.json();
        updateKPIs(data.kpis);
        updateCharts(data);
    } catch (e) {
        console.error('Data fetch failed:', e);
    } finally {
        el.classList.remove('loading');
    }
}

/* ── Chart theme update (called by layout's theme toggle) ── */
window.__chartThemeUpdate = function(theme) {
    const col   = theme === 'dark' ? G.g300 : G.g800;
    const grid  = theme === 'dark' ? 'rgba(134,239,172,.08)' : 'rgba(22,163,74,.09)';
    const tipBg = theme === 'dark' ? '#052E16' : '#14532D';

    Chart.defaults.color = col;
    Chart.defaults.plugins.tooltip.backgroundColor = tipBg;

    Object.values(charts).forEach(ch => {
        if (!ch) return;
        ch.options.plugins?.legend?.labels && (ch.options.plugins.legend.labels.color = col);
        ['x','y','y1','y2'].forEach(axis => {
            if (ch.options.scales?.[axis]) {
                ch.options.scales[axis].ticks.color = col;
                if (ch.options.scales[axis].grid) ch.options.scales[axis].grid.color = grid;
            }
        });
        ch.update('none');
    });
};

/* ── Filter bindings ─────────────────────────────────── */
document.querySelectorAll('.sv-period-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.sv-period-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        state.period = btn.dataset.period;
        loadData();
    });
});
document.getElementById('city-filter').addEventListener('change', e => {
    state.city = e.target.value;
    loadData();
});

/* ── Boot ────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    initCharts();
    loadData();
});

})();
</script>
@endpush
