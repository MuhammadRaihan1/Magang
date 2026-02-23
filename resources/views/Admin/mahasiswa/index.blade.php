@extends('admin.layout')

@section('title','Data Mahasiswa')

@section('content')

<style>
html,body{
    margin:0;
    padding:0;
    background:#e6edf5;
    font-family:"Times New Roman", Times, serif;
}

/* Judul */
.page-title{
    font-size:26px;
    margin:0 6px 10px 6px;
    font-weight:normal;
}

/* Card utama */
.report-box{
    margin:0 3px 20px 3px;
    background:#f8fafc;
    border-radius:16px;
    border:1px solid #cbd5e1;
    overflow:hidden;
    width:calc(100% - 6px);
}

/* Header biru */
.report-header{
    background:#BCC9EE;
    color:#000;
    padding:14px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-size:17px;
}

/* Tombol header */
.header-btn{
    background:#ffffff;
    color:#000;
    padding:6px 18px;
    border-radius:18px;
    text-decoration:none;
    border:1px solid #cbd5e1;
    font-size:14px;
}

/* Tabel */
.report-table{
    width:100%;
    border-collapse:collapse;
    background:#ffffff;
}

/* Header tabel */
.report-table th{
    background:#eef2f7;
    border:1px solid #cfd8e3;
    padding:14px 16px;
    font-size:15px;
    text-align:left;
}

/* Isi tabel */
.report-table td{
    border:1px solid #cfd8e3;
    padding:14px 16px;
    font-size:15px;
}

/* Hover baris */
.report-table tr:hover{
    background:#f1f5f9;
}

/* Aksi hanya teks */
.action-wrapper{
    display:flex;
    gap:12px;
}

.text-edit{
    color:#2563eb;
    text-decoration:none;
    font-size:14px;
}

.text-delete{
    color:#dc2626;
    background:none;
    border:none;
    cursor:pointer;
    font-size:14px;
    padding:0;
}

.text-edit:hover{
    text-decoration:underline;
}

.text-delete:hover{
    text-decoration:underline;
}
</style>

<div class="page-title">
    Data Mahasiswa Magang
</div>

<div class="report-box">

    <div class="report-header">
        <div>Daftar Mahasiswa</div>

        <div>
            <a href="{{ route('admin.mahasiswa.create') }}" class="header-btn">
                + Tambah Mahasiswa
            </a>
        </div>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th style="width:80px;">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th style="width:160px;">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @forelse($mahasiswa as $mhs)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $mhs->name }}</td>
                <td>{{ $mhs->email }}</td>
                <td>
                    <div class="action-wrapper">
                        <a href="{{ route('admin.mahasiswa.edit',$mhs->id) }}" class="text-edit">
                            Edit
                        </a>

                        <form action="{{ route('admin.mahasiswa.destroy',$mhs->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus mahasiswa ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-delete">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align:center;">
                    Belum ada data mahasiswa.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>

@endsection