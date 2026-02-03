@extends('supervisor.layout')

@section('title', 'Laporan Kegiatan Mahasiswa')

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
    gap:16px;
  }

  .page-header h3{
    margin:0;
    font-size:26px;
    font-weight:900;
    color:#0f172a;
  }

  /* FILTER */
  .filter-box{
    display:flex;
    gap:10px;
  }

  .filter-box select{
    border-radius:10px;
    font-weight:600;
  }

  .filter-box button{
    border-radius:10px;
    font-weight:700;
  }

  /* ALERT */
  .alert-success{
    background:#ecfeff;
    color:#0f172a;
    border-left:6px solid #2563eb;
    padding:14px 18px;
    border-radius:12px;
    margin-bottom:20px;
    font-weight:600;
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

  /* HEADER TABLE */
  thead tr{
    background:#c7d2fe;
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
    width:70px;
  }

  thead th:last-child{
    border-top-right-radius:20px;
    text-align:center;
    width:140px;
  }

  tbody td{
    padding:18px;
    font-size:15px;
    color:#0f172a;
    border-top:1px solid #e5e7eb;
    vertical-align:middle;
  }

  tbody tr:hover{
    background:#f8fafc;
  }

  .td-ellipsis{
    max-width:420px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
  }

  /* STATUS BADGE */
  .badge{
    font-size:12px;
    font-weight:800;
    padding:6px 12px;
    border-radius:999px;
  }

  .badge-pending{
    background:#fde68a;
    color:#92400e;
  }

  .badge-approved{
    background:#bbf7d0;
    color:#14532d;
  }

  .badge-rejected{
    background:#fecaca;
    color:#7f1d1d;
  }

  /* ACTION */
  .btn-detail{
    padding:6px 14px;
    border-radius:999px;
    font-size:13px;
    font-weight:800;
    border:2px solid #0f172a;
    background:#fff;
    color:#0f172a;
    transition:.15s ease;
    text-decoration:none;
  }

  .btn-detail:hover{
    background:#0f172a;
    color:#fff;
  }

  /* PAGINATION */
  .pagination{
    justify-content:center;
    margin-top:24px;
  }

  @media(max-width:768px){
    thead th,
    tbody td{
      padding:14px;
      font-size:14px;
    }

    .page-header{
      flex-direction:column;
      align-items:flex-start;
    }
  }
</style>

{{-- PAGE HEADER --}}
<div class="page-header">
  <h3>Laporan Kegiatan Mahasiswa</h3>

  <form method="GET" class="filter-box">
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
  <div class="alert-success">
    {{ session('success') }}
  </div>
@endif

{{-- TABLE --}}
<div class="table-card">
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Mahasiswa</th>
        <th>Tanggal</th>
        <th>Aktivitas</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>

    <tbody>
      @forelse($kegiatans as $i => $k)
        <tr>
          <td>{{ $kegiatans->firstItem() + $i }}</td>
          <td style="font-weight:700;">{{ $k->mahasiswa->name ?? '-' }}</td>
          <td>{{ optional($k->tanggal)->format('d-m-Y') }}</td>
          <td class="td-ellipsis">{{ $k->aktivitas }}</td>
          <td>
            @if($k->status == 'Pending')
              <span class="badge badge-pending">Pending</span>
            @elseif($k->status == 'Approved')
              <span class="badge badge-approved">Approved</span>
            @else
              <span class="badge badge-rejected">Rejected</span>
            @endif
          </td>
          <td style="text-align:center;">
            <a href="{{ route('supervisor.kegiatan.show', $k->id) }}" class="btn-detail">
              Detail
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center py-4" style="color:#64748b;">
            Belum ada laporan.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

{{ $kegiatans->links() }}
@endsection
