@extends('supervisor.layout')

@section('content')
<style>
    .page-title{font-size:32px;font-weight:700;letter-spacing:-.02em;margin-bottom:14px}
    .card-soft{
        background:#fff;
        border:1px solid rgba(0,0,0,.06);
        border-radius:16px;
        box-shadow:0 6px 18px rgba(0,0,0,.06);
    }
    .table-clean{
        width:100%;
        table-layout:auto;
    }
    .table-clean thead th{
        font-size:13px;
        font-weight:600;
        color:#6c757d;
        background:#f8f9fa;
        border-bottom:1px solid rgba(0,0,0,.06);
        padding:14px 16px;
        vertical-align:middle;
        white-space:nowrap;
    }
    .table-clean tbody td{
        padding:16px;
        border-top:1px solid rgba(0,0,0,.06);
        vertical-align:middle;
    }
    .table-clean tbody tr:hover{background:#fbfbfb}
    .pill-soft{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:.25rem .65rem;
        border-radius:999px;
        background:#f1f3f5;
        border:1px solid #e9ecef;
        color:#495057;
        font-size:13px;
        white-space:nowrap;
    }
    .btn-soft{
        border-radius:10px;
        padding:.45rem .75rem;
    }
    .btn-ghost{
        background:#fff;
        border:1px solid rgba(0,0,0,.12);
    }
    .btn-ghost:hover{background:#f8f9fa}
    .btn-primary-soft{
        border:0;
        border-radius:10px;
        padding:.55rem 1rem;
    }
    .col-no{width:70px}
    .col-hasil{width:200px}
    .col-aksi{width:220px}
</style>

<h1 class="page-title">Evaluasi Mahasiswa</h1>
<div class="text-muted mb-3">Daftar mahasiswa bimbingan dan hasil evaluasinya</div>

@if(session('success'))
    <div class="alert alert-success py-2 mb-3">{{ session('success') }}</div>
@endif

<div class="card-soft overflow-hidden w-100">
    <div class="table-responsive">
        <table class="table table-clean mb-0">
            <thead>
                <tr>
                    <th class="col-no text-center">No</th>
                    <th>Mahasiswa</th>
                    <th>Email</th>
                    <th class="col-hasil text-center">Hasil</th>
                    <th class="col-aksi text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($mahasiswas as $mhs)
                    @php
                        $ev = $evaluasiMap[$mhs->id] ?? null;
                        $nilai = $ev?->nilai;
                    @endphp

                    <tr>
                        <td class="text-center text-muted">{{ $loop->iteration }}</td>

                        <td class="fw-semibold">{{ $mhs->name }}</td>

                        <td class="text-muted">{{ $mhs->email }}</td>

                        <td class="text-center">
                            @if($ev)
                                <span class="text-muted me-1">Nilai</span>
                                <span class="fw-semibold">{{ number_format((float) $nilai, 2) }}</span>
                            @else
                                <span class="pill-soft">Belum dinilai</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a href="{{ route('supervisor.evaluasi.create', $mhs->id) }}"
                               class="btn {{ $ev ? 'btn-ghost' : 'btn-primary' }} {{ $ev ? 'btn-soft btn-sm' : 'btn-primary-soft btn-sm' }}">
                                {{ $ev ? 'Edit Evaluasi' : 'Isi Evaluasi' }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            Belum ada mahasiswa bimbingan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
