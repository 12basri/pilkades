<?php

namespace App\Controllers\Kordes;

use App\Controllers\BaseController;
use App\Models\PemilihModel;
use App\Models\WilayahModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class Pemilih extends BaseController
{
    protected $pemilihModel;
    protected $wilayahModel;

    public function __construct()
    {
        $this->pemilihModel = new PemilihModel();
        $this->wilayahModel = new WilayahModel();
    }

    // 1. Menampilkan Daftar Pemilih Wilayah Kordes + Fitur Search + Paginasi
    public function index()
    {
        $idWilayahUser = session()->get('id_wilayah');
        $keyword = $this->request->getGet('keyword');

        // Join ke tabel wilayah untuk mengambil data nama_dusun & no_tps
        $builder = $this->pemilihModel
            ->select('pemilih.*, wilayah.nama_dusun, wilayah.no_tps')
            ->join('wilayah', 'wilayah.id_wilayah = pemilih.id_wilayah', 'left');

        // Jika user memiliki id_wilayah (seperti Kordes), saring data khusus wilayahnya saja
        if (!empty($idWilayahUser)) {
            $builder->where('pemilih.id_wilayah', $idWilayahUser);
        }

        // Fitur Pencarian
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('pemilih.nama', $keyword)
                ->orLike('pemilih.nik', $keyword)
                ->orLike('pemilih.alamat', $keyword)
            ->groupEnd();
        }

        $perPage = 10; // Jumlah data per halaman

        $data = [
            'title'        => 'Data Pemilih',
            'pemilih'      => $builder->orderBy('pemilih.id_pemilih', 'DESC')->paginate($perPage, 'pemilih'),
            'pager'        => $this->pemilihModel->pager,
            'wilayah_list' => $this->wilayahModel->findAll(),
            'keyword'      => $keyword
        ];

        return view('kordes/pemilih/index', $data);
    }

    // 2. Form Tambah Pemilih
    public function create()
    {
        $data = [
            'title'        => 'Tambah Data Pemilih',
            'wilayah_list' => $this->wilayahModel->findAll(),
            'validation'   => \Config\Services::validation()
        ];

        return view('kordes/pemilih/tambah', $data);
    }

    // 3. Memproses Simpan Data Pemilih Baru
    public function store()
    {
        $rules = [
            'nik'            => 'permit_empty|numeric|is_unique[pemilih.nik]|min_length[16]|max_length[16]',
            'nama'           => 'required|min_length[3]',
            'jenis_kelamin'  => 'required|in_list[L,P]',
            'status_pemilih' => 'permit_empty|in_list[belum_didata,pasti_pilih,ragu_ragu,lawan]'
        ];

        $idWilayahUser = session()->get('id_wilayah');
        if (empty($idWilayahUser)) {
            $rules['id_wilayah'] = 'required|numeric';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $targetWilayah = !empty($idWilayahUser) ? $idWilayahUser : $this->request->getPost('id_wilayah');

        $this->pemilihModel->save([
            'nik'                 => $this->request->getPost('nik') ?: null,
            'nama'                => $this->request->getPost('nama'),
            'jenis_kelamin'       => $this->request->getPost('jenis_kelamin'),
            'usia'                => $this->request->getPost('usia') ?: null,
            'alamat'              => $this->request->getPost('alamat'),
            'id_wilayah'          => $targetWilayah,
            'status_pemilih'      => $this->request->getPost('status_pemilih') ?? 'belum_didata',
            'keterangan_aspirasi' => $this->request->getPost('keterangan_aspirasi'),
            'id_relawan'          => session()->get('id_user')
        ]);

        return redirect()->to('/kordes/pemilih')->with('success', 'Data pemilih berhasil ditambahkan.');
    }

    // 4. Form Edit Pemilih
    public function edit($id = null)
    {
        $pemilih = $this->pemilihModel->find($id);

        if (!$pemilih) {
            throw PageNotFoundException::forPageNotFound("Data pemilih dengan ID $id tidak ditemukan.");
        }

        $data = [
            'title'        => 'Edit Data Pemilih',
            'pemilih'      => $pemilih,
            'wilayah_list' => $this->wilayahModel->findAll(),
            'validation'   => \Config\Services::validation()
        ];

        return view('kordes/pemilih/edit', $data);
    }

    // 5. Memproses Update Data Pemilih
    public function update($id = null)
    {
        $pemilihLama = $this->pemilihModel->find($id);

        if (!$pemilihLama) {
            throw PageNotFoundException::forPageNotFound("Data pemilih dengan ID $id tidak ditemukan.");
        }

        $nikInput = $this->request->getPost('nik');
        $ruleNik  = ($pemilihLama['nik'] === $nikInput) 
            ? 'permit_empty|numeric|min_length[16]|max_length[16]' 
            : 'permit_empty|numeric|is_unique[pemilih.nik]|min_length[16]|max_length[16]';

        $rules = [
            'nik'            => $ruleNik,
            'nama'           => 'required|min_length[3]',
            'jenis_kelamin'  => 'required|in_list[L,P]',
            'status_pemilih' => 'permit_empty|in_list[belum_didata,pasti_pilih,ragu_ragu,lawan]'
        ];

        $idWilayahUser = session()->get('id_wilayah');
        if (empty($idWilayahUser)) {
            $rules['id_wilayah'] = 'required|numeric';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $targetWilayah = !empty($idWilayahUser) ? $idWilayahUser : $this->request->getPost('id_wilayah');

        $this->pemilihModel->update($id, [
            'nik'                 => $nikInput ?: null,
            'nama'                => $this->request->getPost('nama'),
            'jenis_kelamin'       => $this->request->getPost('jenis_kelamin'),
            'usia'                => $this->request->getPost('usia') ?: null,
            'alamat'              => $this->request->getPost('alamat'),
            'id_wilayah'          => $targetWilayah,
            'status_pemilih'      => $this->request->getPost('status_pemilih') ?? 'belum_didata',
            'keterangan_aspirasi' => $this->request->getPost('keterangan_aspirasi')
        ]);

        return redirect()->to('/kordes/pemilih')->with('success', 'Data pemilih berhasil diperbarui.');
    }

    // 6. Menghapus Data Pemilih
    public function delete($id = null)
    {
        $pemilih = $this->pemilihModel->find($id);

        if (!$pemilih) {
            return redirect()->to('/kordes/pemilih')->with('error', 'Data pemilih tidak ditemukan.');
        }

        $this->pemilihModel->delete($id);
        return redirect()->to('/kordes/pemilih')->with('success', 'Data pemilih berhasil dihapus.');
    }

    // ==========================================
    // FITUR EXPORT DATA KHUSUS KORDES
    // ==========================================

    private function getPemilihDataKordes()
    {
        $idWilayahUser = session()->get('id_wilayah');

        $builder = $this->pemilihModel
            ->select('pemilih.*, wilayah.nama_dusun, wilayah.no_tps')
            ->join('wilayah', 'wilayah.id_wilayah = pemilih.id_wilayah', 'left');

        if (!empty($idWilayahUser)) {
            $builder->where('pemilih.id_wilayah', $idWilayahUser);
        }

        return $builder->orderBy('pemilih.id_pemilih', 'DESC')->findAll();
    }

    // 7. Export ke Excel (.xlsx)
    public function exportExcel()
    {
        $pemilihData = $this->getPemilihDataKordes();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'NIK');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'L/P');
        $sheet->setCellValue('E1', 'Usia');
        $sheet->setCellValue('F1', 'Alamat');
        $sheet->setCellValue('G1', 'Dusun');
        $sheet->setCellValue('H1', 'TPS');
        $sheet->setCellValue('I1', 'Status Pemilih');
        $sheet->setCellValue('J1', 'Aspirasi');

        $rowNum = 2;
        $no = 1;
        foreach ($pemilihData as $row) {
            $sheet->setCellValue('A' . $rowNum, $no++);
            $sheet->setCellValueExplicit('B' . $rowNum, (string) ($row['nik'] ?? ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $rowNum, $row['nama'] ?? '');
            $sheet->setCellValue('D' . $rowNum, $row['jenis_kelamin'] ?? '');
            $sheet->setCellValue('E' . $rowNum, $row['usia'] ?? '');
            $sheet->setCellValue('F' . $rowNum, $row['alamat'] ?? '');
            $sheet->setCellValue('G' . $rowNum, $row['nama_dusun'] ?? '');
            $sheet->setCellValue('H' . $rowNum, $row['no_tps'] ?? '');
            $sheet->setCellValue('I' . $rowNum, $row['status_pemilih'] ?? '');
            $sheet->setCellValue('J' . $rowNum, $row['keterangan_aspirasi'] ?? '');
            $rowNum++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'data_pemilih_kordes_' . date('Ymd_His') . '.xlsx';

        // Membersihkan buffer sebelum output file agar Excel tidak rusak
        if (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

    // 8. Export ke PDF (.pdf)
    public function exportPdf()
    {
        $pemilihData = $this->getPemilihDataKordes();

        $html = view('kordes/pemilih/pdf_view', [
            'title'   => 'Laporan Data Pemilih Kordes',
            'pemilih' => $pemilihData
        ]);

        // Membersihkan buffer sebelum render PDF
        if (ob_get_level()) {
            ob_end_clean();
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('data_pemilih_kordes_' . date('Ymd_His') . '.pdf', ['Attachment' => true]);
        exit();
    }

    // 9. Export ke CSV (.csv)
    public function exportCsv()
    {
        $pemilihData = $this->getPemilihDataKordes();

        $filename = 'data_pemilih_kordes_' . date('Ymd_His') . '.csv';

        // Membersihkan buffer sebelum output CSV
        if (ob_get_level()) {
            ob_end_clean();
        }

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header("Content-Type: text/csv; charset=UTF-8");

        $file = fopen('php://output', 'w');

        fputcsv($file, ['ID', 'NIK', 'Nama', 'Jenis Kelamin', 'Usia', 'Alamat', 'Dusun', 'TPS', 'Status', 'Aspirasi']);

        foreach ($pemilihData as $row) {
            fputcsv($file, [
                $row['id_pemilih'] ?? '',
                "'" . ($row['nik'] ?? ''),
                $row['nama'] ?? '',
                $row['jenis_kelamin'] ?? '',
                $row['usia'] ?? '',
                $row['alamat'] ?? '',
                $row['nama_dusun'] ?? '',
                $row['no_tps'] ?? '',
                $row['status_pemilih'] ?? '',
                $row['keterangan_aspirasi'] ?? ''
            ]);
        }

        fclose($file);
        exit();
    }
}