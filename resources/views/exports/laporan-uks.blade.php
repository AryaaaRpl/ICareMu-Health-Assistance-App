<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kesehatan UKS - {{ $namaSekolah }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11pt;
            color: #1e293b;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-b: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
            color: #0f172a;
            letter-spacing: 1px;
        }
        .header h2 {
            margin: 4px 0 0 0;
            font-size: 13pt;
            color: #475569;
            font-weight: 600;
        }
        .header p {
            margin: 4px 0 0 0;
            font-size: 9pt;
            color: #64748b;
        }
        .summary-container {
            width: 100%;
            margin-bottom: 20px;
        }
        .summary-box {
            width: 31%;
            float: left;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px;
            text-align: center;
            margin-right: 2%;
        }
        .summary-box:last-child {
            margin-right: 0;
        }
        .summary-title {
            font-size: 8pt;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
        }
        .summary-value {
            font-size: 16pt;
            font-weight: bold;
            color: #0f172a;
            margin-top: 4px;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .table-title {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 9pt;
            text-transform: uppercase;
            padding: 8px 6px;
            text-align: left;
            font-weight: 600;
        }
        td {
            padding: 7px 6px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9pt;
        }
        tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: bold;
            background-color: #e2e8f0;
            color: #334155;
        }
        .footer-sig {
            margin-top: 40px;
            width: 100%;
        }
        .sig-box {
            width: 40%;
            float: right;
            text-align: center;
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $namaSekolah }}</h1>
        <h2>LAPORAN KESEHATAN UKS (USAHA KESEHATAN SEKOLAH)</h2>
        <p>Periode Laporan: {{ $periode }} | Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>

    <div class="summary-container clearfix">
        <div class="summary-box">
            <div class="summary-title">Total Pemeriksaan</div>
            <div class="summary-value">{{ count($records) }}</div>
        </div>
        <div class="summary-box">
            <div class="summary-title">Siswa Dirawat UKS</div>
            <div class="summary-value">{{ $totalRawat }}</div>
        </div>
        <div class="summary-box">
            <div class="summary-title">Rujukan Keluar</div>
            <div class="summary-value">{{ $totalRujuk }}</div>
        </div>
    </div>

    <div class="table-title">Daftar Rekam Medis Siswa</div>
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 22%;">Nama Siswa</th>
                <th style="width: 25%;">Keluhan Utama</th>
                <th style="width: 8%;">Suhu</th>
                <th style="width: 10%;">T. Darah</th>
                <th style="width: 19%;">Status Penanganan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $index => $rec)
                @php
                    $sName = $rec->siswa ? ($rec->siswa->name ?? $rec->siswa->nama_lengkap ?? 'Siswa') : 'Siswa #'.$rec->siswa_id;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $rec->tanggal ?? $rec->created_at->format('Y-m-d') }}</td>
                    <td><strong>{{ $sName }}</strong></td>
                    <td>{{ $rec->keluhan_utama ?? 'Demam/Tidak Enak Badan' }}</td>
                    <td>{{ $rec->suhu ?? '36.5' }}°C</td>
                    <td>{{ $rec->tekanan_darah ?? '120/80' }}</td>
                    <td>
                        <span class="badge">{{ $rec->status_penanganan ?? $rec->status ?? 'Selesai' }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #94a3b8; padding: 15px;">
                        Tidak ada data rekam medis untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-sig clearfix">
        <div class="sig-box">
            <p>Jakarta, {{ date('d F Y') }}<br><strong>Petugas UKS Sekolah</strong></p>
            <br><br><br>
            <p>__________________________<br><strong>( NIP / ID Petugas )</strong></p>
        </div>
    </div>
</body>
</html>
