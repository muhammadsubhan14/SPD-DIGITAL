<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - SPD Digital</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin:0; padding:0; }
        .header { background: #1d4ed8; color: white; padding: 20px; text-align: center; position:relative; }
        .logout { position:absolute; right:20px; top:20px; background:#dc3545; padding:10px 20px; border-radius:6px; color:white; text-decoration:none; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .menu-item { background: #f8fafc; padding: 25px; border-radius: 10px; text-align: center; border: 1px solid #e2e8f0; transition:0.3s; }
        .menu-item:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .menu-item a { color: #1d4ed8; font-weight: bold; font-size: 1.1em; text-decoration: none; }
        table { width:100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding:12px; text-align:left; border-bottom:1px solid #ddd; }
        th { background:#1d4ed8; color:white; }
        tr:hover { background:#f8fafc; }
        .user-info { background:#e0f2fe; padding:15px; border-radius:8px; margin-bottom:20px; font-size:1.1em; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SPD DIGITAL - MAHKAMAH AGUNG RI</h1>
        <a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </div>

    <div class="container">
        <div class="card">
            <div class="user-info">
                <strong>Selamat Datang, {{ auth()->user()->name }}!</strong><br>
                Role: <strong>{{ ucfirst(auth()->user()->role) }}</strong>
                @if(auth()->user()->nip) | NIP: {{ auth()->user()->nip }}@endif
            </div>

            @if(auth()->user()->role === 'admin')
                <h2 style="text-align:center; margin-bottom:30px;">Main Menu</h2>
                <div class="menu-grid">
                    <div class="menu-item">
                        <h3>Group Surat Tugas</h3>
                        <p><a href="{{ url('/admin/group-st/create') }}">+ Buat Group ST Baru</a></p>
                        <p><a href="{{ url('/admin/group-st') }}">Lihat Semua Group ST</a></p>
                    </div>
                    <div class="menu-item">
                        <h3>Perjalanan Dinas</h3>
                        <p><a href="{{ url('/admin/perjalanan-dinas/create') }}">+ Input Perjalanan Dinas</a></p>
                        <p><a href="{{ url('/admin/perjalanan-dinas') }}">Lihat Semua Data</a></p>
                    </div>
                </div>

                                <hr style="margin:40px 0;">

                <h2 style="text-align:center; margin-bottom:20px;">
                    Data Pegawai Mahkamah Agung ({{ \App\Models\MaPegawai::count() }} orang)
                </h2>

                <!-- SEARCH BAR CANTIK DI TENGAH -->
                <div style="text-align:center; margin-bottom:25px;">
                    <form method="GET" action="{{ route('dashboard') }}">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari NIP atau Nama Pegawai..." 
                               style="padding:14px 25px; width:500px; max-width:90%; border:2px solid #1d4ed8; border-radius:50px; font-size:16px; outline:none; box-shadow:0 2px 10px rgba(0,0,0,0.1);"
                               autofocus>
                        <button type="submit" 
                                style="padding:14px 30px; background:#1d4ed8; color:white; border:none; border-radius:50px; cursor:pointer; font-weight:bold; margin-left:10px;">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('dashboard') }}" 
                               style="margin-left:15px; color:#dc3545; text-decoration:underline; font-weight:bold;">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID</th>
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
                            @php
                                $query = \App\Models\MaPegawai::query();
                                if (request('search')) {
                                    $query->where('nip', 'like', '%'.request('search').'%')
                                          ->orWhere('nama', 'like', '%'.request('search').'%');
                                }
                                $pegawai = $query->orderBy('nama')->get();
                            @endphp

                            @forelse($pegawai as $index => $p)
                            <tr>
                                <td style="text-align:center; font-weight:bold;">{{ $loop->iteration }}</td>
                                <td>{{ $p->id }}</td>
                                <td><strong>{{ $p->nip }}</strong></td>
                                <td><strong>{{ $p->nama }}</strong></td>
                                <td>{{ $p->pangkat ?? '-' }}</td>
                                <td>{{ $p->jabatan ?? '-' }}</td>
                                <td>{{ $p->satker ?? '-' }}</td>
                                <td>{{ $p->asal ?? '-' }}</td>
                                <td>{{ $p->tujuan ?? '-' }}</td>
                                <td>{{ $p->bandara ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" style="text-align:center; padding:50px; color:#999; font-size:1.1em;">
                                    @if(request('search'))
                                        Tidak ditemukan pegawai dengan kata kunci "<strong>{{ request('search') }}</strong>"
                                    @else
                                        Belum ada data pegawai.
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align:center; padding:50px; color:#666;">
                    <h2>Halo, {{ auth()->user()->name }}!</h2>
                    <p>Silakan hubungi admin untuk mengakses fitur input data.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>