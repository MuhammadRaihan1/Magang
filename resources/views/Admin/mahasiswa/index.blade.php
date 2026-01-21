@extends('admin.layout')

@section('title', 'Data Mahasiswa')

@section('content')

    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:16px; flex-wrap:wrap;">
        <h2 style="margin:0;">Data Mahasiswa Magang</h2>
        <a href="{{ route('admin.mahasiswa.create') }}" class="btn">+ Tambah Mahasiswa</a>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <div class="table-card">
        <table class="table-admin">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($mahasiswa as $mhs)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mhs->name }}</td>
                        <td>{{ $mhs->email }}</td>
                        <td>
                            <div class="actions-center">
                                <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}"
                                   class="btn-pill btn-edit-outline">
                                    edit
                                </a>

                                <form action="{{ route('admin.mahasiswa.destroy', $mhs->id) }}"
                                      method="POST"
                                      style="margin:0;"
                                      onsubmit="return confirm('Yakin ingin menghapus mahasiswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-pill btn-delete-outline">
                                        hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center; padding:16px;">
                            Belum ada data mahasiswa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
