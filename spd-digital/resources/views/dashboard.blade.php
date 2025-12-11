{{-- 
    Dashboard SPD Digital
    Refactored for better maintainability
--}}

@php
    // Configuration
    $colors = [
        'primary' => '#116e27',
        'secondary' => '#ddaf30',
        'background' => '#f4f6f9',
        'card' => '#ffffff',
        'hover' => '#f8fafc',
        'border' => '#e2e8f0',
        'text_muted' => '#666666',
    ];
    
    $breakpoints = [
        'mobile_s' => '375px',
        'mobile_m' => '480px',
        'mobile_l' => '600px',
        'tablet' => '768px',
        'tablet_landscape' => '1024px',
    ];
    
    // Data fetching - should be in controller ideally
    $searchQuery = request('search');
    $pegawaiQuery = \App\Models\MaPegawai::query();
    
    if ($searchQuery) {
        $pegawaiQuery->where(function($q) use ($searchQuery) {
            $q->where('nip', 'like', "%{$searchQuery}%")
              ->orWhere('nama', 'like', "%{$searchQuery}%");
        });
    }
    
    $pegawaiList = $pegawaiQuery->orderBy('nama')->get();
    $totalPegawai = \App\Models\MaPegawai::count();
    $isAdmin = auth()->user()->role === 'admin';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - SPD Digital</title>
    <style>
        /* ========================================
           BASE STYLES
           ======================================== */
        :root {
            --color-primary: {{ $colors['primary'] }};
            --color-secondary: {{ $colors['secondary'] }};
            --color-bg: {{ $colors['background'] }};
            --color-card: {{ $colors['card'] }};
            --color-hover: {{ $colors['hover'] }};
            --color-border: {{ $colors['border'] }};
            --color-text-muted: {{ $colors['text_muted'] }};
            
            --spacing-xs: 8px;
            --spacing-sm: 12px;
            --spacing-md: 20px;
            --spacing-lg: 30px;
            --spacing-xl: 40px;
            
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 12px;
            --radius-full: 50px;
            
            --shadow-sm: 0 2px 10px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 15px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: var(--color-bg);
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* ========================================
           HEADER
           ======================================== */
        .header {
            background: var(--color-primary);
            color: white;
            padding: var(--spacing-md);
            text-align: center;
            position: relative;
        }
        
        .header__title {
            margin: 0;
            font-size: 1.5em;
        }
        
        .header__logout {
            position: absolute;
            right: var(--spacing-md);
            top: var(--spacing-md);
            background: var(--color-secondary);
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s;
        }
        
        .header__logout:hover {
            opacity: 0.9;
        }

        /* ========================================
           LAYOUT
           ======================================== */
        .container {
            max-width: 1200px;
            margin: var(--spacing-lg) auto;
            padding: 0 var(--spacing-md);
        }
        
        .card {
            background: var(--color-card);
            border-radius: var(--radius-lg);
            padding: 25px;
            box-shadow: var(--shadow-md);
            margin-bottom: var(--spacing-lg);
        }

        /* ========================================
           USER INFO
           ======================================== */
        .user-info {
            background: var(--color-card);
            padding: 15px;
            border-radius: var(--radius-md);
            margin-bottom: var(--spacing-md);
            font-size: 1.1em;
        }

        /* ========================================
           MENU GRID (Admin Only)
           ======================================== */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-xl);
        }
        
        .menu-item {
            background: var(--color-hover);
            padding: 25px;
            border-radius: var(--radius-md);
            text-align: center;
            border: 1px solid var(--color-border);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        
        .menu-item__title {
            margin-top: 0;
            color: var(--color-primary);
        }
        
        .menu-item__link {
            color: var(--color-primary);
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin: 8px 0;
            transition: color 0.3s;
        }
        
        .menu-item__link:hover {
            color: var(--color-secondary);
        }

        /* ========================================
           SECTION DIVIDER
           ======================================== */
        .section-divider {
            margin: var(--spacing-xl) 0;
            border: none;
            border-top: 2px solid var(--color-border);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: var(--spacing-md);
            color: var(--color-primary);
        }

        /* ========================================
           SEARCH FORM
           ======================================== */
        .search-container {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .search-form {
            display: inline-block;
            width: 100%;
            max-width: 600px;
        }
        
        .search-input {
            padding: 14px 25px;
            width: 100%;
            max-width: 500px;
            border: 2px solid var(--color-secondary);
            border-radius: var(--radius-full);
            font-size: 16px;
            outline: none;
            box-shadow: var(--shadow-sm);
            transition: border-color 0.3s;
        }
        
        .search-input:focus {
            border-color: var(--color-primary);
        }
        
        .search-button {
            padding: 14px 30px;
            background: var(--color-secondary);
            color: white;
            border: none;
            border-radius: var(--radius-full);
            cursor: pointer;
            font-weight: bold;
            margin-left: 10px;
            transition: opacity 0.3s;
        }
        
        .search-button:hover {
            opacity: 0.9;
        }
        
        .search-reset {
            margin-left: 15px;
            color: #dc3545;
            text-decoration: underline;
            font-weight: bold;
        }

        /* ========================================
           TABLE
           ======================================== */
        .table-container {
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: var(--spacing-md);
        }
        
        .table__header {
            background: var(--color-primary);
            color: white;
        }
        
        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .table tr:hover {
            background: var(--color-hover);
        }
        
        .table__cell--center {
            text-align: center;
        }
        
        .table__cell--bold {
            font-weight: bold;
        }
        
        .table__empty {
            text-align: center;
            padding: 50px;
            color: #999;
            font-size: 1.1em;
        }

        /* ========================================
           RESPONSIVE DESIGN
           ======================================== */
        
        /* Tablet (768px and below) */
        @media (max-width: {{ $breakpoints['tablet'] }}) {
            .header__title {
                font-size: 1.3em;
                padding-right: 100px;
            }
            
            .header__logout {
                right: 10px;
                top: 15px;
                padding: 8px 15px;
                font-size: 0.9em;
            }
            
            .container {
                margin: var(--spacing-md) auto;
                padding: 0 15px;
            }
            
            .card {
                padding: var(--spacing-md);
            }
            
            .menu-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .menu-item {
                padding: var(--spacing-md);
            }
            
            .table {
                font-size: 0.9em;
            }
            
            .table th,
            .table td {
                padding: 10px 8px;
                white-space: nowrap;
            }
            
            .search-input {
                width: calc(100% - 120px);
                max-width: calc(100% - 120px);
                font-size: 14px;
            }
            
            .search-button {
                width: auto;
                margin-top: 8px;
                font-size: 14px;
            }
        }
        
        /* Mobile Large (600px and below) */
        @media (max-width: {{ $breakpoints['mobile_l'] }}) {
            .header__title {
                font-size: 1.1em;
                padding-right: 95px;
            }
            
            .search-input {
                width: 100%;
                max-width: 100%;
                margin-bottom: 10px;
            }
            
            .search-button {
                width: 100%;
                margin-left: 0;
                margin-top: 0;
            }
            
            .table {
                font-size: 0.85em;
            }
        }
        
        /* Mobile Medium (480px and below) */
        @media (max-width: {{ $breakpoints['mobile_m'] }}) {
            .header {
                padding: 15px 10px;
            }
            
            .header__title {
                font-size: 0.95em;
                padding-right: 88px;
                line-height: 1.3;
            }
            
            .header__logout {
                padding: 6px 12px;
                font-size: 0.85em;
            }
            
            .card {
                padding: 15px;
                border-radius: var(--radius-md);
            }
            
            .menu-item {
                padding: 15px;
            }
            
            .table {
                font-size: 0.78em;
            }
            
            .table th,
            .table td {
                padding: 8px 5px;
            }
            
            .search-input {
                padding: 11px 16px;
                font-size: 13px;
            }
            
            .search-button {
                padding: 11px 22px;
                font-size: 13px;
            }
        }
        
        /* Mobile Small (375px and below) */
        @media (max-width: {{ $breakpoints['mobile_s'] }}) {
            .header {
                padding: 12px 8px;
            }
            
            .header__title {
                font-size: 0.85em;
                padding-right: 82px;
            }
            
            .header__logout {
                padding: 5px 10px;
                font-size: 0.8em;
            }
            
            .container {
                padding: 0 8px;
            }
            
            .card {
                padding: var(--spacing-sm);
            }
            
            .table {
                font-size: 0.72em;
            }
            
            .table th,
            .table td {
                padding: 7px 4px;
            }
            
            .search-input {
                padding: 10px 14px;
                font-size: 12px;
            }
            
            .search-button {
                padding: 10px 20px;
                font-size: 12px;
            }
        }
        
        /* Tablet Landscape (769px - 1024px) */
        @media (min-width: 769px) and (max-width: {{ $breakpoints['tablet_landscape'] }}) {
            .container {
                max-width: 95%;
            }
            
            .menu-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    {{-- HEADER --}}
    <div class="header">
        <h1 class="header__title">SPD DIGITAL - MAHKAMAH AGUNG RI</h1>
        <a href="{{ route('login') }}" 
           class="header__logout" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>

    {{-- MAIN CONTAINER --}}
    <div class="container">
        <div class="card">
            {{-- USER INFO --}}
            <div class="user-info">
                <strong>Hi, {{ auth()->user()->name }}!</strong><br>
                @if(auth()->user()->nip)
                    NIP: {{ auth()->user()->nip }}
                @endif
            </div>

            {{-- ADMIN MENU --}}
            @if($isAdmin)
                <h2 class="section-title">Main Menu</h2>
                <div class="menu-grid">
                    <div class="menu-item">
                        <h3 class="menu-item__title">Group Surat Tugas</h3>
                        <p>
                            <a href="{{ url('/admin/group-st/create') }}" class="menu-item__link">
                                + Buat Group ST Baru
                            </a>
                        </p>
                        <p>
                            <a href="{{ url('/admin/group-st') }}" class="menu-item__link">
                                Lihat Semua Group ST
                            </a>
                        </p>
                    </div>
                    <div class="menu-item">
                        <h3 class="menu-item__title">Perjalanan Dinas</h3>
                        <p>
                            <a href="{{ url('/admin/perjalanan-dinas/create') }}" class="menu-item__link">
                                + Input Perjalanan Dinas
                            </a>
                        </p>
                        <p>
                            <a href="{{ url('/admin/perjalanan-dinas') }}" class="menu-item__link">
                                Lihat Semua Data
                            </a>
                        </p>
                    </div>
                </div>

                <hr class="section-divider">

                <h2 class="section-title">
                    Database Mahkamah Agung ({{ number_format($totalPegawai) }} orang)
                </h2>
            @endif

            {{-- SEARCH FORM --}}
            <div class="search-container">
                <form method="GET" action="{{ route('dashboard') }}" class="search-form">
                    <input type="text" 
                           name="search" 
                           value="{{ $searchQuery }}" 
                           placeholder="Cari NIP atau Nama Pegawai..." 
                           class="search-input"
                           autofocus>
                    <button type="submit" class="search-button" style="margin-top: 10px;">
                        Cari
                    </button>
                    @if($searchQuery)
                        <a href="{{ route('dashboard') }}" class="search-reset">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- DATA TABLE --}}
            <div class="table-container">
                <table class="table">
                    <thead class="table__header">
                        <tr>
                            <th class="table__cell--center">No</th>
                            <th>NIP</th>
                            <th>Nama Lengkap</th>
                            <th>Pangkat/Gol.</th>
                            <th>Jabatan</th>
                            <th>Satker</th>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Bandara</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pegawaiList as $pegawai)
                        <tr>
                            <td class="table__cell--center table__cell--bold">
                                {{ $loop->iteration }}
                            </td>
                            <td class="table__cell--bold">{{ $pegawai->nip }}</td>
                            <td class="table__cell--bold">{{ $pegawai->nama }}</td>
                            <td>{{ $pegawai->gol ?? '-' }}</td>
                            <td>{{ $pegawai->jabatan ?? '-' }}</td>
                            <td>{{ $pegawai->satker ?? '-' }}</td>
                            <td>{{ $pegawai->asal ?? '-' }}</td>
                            <td>{{ $pegawai->tujuan ?? '-' }}</td>
                            <td>{{ $pegawai->bandara ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="table__empty">
                                @if($searchQuery)
                                    Tidak ditemukan pegawai dengan kata kunci "<strong>{{ $searchQuery }}</strong>"
                                @else
                                    Belum ada data pegawai.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>