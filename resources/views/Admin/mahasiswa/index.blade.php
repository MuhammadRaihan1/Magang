@extends('admin.layout')

@section('title', 'Data Mahasiswa')

@section('content')
<style>
  body{
    font-family:'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* HEADER PAGE */
  .page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:22px;
    flex-wrap:wrap;
    gap:14px;
  }

  .page-header h2{
    margin:0;
    font-size:28px;
    font-weight:900;
    color:#0f172a;
  }

  .btn-add{
    padding:10px 20px;
    border-radius:12px;
    background:#2563eb;
    color:#fff;
    font-weight:800;
    text-decoration:none;
    box-shadow:0 10px 22px rgba(37,99,235,.35);
    transition:.2s ease;
  }

  .btn-add:hover{
    transform:translateY(-2px);
  }

  /* TABLE CARD */
  .table-card{
    background:#ffffff;
    border-radius:20px;
    box-shadow:0 22px 45px rgba(15,23,42,.08);
    padding:0;
  }

  table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
  }

  /* === HEADER TABLE FULL WARNA KIRI–KANAN === */
  thead tr{
    background:#c7d2fe; /* sama seperti sidebar */
  }

  thead th{
    padding:18px;
    font-size:13px;
    font-weight:900;
    color:#1e293b;
    text-transform:uppercase;
    letter-spacing:.6px;
    text-align:left;
  }

  thead th:first-child{
    border-top-left-radius:20px;
  }

  thead th:last-child{
    border-top-right-radius:20px;
    text-align:center;
  }

  tbody td{
    padding:18px;
    font-size:15px;
    color:#0f172a;
    border-top:1px solid #e5e7eb;
  }

  tbody tr:hover{
    background:#f8fafc;
  }

  .td-name{
    font-weight:700;
  }

  /* ACTION */
  .actions{
    display:flex;
    justify-content:center;
    gap:10px;
  }

  .btn-pill{
    padding:6px 18px;
    border-radius:999px;
    font-size:13px;
    font-weight:800;
    background:#fff;
    cursor:pointer;
    transition:.15s ease;
  }

  .btn-edit{
    color:#2563eb;
    border:2px solid #2563eb;
  }

  .btn-edit:hover{
    background:#2563eb;
    color:#fff;
  }

  .btn-delete{
    color:#dc2626;
    border:2px solid #dc2626;
  }

  .btn-delete:hover{
    background:#dc2626;
    color:#fff;
  }

  @media(max-width:768px){
    thead th,
    tbody td{
      padding:14px;
      font-size:14px;
    }
  }
</style>

{{-- PAGE HEADER --}}
<div class="page-header">
  <h2>Data Mahasiswa Magang</h2>
  <a href="{{ route('admin.mahasiswa.create') }}" class="btn-add">
    + Tambah Mahasiswa
  </a>
</div>

{{-- TABLE --}}
<div class="table-card">
  <table>
    <thead>
      <tr>
        <th style="width:80px;">No</th>
        <th>Nama</th>
        <th>Email</th>
        <th style="width:200px; text-align:center;">Aksi</th>
      </tr>
    </thead>

    <tbody>
      @forelse($mahasiswa as $mhs)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td class="td-name">{{ $mhs->name }}</td>
          <td>{{ $mhs->email }}</td>
          <td>
            <div class="actions">
              <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}" class="btn-pill btn-edit">
                Edit
              </a>

              <form action="{{ route('admin.mahasiswa.destroy', $mhs->id) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus mahasiswa ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-pill btn-delete">
                  Hapus
                </button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" style="text-align:center; padding:26px; color:#64748b;">
            Belum ada data mahasiswa.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
