<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PemilihModel;
use App\Models\WilayahModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
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

    public function index()
    {
        // Menangkap filter id_wilayah jika ada dari request GET
        $idWilayah = $this->request->getGet('id_wilayah');

        $builder = $this->pemilihModel
            ->select('pemilih.*, wilayah.nama_dusun, wilayah.no_tps')
            ->join('wilayah', 'wilayah.id_wilayah = pemilih.id_wilayah', 'left');

        if (!empty($idWilayah)) {
            $builder->where('pemilih.id_wilayah', $idWilayah);
        }

        $pemilihData = $builder->orderBy('pemilih.id_pemilih', 'DESC')->findAll();

        $data = [
            'title'        => 'Data Pemilih',
            'pemilih'      => $pemilihData,
            'wilayah_list' => $this->wilayahModel->findAll(),
            'selected_wilayah' => $idWilayah
        ];

        return view('admin/pemilih/index', $data);
    }

    public function store()
    {
        // Sanitasi NIK terlebih dahulu agar validasi menghitung angka bersih saja
        $nikRaw = $this->request->getPost('nik');
        $nik = $nikRaw ? preg_replace('/[^0-9]/', '', $nikRaw) : null;

        // Masukkan NIK sanitasi kembali ke Request agar tervalidasi dengan benar
        $postData = $this->request->getPost();
        $postData['nik'] = $nik;
        $this->request->setGlobal('post', $postData);

        // Validasi input
        $rules = [
            'nama'          => 'required|min_length[3]|max_length[255]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'id_wilayah'    => 'required|numeric',
            'nik'           => [
                'rules'  => 'permit_empty|numeric|exact_length[16]|is_unique[pemilih.nik]',
                'errors' => [
                    'exact_length' => 'NIK harus berjumlah persis 16 digit.',
                    'numeric'      => 'NIK hanya boleh berisi angka.',
                    'is_unique'    => '⚠️ NIK ini sudah terdaftar dalam sistem!'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan data ke tabel pemilih
        $saveData = [
            'nik'                 => $nik,
            'nama'                => trim($this->request->getPost('nama')),
            'jenis_kelamin'       => $this->request->getPost('jenis_kelamin'),
            'usia'                => $this->request->getPost('usia') ?: null,
            'alamat'              => $this->request->getPost('alamat') ?: null,
            'id_wilayah'          => $this->request->getPost('id_wilayah'),
            'id_relawan'          => $this->request->getPost('id_relawan') ?: null,
            'status_pemilih'      => $this->request->getPost('status_pemilih') ?: 'belum_didata',
            'keterangan_aspirasi' => $this->request->getPost('keterangan_aspirasi') ?: null,
        ];

        if ($this->pemilihModel->save($saveData)) {
            return redirect()->to('admin/pemilih')->with('success', 'Data pemilih berhasil disimpan.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data pemilih ke database.');
    }

    public function update($id = null)
    {
        if (empty($id)) {
            return redirect()->to('admin/pemilih')->with('errors', ['ID pemilih tidak valid.']);
        }

        $pemilih = $this->pemilihModel->find($id);

        if (!$pemilih) {
            return redirect()->to('admin/pemilih')->with('errors', ['Data pemilih tidak ditemukan.']);
        }

        // Sanitasi NIK
        $nikRaw = $this->request->getPost('nik');
        $nik = $nikRaw ? preg_replace('/[^0-9]/', '', $nikRaw) : null;

        $postData = $this->request->getPost();
        $postData['nik'] = $nik;
        $this->request->setGlobal('post', $postData);

        // Pengecekan is_unique diabaikan untuk ID pemilih yang sedang di-edit
        $rules = [
            'nama'          => 'required|min_length[3]|max_length[255]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'id_wilayah'    => 'required|numeric',
            'nik'           => [
                'rules'  => "permit_empty|numeric|exact_length[16]|is_unique[pemilih.nik,id_pemilih,{$id}]",
                'errors' => [
                    'exact_length' => 'NIK harus berjumlah persis 16 digit.',
                    'numeric'      => 'NIK hanya boleh berisi angka.',
                    'is_unique'    => '⚠️ NIK ini sudah digunakan oleh pemilih lain!'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'nik'                 => $nik,
            'nama'                => trim($this->request->getPost('nama')),
            'jenis_kelamin'       => $this->request->getPost('jenis_kelamin'),
            'usia'                => $this->request->getPost('usia') ?: null,
            'alamat'              => $this->request->getPost('alamat') ?: null,
            'id_wilayah'          => $this->request->getPost('id_wilayah'),
            'id_relawan'          => $this->request->getPost('id_relawan') ?: null,
            'status_pemilih'      => $this->request->getPost('status_pemilih') ?: 'belum_didata',
            'keterangan_aspirasi' => $this->request->getPost('keterangan_aspirasi') ?: null,
        ];

        if ($this->pemilihModel->update($id, $updateData)) {
            return redirect()->to('admin/pemilih')->with('success', 'Data pemilih berhasil diperbarui.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data pemilih.');
    }

    public function delete($id = null)
    {
        if (empty($id)) {
            return redirect()->to('admin/pemilih')->with('errors', ['ID pemilih tidak valid.']);
        }

        $pemilih = $this->pemilihModel->find($id);

        if ($pemilih) {
            return $this->pemilihModel->delete($id)
                ? redirect()->to('admin/pemilih')->with('success', 'Data pemilih berhasil dihapus.')
                : redirect()->to('admin/pemilih')->with('errors', ['Gagal menghapus data.']);
        }

        return redirect()->to('admin/pemilih')->with('errors', ['Data pemilih gagal dihapus atau tidak ditemukan.']);
    }

    /**
     * Alias method untuk menangani route 'admin/pemilih/import'
     */
    public function import()
    {
        return $this->importExcel();
    }

    /**
     * Import Data Pemilih dari File Excel (.xlsx / .xls)
     */
    public function importExcel()
    {
        $file = $this->request->getFile('file_excel');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Silakan pilih file Excel yang valid.');
        }

        $extension = $file->getClientExtension();
        if (!in_array($extension, ['xls', 'xlsx'])) {
            return redirect()->back()->with('error', 'Format file harus berupa .xls atau .xlsx');
        }

        try {
            $reader = IOFactory::createReader(ucfirst($extension));
            $spreadsheet = $reader->load($file->getTempName());
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $inserted = 0;
            // Baris ke-1 dilewati karena merupakan Header kolom
            foreach ($sheetData as $index => $row) {
                if ($index == 1) continue;

                $nik = !empty($row['B']) ? preg_replace('/[^0-9]/', '', (string)$row['B']) : null;
                $nama = trim($row['C'] ?? '');

                // Lewati baris jika nama kosong
                if (empty($nama)) continue;

                $saveData = [
                    'nik'                 => $nik,
                    'nama'                => $nama,
                    'jenis_kelamin'       => strtoupper(trim($row['D'] ?? 'L')),
                    'usia'                => $row['E'] ?? null,
                    'alamat'              => $row['F'] ?? null,
                    'id_wilayah'          => $row['G'] ?? 1, // Pastikan ID Wilayah sesuai
                    'status_pemilih'      => $row['H'] ?? 'belum_didata',
                    'keterangan_aspirasi' => $row['I'] ?? null,
                ];

                $this->pemilihModel->save($saveData);
                $inserted++;
            }

            return redirect()->to('admin/pemilih')->with('success', "Berhasil mengimpor {$inserted} data pemilih.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses file Excel: ' . $e->getMessage());
        }
    }

    /**
     * Alias method untuk menangani route 'admin/pemilih/export'
     */
    public function export()
    {
        return $this->exportExcel();
    }

    /**
     * Helper privat untuk mengambil data pemilih yang sudah difilter berdasarkan Wilayah / TPS
     */
    private function getFilteredPemilih()
    {
        $idWilayah = $this->request->getGet('id_wilayah');

        $builder = $this->pemilihModel
            ->select('pemilih.*, wilayah.nama_dusun, wilayah.no_tps')
            ->join('wilayah', 'wilayah.id_wilayah = pemilih.id_wilayah', 'left');

        if (!empty($idWilayah)) {
            $builder->where('pemilih.id_wilayah', $idWilayah);
        }

        return $builder->orderBy('pemilih.id_pemilih', 'DESC')->findAll();
    }

    /**
     * 1. Export Ke EXCEL (.xlsx) dengan Filter
     */
    public function exportExcel()
    {
        $pemilihData = $this->getFilteredPemilih();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header Kolom
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
            $sheet->setCellValueExplicit('B' . $rowNum, (string) $row['nik'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $rowNum, $row['nama']);
            $sheet->setCellValue('D' . $rowNum, $row['jenis_kelamin']);
            $sheet->setCellValue('E' . $rowNum, $row['usia']);
            $sheet->setCellValue('F' . $rowNum, $row['alamat']);
            $sheet->setCellValue('G' . $rowNum, $row['nama_dusun']);
            $sheet->setCellValue('H' . $rowNum, $row['no_tps']);
            $sheet->setCellValue('I' . $rowNum, $row['status_pemilih']);
            $sheet->setCellValue('J' . $rowNum, $row['keterangan_aspirasi']);
            $rowNum++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'data_pemilih_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

    /**
     * 2. Export Ke PDF (.pdf) dengan Filter
     */
    public function exportPdf()
    {
        $pemilihData = $this->getFilteredPemilih();

        $html = view('admin/pemilih/pdf_view', [
            'title'   => 'Laporan Data Pemilih',
            'pemilih' => $pemilihData
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('data_pemilih_' . date('Ymd_His') . '.pdf', ['Attachment' => true]);
        exit();
    }

    /**
     * 3. Export Ke CSV (.csv) dengan Filter
     */
    public function exportCsv()
    {
        $pemilihData = $this->getFilteredPemilih();

        $filename = 'data_pemilih_' . date('Ymd_His') . '.csv';

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename={$filename}");
        header("Content-Type: application/csv; charset=UTF-8");

        $file = fopen('php://output', 'w');

        fputcsv($file, ['ID', 'NIK', 'Nama', 'Jenis Kelamin', 'Usia', 'Alamat', 'Dusun', 'TPS', 'Status', 'Aspirasi']);

        foreach ($pemilihData as $row) {
            fputcsv($file, [
                $row['id_pemilih'],
                $row['nik'],
                $row['nama'],
                $row['jenis_kelamin'],
                $row['usia'],
                $row['alamat'],
                $row['nama_dusun'],
                $row['no_tps'],
                $row['status_pemilih'],
                $row['keterangan_aspirasi']
            ]);
        }

        fclose($file);
        exit();
    }

    /**
     * API endpoint internal untuk AJAX live-check NIK di frontend
     */
    public function checkNik()
    {
        $nik = $this->request->getGet('nik');
        $id  = $this->request->getGet('id_pemilih');

        if (empty($nik)) {
            return $this->response->setJSON(['exists' => false]);
        }

        $builder = $this->pemilihModel->where('nik', $nik);
        if (!empty($id)) {
            $builder->where('id_pemilih !=', $id);
        }

        $exists = $builder->countAllResults() > 0;

        return $this->response->setJSON(['exists' => $exists]);
    }
}
