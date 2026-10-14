<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin: 0; }
    </style>
</head>
<body>
    <h2><?= $title ?></h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>L/P</th>
                <th>Usia</th>
                <th>Alamat</th>
                <th>Dusun</th>
                <th>TPS</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($pemilih as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nik'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['jenis_kelamin'] ?></td>
                <td><?= $row['usia'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td><?= $row['nama_dusun'] ?></td>
                <td><?= $row['no_tps'] ?></td>
                <td><?= $row['status_pemilih'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>