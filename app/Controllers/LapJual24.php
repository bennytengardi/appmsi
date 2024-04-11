<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesInv;
use App\Models\ModelDivisi;
use App\Models\ModelReceipt;
use App\Models\ModelLapJual24;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual24 extends BaseController
{
    function __construct()
    {
        $this->ModelReceipt  = new ModelReceipt();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelDivisi    = new ModelDivisi();
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelLapJual24 = new ModelLapJual24();
    }

    public function index()
    {
        $data = [
            'title'  => 'SO yg Belum ada Invoice',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'divisi' => $this->ModelDivisi->allData(),
            'customer' => $this->ModelCustomer->alldata2(),
        ];
        return view('lapjual24/filter', $data);
    }

    public function preview()
    {
        $tombolCetak  = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $sampai    = $this->request->getPost('sampai');
        $kodedivisi = $this->request->getPost('kode_divisi');
        $title1    = session()->get('nama_company');
        $title = "Sales Order Yang Belum Ada Invoice";
        $this->ModelLapJual24->clearOutstandingSo();

        $dcust = $this->ModelCustomer->allData2();

        $trxdbt = $this->ModelLapJual24->trxDebet($sampai);
        
        foreach ($trxdbt as $trx1) {
            $tglbukti  = $trx1['tgl_so'];
            $nobukti   = $trx1['no_so'];
            $cust      = $trx1['kode_customer'];
            $nilai     = $trx1['total_so'];
            $realisasi = 0;
            
            $raw2 = [
                'no_so'    => $nobukti,
                'tgl_so'   => $tglbukti,
                'kode_customer' => $cust,
                'total_so' => $nilai,
                'realisasi' => $realisasi,
                'no_invoice' => ''
            ];
            $this->ModelLapJual24->insertOutstandingSO($raw2);
        }

        $trxcrd = $this->ModelLapJual24->trxCredit($sampai);
    
        foreach ($trxcrd as $trx2) {
            $noso      = $trx2['no_so'];
            $totinvoice= $trx2['totreal'];
            $raw3 = [
                'no_so'       => $noso,
                'realisasi'   => $totinvoice,
            ];
            $this->ModelLapJual24->UpdateOutstandingSo($raw3);
        }

        $laporan = $this->ModelLapJual24->getOutstandingSo($kodedivisi);
        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
                'sampai' => $sampai,
                'kodedivisi' => $kodedivisi
            );
            return view('lapjual24/tampil', $data);
        }

        if (isset($tombolExport)) {
            // HEADER
            $spreadsheet = new Spreadsheet;
            $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
            $spreadsheet->getActiveSheet()->mergeCells('A1:E1');
            $spreadsheet->getActiveSheet()->mergeCells('A2:E2');
            $spreadsheet->getActiveSheet()->mergeCells('A3:E3');

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
            $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', " S/D " . date('d-M-Y', strtotime($sampai)));

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', $kodedivisi);

            $spreadsheet->getActiveSheet()->getStyle('A5:E5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $spreadsheet->getActiveSheet()->getStyle('A5:E5')->getFill()->getStartColor()->setARGB('FF4F81BD');
            $spreadsheet->getActiveSheet()->getStyle('A5:E5')
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $spreadsheet->getActiveSheet()->getStyle('A5:E5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO SO');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'TGL SO');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'TOTAL SO');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'TOTAL INVOICE');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'BELUM INVOICE');


            $kolom = 6;
            $sw = 0;
            $kdcust = '';
            // DETAIL

            foreach ($laporan as $lap) {
                if ($kdcust != $lap['nama_customer'] . $lap['kode_customer']) {
                    if ($sw == 1) {
                        // $kolom=$kolom+1;
                        $kolom = $kolom + 2;
                    }
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setSize(10);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_customer']);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $kolom = $kolom + 1;
                }

                $sw = 1;

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['no_so']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, date('d-M-Y', strtotime($lap['tgl_so'])));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['total_so']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['realisasi']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['total_so'] - $lap['realisasi']);
                $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $kdcust =  $lap['nama_customer'] . $lap['kode_customer'];
                $kolom = $kolom + 1;
            }

            $kolom = $kolom + 2;


            $writer = new Xlsx($spreadsheet);
            $filename = 'lapjual24' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
