@extends('supervisor.layout')

@section('content')
<style>
  body{
    font-family:'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* PAGE HEADER */
  .page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:22px;
    flex-wrap:wrap;
    gap:14px;
  }

  .page-header h3{
    margin:0;
    font-size:26px;
    font-weight:900;
    color:#0f172a;
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

  /* HEADER TABLE – FULL WARNA */
  thead tr{
    background:#c7d2fe; /* selaras dengan dashboard */
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
    width:80px;
  }

  thead th:last-child{
    border-top-right-radius:20px;
  }

  tbody td{
    padding:18px;
    font-size:15px;
    color:#0f172a;
    border-top:1px solid #e5e7eb;
    vertical-align:middle;
  }

  tbody tr{
    transition:.15s ease;
  }

  tbody tr:hover{
    background:#f8fafc;
  }

  .td-name{
    font-weight:700;
  }

  .empty-state{
    text-align:center;
    padding:32px;
    color:#64748b;
    font-weight:600;
  }

  @media(max-width:768px){
    thead th,
    tbody td{
      padding:14px;
      font-size:14px;
    }

    .page-header h3{
      font-size:22px;
    }
  }
</style>

{{-- PAGE HEADER --}}
<div class="page-header">
  <h3>Mahasiswa Bimbingan</h3>
</div>

{{-- TABLE --}}
<div class="table-card">
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
      </tr>
    </thead>

    <tbody>
      @forelse($mahasiswas as $mhs)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td class="td-name">{{ $mhs->name }}</td>
          <td>{{ $mhs->email }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="3" class="empty-state">
            Belum ada mahasiswa bimbingan.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
