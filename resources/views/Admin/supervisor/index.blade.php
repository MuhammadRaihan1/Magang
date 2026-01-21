@extends('admin.layout')

@section('title', 'Data Supervisor')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:18px;">
        <h2 style="margin:0; font-size:26px; font-weight:800;">Data Supervisor</h2>
        <a class="btn" href="{{ route('admin.supervisor.create') }}">+ Tambah Supervisor</a>
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
            @forelse($supervisors as $spv)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $spv->name }}</td>
                    <td>{{ $spv->email }}</td>
                    <td>
                        <div class="actions-center">
                            <a href="{{ route('admin.supervisor.edit', $spv->id) }}"
                               class="btn-pill btn-edit-outline">
                                edit
                            </a>

                            <form action="{{ route('admin.supervisor.destroy', $spv->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus supervisor ini?')">
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
                    <td colspan="4" style="text-align:center; padding:20px;">
                        Belum ada data supervisor.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
