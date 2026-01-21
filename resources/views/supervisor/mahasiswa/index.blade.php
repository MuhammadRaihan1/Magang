@extends('supervisor.layout')

@section('content')
    <h3 class="fw-bold mb-3">Mahasiswa Bimbingan</h3>

    <div class="bg-white p-3 rounded-4 shadow-sm">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:70px;">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswas as $mhs)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mhs->name }}</td>
                        <td>{{ $mhs->email }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            Belum ada mahasiswa bimbingan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
