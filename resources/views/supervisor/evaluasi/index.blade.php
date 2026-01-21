@extends('supervisor.layout')

@section('content')
<h3 class="fw-bold mb-3">Evaluasi Mahasiswa</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="bg-white p-3 rounded-4 shadow-sm">
    <table class="table table-striped align-middle mb-0">
        <thead>
            <tr>
                <th style="width:70px;">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th style="width:160px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mahasiswas as $mhs)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mhs->name }}</td>
                    <td>{{ $mhs->email }}</td>
                    <td>
                        <a href="{{ route('supervisor.evaluasi.create', $mhs->id) }}" class="btn btn-primary btn-sm">
                            Isi Evaluasi
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        Belum ada mahasiswa bimbingan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
