<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman BBC-Reads</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .header h3 {
            margin: 3px 0;
            font-size: 13px;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            font-size: 10px;
            color: #555;
        }
        .meta-info {
            margin-bottom: 15px;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #777;
        }
        th {
            background-color: #f2f2f2;
            padding: 6px;
            text-transform: uppercase;
            font-size: 9px;
            text-align: left;
        }
        td {
            padding: 6px;
            font-size: 10px;
        }
        .text-center { text-align: center; }
        .footer-sign {
            float: right;
            width: 220px;
            text-align: center;
            margin-top: 30px;
        }
        .footer-sign p { margin: 0; }
        .space { height: 50px; }
    </style>
</head>
<body>

    <!-- KOP SURAT SEKOLAH -->
    <div class="header">
        <h2>PERPUSTAKAAN DIGITAL BBC-READS</h2>
        <h3>{{ $namaSekolah }}</h3>
        <p>{{ $alamatSekolah }}</p>
    </div>

    <div class="meta-info">
        <strong>PERIODE LAPORAN:</strong> {{ date('d/m/Y', strtotime($tglMulai)) }} s.d. {{ date('d/m/Y', strtotime($tglSelesai)) }}<br>
        <strong>DICETAK PADA:</strong> {{ date('d/m/Y H:i') }} WIB
    </div>

    <!-- TABEL DATA LAPORAN -->
    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="25%">Nama Peminjam</th>
                <th width="15%" class="text-center">Kelas / NISN</th>
                <th width="30%">Judul Buku</th>
                <th width="12%" class="text-center">Tgl Pinjam</th>
                <th width="13%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporans as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $row->nama_peminjam ?? '-' }}</strong></td>
                    <td class="text-center">
                        {{ $row->kelas ?? '-' }}
                        @if (!empty($row->nisn))
                            <br><span style="font-size: 8px; color: #666;">({{ $row->nisn }})</span>
                        @endif
                    </td>
                    <td>{{ $row->buku->judul ?? '-' }}</td>
                    <td class="text-center">
                        {{ $row->tgl_pinjam ? date('d/m/Y', strtotime($row->tgl_pinjam)) : date('d/m/Y', strtotime($row->created_at)) }}
                    </td>
                    <td class="text-center">
                        {{ strtoupper($row->status ?? 'DIPINJAM') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 15px; color: #888;">
                        Tidak ada transaksi peminjaman pada periode tanggal ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <div class="footer-sign">
        <p>Purwakarta, {{ date('d F Y') }}</p>
        <p>Kepala Perpustakaan,</p>
        <div class="space"></div>
        <p><strong><u>{{ $namaKepalaPerpus }}</u></strong></p>
        @if (!empty($nipKepalaPerpus) && $nipKepalaPerpus != '-')
            <p>NIP. {{ $nipKepalaPerpus }}</p>
        @endif
    </div>

</body>
</html>