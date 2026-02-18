<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Hasil Magang</title>
    <style>
        @page { size: A4; margin: 20mm 18mm; }

        body{
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12px;
            color:#000;
            margin:0;
            padding:0;
        }

        .paper{
            border: 1px solid #111;
            padding: 16px 16px 14px;
        }

        .kop{
            position: relative;
            text-align:center;
            padding-top: 2px;
            padding-bottom: 8px;
        }

        .kop .logo{
            position:absolute;
            left:0;
            top:0;
            width:62px;
            height:62px;
        }

        .kop .logo img{
            width:62px;
            height:62px;
            object-fit:contain;
            display:block;
        }

        .kop .univ{
            font-weight:700;
            font-size: 18px;
            text-transform:uppercase;
            letter-spacing: .6px;
            line-height: 1.2;
            margin-top: 6px;
        }

        .kop .fakultas{
            font-weight:700;
            font-size: 12px;
            text-transform:uppercase;
            margin-top: 2px;
        }

        .line{
            border-top:1px solid #777;
            margin: 12px 0 10px;
        }

        .title{
            font-weight:700;
            text-transform:uppercase;
            font-size: 13px;
            margin:0;
        }

        .subtitle{
            font-weight:700;
            text-transform:uppercase;
            font-size: 12px;
            margin:6px 0 0;
        }

        .content{
            font-family: "Times New Roman", Times, serif;
            margin-top: 12px;
            text-align: left;
        }

        .info-table{
            width:100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .info-table td{
            padding: 2px 0;
            font-size: 12px;
            line-height: 1.35;
            vertical-align: top;
        }

        .info-label{
            width: 180px;
            position: relative;
            padding-right: 14px;
            font-weight: 700;
        }

        .info-label .colon{
            position: absolute;
            right: 0;
            top: 0;
            width: 14px;
            text-align: center;
            font-weight: 700;
        }

        .info-value{
            padding-left: 6px;
        }

        .tbl{
            width:100%;
            border-collapse:collapse;
            margin-top:14px;
            font-size:12px;
        }

        .tbl th, .tbl td{
            border:1px solid #111;
            padding:6px;
        }

        .tbl th{
            font-weight:700;
            background:#f5f5f5;
        }

        .right{
            text-align:right;
        }

        .note{
            margin-top:8px;
            font-size:11px;
        }
    </style>
</head>
<body>
<div class="paper">

    <div class="kop">
        <div class="logo">
            <img src="{{ public_path('images/bank.png') }}" alt="Logo">
        </div>

        <div class="univ">NILAI MANAGEMENT MAGANG</div>
        <div class="fakultas">BANK NAGARI</div>

        <div class="line"></div>

        <p class="title">LEMBAR HASIL MAGANG</p>
        <p class="subtitle">2026</p>
    </div>

    <div class="content">
        <table class="info-table">
            <tr>
                <td class="info-label">
                    Nama Mahasiswa <span class="colon">:</span>
                </td>
                <td class="info-value">{{ $mahasiswa->name }}</td>
            </tr>
            <tr>
                <td class="info-label">
                    Email <span class="colon">:</span>
                </td>
                <td class="info-value">{{ $mahasiswa->email }}</td>
            </tr>
            <tr>
                <td class="info-label">
                    Tanggal Penilaian <span class="colon">:</span>
                </td>
                <td class="info-value">{{ $penilaian->tanggal }}</td>
            </tr>
            <tr>
                <td class="info-label">
                    Dicetak <span class="colon">:</span>
                </td>
                <td class="info-value">{{ now()->format('d-m-Y H:i') }}</td>
            </tr>
        </table>

        <table class="tbl">
            <tr>
                <th style="width:40%;">Nilai Akhir</th>
                <th style="width:25%;">Grade</th>
                <th class="right" style="width:35%;">Total Skor</th>
            </tr>
            <tr>
                <td>{{ number_format($penilaian->nilai_akhir ?? 0, 2) }}</td>
                <td>{{ $penilaian->grade ?? '-' }}</td>
                <td class="right">{{ $penilaian->total_skor ?? 0 }}</td>
            </tr>
        </table>

        <div class="note">Catatan: Nilai diambil dari penilaian terakhir mahasiswa.</div>
    </div>

</div>
</body>
</html>
