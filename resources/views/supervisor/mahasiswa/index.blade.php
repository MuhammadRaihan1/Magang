@extends('supervisor.layout')

@section('content')

<style>
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
    font-weight:600;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.table-header h4{
    margin:0;
    font-size:15px;
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
    font-weight:600;
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
</style>

<h3 style="margin-bottom:15px;">Mahasiswa Bimbingan</h3>

<div class="table-wrapper">

    <div class="table-header">
        <h4>Data Mahasiswa Bimbingan</h4>

        <form method="GET">
            <select name="status"
                    class="filter-select"
                    onchange="this.form.submit()">

                <option value="">Semua</option>
                <option value="aktif"
                    {{ request('status') == 'aktif' ? 'selected' : '' }}>
                    Mahasiswa Aktif
                </option>
                <option value="selesai"
                    {{ request('status') == 'selesai' ? 'selected' : '' }}>
                    Mahasiswa Selesai
                </option>
            </select>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:60px;">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status Magang</th>
            </tr>
        </thead>

        <tbody>
            @forelse($mahasiswas as $mhs)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mhs->name }}</td>
                    <td>{{ $mhs->email }}</td>
                    <td>
                        @if($mhs->status_magang == 'Selesai')
                            <span class="status-selesai">Selesai</span>
                        @else
                            <span class="status-aktif">Aktif</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:15px;">
                        Tidak ada data mahasiswa.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection