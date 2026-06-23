@extends('master.back')

@section('styles')
<style>
    .artisan-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        border-radius: 16px;
        padding: 32px;
        margin-bottom: 28px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .artisan-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(83,125,255,0.15) 0%, transparent 70%);
        pointer-events: none;
    }
    .artisan-hero h2 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 6px;
        color: #fff;
    }
    .artisan-hero p {
        color: rgba(255,255,255,0.65);
        margin: 0;
        font-size: 0.95rem;
    }
    .artisan-hero .hero-icon {
        font-size: 3rem;
        opacity: 0.15;
        position: absolute;
        right: 32px;
        top: 50%;
        transform: translateY(-50%);
    }

    /* Cards */
    .tool-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        transition: box-shadow 0.2s;
        margin-bottom: 24px;
    }
    .tool-card:hover {
        box-shadow: 0 6px 28px rgba(0,0,0,0.13);
    }
    .tool-card .card-header {
        border-radius: 14px 14px 0 0 !important;
        font-weight: 700;
        font-size: 1rem;
        padding: 16px 22px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid rgba(0,0,0,0.06);
        background: #fff;
    }
    .tool-card .card-header .header-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #fff;
    }
    .tool-card .card-body {
        padding: 22px;
    }

    /* Action buttons */
    .action-btn {
        border: none;
        border-radius: 10px;
        padding: 10px 22px;
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        transition: all 0.18s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }
    .action-btn:active {
        transform: translateY(0);
    }
    .btn-migrate   { background: linear-gradient(135deg,#1d7af3,#2563eb); color:#fff; }
    .btn-rollback  { background: linear-gradient(135deg,#f5a623,#e8940a); color:#fff; }
    .btn-fresh     { background: linear-gradient(135deg,#e74c3c,#c0392b); color:#fff; }
    .btn-seed      { background: linear-gradient(135deg,#27ae60,#1e8449); color:#fff; }
    .btn-all-seed  { background: linear-gradient(135deg,#8e44ad,#6c3483); color:#fff; }

    /* Migration table */
    .migration-table-wrap { border-radius: 12px; overflow: hidden; }
    .migration-table thead th {
        background: #f8f9fc;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #555;
        font-weight: 700;
        padding: 12px 16px;
        border: none;
    }
    .migration-table tbody tr {
        transition: background 0.15s;
    }
    .migration-table tbody tr:hover {
        background: #f0f4ff;
    }
    .migration-table tbody td {
        padding: 11px 16px;
        vertical-align: middle;
        border-color: #f1f1f1;
        font-size: 0.88rem;
        font-family: 'Courier New', monospace;
    }
    .badge-ran {
        background: linear-gradient(135deg,#27ae60,#1e8449);
        color: #fff;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.04em;
    }
    .badge-pending {
        background: linear-gradient(135deg,#f39c12,#d68910);
        color: #fff;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.04em;
    }
    .stats-row {
        display: flex;
        gap: 12px;
        margin-bottom: 18px;
    }
    .stat-chip {
        border-radius: 10px;
        padding: 10px 18px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.88rem;
        font-weight: 600;
    }
    .stat-chip.ran { background: #eafaf1; color: #1e8449; }
    .stat-chip.pending { background: #fef9e7; color: #d68910; }
    .stat-chip.total { background: #eaf0fb; color: #2563eb; }

    /* Alert output */
    .alert-output {
        border-radius: 10px;
        font-size: 0.88rem;
    }
    .alert-output pre {
        margin: 6px 0 0;
        background: rgba(0,0,0,0.05);
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 0.82rem;
        white-space: pre-wrap;
        word-break: break-word;
        max-height: 160px;
        overflow-y: auto;
    }

    /* Warning box */
    .danger-zone {
        background: #fff5f5;
        border: 1.5px dashed #e74c3c;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 16px;
    }
    .danger-zone p {
        font-size: 0.85rem;
        color: #c0392b;
        margin: 0;
    }

    /* Seeder select */
    .seeder-select {
        border-radius: 10px;
        border: 1.5px solid #dde3f0;
        padding: 10px 14px;
        font-size: 0.9rem;
        width: 100%;
        outline: none;
        transition: border-color 0.2s;
    }
    .seeder-select:focus {
        border-color: #1d7af3;
        box-shadow: 0 0 0 3px rgba(29,122,243,0.12);
    }

    /* Search */
    .migration-search {
        border-radius: 10px;
        border: 1.5px solid #dde3f0;
        padding: 9px 14px 9px 40px;
        font-size: 0.9rem;
        width: 100%;
        outline: none;
        transition: border-color 0.2s;
    }
    .migration-search:focus {
        border-color: #1d7af3;
        box-shadow: 0 0 0 3px rgba(29,122,243,0.12);
    }
    .search-wrap {
        position: relative;
        margin-bottom: 16px;
    }
    .search-wrap i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 0.9rem;
    }
    .filter-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 14px;
    }
    .filter-tab {
        border: none;
        background: #f0f4ff;
        color: #2563eb;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s;
    }
    .filter-tab.active, .filter-tab:hover {
        background: #1d7af3;
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    {{-- Hero --}}
    <div class="artisan-hero">
        <i class="fas fa-terminal hero-icon"></i>
        <h2><i class="fas fa-tools mr-2" style="font-size:1.4rem;opacity:.9;"></i> Artisan Tools</h2>
        <p>Run database migrations & seeders directly from the admin panel. Use with care in production.</p>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-output alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {!! session('success') !!}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-output alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            {!! session('error') !!}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row">

        {{-- LEFT COLUMN: Migrations --}}
        <div class="col-lg-7">

            {{-- Migration Actions --}}
            <div class="card tool-card">
                <div class="card-header">
                    <span class="header-icon" style="background:linear-gradient(135deg,#1d7af3,#2563eb);">
                        <i class="fas fa-database"></i>
                    </span>
                    Migration Commands
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <form method="POST" action="{{ route('back.artisan.migrate') }}">
                                @csrf
                                <button type="submit" class="action-btn btn-migrate w-100 justify-content-center">
                                    <i class="fas fa-play"></i> Run Migrate
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4 mb-3">
                            <form method="POST" action="{{ route('back.artisan.rollback') }}">
                                @csrf
                                <button type="submit" class="action-btn btn-rollback w-100 justify-content-center"
                                    onclick="return confirm('Rollback the last batch of migrations?')">
                                    <i class="fas fa-undo"></i> Rollback
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="button" class="action-btn btn-fresh w-100 justify-content-center"
                                data-toggle="modal" data-target="#freshModal">
                                <i class="fas fa-fire"></i> Migrate Fresh
                            </button>
                        </div>
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        <b>Run Migrate</b> applies pending migrations. <b>Rollback</b> reverts the last batch.
                        <b>Migrate Fresh</b> drops all tables and re-runs everything.
                    </small>
                </div>
            </div>

            {{-- Migration Status Table --}}
            <div class="card tool-card">
                <div class="card-header">
                    <span class="header-icon" style="background:linear-gradient(135deg,#27ae60,#1e8449);">
                        <i class="fas fa-list-check" style="font-size:0.9rem;"></i>
                    </span>
                    Migration Status
                    <span class="ml-auto text-muted" style="font-size:0.8rem;font-weight:400;">
                        {{ count($migrationFiles) }} total
                    </span>
                </div>
                <div class="card-body">

                    {{-- Stats --}}
                    @php
                        $ranCount     = count(array_intersect($migrationFiles, $ranMigrations));
                        $pendingCount = count($migrationFiles) - $ranCount;
                    @endphp
                    <div class="stats-row">
                        <div class="stat-chip total"><i class="fas fa-layer-group"></i> {{ count($migrationFiles) }} Total</div>
                        <div class="stat-chip ran"><i class="fas fa-check-circle"></i> {{ $ranCount }} Ran</div>
                        <div class="stat-chip pending"><i class="fas fa-clock"></i> {{ $pendingCount }} Pending</div>
                    </div>

                    {{-- Filter tabs --}}
                    <div class="filter-tabs">
                        <button class="filter-tab active" onclick="filterMigrations('all', this)">All</button>
                        <button class="filter-tab" onclick="filterMigrations('ran', this)">Ran</button>
                        <button class="filter-tab" onclick="filterMigrations('pending', this)">Pending</button>
                    </div>

                    {{-- Search --}}
                    <div class="search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text" id="migrationSearch" class="migration-search" placeholder="Search migrations..." onkeyup="searchMigrations()">
                    </div>

                    <div class="migration-table-wrap">
                        <table class="table migration-table" id="migrationTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Migration File</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($migrationFiles as $i => $file)
                                    @php $isRan = in_array($file, $ranMigrations); @endphp
                                    <tr class="migration-row" data-status="{{ $isRan ? 'ran' : 'pending' }}">
                                        <td class="text-muted" style="font-family:inherit;font-size:0.82rem;">{{ $i + 1 }}</td>
                                        <td>{{ $file }}</td>
                                        <td>
                                            @if($isRan)
                                                <span class="badge-ran"><i class="fas fa-check mr-1"></i>Ran</span>
                                            @else
                                                <span class="badge-pending"><i class="fas fa-clock mr-1"></i>Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN: Seeders --}}
        <div class="col-lg-5">

            {{-- Run All Seeders --}}
            <div class="card tool-card">
                <div class="card-header">
                    <span class="header-icon" style="background:linear-gradient(135deg,#8e44ad,#6c3483);">
                        <i class="fas fa-seedling" style="font-size:0.9rem;"></i>
                    </span>
                    Run All Seeders
                </div>
                <div class="card-body">
                    <p class="text-muted" style="font-size:0.88rem;">
                        Runs <code>DatabaseSeeder</code> which will call all registered seeders.
                    </p>
                    <form method="POST" action="{{ route('back.artisan.seed.all') }}">
                        @csrf
                        <button type="submit" class="action-btn btn-all-seed w-100 justify-content-center"
                            onclick="return confirm('Run all seeders? This may insert or overwrite data.')">
                            <i class="fas fa-play-circle"></i> Run All Seeders (DatabaseSeeder)
                        </button>
                    </form>
                </div>
            </div>

            {{-- Run Specific Seeder --}}
            <div class="card tool-card">
                <div class="card-header">
                    <span class="header-icon" style="background:linear-gradient(135deg,#27ae60,#1e8449);">
                        <i class="fas fa-leaf" style="font-size:0.9rem;"></i>
                    </span>
                    Run Specific Seeder
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('back.artisan.seed') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size:0.85rem;font-weight:600;">
                                <i class="fas fa-list mr-1"></i> Select Seeder Class
                            </label>
                            <select name="seeder" class="seeder-select" required>
                                <option value="">— Choose a seeder —</option>
                                @foreach($seeders as $seeder)
                                    <option value="{{ $seeder }}">{{ $seeder }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="action-btn btn-seed w-100 justify-content-center"
                            onclick="return confirm('Run the selected seeder?')">
                            <i class="fas fa-play"></i> Run Seeder
                        </button>
                    </form>
                </div>
            </div>

            {{-- Quick Tips --}}
            <div class="card tool-card" style="background:#f8f9fc;">
                <div class="card-header" style="background:#f8f9fc;">
                    <span class="header-icon" style="background:linear-gradient(135deg,#f39c12,#d68910);">
                        <i class="fas fa-lightbulb" style="font-size:0.9rem;"></i>
                    </span>
                    Quick Reference
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0" style="font-size:0.86rem;line-height:1.9;">
                        <li><span class="badge-ran mr-2"><i class="fas fa-check"></i> Ran</span> Migration has been applied to the DB</li>
                        <li class="mt-2"><span class="badge-pending mr-2"><i class="fas fa-clock"></i> Pending</span> Migration has NOT been run yet</li>
                        <li class="mt-3 text-muted"><i class="fas fa-exclamation-triangle mr-1 text-warning"></i> <b>Migrate Fresh</b> drops all tables — use only in development!</li>
                        <li class="mt-1 text-muted"><i class="fas fa-exclamation-triangle mr-1 text-warning"></i> Seeders may overwrite existing data.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

</div>

{{-- Migrate Fresh Confirm Modal --}}
<div class="modal fade" id="freshModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:14px;border:none;overflow:hidden;">
            <div class="modal-header" style="background:linear-gradient(135deg,#e74c3c,#c0392b);border:none;">
                <h5 class="modal-title text-white"><i class="fas fa-fire mr-2"></i>Confirm: Migrate Fresh</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="danger-zone">
                    <p><i class="fas fa-skull-crossbones mr-1"></i> <b>WARNING:</b> This will <strong>DROP ALL TABLES</strong> and re-run all migrations from scratch. All existing data will be permanently lost!</p>
                </div>
                <p class="text-muted" style="font-size:0.88rem;">Only use this in a development/staging environment. Are you absolutely sure?</p>
            </div>
            <div class="modal-footer" style="border:none;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('back.artisan.fresh') }}">
                    @csrf
                    <button type="submit" class="action-btn btn-fresh">
                        <i class="fas fa-fire"></i> Yes, Drop & Migrate
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Filter migrations by status
    var currentFilter = 'all';

    function filterMigrations(status, btn) {
        currentFilter = status;
        document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        applyFilters();
    }

    function searchMigrations() {
        applyFilters();
    }

    function applyFilters() {
        var query = document.getElementById('migrationSearch').value.toLowerCase();
        document.querySelectorAll('.migration-row').forEach(function(row) {
            var text   = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            var status = row.getAttribute('data-status');
            var matchesSearch = text.includes(query);
            var matchesFilter = (currentFilter === 'all') || (status === currentFilter);
            row.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
        });
    }
</script>
@endsection
