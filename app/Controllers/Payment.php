<?php

namespace App\Controllers;

use App\Models\ModelPurchInv;
use App\Models\ModelSupplier;
use App\Models\ModelCounter;
use App\Models\ModelPayment;
use App\Models\ModelDataPayment;
use App\Models\ModelJurnal;
use App\Models\ModelAccount;
use App\Models\ModelLogHistory;
use Config\Services;

class Payment extends BaseController
{
    public function __construct()
    {
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelPurchInv = new ModelPurchInv();
        $this->ModelCounter  = new ModelCounter();
        $this->ModelPayment  = new ModelPayment();
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelAccount  = new ModelAccount();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date_format(date_create("2023-01-01"), "Y-m-d");
        session()->set('tglawlpay', $date);
        session()->set('tglakhpay', date('Y-m-d'));
        return view('payment/v_index');
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataPayment = new ModelDataPayment($request);
        if ($request->getMethod(true) == 'POST') {
            $payment = $this->ModelDataPayment->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($payment as $cr) {
                $row = [];
                $row[] = $no++;
                $row[] = $cr['no_payment'];
                $row[] = date('d-m-Y', strtotime($cr['tgl_payment']));
                $row[] = $cr['nama_supplier'];
                $row[] = $cr['no_giro'];
                $row[] = $cr['nama_account'];
                $row[] = $cr['currency'];
                if ($cr['currency'] == "IDR") {
                    $row[] = number_format($cr['total_bayar'] * $cr['nilai_tukar'], '2', ',', '.');
                } else {
                    $row[] = number_format($cr['total_bayar'], '2', ',', '.');
                }
                $row[] =
                    '<a href="' . base_url('Payment/edit/' . $cr['no_payment']) . '" class="btn btn-success btn-xs mr-2"  style="font-size: 10px; height: 18px;"><i class="fa fa-edit"></i> Edit</a>' .
                    '<a href="' . base_url('Payment/detail/' . $cr['no_payment']) . '" class="btn btn-info btn-xs mr-2"  style="font-size: 10px;height: 18px;"><i class="fa fa-eye"></i> Detail</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-xs\"  style=\"font-size: 10px;height: 18px;\" onclick=\"hapusPayment('" . $cr['no_payment'] . "','" . $cr['nama_supplier'] . "') \"> <i class='fa fa-trash-alt'></i> Delete</button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataPayment->count_all(),
                "recordsFiltered" => $this->ModelDataPayment->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        date_default_timezone_set('Asia/Jakarta');
        $ctr    = $this->ModelCounter->allData();
        $nomor  = str_pad(strval(($ctr['vp'] + 1)), 5, '0', STR_PAD_LEFT);
        $no_payment  = 'VP-' .  date('Y') . '-' . $nomor;
        $tgl_payment = date('Y-m-d');
        $data = [
            'tgl_payment'  => $tgl_payment,
            'tgl_giro'     => $tgl_payment,
            'account'      => $this->ModelAccount->allDataBank(),
            'supplier'     => $this->ModelSupplier->alldata(),
            'no_payment'   => $no_payment,
            'validation'   => \config\Services::validation()
        ];
        return view('payment/v_add', $data);
    }

    public function get_data_pi()
    {
        $kode_supplier = $this->request->getPost('kode_supplier');
        $data = $this->ModelPayment->get_pibysupp($kode_supplier);
        echo json_encode($data);
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $no_payment      = $this->request->getPost('no_payment');
            $tgl_payment     = $this->request->getPost('tgl_payment');
            $kode_supplier   = $this->request->getPost('kode_supplier');
            $kode_account    = $this->request->getPost('kode_account');
            $no_giro         = $this->request->getPost('no_giro');
            $tgl_giro        = $this->request->getPost('tgl_giro');
            $matauang        = $this->request->getPost('matauang');
            $nilai_tukar     = str_replace(',', '', $this->request->getPost('kurs'));
            $total_potongan  = str_replace(',', '', $this->request->getPost('total_potongan'));
            $total_bayar     = str_replace(',', '', $this->request->getPost('total_bayar'));
            $total_pph23     = str_replace(',', '', $this->request->getPost('total_pph23'));
            $total_ongkir    = str_replace(',', '', $this->request->getPost('total_ongkir'));
            $supplier        = $this->ModelSupplier->detail($kode_supplier);

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'kode_supplier' => [
                    'label' => 'Supplier ID',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required',
                    ]
                ],
                'kode_account' => [
                    'label' => 'Payment From',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required !!',
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorSupplier'   => $validation->getError('kode_supplier'),
                        'errorAccount'    => $validation->getError('kode_account')
                    ]
                ];
            } else {
                $data = [
                    'no_payment'      => $no_payment,
                    'tgl_payment'     => $tgl_payment,
                    'kode_supplier'   => $kode_supplier,
                    'kode_account'    => $kode_account,
                    'no_giro'         => $no_giro,
                    'tgl_giro'        => $tgl_giro,
                    'nilai_tukar'     => $nilai_tukar,
                    'total_potongan'  => $total_potongan,
                    'total_bayar'     => $total_bayar,
                    'total_pph23'     => $total_pph23,
                    'total_ongkir'    => $total_ongkir
                ];

                $this->ModelPayment->add($data);
                $ctr = $this->ModelCounter->allData();
                $inv = $ctr['vp'] + 1;
                $datactr = [
                    'vp' => $inv
                ];
                $this->ModelCounter->updctr($datactr);


                $totitem = $this->request->getPost('totalitem');
                for ($i = 1; $i <= $totitem; $i++) {
                    $data1 = [
                        'no_payment'   => $no_payment,
                        'no_invoice'   => $this->request->getPost('no_invoice' . $i),
                        'owing'        => str_replace(',', '', $this->request->getPost('owing' . $i)),
                        'jumlah_bayar' => str_replace(',', '', $this->request->getPost('jumlah_bayar' . $i)),
                        'potongan'     => str_replace(',', '', $this->request->getPost('potongan' . $i)),
                        'pph23'        => str_replace(',', '', $this->request->getPost('pph23' . $i)),
                        'ongkir'        => str_replace(',', '', $this->request->getPost('ongkir' . $i)),
                    ];

                    if ($data1['jumlah_bayar'] > 0 || $data1['potongan'] > 0 || $data1['pph23'] > 0 || $data1['ongkir'] > 0) {
                        $this->ModelPayment->add_detail($data1);
                    }
                }

                // Insert Data Jurnal
                $codejurnal = 'Supplier Payment';
                $description = 'PEMBAYARAN - ' . $supplier['nama_supplier'];
                $description2 = 'POTONGAN INV - ' . $supplier['nama_supplier'];
                $description3 = 'PPH PS23 - ' . $supplier['nama_supplier'];
                $description4 = 'ONGKOS KIRIM - ' . $supplier['nama_supplier'];

                $data2 = [
                    'no_voucher'     => $no_payment,
                    'tgl_voucher'    => $tgl_payment,
                    'kode_account'   => '2101.001',
                    'debet'          => ($total_bayar + $total_potongan + $total_pph23 + $total_ongkir) * $nilai_tukar,
                    'prime_debet'    => $total_bayar + $total_potongan + $total_pph23 + $total_ongkir,
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'keterangan'     => $description,
                    'codejurnal'     => $codejurnal,
                    'rate'           => $nilai_tukar,
                ];
                $this->ModelJurnal->add_detail($data2);

                if ($total_bayar <> 0) {
                    if ($matauang === 'IDR') {
                        $prmcrd = $total_bayar * $nilai_tukar;
                    } else {
                        $prmcrd = $total_bayar;
                    }

                    $data3 = [
                        'no_voucher'     => $no_payment,
                        'tgl_voucher'    => $tgl_payment,
                        'kode_account'   => $kode_account,
                        'debet'          => 0,
                        'prime_debet'    => 0,
                        'credit'         => $total_bayar * $nilai_tukar,
                        'prime_credit'   => $prmcrd,
                        'keterangan'     => $description,
                        'codejurnal'     => $codejurnal,
                        'rate'           => $nilai_tukar,
                    ];
                    $this->ModelJurnal->add_detail($data3);
                }

                if ($total_potongan <> 0) {
                    $data4 = [
                        'no_voucher'     => $no_payment,
                        'tgl_voucher'    => $tgl_payment,
                        'kode_account'   => '6102.006',
                        'debet'          => 0,
                        'prime_debet'    => 0,
                        'credit'         => $total_potongan * $nilai_tukar,
                        'prime_credit'   => $total_potongan,
                        'keterangan'     => $description2,
                        'codejurnal'     => $codejurnal,
                        'rate'           => $nilai_tukar,
                    ];
                    $this->ModelJurnal->add_detail($data4);
                }

               if ($total_pph23 <> 0) {
                    $data6 = [
                        'no_voucher'     => $no_payment,
                        'tgl_voucher'    => $tgl_payment,
                        'kode_account'   => '2104.003',
                        'debet'          => 0,
                        'prime_debet'    => 0,
                        'credit'         => $total_pph23 * $nilai_tukar,
                        'prime_credit'   => $total_pph23,
                        'keterangan'     => $description3,
                        'codejurnal'     => $codejurnal,
                        'rate'           => $nilai_tukar,
                    ];
                    $this->ModelJurnal->add_detail($data6);
                }

               if ($total_ongkir <> 0) {
                    $data7 = [
                        'no_voucher'     => $no_payment,
                        'tgl_voucher'    => $tgl_payment,
                        'kode_account'   => '6108.003',
                        'debet'          => $total_ongkir * $nilai_tukar,
                        'prime_debet'    => $total_ongkir,
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'keterangan'     => $description4,
                        'codejurnal'     => $codejurnal,
                        'rate'           => $nilai_tukar,
                    ];
                    $this->ModelJurnal->add_detail($data7);
                }

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menambah Pembayaran Supplier : ' . $no_payment,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Supplier Payment has been added !!!'
                ];
                // }
            }
            echo json_encode($msg);
        }
    }

    public function edit($no_payment)
    {
        $payment1 =  $this->ModelPayment->detail($no_payment);
        $kode_supplier = $payment1['kode_supplier'];
        $data = [
            'payment'      => $payment1,
            'dpayment'     => $this->ModelPayment->detail_vp($no_payment),
            'doutstanding' => $this->ModelPayment->detail_outstanding($kode_supplier),
            'PurchInv'     => $this->ModelPurchInv->allData(),
            'account'      => $this->ModelAccount->allDataBank(),
        ];
        return view('payment/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $no_payment      = $this->request->getPost('no_payment');
            $tgl_payment     = $this->request->getPost('tgl_payment');
            $kode_supplier   = $this->request->getPost('kode_supplier');
            $kode_account    = $this->request->getPost('kode_account');
            $no_giro         = $this->request->getPost('no_giro');
            $tgl_giro        = $this->request->getPost('tgl_giro');
            $matauang        = $this->request->getPost('matauang');
            $nilai_tukar     = str_replace(',', '', $this->request->getPost('kurs'));
            $total_potongan  = str_replace(',', '', $this->request->getPost('total_potongan'));
            $total_pph23     = str_replace(',', '', $this->request->getPost('total_pph23'));
            $total_ongkir    = str_replace(',', '', $this->request->getPost('total_ongkir'));
            $total_bayar     = str_replace(',', '', $this->request->getPost('total_bayar'));
            $supplier        = $this->ModelSupplier->detail($kode_supplier);
            

            $data = [
                'no_payment'      => $no_payment,
                'tgl_payment'     => $tgl_payment,
                'kode_supplier'   => $kode_supplier,
                'kode_account'    => $kode_account,
                'no_giro'         => $no_giro,
                'tgl_giro'        => $tgl_giro,
                'nilai_tukar'     => $nilai_tukar,
                'total_potongan'  => $total_potongan,
                'total_pph23'     => $total_pph23,
                'total_ongkir'    => $total_ongkir,
                'total_bayar'     => $total_bayar,
            ];
            $this->ModelPayment->edit($data);

            $this->ModelPayment->delete_detail($no_payment);

            $totitem = $this->request->getPost('totalitem');
            for ($i = 1; $i <= $totitem; $i++) {
                $data1 = [
                    'no_payment'   => $no_payment,
                    'no_invoice'   => $this->request->getPost('no_invoice' . $i),
                    'owing'        => str_replace(',', '', $this->request->getPost('owing' . $i)),
                    'jumlah_bayar' => str_replace(',', '', $this->request->getPost('jumlah_bayar' . $i)),
                    'potongan'     => str_replace(',', '', $this->request->getPost('potongan' . $i)),
                    'pph23'        => str_replace(',', '', $this->request->getPost('pph23' . $i)),
                    'ongkir'       => str_replace(',', '', $this->request->getPost('ongkir' . $i)),
                ];

                if ($data1['jumlah_bayar'] > 0 || $data1['potongan'] > 0 || $data1['pph23'] > 0 || $data1['ongkir'] > 0) {
                    $this->ModelPayment->add_detail($data1);
                }
            }

            $this->ModelJurnal->delete_detail($no_payment);

            // Insert Data Jurnal
            $codejurnal = 'Supplier Payment';
            $description = 'PEMBAYARAN - ' . $supplier['nama_supplier'];
            $description2 = 'POTONGAN INV - ' . $supplier['nama_supplier'];
            $description3 = 'PPH PS23 - ' . $supplier['nama_supplier'];
            $description4 = 'ONGKOS KIRIM - ' . $supplier['nama_supplier'];

            $data2 = [
                'no_voucher'     => $no_payment,
                'tgl_voucher'    => $tgl_payment,
                'kode_account'   => '2101.001',
                'debet'          => ($total_bayar + $total_potongan + $total_pph23 - $total_ongkir) * $nilai_tukar,
                'prime_debet'    => $total_bayar + $total_potongan + $total_pph23 - $total_ongkir,
                'credit'         => 0,
                'prime_credit'   => 0,
                'keterangan'     => $description,
                'codejurnal'     => $codejurnal,
                'rate'           => $nilai_tukar,
            ];
            $this->ModelJurnal->add_detail($data2);

            if ($total_bayar <> 0) {
                if ($matauang === 'IDR') {
                    $prmcrd = $total_bayar * $nilai_tukar;
                } else {
                    $prmcrd = $total_bayar;
                }
                $data3 = [
                    'no_voucher'     => $no_payment,
                    'tgl_voucher'    => $tgl_payment,
                    'kode_account'   => $kode_account,
                    'debet'          => 0,
                    'prime_debet'    => 0,
                    'credit'         => $total_bayar * $nilai_tukar,
                    'prime_credit'   => $prmcrd,
                    'keterangan'     => $description,
                    'codejurnal'     => $codejurnal,
                    'rate'           => $nilai_tukar,
                ];
                $this->ModelJurnal->add_detail($data3);
            }

            if ($total_potongan <> 0) {
                $data4 = [
                    'no_voucher'     => $no_payment,
                    'tgl_voucher'    => $tgl_payment,
                    'kode_account'   => '6102.006',
                    'debet'          => 0,
                    'prime_debet'    => 0,
                    'credit'         => $total_potongan * $nilai_tukar,
                    'prime_credit'   => $total_potongan,
                    'keterangan'     => $description2,
                    'codejurnal'     => $codejurnal,
                    'rate'           => $nilai_tukar,
                ];
                $this->ModelJurnal->add_detail($data4);
            }

           if ($total_pph23 <> 0) {
                $data6 = [
                    'no_voucher'     => $no_payment,
                    'tgl_voucher'    => $tgl_payment,
                    'kode_account'   => '2104.003',
                    'debet'          => 0,
                    'prime_debet'    => 0,
                    'credit'         => $total_pph23 * $nilai_tukar,
                    'prime_credit'   => $total_pph23,
                    'keterangan'     => $description3,
                    'codejurnal'     => $codejurnal,
                    'rate'           => $nilai_tukar,
                ];
                $this->ModelJurnal->add_detail($data6);
            }
            
            if ($total_ongkir <> 0) {
                $data7 = [
                    'no_voucher'     => $no_payment,
                    'tgl_voucher'    => $tgl_payment,
                    'kode_account'   => '6108.003',
                    'debet'          => $total_ongkir * $nilai_tukar,
                    'prime_debet'    => $total_ongkir,
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'keterangan'     => $description4,
                    'codejurnal'     => $codejurnal,
                    'rate'           => $nilai_tukar,
                ];
                $this->ModelJurnal->add_detail($data7);
            }

            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Merubah Pembayaran Supplier : ' . $no_payment,
            ];
            $this->ModelLogHistory->add($datalog);

            $msg = ['sukses' => 'Supplier Payment has been Updated !!!'];
            echo json_encode($msg);
        }
    }

    public function setses()
    {
        if ($this->request->isAJAX()) {
            $tgl1 = $this->request->getPost('tgl1');
            $tgl2 = $this->request->getPost('tgl2');
            session()->set('tglawlpay', $tgl1);
            session()->set('tglakhpay', $tgl2);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function detail($no_payment)
    {
        $data = [
            'payment'    => $this->ModelPayment->detail($no_payment),
            'dpayment'   => $this->ModelPayment->detail_vp($no_payment),
        ];
        return view('payment/v_list', $data);
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $no_payment = $this->request->getVar('no_payment');
            $this->ModelPayment->delete_master($no_payment);
            $this->ModelPayment->delete_detail($no_payment);
            $this->ModelJurnal->delete_detail($no_payment);
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Pembayaran Supplier : ' . $no_payment,
            ];
            $this->ModelLogHistory->add($datalog);
            
            $msg = ['sukses' => 'Supplier Payment has been deleted'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }
}
