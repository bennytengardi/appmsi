<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesman;
use App\Models\ModelDataCustomer;
use App\Models\ModelBarang;
use App\Models\ModelSalesInv;
use App\Models\ModelDataSalesInv;
use App\Models\ModelCounter;
use App\Models\ModelDataBrg;
use App\Models\ModelDivisi;
use App\Models\ModelJurnal;
use App\Models\ModelLogHistory;

// use CodeIgniter\CLI\Console;
use Config\Services;

class SalesInv extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelSalesman = new ModelSalesman();
        $this->ModelDivisi   = new ModelDivisi();
        $this->ModelCounter  = new ModelCounter();
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date_format(date_create("2023-01-01"), "Y-m-d");
        session()->set('tglawlinv', $date);
        session()->set('tglakhinv', date('Y-m-d'));
        session()->set('cust1', 'ALL');
        $data = [
            'customer'    => $this->ModelCustomer->allData2(),
        ];
        return view('salesinv/v_index', $data);
    }

    public function index2($id_inv)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date_format(date_create("2023-01-01"), "Y-m-d");
        session()->set('tglawlinv', $date);
        session()->set('tglakhinv', date('Y-m-d'));
        session()->set('cust1', 'ALL');

        $mb = $this->ModelSalesInv->detail($id_inv);
        $no_invoice = $mb['no_invoice'];
        $this->ModelSalesInv->clearCart($no_invoice);

        $data = [
            'customer'    => $this->ModelCustomer->allData2(),
        ];
        return view('salesinv/v_index', $data);
    }


    public function listData()
    {
        $request = Services::request();
        $this->ModelDataSalesInv = new ModelDataSalesInv($request);
        if ($request->getMethod(true) == 'POST') {
            $salesinv = $this->ModelDataSalesInv->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($salesinv as $sl) {
                $row = [];
                $row[] = $no++;
                $row[] = $sl['no_invoice'];
                $row[] = date('d-m-Y', strtotime($sl['tgl_invoice']));
                $row[] = $sl['nama_customer'];
                $row[] = $sl['no_suratjln'];
                $row[] = $sl['kode_divisi'];
                $row[] = number_format($sl['total_invoice'], '0', '.', ',');
                if (($sl['total_invoice'] - $sl['total_retur']) > ($sl['total_bayar'] + $sl['total_potongan'])) {
                    $row[] = "<span class=\"badge badge-pill badge-primary\" style=\"border-radius: 10px; padding: 5px; font-weight: normal\"></span>";
                } else {
                    $row[] = "<span class=\"badge badge-pill badge-danger\" style=\"border-radius: 10px; padding: 7px; font-weight: normal \">Paid<span>";
                }
                if (session()->get('level') == "1") {
                    $row[] =
                        '<a href="' . base_url('SalesInv/edit/' . $sl['id_inv']) . '" class="btn btn-success btn-xs mr-2"></i>Edit</a>' .
                        '<a href="' . base_url('SalesInv/detail/' . $sl['id_inv']) . '" class="btn btn-info btn-xs mr-2">Detail</a>' .
                        '<a href="' . base_url('SalesInv/print/' . $sl['id_inv']) . '" class="btn btn-primary btn-xs mr-2">Inv Jhns</a>' .
                        '<a href="' . base_url('SalesInv/print2/' . $sl['id_inv']) . '" class="btn btn-primary btn-xs mr-2">Inv Frnk</a>' .
                        "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"hapusSalesInv('" . $sl['no_invoice'] . "','" . $sl['nama_customer'] . "') \">Delete</button>";
                } else {
                    $row[] =
                        '<a href="' . base_url('SalesInv/detail/' . $sl['id_inv']) . '" class="btn btn-info btn-xs mr-2">See Detail</a>' .
                        '<a href="' . base_url('SalesInv/print/' . $sl['id_inv']) . '" class="btn btn-success btn-xs mr-2">Inv Johnson</a>' .
                        '<a href="' . base_url('SalesInv/print2/' . $sl['id_inv']) . '" class="btn btn-danger btn-xs mr-2">Inv Franklin</a>' ;
                }
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataSalesInv->count_all(),
                "recordsFiltered" => $this->ModelDataSalesInv->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
        
    public function add()
    {
        date_default_timezone_set('Asia/Jakarta');
        session()->set('dp',0);
        session()->set('disc',0);
        session()->set('ongkir',0);
        $tgl_invoice = date('Y-m-d');
        $no_random = rand();
        $no_invoice = '';
        $data = [
            'tgl_invoice'  => $tgl_invoice,
            'due_date'     => $tgl_invoice,
            'divisi'       => $this->ModelDivisi->allData(),
            'barang'       => $this->ModelBarang->allData(),
            'salesman'     => $this->ModelSalesman->allData(),
            'customer'     => $this->ModelCustomer->allData(),
            'no_invoice'   => $no_invoice,
            'no_random'    => $no_random,
            'validation'   => \config\Services::validation()
        ];
        $this->ModelSalesInv->clearCart($no_random);
        return view('salesinv/v_add', $data);
    }

    public function setses()
    {
        if ($this->request->isAJAX()) {
            $tgl1 = $this->request->getPost('tgl1');
            $tgl2 = $this->request->getPost('tgl2');
            $cust1 = $this->request->getPost('cust');

            session()->set('tglawlinv', $tgl1);
            session()->set('tglakhinv', $tgl2);
            session()->set('cust1', $cust1);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function viewDataBarang()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getPost('keyword');
            $data = [
                'keyword' => $keyword,
            ];
            $msg = [
                'viewmodal' => view('salesinv/v_caribarang', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function listDataBarang()
    {
        if ($this->request->isAJAX()) {
            $keywordkodebarang = $this->request->getPost('keywordkodebarang');
            $request = Services::request();
            $modeldatabrg = new ModelDataBrg($request);
            if ($request->getMethod(true) == 'POST') {
                $lists = $modeldatabrg->get_datatables($keywordkodebarang);
                $data = [];
                $no = $request->getPost("start");
                foreach ($lists as $list) {
                    $no++;
                    $row = [];
                    $row[] = $no;
                    $row[] = $list['kode_barang'];
                    $row[] = $list['nama_barang'];
                    $row[] = number_format($list['awal'] + $list['masuk'] + $list['returjual'] - $list['keluar'] - $list['returbeli'] + $list['adjust'], 0, '.', ',');
                    $row[] = $list['kode_satuan'];
                    $row[] = number_format($list['hargajual'], 0);
                    $row[] = "<button type=\"button\" class=\"btn btn-xs btn-info\" style=\"height: 26px; font-size: 12px;\"  onclick=\"pilihitem('" . $list['kode_barang'] .  "','" . "')\" ><i class=\"fa fa-check\"></i></button>";
                    $data[] = $row;
                }
                $output = [
                    "draw" => $request->getPost('draw'),
                    "recordsTotal" => $modeldatabrg->count_all($keywordkodebarang),
                    "recordsFiltered" => $modeldatabrg->count_filtered($keywordkodebarang),
                    "data" => $data
                ];
                echo json_encode($output);
            }
        }
    }

    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $no_invoice = $this->request->getPost('no_invoice');
            $dtl        = $this->ModelSalesInv->getCart($no_invoice);
            $data  = [
                'datadetail' => $dtl
            ];
            $msg = [
                'data' => view('salesinv/v_harga', $data)
            ];
            echo json_encode($msg);
        }
    }

   
    public function simpanTemp()
    {
        if ($this->request->isAJAX()) {
            if (empty($this->request->getPost('qty'))) {
                $qty = 0;
            } else {
                $qty  = str_replace(',', '', $this->request->getPost('qty'));
            }
            if (empty($this->request->getPost('harga'))) {
                $harga = 0;
            } else {
                $harga = str_replace(',', '', $this->request->getPost('harga'));
            }
            if (empty($this->request->getPost('cogs'))) {
                $cogs = 0;
            } else {
                $cogs = str_replace(',', '', $this->request->getPost('cogs'));
            }
            
            $no_random   = $this->request->getPost('no_random');
            $id_barang   = $this->request->getPost('id_barang');
            $kode_barang = $this->request->getPost('kode_barang');
            $nama_barang = $this->request->getPost('nama_barang');

            if (strlen($nama_barang) > 0) {
                $queryCekBarang = $this->db->table('tbl_barang')
                    ->where('kode_barang', $kode_barang)
                    ->where('nama_barang', $nama_barang)->get();
            } else {
                $queryCekBarang = $this->db->table('tbl_barang')
                    ->like('kode_barang', $kode_barang)
                    ->orLike('nama_barang', $kode_barang)->get();
            }

            $totalData = $queryCekBarang->getNumRows();
            if ($totalData > 1) {
                $msg = [
                    'totaldata' => 'banyak'
                ];
            } else if ($totalData == 1) {
                $tkeranjang = $this->db->table('keranjangjual');
                $barang     = $queryCekBarang->getRowArray();
                $subtotal   = $qty * $harga;
                $isikeranjang = [
                    'no_invoice'  => $no_random,
                    'id_barang'   => $id_barang,
                    'kode_barang' => $kode_barang,
                    'harga'       => $harga,
                    'qty'         => $qty,
                    'cogs'        => $cogs,
                    'subtotal'    => $subtotal
                ];
                $tkeranjang->insert($isikeranjang);
                $msg = ['sukses' => 'berhasil'];
            } else {
                $msg = ['error' => 'Maaf Barang ini tidak ditemukan'];
            }
            echo json_encode($msg);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $no_random     = $this->request->getPost('no_random');
            $no_invoice    = $this->request->getPost('no_invoice');
            $tgl_invoice   = $this->request->getPost('tgl_invoice');
            $kode_divisi   = $this->request->getPost('kode_divisi');
            $kodejual      = $this->request->getPost('kodejual');
            $kode_customer = $this->request->getPost('kode_customer');
            $no_suratjln   = $this->request->getPost('no_suratjln');
            $pembayaran    = $this->request->getPost('pembayaran');
            $description   = $this->request->getPost('description');
            $total_amount   = str_replace(',', '', $this->request->getPost('total_amount'));
            $total_discount = str_replace(',', '', $this->request->getPost('total_discount'));
            $total_dp       = str_replace(',', '', $this->request->getPost('total_dp'));
            $total_dpp      = str_replace(',', '', $this->request->getPost('total_dpp'));
            $total_ppn      = str_replace(',', '', $this->request->getPost('total_ppn'));
            $ongkir         = str_replace(',', '', $this->request->getPost('ongkir'));
            $total_invoice  = str_replace(',', '', $this->request->getPost('total_invoice'));
            $total_hpp      = str_replace(',', '', $this->request->getPost('total_hpp'));
            $kode_accjual   = $this->request->getPost('kode_accjual');            
            $kode_acchpp    = $this->request->getPost('kode_acchpp');
            $kode_accinv    = $this->request->getPost('kode_accinv');            
            $kode_salesman  = $this->request->getPost('kode_salesman');            
            $customer       = $this->ModelCustomer->detail($kode_customer);
            
            $validation =  \Config\Services::validation();
        
            $valid = $this->validate([
                'kode_customer' => [
                    'label' => 'Kode Customer',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi'
                    ]
                ],
                'no_invoice' => [
                    'label' => 'No Invoice',
                    'rules' => 'required|is_unique[tbl_salesinv.no_invoice]',
                    'errors' => [
                        'required'  => '{field} harus diisi',
                        'is_unique' => '{field} sudah ada'
                    ]
                ],
                'no_suratjln' => [
                    'label' => 'No.DO',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi'
                    ]
                ],
                'kode_divisi' => [
                    'label' => 'Kode Divisi',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorKodeCustomer' => $validation->getError('kode_customer'),
                        'errorNoInvoice'    => $validation->getError('no_invoice'),
                        'errorNoSj'         => $validation->getError('no_suratjln'),
                        'errorKodeDivisi'   => $validation->getError('kode_divisi'),
                    ]
                ];
                echo json_encode($msg);
            } else {
                $ambildatakeranjang = $this->ModelSalesInv->getCart($no_random);
                if (empty($ambildatakeranjang)) {
                    $msg = [
                        'error' => 'Maaf, Belum diisi transaksi !!!!'
                    ];
                    echo json_encode($msg);
                } else {
                    $data = [
                        'no_invoice'     => $no_invoice,
                        'tgl_invoice'    => $tgl_invoice,
                        'kode_divisi'    => $kode_divisi,
                        'kodejual'       => $kodejual,
                        'kode_customer'  => $kode_customer,
                        'kode_salesman'  => $kode_salesman,
                        'no_suratjln'    => $no_suratjln,
                        'pembayaran'     => $pembayaran,
                        'keterangan'     => $description,
                        'total_amount'   => $total_amount,
                        'total_discount' => $total_discount,
                        'total_dp'       => $total_dp,
                        'total_dpp'      => $total_dpp,
                        'total_ppn'      => $total_ppn,
                        'ongkir'         => $ongkir,
                        'total_invoice'  => $total_invoice,
                        'total_hpp'      => $total_hpp
                    ];           
                    $this->ModelSalesInv->add($data);

                    foreach ($ambildatakeranjang as $row) :
                        $datainv = array(
                            'no_invoice'   => $no_invoice,
                            'id_barang'    => $row['id_barang'],
                            'kode_barang'  => $row['kode_barang'],
                            'qty'          => $row['qty'],
                            'harga'        => $row['harga'],
                            'cogs'         => $row['cogs'],
                            'subtotal'     => $row['subtotal'],
                        );
                        $this->ModelSalesInv->add_detail($datainv);
                    endforeach;

                    // Insert Jurnal

                    if ($kodejual == 'SALES') {
                        $codejurnal = 'Sales Invoice';
                        $keterangan = 'PENJUALAN - ' . $customer['nama_customer'];
                        $data1 = [
                            'no_voucher'     => $no_invoice,
                            'tgl_voucher'    => $tgl_invoice,
                            'kode_account'   => session()->get('acctar'),
                            'debet'          => $total_invoice,
                            'prime_debet'    => $total_invoice,
                            'credit'         => 0,
                            'prime_credit'   => 0,
                            'rate'           => 1,
                            'keterangan'     => $keterangan,
                            'codejurnal'     => $codejurnal,
                        ];
                        $this->ModelJurnal->add_detail($data1);
    
                        if ($total_dp > 0) {
                            $data0 = [
                                'no_voucher'     => $no_invoice,
                                'tgl_voucher'    => $tgl_invoice,
                                'kode_account'   => session()->get('acctumuka'),
                                'debet'          => $total_dp,
                                'prime_debet'    => $total_dp,
                                'credit'         => 0,
                                'prime_credit'   => 0,
                                'rate'           => 1,
                                'keterangan'     => $keterangan,
                                'codejurnal'     => $codejurnal,
                            ];
                            $this->ModelJurnal->add_detail($data0);
                        }
    
                        $data2 = [
                            'no_voucher'     => $no_invoice,
                            'tgl_voucher'    => $tgl_invoice,
                            'kode_account'   => $kode_accjual,
                            'debet'          => 0,
                            'prime_debet'    => 0,
                            'credit'         => $total_amount - $total_discount,
                            'prime_credit'   => $total_amount - $total_discount,
                            'rate'           => 1,
                            'keterangan'     => $keterangan,
                            'codejurnal'     => $codejurnal,
                        ];
                        $this->ModelJurnal->add_detail($data2);
    
                        if ($total_ppn > 0) {
                            $data3 = [
                                'no_voucher'     => $no_invoice,
                                'tgl_voucher'    => $tgl_invoice,
                                'kode_account'   => session()->get('acctppnk'),
                                'debet'          => 0,
                                'prime_debet'    => 0,
                                'credit'         => $total_ppn,
                                'prime_credit'   => $total_ppn,
                                'rate'           => 1,
                                'keterangan'     => $keterangan,
                                'codejurnal'     => $codejurnal,
                            ];
                            $this->ModelJurnal->add_detail($data3);
                        }
                        
                        if ($total_hpp > 0) {
                            $data4 = [
                                'no_voucher'     => $no_invoice,
                                'tgl_voucher'    => $tgl_invoice,
                                'kode_account'   => $kode_acchpp,
                                'debet'          => $total_hpp,
                                'prime_debet'    => $total_hpp,
                                'credit'         => 0,
                                'prime_credit'   => 0,
                                'rate'           => 1,
                                'keterangan'     => $keterangan,
                                'codejurnal'     => $codejurnal,
                            ];
                            $this->ModelJurnal->add_detail($data4);
            
                            $data5 = [
                                'no_voucher'     => $no_invoice,
                                'tgl_voucher'    => $tgl_invoice,
                                'kode_account'   => $kode_accinv,
                                'debet'          => 0,
                                'prime_debet'    => 0,
                                'credit'         => $total_hpp,
                                'prime_credit'   => $total_hpp,
                                'rate'           => 1,
                                'keterangan'     => $keterangan,
                                'codejurnal'     => $codejurnal,
                            ];
                            $this->ModelJurnal->add_detail($data5);
                        }
    
                        if ($ongkir > 0) {
                            $data6 = [
                                'no_voucher'     => $no_invoice,
                                'tgl_voucher'    => $tgl_invoice,
                                'kode_account'   => '6108.003',
                                'debet'          => 0,
                                'prime_debet'    => 0,
                                'credit'         => $ongkir,
                                'prime_credit'   => $ongkir,
                                'rate'           => 1,
                                'keterangan'     => $keterangan,
                                'codejurnal'     => $codejurnal,
                            ];
                            $this->ModelJurnal->add_detail($data6);
                        }
                    } else {
                        $codejurnal = 'Sales Invoice';
                        $keterangan = 'UANG MUKA - ' . $customer['nama_customer'];
                        $data1 = [
                            'no_voucher'     => $no_invoice,
                            'tgl_voucher'    => $tgl_invoice,
                            'kode_account'   => session()->get('acctar'),
                            'debet'          => $total_invoice,
                            'prime_debet'    => $total_invoice,
                            'credit'         => 0,
                            'prime_credit'   => 0,
                            'rate'           => 1,
                            'keterangan'     => $keterangan,
                            'codejurnal'     => $codejurnal,
                        ];
                        $this->ModelJurnal->add_detail($data1);

                        if ($total_ppn > 0) {
                            $data3 = [
                                'no_voucher'     => $no_invoice,
                                'tgl_voucher'    => $tgl_invoice,
                                'kode_account'   => session()->get('acctppnk'),
                                'debet'          => 0,
                                'prime_debet'    => 0,
                                'credit'         => $total_ppn,
                                'prime_credit'   => $total_ppn,
                                'rate'           => 1,
                                'keterangan'     => $keterangan,
                                'codejurnal'     => $codejurnal,
                            ];
                            $this->ModelJurnal->add_detail($data3);
                        }
                        
                        $data0 = [
                            'no_voucher'     => $no_invoice,
                            'tgl_voucher'    => $tgl_invoice,
                            'kode_account'   => session()->get('acctumuka'),
                            'debet'          => 0,
                            'prime_debet'    => 0,
                            'credit'         => $total_dpp,
                            'prime_credit'   => $total_dpp,
                            'rate'           => 1,
                            'keterangan'     => $keterangan,
                            'codejurnal'     => $codejurnal,
                        ];
                        $this->ModelJurnal->add_detail($data0);
                    }

                    $this->ModelSalesInv->clearCart($no_random);

                    date_default_timezone_set('Asia/Jakarta');
                    $datalog = [
                        'username'  => session()->get('username'),
                        'jamtrx'    => date('Y-m-d H:i:s'),
                        'kegiatan'  => 'Menambah Sales Invoice : ' . $no_invoice,
                    ];
                    $this->ModelLogHistory->add($datalog);

                    $msg = [
                        'sukses' => 'Sales Invoice has been Added'
                    ];
                    echo json_encode($msg);
                }
            }
        }
    }

    public function edit($id_inv)
    {
        $msalesinv = $this->ModelSalesInv->detail($id_inv);
        session()->set('dp',$msalesinv['total_dp']);
        session()->set('disc',$msalesinv['total_discount']);
        session()->set('ongkir',$msalesinv['ongkir']);

        $no_invoice  = $msalesinv['no_invoice'];
        $dsalesinv   = $this->ModelSalesInv->detail_si($no_invoice);
        $this->ModelSalesInv->clearCart($no_invoice);
        foreach ($dsalesinv as $sinv) {
            $datakeranjang = array(
                'id_salesinv' => $sinv['id_salesinv'],
                'no_invoice'  => $sinv['no_invoice'],
                'id_barang'   => $sinv['id_barang'],
                'kode_barang' => $sinv['kode_barang'],
                'qty'         => $sinv['qty'],
                'harga'       => $sinv['harga'],
                'cogs'        => $sinv['cogs'],
                'subtotal'    => $sinv['subtotal'],
            );
            $this->ModelSalesInv->addCart($datakeranjang);
        }

        $data = [
            'minvoice'       => $msalesinv,
            'divisi'         => $this->ModelDivisi->allData(),
            'customer'       => $this->ModelCustomer->allData(),
            'salesman'       => $this->ModelSalesman->allData(),
            'barang'         => $this->ModelBarang->allData(),
        ];
        
        return view('salesinv/v_edit', $data);
    }

    public function viewEditHarga()
    {
        if ($this->request->isAJAX()) {
            $id_salesinv  = $this->request->getPost('id_salesinv');
            $no_invoice   = $this->request->getPost('no_invoice');
            $id_barang    = $this->request->getPost('id_barang');
            $kode_barang  = $this->request->getPost('kode_barang');
            $nama_barang  = $this->request->getPost('nama_barang');
            $kode_satuan  = $this->request->getPost('kode_satuan');
            $qty          = $this->request->getPost('qty');
            $harga        = $this->request->getPost('harga');
            $cogs         = $this->request->getPost('cogs');
            $subtotal     = $this->request->getPost('subtotal');

            $data = [
                'id_salesinv' => $id_salesinv,
                'no_invoice'  => $no_invoice,
                'id_barang'   => $id_barang,
                'kode_barang' => $kode_barang,
                'nama_barang' => $nama_barang,
                'kode_satuan' => $kode_satuan,
                'qty'         => $qty,
                'harga'       => $harga,
                'cogs'        => $cogs,
                'subtotal'    => $subtotal,
            ];
            $msg = [
                'viewmodal' => view('salesinv/v_editharga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updateHarga()
    {
        if ($this->request->isAJAX()) {
            $id_salesinv   = $this->request->getPost('id_salesinv');
            $no_invoice    = $this->request->getPost('no_invoice');
            $qty           = $this->request->getPost('qty');
            $harga         = str_replace(',', '', $this->request->getPost('harga'));
            $cogs          = str_replace(',', '', $this->request->getPost('cogs'));
            $subtotal      = str_replace(',', '', $qty * $harga);
            $data = array(
                'id_salesinv' => $id_salesinv,
                'no_invoice'  => $no_invoice,
                'qty'         => $qty,
                'harga'       => $harga,
                'cogs'        => $cogs,
                'subtotal'    => $subtotal,
            );
            $this->ModelSalesInv->editCart($data);

            $msg = [
                'sukses' => 'berhasil'
            ];

            echo json_encode($msg);
        }
    }


    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            date_default_timezone_set('Asia/Jakarta');
            $id_inv        = $this->request->getPost('id_inv');
            $no_invoice    = $this->request->getPost('no_invoice');
            $tgl_invoice   = $this->request->getPost('tgl_invoice');
            $kode_divisi   = $this->request->getPost('kode_divisi');
            $kodejual      = $this->request->getPost('kodejual');
            $kode_customer = $this->request->getPost('kode_customer');
            $kode_salesman = $this->request->getPost('kode_salesman');
            $no_suratjln   = $this->request->getPost('no_suratjln');
            $pembayaran    = $this->request->getPost('pembayaran');
            $description   = $this->request->getPost('description');
            $total_amount   = str_replace(',', '', $this->request->getPost('total_amount'));
            $total_discount = str_replace(',', '', $this->request->getPost('total_discount'));
            $total_dp       = str_replace(',', '', $this->request->getPost('total_dp'));
            $total_dpp      = str_replace(',', '', $this->request->getPost('total_dpp'));
            $total_ppn      = str_replace(',', '', $this->request->getPost('total_ppn'));
            $ongkir         = str_replace(',', '', $this->request->getPost('ongkir'));
            $total_invoice  = str_replace(',', '', $this->request->getPost('total_invoice'));
            $total_hpp      = str_replace(',', '', $this->request->getPost('total_hpp'));
            $kode_accjual   = $this->request->getPost('kode_accjual');            
            $kode_acchpp    = $this->request->getPost('kode_acchpp');
            $kode_accinv    = $this->request->getPost('kode_accinv');            
            
            $customer       = $this->ModelCustomer->detail($kode_customer);

            $data = [
                'id_inv'         => $id_inv,
                'no_invoice'     => $no_invoice,
                'tgl_invoice'    => $tgl_invoice,
                'kode_divisi'    => $kode_divisi,
                'kodejual'       => $kodejual,
                'kode_customer'  => $kode_customer,
                'kode_salesman'  => $kode_salesman,
                'no_suratjln'    => $no_suratjln,
                'pembayaran'     => $pembayaran,
                'keterangan'     => $description,
                'total_amount'   => $total_amount,
                'total_discount' => $total_discount,
                'total_dp'       => $total_dp,
                'total_dpp'      => $total_dpp,
                'total_ppn'      => $total_ppn,  
                'ongkir'         => $ongkir,
                'total_invoice'  => $total_invoice,
                'total_hpp'      => $total_hpp,
            ];           

            $ambildatakeranjang = $this->ModelSalesInv->getCart($no_invoice);
            if (empty($ambildatakeranjang)) {
                $msg = [
                    'error' => 'Maaf, Belum diisi transaksi !!!!'
                ];
                echo json_encode($msg);
            } else {
                $this->ModelSalesInv->edit($data);
                $this->ModelSalesInv->delete_detail($no_invoice);
                
                foreach ($ambildatakeranjang as $row) :
                    $datainv = array(
                        'no_invoice'   => $row['no_invoice'],
                        'id_barang'    => $row['id_barang'],
                        'kode_barang'  => $row['kode_barang'],
                        'qty'          => $row['qty'],
                        'harga'        => $row['harga'],
                        'cogs'         => $row['cogs'],
                        'subtotal'     => $row['subtotal'],
                    );
                    $this->ModelSalesInv->add_detail($datainv);
                endforeach;
                $this->ModelJurnal->delete_detail($no_invoice);

                if ($kodejual == 'SALES') {
                    $codejurnal = 'Sales Invoice';
                    $keterangan = 'PENJUALAN - ' . $customer['nama_customer'];
                    $data1 = [
                        'no_voucher'     => $no_invoice,
                        'tgl_voucher'    => $tgl_invoice,
                        'kode_account'   => session()->get('acctar'),
                        'debet'          => $total_invoice,
                        'prime_debet'    => $total_invoice,
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'rate'           => 1,
                        'keterangan'     => $keterangan,
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data1);

                    if ($total_dp > 0) {
                        $data0 = [
                            'no_voucher'     => $no_invoice,
                            'tgl_voucher'    => $tgl_invoice,
                            'kode_account'   => session()->get('acctumuka'),
                            'debet'          => $total_dp,
                            'prime_debet'    => $total_dp,
                            'credit'         => 0,
                            'prime_credit'   => 0,
                            'rate'           => 1,
                            'keterangan'     => $keterangan,
                            'codejurnal'     => $codejurnal,
                        ];
                        $this->ModelJurnal->add_detail($data0);
                    }

                    $data2 = [
                        'no_voucher'     => $no_invoice,
                        'tgl_voucher'    => $tgl_invoice,
                        'kode_account'   => $kode_accjual,
                        'debet'          => 0,
                        'prime_debet'    => 0,
                        'credit'         => $total_amount - $total_discount,
                        'prime_credit'   => $total_amount - $total_discount,
                        'rate'           => 1,
                        'keterangan'     => $keterangan,
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data2);

                    if ($total_ppn > 0) {
                        $data3 = [
                            'no_voucher'     => $no_invoice,
                            'tgl_voucher'    => $tgl_invoice,
                            'kode_account'   => session()->get('acctppnk'),
                            'debet'          => 0,
                            'prime_debet'    => 0,
                            'credit'         => $total_ppn,
                            'prime_credit'   => $total_ppn,
                            'rate'           => 1,
                            'keterangan'     => $keterangan,
                            'codejurnal'     => $codejurnal,
                        ];
                        $this->ModelJurnal->add_detail($data3);
                    }
                    
                    if ($total_hpp > 0) {
                        $data4 = [
                            'no_voucher'     => $no_invoice,
                            'tgl_voucher'    => $tgl_invoice,
                            'kode_account'   => $kode_acchpp,
                            'debet'          => $total_hpp,
                            'prime_debet'    => $total_hpp,
                            'credit'         => 0,
                            'prime_credit'   => 0,
                            'rate'           => 1,
                            'keterangan'     => $keterangan,
                            'codejurnal'     => $codejurnal,
                        ];
                        $this->ModelJurnal->add_detail($data4);
        
                        $data5 = [
                            'no_voucher'     => $no_invoice,
                            'tgl_voucher'    => $tgl_invoice,
                            'kode_account'   => $kode_accinv,
                            'debet'          => 0,
                            'prime_debet'    => 0,
                            'credit'         => $total_hpp,
                            'prime_credit'   => $total_hpp,
                            'rate'           => 1,
                            'keterangan'     => $keterangan,
                            'codejurnal'     => $codejurnal,
                        ];
                        $this->ModelJurnal->add_detail($data5);
                    }

                    if ($ongkir > 0) {
                        $data6 = [
                            'no_voucher'     => $no_invoice,
                            'tgl_voucher'    => $tgl_invoice,
                            'kode_account'   => '6108.003',
                            'debet'          => 0,
                            'prime_debet'    => 0,
                            'credit'         => $ongkir,
                            'prime_credit'   => $ongkir,
                            'rate'           => 1,
                            'keterangan'     => $keterangan,
                            'codejurnal'     => $codejurnal,
                        ];
                        $this->ModelJurnal->add_detail($data6);
                    }
                } else {
                    $codejurnal = 'Sales Invoice';
                    $keterangan = 'UANG MUKA - ' . $customer['nama_customer'];
                    $data1 = [
                        'no_voucher'     => $no_invoice,
                        'tgl_voucher'    => $tgl_invoice,
                        'kode_account'   => session()->get('acctar'),
                        'debet'          => $total_invoice,
                        'prime_debet'    => $total_invoice,
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'rate'           => 1,
                        'keterangan'     => $keterangan,
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data1);

                    if ($total_ppn > 0) {
                        $data3 = [
                            'no_voucher'     => $no_invoice,
                            'tgl_voucher'    => $tgl_invoice,
                            'kode_account'   => session()->get('acctppnk'),
                            'debet'          => 0,
                            'prime_debet'    => 0,
                            'credit'         => $total_ppn,
                            'prime_credit'   => $total_ppn,
                            'rate'           => 1,
                            'keterangan'     => $keterangan,
                            'codejurnal'     => $codejurnal,
                        ];
                        $this->ModelJurnal->add_detail($data3);
                    }
                    
                    $data0 = [
                        'no_voucher'     => $no_invoice,
                        'tgl_voucher'    => $tgl_invoice,
                        'kode_account'   => session()->get('acctumuka'),
                        'debet'          => 0,
                        'prime_debet'    => 0,
                        'credit'         => $total_dpp,
                        'prime_credit'   => $total_dpp,
                        'rate'           => 1,
                        'keterangan'     => $keterangan,
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data0);
                }

                $this->ModelSalesInv->clearCart($no_invoice);

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Sales Invoice : ' . $no_invoice,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Sales Invoice has been Updated'
                ];
                echo json_encode($msg);
            }
        }
    }

    public function get_datasj() {
        if ($this->request->isAJAX()) {
            $no_suratjln = $this->request->getPost('no_suratjln');
            $no_random = $this->request->getPost('no_random');
            $this->ModelSalesInv->clearCart($no_random);
            $datasrtjln = $this->ModelSalesInv->get_sjbybrg($no_suratjln);
            foreach ($datasrtjln as $list) {
                $isikeranjang = [
                    'no_invoice'  => $no_random,
                    'id_barang'   => $list['id_barang'],
                    'kode_barang' => $list['kode_barang'],
                    'harga'       => $list['hargajual'],
                    'qty'         => $list['qty'],
                    'cogs'        => $list['hargabeli'] * $list['nilaikurs'],
                    'subtotal'    => $list['hargajual'] * $list['qty']
                ];
                $this->ModelSalesInv->addCart($isikeranjang);
            }
            $msg = ['sukses' => 'berhasil'];
            echo json_encode($msg);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $this->ModelSalesInv->deleteCart($id);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function detail($id_inv)
    {
        $minv   = $this->ModelSalesInv->detail($id_inv);
        $no_invoice = $minv['no_invoice'];
        $data = [
            'minvoice' => $minv,
            'dinvoice' => $this->ModelSalesInv->detail_si($no_invoice),
        ];
        return view('salesinv/v_list', $data);
    }

    public function print($id_inv)
    {
        $minv   = $this->ModelSalesInv->detail($id_inv);
        $no_invoice = $minv['no_invoice'];
        $data = [
            'minvoice' => $minv,
            'dinvoice' => $this->ModelSalesInv->detail_si($no_invoice),
        ];

        return view('salesinv/v_print', $data);
    }

    public function print2($id_inv)
    {
        $minv   = $this->ModelSalesInv->detail($id_inv);
        $no_invoice = $minv['no_invoice'];
        $data = [
            'minvoice' => $minv,
            'dinvoice' => $this->ModelSalesInv->detail_si($no_invoice),
        ];

        return view('salesinv/v_print2', $data);
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $noinvoice = $this->request->getVar('no_invoice');
            $this->ModelSalesInv->delete_master($noinvoice);
            $this->ModelSalesInv->delete_detail($noinvoice);
            $this->ModelJurnal->delete_detail($noinvoice);

            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Sales Invoice : ' . $noinvoice,
            ];
            $this->ModelLogHistory->add($datalog);

            $msg = ['sukses' => 'Sales Invoice has been Deleted'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }

    public function cari_noinvoice()
    {
        $no_invoice = $this->request->getPost('no_invoice');
        $data = $this->ModelSalesInv->detail($no_invoice);
        echo json_encode($data);
    }

    public function ambilSuratJln()
    {
        $kode_customer = $this->request->getPost('kode_customer');
        $data = $this->ModelSalesInv->ambilDataSj($kode_customer);
        session()->set('kodecust', $kode_customer);
        $output = "<option value=''>PILIH NO DO</option>";
        foreach ($data as $row) {
            $output .= '<option value="' . $row['no_suratjln'] . '">' . $row['no_suratjln'] . '</option>';
        }
        echo json_encode($output);
    }

    public function hitungTotalBelanja()
    {
        if ($this->request->isAJAX()) {
            $no_invoice = $this->request->getPost('no_random');
            if ($this->request->getPost('total_discount') == '') {
                $totdis = 0;
            } else {
                $totdis = str_replace(',', '', $this->request->getPost('total_discount'));
            }
            if ($this->request->getPost('total_dp') == '') {
                $totdp = 0;
            } else {
                $totdp = str_replace(',', '', $this->request->getPost('total_dp'));
            }
            if ($this->request->getPost('ongkir') == '') {
                $totongkir = 0;
            } else {
                $totongkir = str_replace(',', '', $this->request->getPost('ongkir'));
            }

            $tkeranjang = $this->db->table('keranjangjual');
            $queryTotal = $tkeranjang->select('SUM(subtotal) as totalAmount')->where('no_invoice', $no_invoice)->get();
            $rowTotal   = $queryTotal->getRowArray();
            $totamt     = $rowTotal['totalAmount'];
            $totdpp     = $totamt - $totdis - $totdp;
            $totppn     = $totdpp * 0.11;
            $totinv     = $totdpp + $totppn + $totongkir;
            $msg = [
                'totalamount' =>  number_format($totamt, 0, '.', ','),
                'totaldpp' =>  number_format($totdpp, 0, '.', ','),
                'totalppn' =>  number_format($totppn, 0, '.', ','),
                'totalinvoice' =>  number_format($totinv, 0, '.', ',')
            ];
            session()->set('dp', $totdp);
            session()->set('disc', $totdis);
            session()->set('ongkir',$totongkir);
            echo json_encode($msg);
        }
    }

    public function hitungTotalBelanja2()
    {
        if ($this->request->isAJAX()) {
            $no_invoice = $this->request->getPost('no_invoice');
            if ($this->request->getPost('total_discount') == '') {
                $totdis = 0;
            } else {
                $totdis = str_replace(',', '', $this->request->getPost('total_discount'));
            }
            if ($this->request->getPost('total_dp') == '') {
                $totdp = 0;
            } else {
                $totdp = str_replace(',', '', $this->request->getPost('total_dp'));
            }
            if ($this->request->getPost('ongkir') == '') {
                $totongkir = 0;
            } else {
                $totongkir = str_replace(',', '', $this->request->getPost('ongkir'));
            }

            $tkeranjang = $this->db->table('keranjangjual');
            $queryTotal = $tkeranjang->select('SUM(subtotal) as totalAmount')->where('no_invoice', $no_invoice)->get();
            $rowTotal   = $queryTotal->getRowArray();
            $totamt     = $rowTotal['totalAmount'];
            $totdpp     = $totamt - $totdis - $totdp;
            $totppn     = $totdpp * 0.11;
            $totinv     = $totdpp + $totppn + $totongkir;
            $msg = [
                'totalamount' =>  number_format($totamt, 0, '.', ','),
                'totaldpp' =>  number_format($totdpp, 0, '.', ','),
                'totalppn' =>  number_format($totppn, 0, '.', ','),
                'totalinvoice' =>  number_format($totinv, 0, '.', ',')
            ];
            // session()->set('dp', $totdp);
            // session()->set('disc', $totdis);
            // session()->set('ongkir',$totongkir);
            echo json_encode($msg);
        }
    }
    
    public function cari_kodedivisi()
    {
        $kode_divisi = $this->request->getPost('kode_divisi');
        $data = $this->ModelDivisi->detail($kode_divisi);
        echo json_encode($data);
    }

    public function posted()
    {
        $lap = $this->ModelSalesInv->getDetail();
        foreach ($lap as $row) :
            $data = array(
                'id_salesinv'  => $row['id_salesinv'],
                'id_barang'    => $row['id_barang'],
                'cogs'         => $row['hargabeli']
            );
            $this->ModelSalesInv->updateDetail($data);
        endforeach;

    }

}
