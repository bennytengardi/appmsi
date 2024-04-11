<?php

namespace App\Controllers;

use App\Models\ModelSalesInv;
use App\Models\ModelCustomer;
use App\Models\ModelCounter;
use App\Models\ModelReceipt;
use App\Models\ModelDataReceipt;
use App\Models\ModelJurnal;
use App\Models\ModelAccount;
use App\Models\ModelLogHistory;
use Config\Services;

class Receipt extends BaseController
{
    public function __construct()
    {
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelCounter  = new ModelCounter();
        $this->ModelReceipt  = new ModelReceipt();
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelAccount  = new ModelAccount();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date_format(date_create("2023-01-01"), "Y-m-d");
        session()->set('tglawlrcp', $date);
        session()->set('tglakhrcp', date('Y-m-d'));
        session()->set('cust2', 'ALL');
        $data = [
            'customer'    => $this->ModelCustomer->allData2(),
        ];


        return view('receipt/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataReceipt = new ModelDataReceipt($request);
        if ($request->getMethod(true) == 'POST') {
            $receipt = $this->ModelDataReceipt->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($receipt as $cr) {
                $row = [];
                $row[] = $no++;
                $row[] = $cr['no_receipt'];
                $row[] = date('d-m-Y', strtotime($cr['tgl_receipt']));
                $row[] = $cr['nama_customer'];
                $row[] = $cr['no_giro'];
                $row[] = date('d-m-Y', strtotime($cr['tgl_giro']));
                $row[] = $cr['nama_account'];
                $row[] = number_format($cr['total_bayar'], '0', ',', '.');
                $row[] =
                    '<a href="' . base_url('Receipt/edit/' . $cr['no_receipt']) . '" class="btn btn-success btn-xs mr-2"  style="font-size: 12px"><i class="fa fa-edit"></i> Edit</a>' .
                    '<a href="' . base_url('Receipt/detail/' . $cr['no_receipt']) . '" class="btn btn-info btn-xs mr-2"  style="font-size: 12px"><i class="fa fa-eye"></i> Detail</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-xs\"  style=\"font-size: 12px;\" onclick=\"hapusReceipt('" . $cr['no_receipt'] . "','" . $cr['nama_customer'] . "') \"> <i class='fa fa-trash-alt'></i> Delete</button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataReceipt->count_all(),
                "recordsFiltered" => $this->ModelDataReceipt->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        date_default_timezone_set('Asia/Jakarta');
        $ctr    = $this->ModelCounter->allData();
        $nomor  = str_pad(strval(($ctr['cr'] + 1)), 5, '0', STR_PAD_LEFT);
        $no_receipt  = 'CR-' .  date('Y') . '-' . $nomor;
        $tgl_receipt = date('Y-m-d');
        $data = [
            'tgl_receipt'  => $tgl_receipt,
            'tgl_giro'     => $tgl_receipt,
            'account'    => $this->ModelAccount->allDataBank(),
            'customer'     => $this->ModelCustomer->alldata(),
            'no_receipt'   => $no_receipt,
            'validation'   => \config\Services::validation()
        ];
        return view('receipt/v_add', $data);
    }

    public function get_data_si()
    {
        $kode_customer = $this->request->getPost('kode_customer');
        $data = $this->ModelReceipt->get_pibycust($kode_customer);
        echo json_encode($data);
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $no_receipt      = $this->request->getPost('no_receipt');
            $tgl_receipt     = $this->request->getPost('tgl_receipt');
            $kode_customer   = $this->request->getPost('kode_customer');
            $kode_account    = $this->request->getPost('kode_account');
            $no_giro         = $this->request->getPost('no_giro');
            $tgl_giro        = $this->request->getPost('tgl_giro');
            $total_potongan  = str_replace(',', '', $this->request->getPost('total_potongan'));
            $total_bayar     = str_replace(',', '', $this->request->getPost('total_bayar'));
            $total_admin     = str_replace(',', '', $this->request->getPost('total_admin'));
            $total_pph23     = str_replace(',', '', $this->request->getPost('total_pph23'));
            $total_pph4      = str_replace(',', '', $this->request->getPost('total_pph4'));
            $customer        = $this->ModelCustomer->detail($kode_customer);

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'kode_customer' => [
                    'label' => 'Customer ID',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required',
                    ]
                ],
                'kode_account' => [
                    'label' => 'Deposit To',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} is required !!',
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorCustomer'   => $validation->getError('kode_customer'),
                        'errorAccount'    => $validation->getError('kode_account')
                    ]
                ];
            } else {
                $data = [
                    'no_receipt'      => $no_receipt,
                    'tgl_receipt'     => $tgl_receipt,
                    'kode_customer'   => $kode_customer,
                    'kode_account'    => $kode_account,
                    'no_giro'         => $no_giro,
                    'tgl_giro'        => $tgl_giro,
                    'total_potongan'  => $total_potongan,
                    'total_admin'     => $total_admin,
                    'total_pph23'     => $total_pph23,
                    'total_pph4'      => $total_pph4,
                    'total_bayar'     => $total_bayar,
                ];

                $this->ModelReceipt->add($data);
                $ctr = $this->ModelCounter->allData();
                $inv = $ctr['cr'] + 1;
                $datactr = [
                    'cr' => $inv
                ];
                $this->ModelCounter->updctr($datactr);


                $totitem = $this->request->getPost('totalitem');
                for ($i = 1; $i <= $totitem; $i++) {
                    $data1 = [
                        'no_receipt'   => $no_receipt,
                        'no_invoice'   => $this->request->getPost('no_invoice' . $i),
                        'owing'        => str_replace(',', '', $this->request->getPost('owing' . $i)),
                        'jumlah_bayar' => str_replace(',', '', $this->request->getPost('jumlah_bayar' . $i)),
                        'potongan'     => str_replace(',', '', $this->request->getPost('potongan' . $i)),
                        'admin'        => str_replace(',', '', $this->request->getPost('admin' . $i)),
                        'pph23'        => str_replace(',', '', $this->request->getPost('pph23' . $i)),
                        'pph4'         => str_replace(',', '', $this->request->getPost('pph4' . $i)),
                    ];

                    if ($data1['jumlah_bayar'] > 0 || $data1['potongan'] > 0 || $data1['admin'] > 0 || $data1['pph23'] > 0 || $data1['pph4'] > 0) {
                        $this->ModelReceipt->add_detail($data1);
                    }
                }

                // Insert Data Jurnal
                $codejurnal = 'Customer Receipt';
                $description = 'PEMBAYARAN - ' . $customer['nama_customer'];
                $description2 = 'POTONGAN INV - ' . $customer['nama_customer'];
                $description3 = 'BIAYA ADMIN - ' . $customer['nama_customer'];
                $description4 = 'POTONGAN PPH Ps23 - ' . $customer['nama_customer'];
                $description5 = 'POTONGAN PPH Ps4 - ' . $customer['nama_customer'];

                $data2 = [
                    'no_voucher'     => $no_receipt,
                    'tgl_voucher'    => $tgl_receipt,
                    'kode_account'   => session()->get('acctar'),
                    'credit'         => $total_bayar + $total_potongan + $total_admin + $total_pph23 + $total_pph4,
                    'prime_credit'   => $total_bayar + $total_potongan + $total_admin + $total_pph23 + $total_pph4,
                    'debet'          => 0,
                    'prime_debet'    => 0,
                    'keterangan'     => $description,
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data2);

                if ($total_bayar <> 0) {
                    $data3 = [
                        'no_voucher'     => $no_receipt,
                        'tgl_voucher'    => $tgl_receipt,
                        'kode_account'   => $kode_account,
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'debet'          => $total_bayar,
                        'prime_debet'    => $total_bayar,
                        'keterangan'     => $description,
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data3);
                }

                if ($total_potongan <> 0) {
                    $data4 = [
                        'no_voucher'     => $no_receipt,
                        'tgl_voucher'    => $tgl_receipt,
                        'kode_account'   => '6102.013',
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'debet'          => $total_potongan,
                        'prime_debet'    => $total_potongan,
                        'keterangan'     => $description2,
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data4);
                }

                if ($total_admin <> 0) {
                    $data6 = [
                        'no_voucher'     => $no_receipt,
                        'tgl_voucher'    => $tgl_receipt,
                        'kode_account'   => '6102.006',
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'debet'          => $total_admin,
                        'prime_debet'    => $total_admin,
                        'keterangan'     => $description3,
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data6);
                }
                
                if ($total_pph23 <> 0) {
                    $data7 = [
                        'no_voucher'     => $no_receipt,
                        'tgl_voucher'    => $tgl_receipt,
                        'kode_account'   => '1106.003',
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'debet'          => $total_pph23,
                        'prime_debet'    => $total_pph23,
                        'keterangan'     => $description4,
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data7);
                }
                
                if ($total_pph4 <> 0) {
                    $data8 = [
                        'no_voucher'     => $no_receipt,
                        'tgl_voucher'    => $tgl_receipt,
                        'kode_account'   => '1106.005',
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'debet'          => $total_pph4,
                        'prime_debet'    => $total_pph4,
                        'keterangan'     => $description5,
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data8);
                }
                
                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menambah Pelunasan Piutang : ' . $no_receipt,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Customer Receipt has been added !!!'
                ];
                // }
            }
            echo json_encode($msg);
        }
    }

    public function edit($no_receipt)
    {
        $receipt1 =  $this->ModelReceipt->detail($no_receipt);
        $kode_customer = $receipt1['kode_customer'];
        $data = [
            'receipt'      => $receipt1,
            'dreceipt'     => $this->ModelReceipt->detail_cr($no_receipt),
            'doutstanding' => $this->ModelReceipt->detail_outstanding($kode_customer),
            'salesinv'     => $this->ModelSalesInv->allData(),
            'account'      => $this->ModelAccount->allDataBank(),
        ];
        return view('receipt/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $no_receipt      = $this->request->getPost('no_receipt');
            $tgl_receipt     = $this->request->getPost('tgl_receipt');
            $kode_customer   = $this->request->getPost('kode_customer');
            $kode_account    = $this->request->getPost('kode_account');
            $no_giro         = $this->request->getPost('no_giro');
            $tgl_giro        = $this->request->getPost('tgl_giro');
            $total_potongan  = str_replace(',', '', $this->request->getPost('total_potongan'));
            $total_admin     = str_replace(',', '', $this->request->getPost('total_admin'));
            $total_pph23     = str_replace(',', '', $this->request->getPost('total_pph23'));
            $total_pph4      = str_replace(',', '', $this->request->getPost('total_pph4'));
            $total_bayar     = str_replace(',', '', $this->request->getPost('total_bayar'));
            $customer        = $this->ModelCustomer->detail($kode_customer);

            $data = [
                'no_receipt'      => $no_receipt,
                'tgl_receipt'     => $tgl_receipt,
                'kode_customer'   => $kode_customer,
                'kode_account'    => $kode_account,
                'no_giro'         => $no_giro,
                'tgl_giro'        => $tgl_giro,
                'total_potongan'  => $total_potongan,
                'total_admin'     => $total_admin,
                'total_bayar'     => $total_bayar,
            ];
            $this->ModelReceipt->edit($data);
            $this->ModelReceipt->delete_detail($no_receipt);

            $totitem = $this->request->getPost('totalitem');
            for ($i = 1; $i <= $totitem; $i++) {
                $data1 = [
                    'no_receipt'   => $no_receipt,
                    'no_invoice'   => $this->request->getPost('no_invoice' . $i),
                    'owing'        => str_replace(',', '', $this->request->getPost('owing' . $i)),
                    'jumlah_bayar' => str_replace(',', '', $this->request->getPost('jumlah_bayar' . $i)),
                    'potongan'     => str_replace(',', '', $this->request->getPost('potongan' . $i)),
                    'admin'        => str_replace(',', '', $this->request->getPost('admin' . $i)),
                    'pph23'        => str_replace(',', '', $this->request->getPost('pph23' . $i)),
                    'pph4'         => str_replace(',', '', $this->request->getPost('pph4' . $i)),
                ];

               if ($data1['jumlah_bayar'] > 0 || $data1['potongan'] > 0 || $data1['admin'] > 0 || $data1['pph23'] > 0 || $data1['pph4'] > 0) {
                    $this->ModelReceipt->add_detail($data1);
                }
            }

            $this->ModelJurnal->delete_detail($no_receipt);

             // Insert Data Jurnal
            $codejurnal = 'Customer Receipt';
            $description = 'PEMBAYARAN - ' . $customer['nama_customer'];
            $description2 = 'POTONGAN INV - ' . $customer['nama_customer'];
            $description3 = 'BIAYA ADMIN - ' . $customer['nama_customer'];
            $description4 = 'POTONGAN PPH Ps23 - ' . $customer['nama_customer'];
            $description5 = 'POTONGAN PPH Ps4 - ' . $customer['nama_customer'];
            $data2 = [
                'no_voucher'     => $no_receipt,
                'tgl_voucher'    => $tgl_receipt,
                'kode_account'   => session()->get('acctar'),
                'credit'         => $total_bayar + $total_potongan + $total_admin + $total_pph23 + $total_pph4,
                'prime_credit'   => $total_bayar + $total_potongan + $total_admin + $total_pph23 + $total_pph4,
                'debet'          => 0,
                'prime_debet'    => 0,
                'keterangan'     => $description,
                'codejurnal'     => $codejurnal,
            ];
            $this->ModelJurnal->add_detail($data2);

            if ($total_bayar <> 0) {
                $data3 = [
                    'no_voucher'     => $no_receipt,
                    'tgl_voucher'    => $tgl_receipt,
                    'kode_account'   => $kode_account,
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'debet'          => $total_bayar,
                    'prime_debet'    => $total_bayar,
                    'keterangan'     => $description,
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data3);
            }

            if ($total_potongan <> 0) {
                $data4 = [
                    'no_voucher'     => $no_receipt,
                    'tgl_voucher'    => $tgl_receipt,
                    'kode_account'   => '6102.013',
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'debet'          => $total_potongan,
                    'prime_debet'    => $total_potongan,
                    'keterangan'     => $description2,
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data4);
            }

            if ($total_admin <> 0) {
                $data6 = [
                    'no_voucher'     => $no_receipt,
                    'tgl_voucher'    => $tgl_receipt,
                    'kode_account'   => '6102.006',
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'debet'          => $total_admin,
                    'prime_debet'    => $total_admin,
                    'keterangan'     => $description3,
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data6);
            }
            
            if ($total_pph23 <> 0) {
                $data7 = [
                    'no_voucher'     => $no_receipt,
                    'tgl_voucher'    => $tgl_receipt,
                    'kode_account'   => '1106.003',
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'debet'          => $total_pph23,
                    'prime_debet'    => $total_pph23,
                    'keterangan'     => $description4,
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data7);
            }
            
            if ($total_pph4 <> 0) {
                $data8 = [
                    'no_voucher'     => $no_receipt,
                    'tgl_voucher'    => $tgl_receipt,
                    'kode_account'   => '1106.005',
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'debet'          => $total_pph4,
                    'prime_debet'    => $total_pph4,
                    'keterangan'     => $description5,
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data8);
            }

            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Merubah Pelunasan Piutang : ' . $no_receipt,
            ];
            $this->ModelLogHistory->add($datalog);
 
            $msg = ['sukses' => 'Customer Receipt has been Updated !!!'];
            echo json_encode($msg);
        }
    }

    public function setses()
    {
        if ($this->request->isAJAX()) {
            $tgl1 = $this->request->getPost('tgl1');
            $tgl2 = $this->request->getPost('tgl2');
            $cust2 = $this->request->getPost('cust');
            session()->set('tglawlrcp', $tgl1);
            session()->set('tglakhrcp', $tgl2);
            session()->set('cust2', $cust2);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function detail($no_receipt)
    {
        $data = [
            'receipt'    => $this->ModelReceipt->detail($no_receipt),
            'dreceipt'   => $this->ModelReceipt->detail_cr($no_receipt),
        ];
        return view('receipt/v_list', $data);
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $no_receipt = $this->request->getVar('no_receipt');
            $this->ModelReceipt->delete_master($no_receipt);
            $this->ModelReceipt->delete_detail($no_receipt);
            $this->ModelJurnal->delete_detail($no_receipt);

            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Pelunasan Piutang : ' . $no_receipt,
            ];
            $this->ModelLogHistory->add($datalog);

            $msg = ['sukses' => 'Customer Receipt has been Deleted !!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }
}
