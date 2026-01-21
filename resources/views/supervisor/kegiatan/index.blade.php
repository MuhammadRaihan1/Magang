@extends('supervisor.layout')

@section('title', 'Laporan Kegiatan Mahasiswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="m-0">Laporan Kegiatan Mahasiswa</h3>

    <form method="GET" class="d-flex gap-2">
        <select name="status" class="form-select">
            <option value="">Semua</option>
            <option value="Pending"  {{ request('status')=='Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Approved" {{ request('status')=='Approved' ? 'selected' : '' }}>Approved</option>
            <option value="Rejected" {{ request('status')=='Rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        <button class="btn btn-primary">Filter</button>
    </form>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>Tanggal</th>
                    <th>Aktivitas</th>
                    <th>Status</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($kegiatans as $i => $k)
                    <tr>
                        <td>{{ $kegiatans->firstItem() + $i }}</td>
                        <td>{{ $k->mahasiswa->name ?? '-' }}</td>
                        <td>{{ optional($k->tanggal)->format('d-m-Y') }}</td>
                        <td style="max-width:420px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $k->aktivitas }}
                        </td>
                        <td>
                            @if($k->status == 'Pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($k->status == 'Approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('supervisor.kegiatan.show', $k->id) }}">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada laporan.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $kegiatans->links() }}
    </div>
</div>
@endsection
