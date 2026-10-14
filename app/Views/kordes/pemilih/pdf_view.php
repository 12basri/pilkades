<!DOCTYPE html>
<html>
<head>
    <title><?= esc($title) ?></title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h3 style="text-align:center;"><?= esc($title) ?></h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>L/P</th>
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
                <td><?= esc($row['nik'] ?? '-') ?></td>
                <td><?= esc($row['nama'] ?? '-') ?></td>
                <td><?= esc($row['jenis_kelamin'] ?? '-') ?></td>
                <td><?= esc($row['alamat'] ?? '-') ?></td>
                <td><?= esc($row['nama_dusun'] ?? '-') ?></td>
                <td><?= esc($row['no_tps'] ?? '-') ?></td>
                <td><?= esc($row['status_pemilih'] ?? '-') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>