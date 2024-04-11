<?php

namespace App\Controllers;

use App\Models\ModelSupplier;
use App\Models\ModelBarang;
use App\Models\ModelAccount;
use App\Models\ModelPurchInv;
use App\Models\ModelDataPurchInv;
use App\Models\ModelCounter;
use App\Models\ModelDataBrg;
use App\Models\ModelJurnal;
use App\Models\ModelDivisi;
use App\Models\ModelLogHistory;

use Config\Services;

class PurchInv extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelPurchInv = new ModelPurchInv();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelCounter  = new ModelCounter();
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelDivisi   = new ModelDivisi();
        $this->ModelAccount  = new ModelAccount();
        $this->ModelLogHistory = new ModelLogHistory();
    }


    public function index()
    {
        return view('purchinv/v_index');
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataPurchInv = new ModelDataPurchInv($request);
        if ($request->getMethod(true) == 'POST') {
            $purchinv = $this->ModelDataPurchInv->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($purchinv as $purch) {
                $row = [];
                $row[] = $no++;
                $row[] = $purch['no_invoice'];
                $row[] = date('d-m-Y', strtotime($purch['tgl_invoice']));
                $row[] = $purch['invoice_supp'];
                $row[] = $purch['nama_supplier'];
                $row[] = $purch['kode_divisi'];
                $row[] = $purch['currency'];
                $row[] = $purch['no_po'];
                $row[] = number_format($purch['total_invoice'], '2', ',', '.');
                $row[] = number_format($purch['total_bayar'], '2', ',', '.');
                if (session()->get('level') == "1") {
                    $row[] =
                        '<a href="' . base_url('PurchInv/edit/' . $purch['no_invoice']) . '" class="btn btn-success btn-xs mr-2" style="font-size: 10px; height: 18px;"></i>EDIT</a>' .
                        '<a href="' . base_url('PurchInv/detail/' . $purch['no_invoice']) . '" class="btn btn-info btn-xs mr-2" style="font-size: 10px; height: 18px;">DETAIL</a>' .
                        '<a href="' . base_url('PurchInv/print/' . $purch['no_invoice']) . '" class="btn btn-primary btn-xs mr-2" style="font-size: 10px; height: 18px;">PRINT</a>' .
                        "<button type=\"button\" class=\"btn btn-danger btn-xs\" style=\"font-size: 10px; height: 18px;\" onclick=\"hapusPurchInv('" . $purch['no_invoice'] . "','" . $purch['nama_supplier'] . "') \">DELETE</button>";
                } else {
                    $row[] =
                        '<a href="' . base_url('PurchInv/detail/' . $purch['no_invoice']) . '" class="btn btn-info btn-xs mr-2" style="font-size: 10px; height: 18px;">DETAIL</a>';
                }
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataPurchInv->count_all(),
                "recordsFiltered" => $this->ModelDataPurchInv->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tgl_invoice = date('Y-m-d');
        $ctr    = $this->ModelCounter->allData();
        $nomor  = str_pad(strval(($ctr['pi'] + 1)), 4, '0', STR_PAD_LEFT);
        $no_invoice  = $nomor . '-PI-' . date('Y');
        session()->set('disc', 0);
        session()->set('vat', 0);
        $data = [
            'no_invoice'   => $no_invoice,
            'tgl_invoice'  => $tgl_invoice,
            'supplier'     => $this->ModelSupplier->alldata(),
            'divisi'       => $this->ModelDivisi->allData(),
            'account'      => $this->ModelAccount->allDataBiaya(),
            'validation'   => \config\Services::validation()
        ];
        $this->ModelPurchInv->clearCart($no_invoice);
        return view('purchinv/v_add', $data);
    }

    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $no_invoice = $this->request->getPost('no_invoice');
            $status     = $this->request->getPost('status');
            $dtl        = $this->ModelPurchInv->getCart($no_invoice);
            $data  = [
                'datadetail' => $dtl,
                'status'     => $status
            ];

            $msg = [
                'data' => view('purchinv/v_harga', $data)
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
                'viewmodal' => view('purchinv/v_caribarang', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function listDataBarang()
    {
        if ($this->request->isAJAX()) {
            $keywordkodebarang = $this->request->getPost('keywordkodebarang');
            $request = Services::request();
            $modeldatabarang = new ModelDataBrg($request);
            if ($request->getMethod(true) == 'POST') {
                $lists = $modeldatabarang->get_datatables($keywordkodebarang);
                $data = [];
                $no = $request->getPost("start");
                foreach ($lists as $list) {
                    $no++;
                    $row = [];
                    $row[] = $no;
                    $row[] = $list['kode_barang'];
                    $row[] = $list['nama_barang'];
                    $row[] = $list['kode_satuan'];
                    $row[] = number_format($list['hargabeli'], 0, '.', ',');
                    $row[] = "<button type=\"button\" class=\"btn btn-xs btn-info\" style=\"height: 26px; font-size: 12px;\"  onclick=\"pilihitem('" . $list['id_barang'] .  "','" . "')\" ><i class=\"fa fa-check\"></i></button>";
                    $data[] = $row;
                }
                $output = [
                    "draw" => $request->getPost('draw'),
                    "recordsTotal" => $modeldatabarang->count_all($keywordkodebarang),
                    "recordsFiltered" => $modeldatabarang->count_filtered($keywordkodebarang),
                    "data" => $data
                ];
                echo json_encode($output);
            }
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

            $no_invoice    = $this->request->getPost('no_invoice');
            $id_barang     = $this->request->getPost('id_barang');
            $kode_barang   = $this->request->getPost('kode_barang');
            $nama_barang   = $this->request->getPost('nama_barang');
            $kode_satuan   = $this->request->getPost('kode_satuan');
            $vat = $this->request->getPost('vat');
            session()->set('vat', $vat);

            if (strlen($nama_barang) > 0) {
                // insert ke keranjang
                $tkeranjang = $this->db->table('keranjangbeli');
                $subtotal   = $qty * $harga;
                $isikeranjang = [
                    'no_invoice'  => $no_invoice,
                    'id_barang'   => $id_barang,
                    'kode_barang' => $kode_barang,
                    'harga'       => $harga,
                    'qty'         => $qty,
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
            $no_invoice     = $this->request->getPost('no_invoice');
            $tgl_invoice    = $this->request->getPost('tgl_invoice');
            $kode_divisi    = $this->request->getPost('kode_divisi');
            $kode_supplier  = $this->request->getPost('kode_supplier');
            $invoice_supp   = $this->request->getPost('invoice_supp');
            $kurs           = str_replace(',','', $this->request->getpost('kurs'));
            $total_amount   = str_replace(',', '', $this->request->getPost('total_amount'));
            $total_discount = str_replace(',', '', $this->request->getPost('total_discount'));
            $total_dpp      = str_replace(',', '', $this->request->getPost('total_dpp'));
            $vat            = str_replace(',', '', $this->request->getPost('vat'));
            $total_ppn      = str_replace(',', '', $this->request->getPost('total_ppn'));
            $total_invoice  = str_replace(',', '', $this->request->getPost('total_invoice'));
            $keterangan     = $this->request->getPost('keterangan');            
            $supplier       = $this->ModelSupplier->detail($kode_supplier);
            $kode_accinv    = $this->request->getPost('kode_accinv');      
            $kode_account   = $this->request->getPost('kode_account');
            if ($kode_account) {
                $kode_accinv = $kode_account;
            } 
            
            $validation     =  \Config\Services::validation();

            $valid = $this->validate([
                'kode_supplier' => [
                    'label' => 'Kode Supplier',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'no_invoice' => [
                    'label' => 'No Invoice',
                    'rules' => 'required|is_unique[tbl_purchinv.no_invoice]',
                    'errors' => [
                        'is_unique' => '{field} sudah ada, coba dengan Nomor yang lain',
                        'required'  => '{field} tidak boleh kosong'
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
                        'errorKodeSupplier'   => $validation->getError('kode_supplier'),
                        'errorNoInvoice'      => $validation->getError('no_invoice'),
                        'errorKodeDivisi'   => $validation->getError('kode_divisi'),
                    ]
                ];
            } else {
                $data = [
                    'no_invoice'     => $no_invoice,
                    'tgl_invoice'    => $tgl_invoice,
                    'kode_divisi'    => $kode_divisi,
                    'invoice_supp'   => $invoice_supp,
                    'keterangan'     => $keterangan,
                    'kode_supplier'  => $kode_supplier,
                    'kursbeli'       => $kurs,
                    'total_amount'   => $total_amount,
                    'total_discount' => $total_discount,
                    'total_dpp'      => $total_dpp,
                    'vat'            => $vat,
                    'total_ppn'      => $total_ppn,
                    'total_invoice'  => $total_invoice,
                    'kode_account'   => $kode_account
                ];

                $ambildatakeranjang = $this->ModelPurchInv->ambilCart($no_invoice);
                
                if (empty($ambildatakeranjang)) {
                    $msg = [
                        'error' => 'Maaf, Data Transaksi masih Kosong !!!!'
                    ];
                    echo json_encode($msg);
                } else {
                    $this->ModelPurchInv->add($data);
                    $ctr = $this->ModelCounter->allData();
                    $inv = $ctr['pi'] + 1;
                    $datactr = [
                        'pi' => $inv
                    ];
                    $this->ModelCounter->updctr($datactr);
                    foreach ($ambildatakeranjang as $row) :
                        $databeli = array(
                            'no_invoice'   => $row['no_invoice'],
                            'id_barang'    => $row['id_barang'],
                            'kode_barang'  => $row['kode_barang'],
                            'qty'          => $row['qty'],
                            'harga'        => $row['harga'],
                            'subtotal'     => $row['subtotal'],
                        );
                        $this->ModelPurchInv->add_detail($databeli);
                    endforeach;

                    $this->ModelJurnal->delete_detail($no_invoice);

                    // Insert Jurnal
                    $codejurnal = 'Purchase Invoice';
                    $keterangan = 'PEMBELIAN DARI: ' . $supplier['nama_supplier'];
 
                    $data1 = [
                        'no_voucher'     => $no_invoice,
                        'tgl_voucher'    => $tgl_invoice,
                        'kode_account'   => session()->get('acctap'),
                        'debet'          => 0,
                        'prime_debet'    => 0,
                        'credit'         => $total_invoice * $kurs,
                        'prime_credit'   => $total_invoice,
                        'rate'           => $kurs,
                        'keterangan'     => $keterangan,
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data1);
                    
                    $data2 = [
                        'no_voucher'     => $no_invoice,
                        'tgl_voucher'    => $tgl_invoice,
                        'kode_account'   => $kode_accinv,
                        'debet'          => $total_dpp * $kurs,
                        'prime_debet'    => $total_dpp,
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'rate'           => $kurs,
                        'keterangan'     => $keterangan,
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data2);
                    if ($total_ppn > 0) {
                        $data3 = [
                            'no_voucher'     => $no_invoice,
                            'tgl_voucher'    => $tgl_invoice,
                            'kode_account'   => session()->get('acctppnm'),
                            'credit'         => 0,
                            'prime_credit'   => 0,
                            'debet'          => $total_ppn * $kurs,
                            'prime_debet'    => $total_ppn,
                            'rate'           => $kurs,
                            'keterangan'     => $keterangan,
                            'codejurnal'     => $codejurnal,
                        ];
                        $this->ModelJurnal->add_detail($data3);
                    }    
                    $this->ModelPurchInv->clearCart($no_invoice);
                    date_default_timezone_set('Asia/Jakarta');
                    $datalog = [
                        'username'  => session()->get('username'),
                        'jamtrx'    => date('Y-m-d H:i:s'),
                        'kegiatan'  => 'Menambah Purchase Invoice : ' . $no_invoice,
                    ];
                    $this->ModelLogHistory->add($datalog);

                    $msg = [
                        'sukses' => 'Purchase Invoice has been added'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    public function edit($no_invoice)
    {
        $dpurchinv = $this->ModelPurchInv->detail_pi($no_invoice);
        $this->ModelPurchInv->clearCart($no_invoice);
        foreach ($dpurchinv as $pinv) {
            $datakeranjang = array(
                'id_purchinv' => $pinv['id_purchinv'],
                'no_invoice'  => $pinv['no_invoice'],
                'id_barang'   => $pinv['id_barang'],
                'kode_barang' => $pinv['kode_barang'],
                'qty'         => $pinv['qty'],
                'harga'       => $pinv['harga'],
                'subtotal'    => $pinv['subtotal'],
            );
            $this->ModelPurchInv->addCart($datakeranjang);
        }

        $pi = $this->ModelPurchInv->detail($no_invoice);
        $pi2 = $this->ModelPurchInv->detail2($no_invoice);
     
        session()->set('disc', $pi['total_discount']);     
        session()->set('vat', $pi['vat']);     
        $data = [
            'pi'             => $pi,
            'pi2'            => $pi2,
            'total_discount' => $pi['total_discount'],
            'vat'            => $pi['vat'],
            'account'        => $this->ModelAccount->allDataBiaya(),
            'divisi'         => $this->ModelDivisi->allData(),
            'supplier'       => $this->ModelSupplier->alldata(),
        ];
        return view('purchinv/v_edit', $data);
    }

    public function viewEditHarga()
    {
        if ($this->request->isAJAX()) {
            $id_purchinv  = $this->request->getPost('id_purchinv');
            $no_invoice   = $this->request->getPost('no_invoice');
            $id_barang    = $this->request->getPost('id_barang');
            $kode_barang  = $this->request->getPost('kode_barang');
            $nama_barang  = $this->request->getPost('nama_barang');
            $kode_satuan  = $this->request->getPost('kode_satuan');
            $qty          = $this->request->getPost('qty');
            $harga        = $this->request->getPost('harga');
            $subtotal     = $this->request->getPost('subtotal');

            $data = [
                'id_purchinv' => $id_purchinv,
                'no_invoice'  => $no_invoice,
                'id_barang'   => $id_barang,
                'kode_barang' => $kode_barang,
                'nama_barang' => $nama_barang,
                'kode_satuan' => $kode_satuan,
                'qty'         => $qty,
                'harga'       => $harga,
                'subtotal'    => $subtotal,
            ];

            $msg = [
                'viewmodal' => view('purchinv/v_editharga', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function updateHarga()
    {
        if ($this->request->isAJAX()) {
            $id_purchinv   = $this->request->getPost('id_purchinv');
            $no_invoice    = $this->request->getPost('no_invoice');
            $qty           = str_replace(',', '', $this->request->getPost('qty'));
            $harga         = str_replace(',', '', $this->request->getPost('harga'));
            $subtotal      = str_replace(',', '', $qty * $harga);

            $data = array(
                'id_purchinv' => $id_purchinv,
                'no_invoice'  => $no_invoice,
                'qty'         => $qty,
                'harga'       => $harga,
                'subtotal'    => $subtotal,
            );
            $this->ModelPurchInv->editCart($data);
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
            $no_invoice     = $this->request->getPost('no_invoice');
            $tgl_invoice    = $this->request->getPost('tgl_invoice');
            $kode_divisi    = $this->request->getPost('kode_divisi');
            $kode_supplier  = $this->request->getPost('kode_supplier');
            $invoice_supp   = $this->request->getPost('invoice_supp');
            $kurs           = str_replace(',','', $this->request->getpost('kurs'));
            $total_amount   = str_replace(',', '', $this->request->getPost('total_amount'));
            $total_discount = str_replace(',', '', $this->request->getPost('total_discount'));
            $total_dpp      = str_replace(',', '', $this->request->getPost('total_dpp'));
            $vat            = str_replace(',', '', $this->request->getPost('vat'));
            $total_ppn      = str_replace(',', '', $this->request->getPost('total_ppn'));
            $total_invoice  = str_replace(',', '', $this->request->getPost('total_invoice'));
            $keterangan     = $this->request->getPost('keterangan');            
            $kode_accinv    = $this->request->getPost('kode_accinv'); 
            $kode_account   = $this->request->getPost('kode_account');
            $supplier       = $this->ModelSupplier->detail($kode_supplier);
            if ($kode_account) {
                $kode_accinv = $kode_account;
            } 

            $data = [
                'no_invoice'     => $no_invoice,
                'tgl_invoice'    => $tgl_invoice,
                'kode_divisi'    => $kode_divisi,
                'invoice_supp'   => $invoice_supp,
                'kode_supplier'  => $kode_supplier,
                'keterangan'     => $keterangan,
                'kursbeli'       => $kurs,
                'total_amount'   => $total_amount,
                'total_discount' => $total_discount,
                'total_dpp'      => $total_dpp,
                'vat'            => $vat,
                'total_ppn'      => $total_ppn,
                'total_invoice'  => $total_invoice,
                'kode_account'   => $kode_account,
            ];

            $ambildatakeranjang = $this->ModelPurchInv->ambilCart($no_invoice);
            if (empty($ambildatakeranjang)) {
                $msg = [
                    'error' => 'Maaf, Data Transaksi masih Kosong !!!!'
                ];
                echo json_encode($msg);
            } else {
                $this->ModelPurchInv->edit($data);
                $this->ModelPurchInv->delete_detail($no_invoice);
                foreach ($ambildatakeranjang as $row) :
                    $datainv = array(
                        'no_invoice'   => $row['no_invoice'],
                        'id_barang'    => $row['id_barang'],
                        'kode_barang'  => $row['kode_barang'],
                        'qty'          => $row['qty'],
                        'harga'        => $row['harga'],
                        'subtotal'     => $row['subtotal'],
                    );
                    $this->ModelPurchInv->add_detail($datainv);
                endforeach;
                $this->ModelJurnal->delete_detail($no_invoice);

                // Insert Jurnal
                $codejurnal = 'Purchase Invoice';
                $keterangan = 'PEMBELIAN DARI: ' . $supplier['nama_supplier'];
                $data1 = [
                    'no_voucher'     => $no_invoice,
                    'tgl_voucher'    => $tgl_invoice,
                    'kode_account'   => session()->get('acctap'),
                    'debet'          => 0,
                    'prime_debet'    => 0,
                    'credit'         => $total_invoice * $kurs,
                    'prime_credit'   => $total_invoice,
                    'rate'           => $kurs,
                    'keterangan'     => $keterangan,
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data1);

                $data2 = [
                    'no_voucher'     => $no_invoice,
                    'tgl_voucher'    => $tgl_invoice,
                    'kode_account'   => $kode_accinv,
                    'debet'          => $total_dpp * $kurs,
                    'prime_debet'    => $total_dpp,
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'rate'           => $kurs,
                    'keterangan'     => $keterangan,
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data2);
                if ($total_ppn > 0) {
                    $data3 = [
                        'no_voucher'     => $no_invoice,
                        'tgl_voucher'    => $tgl_invoice,
                        'kode_account'   => session()->get('acctppnm'),
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'debet'          => $total_ppn * $kurs,
                        'prime_debet'    => $total_ppn,
                        'rate'           => $kurs,
                        'keterangan'     => $keterangan,
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data3);
                }    
                
                $this->ModelPurchInv->clearCart($no_invoice);
                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Purchase Invoice : ' . $no_invoice,
                ];
                $this->ModelLogHistory->add($datalog);
                
                $msg = [
                    'sukses' => 'Purchase Invoice has been Updated !!'
                ];
                echo json_encode($msg);
            }
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $this->ModelPurchInv->deleteCart($id);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function detail($no_invoice)
    {
        $data = [
            'pi'    => $this->ModelPurchInv->detail($no_invoice),
            'pi2'   => $this->ModelPurchInv->detail2($no_invoice),
            'dpi'   => $this->ModelPurchInv->detail_pi($no_invoice),
        ];
        return view('purchinv/v_list', $data);
    }

    public function print($no_invoice)
    {
        $data = [
            'pi'    => $this->ModelPurchInv->detail($no_invoice),
            'dpi'   => $this->ModelPurchInv->detail_pi($no_invoice),
        ];
        return view('purchinv/v_print', $data);
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $noinvoice = $this->request->getVar('no_invoice');
            $this->ModelPurchInv->delete_master($noinvoice);
            $this->ModelPurchInv->delete_detail($noinvoice);
            $this->ModelJurnal->delete_detail($noinvoice);
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Purchase Invoice : ' . $noinvoice,
            ];
            $this->ModelLogHistory->add($datalog);
            
            $msg = ['sukses' => 'Purchase Invoice has been deleted !!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }

    public function cari_noinvoice()
    {
        $no_invoice = $this->request->getPost('no_invoice');
        $data = $this->ModelPurchInv->detail($no_invoice);
        if ($data) {
            $msg = ['sukses' => 'berhasil'];
        } else {
            $msg = ['sukses' => 'gagal'];
        }
        echo json_encode($msg);
    }
    
    public function hitungTotalBelanja()
    {
        if ($this->request->isAJAX()) {
            $no_invoice = $this->request->getPost('no_invoice');
            $status = $this->request->getPost('status');
            $vat    = $this->request->getPost('vat');
            if ($this->request->getPost('total_discount') == '') {
                $totdis = 0;
            } else {
                $totdis = str_replace(',', '', $this->request->getPost('total_discount'));
            }
            if ($this->request->getPost('vat') == '') {
                $vat = 0;
            } else {
                $vat = str_replace(',', '', $this->request->getPost('vat'));
            }

            $tkeranjang = $this->db->table('keranjangbeli');
            $queryTotal = $tkeranjang->select('SUM(subtotal) as totalAmount')->where('no_invoice', $no_invoice)->get();
            $rowTotal   = $queryTotal->getRowArray();
            $totamt     = $rowTotal['totalAmount'];
            $totdpp     = $totamt - $totdis;
            if ($status == 'PKP') {
                $totppn = $totdpp * ($vat/100);
            } else {
                $totppn = $totdpp * 0;
            }
            $totinv = $totppn + $totdpp;
            $msg = [
                'totalamount' =>  number_format($totamt, 2, '.', ','),
                'totaldpp' =>  number_format($totdpp, 2, '.', ','),
                'totalppn' =>  number_format($totppn, 2, '.', ','),
                'totalinvoice' =>  number_format($totinv, 2, '.', ',')
            ];
            session()->set('disc', $totdis);
            session()->set('vat', $vat);
            echo json_encode($msg);
        }
    }

    public function cari_kodedivisi()
    {
        $kode_divisi = $this->request->getPost('kode_divisi');
        $data = $this->ModelDivisi->detail($kode_divisi);
        echo json_encode($data);
    }

    public function ambilPurchOrd()
    {
        $kode_supplier = $this->request->getPost('kode_supplier');
        $data = $this->ModelPurchInv->ambilDataPO($kode_supplier);

        session()->set('kodesupp', $kode_supplier);
        $output = "<option value=''>PILIH NO PO</option>";
        foreach ($data as $row) {
            $output .= '<option value="' . $row['no_po'] . '">' . $row['no_po'] . '</option>';
        }
        echo json_encode($output);
    }

    public function get_datapo()
    {
        if ($this->request->isAJAX()) {
            $no_po = $this->request->getPost('no_po');
            $no_invoice = $this->request->getPost('no_invoice');
            $this->ModelPurchInv->clearCart($no_invoice);
            $datapo = $this->ModelPurchInv->get_pobybrg($no_po);
            foreach ($datapo as $list) {
                $isikeranjang = [
                    'no_invoice'  => $no_invoice,
                    'id_barang'   => $list['id_barang'],
                    'kode_barang' => $list['kode_barang'],
                    'harga'       => $list['harga'],
                    'qty'         => $list['qty'],
                    'subtotal'    => $list['subtotal']
                ];
                $this->ModelPurchInv->addCart($isikeranjang);
            }
            $msg = ['sukses' => 'berhasil'];
            echo json_encode($msg);
        }
    }


}
