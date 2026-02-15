<!DOCTYPE html>
<html>
<head>
    <title>Surat Export</title>
    <style>
        body {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 1rem;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 0.75rem;
            vertical-align: top;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Surat Masuk/Keluar</h2>
    <p>Tanggal Cetak: {{ \Carbon\Carbon::now('Asia/Makassar')->format('d-m-Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th>No Surat</th>
                <th>Perihal</th>
                <th>Tgl Surat</th>
                <th style="width: 10%">Jenis</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $index => $doc)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $doc->nomor_dokumen }}</td>
                    <td>{{ $doc->perihal }}</td>
                    <td>{{ $doc->tanggal_dokumen ? \Carbon\Carbon::parse($doc->tanggal_dokumen)->format('d-m-Y') : '-' }}</td>
                    <td>{{ ucfirst($doc->jenis) }}</td>
                    <td>
                        @if($doc->jenis == 'masuk')
                            Dari: {{ $doc->pengirim }}
                        @else
                            Tujuan: {{ $doc->penerima }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
