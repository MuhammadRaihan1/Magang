@extends('admin.layout')

@section('title','Data Supervisor')

@section('content')

<style>
html,body{
    margin:0;
    padding:0;
    background:#e6edf5;
    font-family:"Times New Roman", Times, serif;
}


.page-title{
    font-size:26px;
    margin:0 6px 10px 6px;
    font-weight:normal;
}


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


.header-btn{
    background:#ffffff;
    color:#000;
    padding:6px 18px;
    border-radius:18px;
    text-decoration:none;
    border:1px solid #cbd5e1;
    font-size:14px;
}


.alert-success{
    background:#ecfeff;
    border-left:6px solid #2563eb;
    padding:12px 16px;
    margin:12px 6px;
    border-radius:8px;
}


.report-table{
    width:100%;
    border-collapse:collapse;
    background:#ffffff;
}


.report-table th{
    background:#eef2f7;
    border:1px solid #cfd8e3;
    padding:14px 16px;
    font-size:15px;
    text-align:left;
}


.report-table td{
    border:1px solid #cfd8e3;
    padding:14px 16px;
    font-size:15px;
}


.report-table tr:hover{
    background:#f1f5f9;
}


.action-wrapper{
    display:flex;
    gap:14px;
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
    Data Supervisor
</div>

<div class="report-box">

    <div class="report-header">
        <div>Daftar Supervisor</div>

        <div>
            <a href="{{ route('admin.supervisor.create') }}" class="header-btn">
                + Tambah Supervisor
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

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
        @forelse($supervisors as $spv)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $spv->name }}</td>
                <td>{{ $spv->email }}</td>
                <td>
                    <div class="action-wrapper">

                        <a href="{{ route('admin.supervisor.edit',$spv->id) }}" class="text-edit">
                            Edit
                        </a>

                        <form action="{{ route('admin.supervisor.destroy',$spv->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin hapus supervisor ini?')">
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
                    Belum ada data supervisor.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>

@endsection