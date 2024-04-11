<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSuratJln;
use App\Models\ModelBarang;
use App\Models\ModelDivisi;
use App\Models\ModelLapJual23;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual23 extends BaseController
{
    function __construct()
    {
        $this->ModelSuratJln = new ModelSuratJln();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelDivisi = new ModelDivisi();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelLapJual23 = new ModelLapJual23();
    }

    public function index()
    {
        $data = [
            'title' => 'Surat Jalan By Division',
            'divisi' => $this->ModelDivisi->allData(),
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
        ];
        return view('lapjual23/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kodedivisi  = $this->request->getPost('kode_divisi');
        $typelap   = $this->request->getPost('typelap');
        $title = "Surat Jalan Per Divisi";
        $title1 = session()->get('nama_company');
        $laporan = $this->ModelLapJual23->lapjual23($dari, $sampai,$kodedivisi, $typelap);


        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => $title1,
                'divisi'  => $kodedivisi,
                'laporan' => $laporan,
            );
            if ($typelap == 'REKAP') {
                return view('lapjual23/tampil', $data);
            } else {
                return view('lapjual23/tampildetail', $data);
            }
        }

        if (isset($tombolExport)) {

            if ($typelap == 'REKAP') {

                // HEADER
                $spreadsheet = new Spreadsheet;
                $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
                $spreadsheet->getActiveSheet()->mergeCells('A1:F1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:F2');
                $spreadsheet->getActiveSheet()->mergeCells('A3:F3');

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

                $spreadsheet->getActiveSheet()->getStyle('A5:F5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $spreadsheet->getActiveSheet()->getStyle('A5:F5')->getFill()->getStartColor()->setARGB('FF4F81BD');
                $spreadsheet->getActiveSheet()->getStyle('A5:F5')
                    ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $spreadsheet->getActiveSheet()->getStyle('A5:F5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', $kodedivisi);

                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(40);


                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NO SRT JLN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'TGL SRT JLN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'NO_SO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'NO_PO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'NAMA CUSTOMER');


                $kolom = 6;
                $nomor = 1;
                $t01 = 0;
                $t02 = 0;
                $t03 = 0;
                $t04 = 0;
                $t05 = 0;
                $t06 = 0;
                $t07 = 0;

                // DETAIL

                foreach ($laporan as $sttb) {

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $nomor);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $sttb['no_suratjln']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, date('d-M-Y', strtotime($sttb['tgl_suratjln'])));
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $sttb['no_so']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $sttb['no_po']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $sttb['nama_customer']);
                    $kolom++;
                    $nomor++;
                }

                // FOOTER TOTAL


                $writer = new Xlsx($spreadsheet);
                $filename = 'lapjual23' .  '.xlsx';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename = ' . $filename . '');
                header('Cache-Control: max-age=0');
                ob_end_clean();
                $writer->save('php://output');
                exit;
            } else {

                $spreadsheet = new Spreadsheet;
                $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
                $spreadsheet->getActiveSheet()->mergeCells('A1:G1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:G2');
                $spreadsheet->getActiveSheet()->mergeCells('A3:G3');

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', $kodedivisi);

                $spreadsheet->getActiveSheet()->getStyle('A5:G5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $spreadsheet->getActiveSheet()->getStyle('A5:G5')->getFill()->getStartColor()->setARGB('FF4F81BD');
                $spreadsheet->getActiveSheet()->getStyle('A5:G5')
                    ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $spreadsheet->getActiveSheet()->getStyle('A5:G5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(40);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(50);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(8);


                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO SRT JLN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'TGL SRT SJLN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'NO SO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'NAMA CUSTOMER');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'NAMA BARANG');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'QTY');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'SATUAN');

                $kolom = 6;
                $nomor = 1;
                $totamt = 0;
                $gtotamt = 0;
                $totppn = 0;
                $gtotppn = 0;
                $totinv = 0;
                $gtotinv = 0;
                $sw = 0;
                $tgl = '';
                $noinv = '';

                // DETAIL
                foreach ($laporan as $lap) {
                    if ($lap['no_suratjln'] != $noinv) {
                        if ($sw == 1) {
                            $kolom = $kolom + 2;
                        }
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['no_suratjln']);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, date('d-M-Y', strtotime($lap['tgl_suratjln'])));
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['no_so']);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['nama_customer']);
                        $noinv = $lap['no_suratjln'];
                    }

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['nama_barang']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $lap['qty']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $lap['kode_satuan']);
                    $noinv = $lap['no_suratjln'];
                    $sw = 1;
                    $kolom = $kolom + 1;
                    $nomor++;
                }



                $writer = new Xlsx($spreadsheet);
                $filename = 'lapjual23d' .  '.xlsx';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename = ' . $filename . '');
                header('Cache-Control: max-age=0');
                ob_end_clean();
                $writer->save('php://output');
                exit;
            }
        }
    }
}
