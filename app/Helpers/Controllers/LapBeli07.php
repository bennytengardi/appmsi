<?php

namespace App\Controllers;

use App\Models\ModelSupplier;
use App\Models\ModelPurchInv;
use App\Models\ModelPayment;
use App\Models\ModelLapBeli07;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapBeli07 extends BaseController
{
    function __construct()
    {
        $this->ModelPayment  = new ModelPayment();
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelPurchInv = new ModelPurchInv();
        $this->ModelLapBeli07 = new ModelLapBeli07();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Kartu Hutang',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'supplier' => $this->ModelSupplier->allData2(),
        ];
        return view('lapbeli07/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kodesupp  = $this->request->getPost('kode_supplier');
        $title1    = session()->get('nama_company');

        $title = "LAPORAN KARTU HUTANG";
        $supplier = $this->ModelSupplier->allData();
        foreach ($supplier as $cus) {
            $data = [
                'kode_supplier' => $cus['kode_supplier'],
                'awldbt' => 0,
                'awlcrd' => 0,
                'crd' => 0,
                'dbt' => 0
            ];
            $this->ModelSupplier->clearSaldo($data);
        }

        $awldbt = $this->ModelLapBeli07->awalDebet($dari, $kodesupp);
        foreach ($awldbt as $aw1) {
            $supp = $aw1['kode_supplier'];
            $nilai = $aw1['awldbt'];
            $raw1 = [
                'kode_supplier' => $supp,
                'awldbt' => $nilai
            ];
            $this->ModelLapBeli07->updateSaldoAwal($raw1);
        }
        $awlcrd = $this->ModelLapBeli07->awalCredit($dari, $kodesupp);
        foreach ($awlcrd as $aw1) {
            $supp = $aw1['kode_supplier'];
            $nilai = $aw1['awlcrd'];
            $raw2 = [
                'kode_supplier' => $supp,
                'awlcrd' => $nilai
            ];

            $this->ModelLapBeli07->updateSaldoAwal($raw2);
        }

        $this->ModelLapBeli07->clearKartuHutang();


        if ($kodesupp == "ALL") {
            $dsupp = $this->ModelSupplier->allData();
        } else {
            $dsupp = $this->ModelSupplier->getSupp($kodesupp);
        }
        // dd($dsupp);

        foreach ($dsupp as $aw3) {
            $tglbukti  = date('Y-m-d', strtotime('-1 days', strtotime($dari)));
            $nobukti   = '';
            $rectype   = '1';
            $supp      = $aw3['kode_supplier'];
            $nilai     = $aw3['awal'] + $aw3['awldbt'] - $aw3['awlcrd'];
            $raw1 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => 'Saldo Awal',
                'kode_supplier' => $supp,
                'saldo'         => $nilai,
                'rectype'       => $rectype
            ];

            $this->ModelLapBeli07->insertKartuHutang($raw1);
        }


        $trxdbt = $this->ModelLapBeli07->trxDebet($dari, $sampai, $kodesupp);
        foreach ($trxdbt as $trx1) {
            $tglbukti  = $trx1['tgl_invoice'];
            $nobukti   = $trx1['no_invoice'];
            $rectype   = '1';
            $keterangan = 'Pembelian';
            $supp      = $trx1['kode_supplier'];
            $nilai     = $trx1['total_invoice'];
            $raw2 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_supplier' => $supp,
                'masuk'         => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapBeli07->insertKartuHutang($raw2);
        }

        $trxcrd = $this->ModelLapBeli07->trxCredit($dari, $sampai, $kodesupp);
        foreach ($trxcrd as $trx2) {
            $tglbukti  = $trx2['tgl_payment'];
            $nobukti   = $trx2['no_payment'];
            $rectype   = '2';
            $keterangan = 'Pelunasan';
            $supp      = $trx2['kode_supplier'];
            $nilai     = $trx2['total_bayar'] + $trx2['total_potongan'];
            $raw3 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_supplier' => $supp,
                'keluar'        => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapBeli07->insertKartuHutang($raw3);
        }

        $laporan = $this->ModelLapBeli07->getKartuHutang();

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
            return view('lapbeli07/tampil', $data);
        }


        if (isset($tombolExport)) {
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


            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'TANGGAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NO INVOICE');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'KETERANGAN');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'DEBET');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'CREDIT');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'SALDO');


            $kolom = 6;
            $totdbt = 0;
            $totcrd = 0;
            $saldo = 0;
            $sw = 0;
            $kdsupp = '';
            // DETAIL

            foreach ($laporan as $lap) {
                if ($kdsupp <> $lap['kode_supplier']) {
                    if ($sw == 1) {
                        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'C' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $totdbt);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totcrd);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);

                        $kolom = $kolom + 1;
                        $totdbt = 0;
                        $totcrd = 0;
                    }

                    $kolom = $kolom + 1;
                    $det = $lap['nama_supplier'];
                    $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'F' . $kolom);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $det);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $kdsupp = $lap['kode_supplier'];
                    $saldo  = $lap['saldo'];
                    $kolom  = $kolom + 1;
                }

                $totdbt = $totdbt + $lap['masuk'];
                $totcrd = $totcrd + $lap['keluar'];
                $saldo  = $saldo + $lap['masuk'] - $lap['keluar'];
                $sw = 1;

                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, date('d-M-Y', strtotime($lap['tgl_bukti'])));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $lap['no_bukti']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['keterangan']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['masuk']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['keluar']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $saldo);
                $kolom++;
            }

            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'C' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $totdbt);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totcrd);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapbeli07' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
