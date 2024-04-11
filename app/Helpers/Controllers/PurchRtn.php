<?php

namespace App\Controllers;
use App\Models\ModelDataPurchRtn;
use App\Models\ModelPurchRtn;
use App\Models\ModelSupplier;
use App\Models\ModelCounter;
use App\Models\ModelPurchInv;
use App\Models\ModelJurnal;
use App\Models\ModelLogHistory;

use Config\Services;

class PurchRtn extends BaseController
{
    public function __construct()
    {
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelPurchInv = new ModelPurchInv();
        $this->ModelCounter  = new ModelCounter();
        $this->ModelPurchRtn = new ModelPurchRtn();
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        return view('purchrtn/v_index');
    }

    public function index2($no_retur)
    {
        $this->ModelPurchRtn->clearCart($no_retur);
        return view('purchrtn/v_index');
    }


    public function listData()
    {
        $request = Services::request();
        $this->ModelDataPurchRtn = new ModelDataPurchRtn($request);
        if ($request->getMethod(true) == 'POST') {
            $purchrtn = $this->ModelDataPurchRtn->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($purchrtn as $pr) {
                $row = [];
                $row[] = $no++;
                $row[] = $pr['no_retur'];
                $row[] = date('d-m-Y', strtotime($pr['tgl_retur']));
                $row[] = $pr['nama_supplier'];
                $row[] = $pr['no_invoice'];
                $row[] = $pr['currency'];
                $row[] = number_format($pr['total_retur'], '2', ',', '.');
                $row[] =
                    '<a href="' . base_url('PurchRtn/edit/' . $pr['no_retur']) . '" class="btn btn-success btn-xs mr-2"></i>EDIT</a>' .
                    '<a href="' . base_url('PurchRtn/detail/' . $pr['no_retur']) . '" class="btn btn-info btn-xs mr-2">DETAIL</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"hapusPr('" . $pr['no_retur'] . "','" . $pr['nama_supplier'] . "') \">DELETE</button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataPurchRtn->count_all(),
                "recordsFiltered" => $this->ModelDataPurchRtn->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {

        date_default_timezone_set('Asia/Jakarta');
        $tgl_retur = date('Y-m-d');
        $ctr    = $this->ModelCounter->allData();
        $nomor  = str_pad(strval(($ctr['pr'])), 5, '0', STR_PAD_LEFT);
        $no_retur = 'PR-' . $nomor .  '-' . date('y');
        $no_random = rand();
        $data = [
            'no_retur'   => $no_retur,
            'no_random'  => $no_random,
            'tgl_retur'  => $tgl_retur,
            'supplier'   => $this->ModelSupplier->alldata(),
            'validation' => \config\Services::validation()
        ];
        $this->ModelPurchRtn->clearCart($no_random);
        return view('purchrtn/v_add', $data);
    }


    public function ambil_pi()
    {
        $kode_supplier = $this->request->getPost('kode_supplier');
        $data = $this->ModelPurchRtn->ambildatapi($kode_supplier);
        session()->set('kodesupp', $kode_supplier);
        $output = "<option value=''>PILIH INVOICE</option>";
        foreach ($data as $row) {
            $output .= '<option value="' . $row['no_invoice'] . '">' . $row['no_invoice'] . '</option>';
        }
        echo json_encode($output);
    }

    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $no_retur = $this->request->getPost('no_retur');
            $dtl      = $this->ModelPurchRtn->getCart($no_retur);
            $data  = [
                'datadetail' => $dtl
            ];

            $msg = [
                'data' => view('purchrtn/v_harga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function get_bysupp()
    {
        $kode_supplier = $this->request->getPost('kode_supplier');
        $data = $this->ModelSupplier->detail($kode_supplier);
        session()->set('kodesupp', $kode_supplier);
        echo json_encode($data);
    }

    public function get_byinvoice()
    {
        $no_invoice = $this->request->getPost('no_invoice');
        $data = $this->ModelPurchInv->detail($no_invoice);
        echo json_encode($data);
    }

    public function get_datainvoice() {
        if ($this->request->isAJAX()) {
            $no_invoice = $this->request->getPost('no_invoice');
            $no_random = $this->request->getPost('no_random');
            $this->ModelPurchRtn->clearCart($no_random);
            $datainvoice = $this->ModelPurchRtn->get_invbybrg($no_invoice);
            foreach ($datainvoice as $list) {
                $isikeranjang = [
                    'no_retur'    => $no_random,
                    'id_barang'   => $list['id_barang'],
                    'kode_barang' => $list['kode_barang'],
                    'harga'       => $list['harga'],
                    'qty'         => $list['qty'],
                    'subtotal'    => $list['harga'] * $list['qty']
                ];
                $this->ModelPurchRtn->addCart($isikeranjang);
            }
            $msg = ['sukses' => 'berhasil'];
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
                'viewmodal' => view('purchrtn/v_caribarang', $data)
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
            $no_random   = $this->request->getPost('no_random');
            $id_barang   = $this->request->getPost('id_barang');
            $kode_barang = $this->request->getPost('kode_barang');
            $nama_barang = $this->request->getPost('nama_barang');
            $kode_satuan = $this->request->getPost('kode_satuan');

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
                // insert ke keranjang
                $tkeranjang = $this->db->table('keranjangpr');
                $barang     = $queryCekBarang->getRowArray();
                $subtotal   = $qty * $harga;
                $isikeranjang = [
                    'no_retur'    => $no_random,
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

    public function viewEditHarga()
    {
        if ($this->request->isAJAX()) {
            $id_purchrtn  = $this->request->getPost('id_purchrtn');
            $no_retur     = $this->request->getPost('no_retur');
            $kode_barang  = $this->request->getPost('kode_barang');
            $nama_barang  = $this->request->getPost('nama_barang');
            $kode_satuan  = $this->request->getPost('kode_satuan');
            $qty          = $this->request->getPost('qty');
            $harga        = $this->request->getPost('harga');
            $subtotal     = $this->request->getPost('subtotal');

            $data = [
                'id_purchrtn' => $id_purchrtn,
                'no_retur'    => $no_retur,
                'kode_barang' => $kode_barang,
                'nama_barang' => $nama_barang,
                'kode_satuan' => $kode_satuan,
                'qty'         => $qty,
                'harga'       => $harga,
                'subtotal'    => $subtotal,
            ];
        
            $msg = [
                'viewmodal' => view('purchrtn/v_editharga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updateHarga()
    {
        if ($this->request->isAJAX()) {
            $id_purchrtn   = $this->request->getPost('id_purchrtn');
            $no_retur      = $this->request->getPost('no_retur');
            $qty           = str_replace(',', '', $this->request->getPost('qty'));
            $harga         = str_replace(',', '', $this->request->getPost('harga'));
            $subtotal      = str_replace(',', '', $qty * $harga);

            $data = array(
                'id_purchrtn' => $id_purchrtn,
                'no_retur'    => $no_retur,
                'qty'         => $qty,
                'harga'       => $harga,
                'subtotal'    => $subtotal,
            );
            $this->ModelPurchRtn->editCart($data);

            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $no_random     = $this->request->getPost('no_random');
            $tgl_retur     = $this->request->getPost('tgl_retur');
            $kode_supplier = $this->request->getPost('kode_supplier');
            $keterangan    = $this->request->getPost('keterangan');
            $no_invoice    = $this->request->getPost('no_invoice');
            $kurs          = str_replace(",", "", $this->request->getPost('kurs'));
            $total_dpp     = str_replace(",", "", $this->request->getPost('total_dpp'));
            $total_ppn     = str_replace(",", "", $this->request->getPost('total_ppn'));
            $total_retur   = str_replace(",", "", $this->request->getPost('total_retur'));
            $supplier      = $this->ModelSupplier->detail($kode_supplier);

            $ctr = $this->ModelCounter->allData();
            $pr = $ctr['pr'];
            $datactr = [
                'pr' => $pr
            ];
            $this->ModelCounter->updctr($datactr);
            $ctr    = $this->ModelCounter->allData();
            $nomor  = str_pad(strval($ctr['pr']), 5, '0', STR_PAD_LEFT);
            $no_retur = 'PR-' . $nomor .  '-' . date('y');

            if (empty($kode_supplier)) {
                $msg = [
                    'error' => 'Maaf, Kode Supplier Harus diisi !!!!'
                ];
                echo json_encode($msg);
            } else {
                $data = [
                    'no_retur'       => $no_retur,
                    'tgl_retur'      => $tgl_retur,
                    'kode_supplier'  => $kode_supplier,
                    'keterangan'     => $keterangan,
                    'no_invoice'     => $no_invoice,
                    'kurs'           => $kurs,
                    'total_dpp'      => $total_dpp,
                    'total_ppn'      => $total_ppn,
                    'total_retur'    => $total_retur,
                ];

                $this->ModelPurchRtn->add($data);
                $ctr = $this->ModelCounter->allData();
                $inv = $ctr['pr'] + 1;
                $datactr = [
                    'pr' => $inv
                ];
                $this->ModelCounter->updctr($datactr);

                $ambildatakeranjang = $this->ModelPurchRtn->getCart($no_random);

                foreach ($ambildatakeranjang as $row) :
                    $datapr = array(
                        'no_retur'     => $no_retur,
                        'id_barang'    => $row['id_barang'],
                        'kode_barang'  => $row['kode_barang'],
                        'qty'          => $row['qty'],
                        'harga'        => $row['harga'],
                        'subtotal'     => $row['subtotal']
                    );
                    $this->ModelPurchRtn->add_detail($datapr);
                endforeach;

                // Insert Jurnal

                $codejurnal = 'Purchase Return';
                $keterangan = 'RETUR PEMBELIAN - ' . $supplier['nama_supplier'];

                $data2 = [
                    'no_voucher'     => $no_retur,
                    'tgl_voucher'    => $tgl_retur,
                    'kode_account'   => session()->get('acctinvt'),
                    'credit'         => $total_dpp *  $kurs,
                    'prime_credit'   => $total_dpp,
                    'debet'          => 0,
                    'prime_debet'    => 0,
                    'rate'           => $kurs,
                    'keterangan'     => $keterangan,
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data2);

                if ($total_ppn > 0) {
                    $data3 = [
                        'no_voucher'     => $no_retur,
                        'tgl_voucher'    => $tgl_retur,
                        'kode_account'   => session()->get('acctppnm'),
                        'credit'         => ($total_retur - $total_dpp) * $kurs,
                        'prime_credit'   => $total_retur - $total_dpp,
                        'debet'          => 0,
                        'prime_debet'    => 0,
                        'rate'           => $kurs,
                        'keterangan'     => $keterangan,
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data3);
                }

                $data1 = [
                    'no_voucher'     => $no_retur,
                    'tgl_voucher'    => $tgl_retur,
                    'kode_account'   => session()->get('acctap'),
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'debet'          => $total_retur * $kurs,
                    'prime_debet'    => $total_retur,
                    'rate'           => $kurs,
                    'keterangan'     => $keterangan,
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data1);

                $this->ModelPurchRtn->clearCart($no_random);

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menambah Retur Pembelian  : ' . $no_retur,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Purchase return has been added !!'
                ];
                echo json_encode($msg);
            }
        }
    }

    public function edit($no_retur)
    {
        $dpr = $this->ModelPurchRtn->detail_pr($no_retur);
        $this->ModelPurchRtn->clearCart($no_retur);
        foreach ($dpr as $dbl) {
            $datakeranjang = array(
                'id_purchrtn' => $dbl['id_purchrtn'],
                'no_retur'    => $dbl['no_retur'],
                'id_barang'   => $dbl['id_barang'],
                'kode_barang' => $dbl['kode_barang'],
                'qty'         => $dbl['qty'],
                'harga'       => $dbl['harga'],
                'subtotal'    => $dbl['subtotal'],
            );
            $this->ModelPurchRtn->addCart($datakeranjang);
        }
        $pr = $this->ModelPurchRtn->detail($no_retur);
        $data = [
            'pr'  => $pr,
        ];
        return view('purchrtn/v_edit', $data);
    }


    public function updateData()
    {
        if ($this->request->isAJAX()) {
            date_default_timezone_set('Asia/Jakarta');
            $no_retur      = $this->request->getPost('no_retur');
            $tgl_retur     = $this->request->getPost('tgl_retur');
            $kode_supplier = $this->request->getPost('kode_supplier');
            $keterangan    = $this->request->getPost('keterangan');
            $no_invoice    = $this->request->getPost('no_invoice');
            $kurs          = str_replace(",", "", $this->request->getPost('kurs'));
            $total_dpp     = str_replace(",", "", $this->request->getPost('total_dpp'));
            $total_ppn     = str_replace(",", "", $this->request->getPost('total_ppn'));
            $total_retur   = str_replace(",", "", $this->request->getPost('total_retur'));
            $supplier      = $this->ModelSupplier->detail($kode_supplier);

            $data = [
                'no_retur'      => $no_retur,
                'tgl_retur'     => $tgl_retur,
                'kode_supplier' => $kode_supplier,
                'keterangan'    => $keterangan,
                'no_invoice'    => $no_invoice,
                'total_dpp'     => $total_dpp,
                'total_ppn'     => $total_ppn,
                'total_retur'   => $total_retur,
            ];

            $this->ModelPurchRtn->edit($data);
            $this->ModelPurchRtn->delete_detail($no_retur);

            $ambildatakeranjang = $this->ModelPurchRtn->getCart($no_retur);
        
            foreach ($ambildatakeranjang as $row) :
                $data2 = array(
                    'id_purchrtn'  => $row['id_purchrtn'],
                    'no_retur'     => $row['no_retur'],
                    'id_barang'    => $row['id_barang'],
                    'kode_barang'  => $row['kode_barang'],
                    'qty'          => $row['qty'],
                    'harga'        => $row['harga'],
                    'subtotal'     => $row['subtotal']
                );
                $this->ModelPurchRtn->add_detail($data2);
            endforeach;

            $this->ModelJurnal->delete_detail($no_retur);

            $codejurnal = 'Purchase Return';
            $keterangan = 'RETUR PEMBELIAN - ' . $supplier['nama_supplier'];

            $data2 = [
                'no_voucher'     => $no_retur,
                'tgl_voucher'    => $tgl_retur,
                'kode_account'   => session()->get('acctinvt'),
                'credit'         => $total_dpp *  $kurs,
                'prime_credit'   => $total_dpp,
                'debet'          => 0,
                'prime_debet'    => 0,
                'rate'           => $kurs,
                'keterangan'     => $keterangan,
                'codejurnal'     => $codejurnal,
            ];
            $this->ModelJurnal->add_detail($data2);

            if ($total_ppn > 0) {
                $data3 = [
                    'no_voucher'     => $no_retur,
                    'tgl_voucher'    => $tgl_retur,
                    'kode_account'   => session()->get('acctppnm'),
                    'credit'         => ($total_retur - $total_dpp) * $kurs,
                    'prime_credit'   => $total_retur - $total_dpp,
                    'debet'          => 0,
                    'prime_debet'    => 0,
                    'rate'           => $kurs,
                    'keterangan'     => $keterangan,
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data3);
            }

            $data1 = [
                'no_voucher'     => $no_retur,
                'tgl_voucher'    => $tgl_retur,
                'kode_account'   => session()->get('acctap'),
                'credit'         => 0,
                'prime_credit'   => 0,
                'debet'          => $total_retur * $kurs,
                'prime_debet'    => $total_retur,
                'rate'           => $kurs,
                'keterangan'     => $keterangan,
                'codejurnal'     => $codejurnal,
            ];
            $this->ModelJurnal->add_detail($data1);
            
            $this->ModelPurchRtn->clearCart($no_retur);
            
                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Retur Pembelian  : ' . $no_retur,
                ];
                $this->ModelLogHistory->add($datalog);
            

            $msg = [
                'sukses' => 'Purchase Return has been Updated'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $this->ModelPurchRtn->deleteCart($id);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $noretur = $this->request->getVar('no_retur');
            $this->ModelPurchRtn->delete_master($noretur);
            $this->ModelPurchRtn->delete_detail($noretur);
            $this->ModelJurnal->delete_detail($noretur);
            
                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menghapus Retur Pembelian  : ' . $noretur,
                ];
                $this->ModelLogHistory->add($datalog);
            
            $msg = ['sukses' => 'Sales Return has been deleted !!!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }

    public function detail($no_retur)
    {
        $data = [
            'title' => 'Purchase Return',
            'pr'   => $this->ModelPurchRtn->detail($no_retur),
            'dpr'  => $this->ModelPurchRtn->detail_pr($no_retur),
        ];
        return view('purchrtn/v_list', $data);
    }
}
