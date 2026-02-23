@extends('supervisor.layout')

@section('title', 'Laporan Kegiatan Mahasiswa')

@section('content')

<style>
body{
    font-family:"Times New Roman", Times, serif;
}

.table-wrapper{
    background:#f8fafc;
    border:1px solid #d1d5db;
    border-radius:6px;
    overflow:hidden;
}

.table-header{
    background:#5b8bd9;
    color:#fff;
    padding:10px 16px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.table-header h4{
    margin:0;
    font-size:14px;
    font-weight:normal;
}

.filter-select{
    padding:4px 8px;
    font-size:13px;
    border-radius:4px;
    border:none;
}

table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
}

thead{
    background:#f1f5f9;
}

thead th{
    padding:10px;
    font-size:13px;
    font-weight:normal;
    text-align:left;
    border:1px solid #e5e7eb;
}

tbody td{
    padding:10px;
    font-size:13px;
    border:1px solid #e5e7eb;
}

tbody tr:nth-child(even){
    background:#f9fafb;
}

tbody tr:hover{
    background:#eef2f7;
}

.status-aktif{
    color:#2563eb;
    font-weight:600;
}

.status-selesai{
    color:#16a34a;
    font-weight:600;
}

.btn-detail{
    padding:4px 8px;
    font-size:12px;
    background:#5b8bd9;
    color:#fff;
    border:none;
    border-radius:4px;
    text-decoration:none;
}

.btn-detail:hover{
    background:#4a78c2;
}
</style>

<h3 style="margin-bottom:15px; font-weight:normal;">Laporan Kegiatan Mahasiswa</h3>

<div class="table-wrapper">

    <div class="table-header">
        <h4>Data Laporan</h4>

        @if(isset($mahasiswas))
            <form method="GET">
                <select name="status_magang"
                        class="filter-select"
                        onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="aktif"
                        {{ request('status_magang') == 'aktif' ? 'selected' : '' }}>
                        Mahasiswa Aktif
                    </option>
                    <option value="selesai"
                        {{ request('status_magang') == 'selesai' ? 'selected' : '' }}>
                        Mahasiswa Selesai
                    </option>
                </select>
            </form>
        @endif
    </div>

    @if(isset($mahasiswas))

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>Status Magang</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($mahasiswas as $i => $m)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $m->name }}</td>
                        <td>
                            @if($m->penilaianTerakhir && $m->penilaianTerakhir->nilai_akhir)
                                <span class="status-selesai">Selesai</span>
                            @else
                                <span class="status-aktif">Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('supervisor.kegiatan.index', ['mahasiswa_id' => $m->id]) }}"
                               class="btn-detail">
                                Lihat Laporan
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding:15px;">
                            Tidak ada mahasiswa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    @endif


    @if(isset($kegiatans))

        <div style="padding:10px;">
            <a href="{{ route('supervisor.kegiatan.index') }}"
               class="btn-detail">
               ← Kembali ke Daftar Mahasiswa
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Aktivitas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($kegiatans as $i => $k)
                    <tr>
                        <td>{{ $kegiatans->firstItem() + $i }}</td>
                        <td>{{ optional($k->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $k->aktivitas }}</td>
                        <td>{{ $k->status }}</td>
                        <td>
                            <a href="{{ route('supervisor.kegiatan.show', $k->id) }}"
                               class="btn-detail">
                               Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:15px;">
                            Belum ada laporan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="padding:10px;">
            {{ $kegiatans->links() }}
        </div>

    @endif

</div>

@endsection