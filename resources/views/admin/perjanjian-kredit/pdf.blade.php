<!DOCTYPE html>
<html>
<head>
    <title>Perjanjian Kredit Export</title>
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
    <h2 style="text-align: center;">Laporan Perjanjian Kredit</h2>
    <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th>No PK</th>
                <th>Tgl PK</th>
                <th>Nama Peminjam</th>
                <th>Filename</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $index => $doc)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $doc->nomor_dokumen }}</td>
                    <td>{{ $doc->tanggal_dokumen ? \Carbon\Carbon::parse($doc->tanggal_dokumen)->format('d-m-Y') : '-' }}</td>
                    <td>{{ $doc->nama_peminjam }}</td>
                    <td>{{ $doc->filename }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>