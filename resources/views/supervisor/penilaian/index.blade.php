@extends('supervisor.layout')

@section('title', 'Penilaian Mahasiswa')

@section('content')

<style>
body{
    font-family:"Times New Roman", Times, serif;
}

.wrapper-box{
    background:#f8fafc;
    border:1px solid #d1d5db;
    border-radius:6px;
    overflow:hidden;
}

.top-header{
    background:#5b8bd9;
    color:#fff;
    padding:10px 16px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.top-header h3{
    margin:0;
    font-size:16px;
    font-weight:normal;
}

.filter-select{
    padding:4px 8px;
    font-size:13px;
    border-radius:4px;
    border:none;
}

.alert-success{
    background:#f0f9ff;
    border:1px solid #d1d5db;
    padding:10px 16px;
    margin-bottom:12px;
    font-size:14px;
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
    padding:8px;
    font-size:13px;
    font-weight:normal;
    border:1px solid #e5e7eb;
    text-align:left;
}

tbody td{
    padding:8px;
    font-size:13px;
    border:1px solid #e5e7eb;
}

tbody tr:nth-child(even){
    background:#f9fafb;
}

.center{
    text-align:center;
}

.status-belum{
    color:#64748b;
}

.grade-a{ color:#16a34a; }
.grade-b{ color:#2563eb; }
.grade-c{ color:#f59e0b; }
.grade-d{ color:#dc2626; }

.aksi-group{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
}

.btn-action{
    padding:4px 10px;
    font-size:12px;
    background:#5b8bd9;
    color:#fff;
    border:none;
    border-radius:4px;
    text-decoration:none;
    display:inline-block;
}

.btn-action:hover{
    background:#4a78c2;
}

.btn-primary-soft{
    padding:4px 12px;
    font-size:12px;
    background:#2563eb;
    color:#fff;
    border:none;
    border-radius:4px;
    text-decoration:none;
    display:inline-block;
}

.btn-primary-soft:hover{
    background:#1e40af;
}

.btn-print-img{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:0;
}

.btn-print-img img{
    width:22px;
    height:22px;
    object-fit:contain;
}
</style>

<h3 style="margin-bottom:15px;">Penilaian Akhir Mahasiswa</h3>

@if(session('success'))
<div class="alert-success">
    {{ session('success') }}
</div>
@endif

<div class="wrapper-box">

    <div class="top-header">
        <h3>Data Penilaian Mahasiswa</h3>

        <form method="GET">
            <select name="status_nilai"
                    class="filter-select"
                    onchange="this.form.submit()">

                <option value="">Semua</option>
                <option value="sudah"
                    {{ request('status_nilai') == 'sudah' ? 'selected' : '' }}>
                    Sudah Dinilai
                </option>
                <option value="belum"
                    {{ request('status_nilai') == 'belum' ? 'selected' : '' }}>
                    Belum Dinilai
                </option>
            </select>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:60px;">No</th>
                <th>Mahasiswa</th>
                <th>Email</th>
                <th style="width:200px;">Hasil</th>
                <th style="width:260px;" class="center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($mahasiswa as $i => $mhs)
                @php
                    $p = $mhs->penilaians->first();
                    $grade = $p->grade ?? null;
                    $gradeClass = '';
                    if ($grade === 'A') $gradeClass = 'grade-a';
                    elseif ($grade === 'B') $gradeClass = 'grade-b';
                    elseif ($grade === 'C') $gradeClass = 'grade-c';
                    elseif (in_array($grade, ['D','E'])) $gradeClass = 'grade-d';
                @endphp

                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $mhs->name }}</td>
                    <td>{{ $mhs->email }}</td>

                    <td>
                        @if($p)
                            Nilai: {{ number_format($p->nilai_akhir, 2) }} |
                            <span class="{{ $gradeClass }}">{{ $grade }}</span>
                        @else
                            <span class="status-belum">Belum dinilai</span>
                        @endif
                    </td>

                    <td class="center">
                        <div class="aksi-group">
                            @if($p)
                                <a class="btn-action" href="{{ route('supervisor.penilaian.show', $mhs->id) }}">Detail</a>
                                <a class="btn-action" href="{{ route('supervisor.penilaian.edit', $mhs->id) }}">Edit</a>

                                <a class="btn-print-img"
                                   href="{{ route('supervisor.penilaian.cetak.pdf', $mhs->id) }}"
                                   target="_blank"
                                   title="Cetak PDF">
                                    <img src="{{ asset('images/logoprint.png') }}" alt="Cetak">
                                </a>
                            @else
                                <a class="btn-primary-soft" href="{{ route('supervisor.penilaian.create', $mhs->id) }}">
                                    Isi Penilaian
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="center">
                        Data mahasiswa tidak ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection