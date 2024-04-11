<?php

namespace App\Controllers;

use App\Models\ModelDataSalesRtn;
use App\Models\ModelSalesRtn;
use App\Models\ModelCustomer;
use App\Models\ModelCounter;
use App\Models\ModelSalesInv;
use App\Models\ModelJurnal;
use App\Models\ModelLogHistory;

use Config\Services;

class SalesRtn extends BaseController
{
    public function __construct()
    {
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelCounter  = new ModelCounter();
        $this->ModelSalesRtn = new ModelSalesRtn();
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        return view('salesrtn/v_index');
    }

    public function index2($no_retur)
    {
        $this->ModelSalesRtn->clearCart($no_retur);
        return view('salesrtn/v_index');
    }


    public function listData()
    {
        $request = Services::request();
        $this->ModelDataSalesRtn = new ModelDataSalesRtn($request);
        if ($request->getMethod(true) == 'POST') {
            $salesrtn = $this->ModelDataSalesRtn->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($salesrtn as $sr) {
                $row = [];
                $row[] = $no++;
                $row[] = $sr['no_retur'];
                $row[] = date('d-m-Y', strtotime($sr['tgl_retur']));
                $row[] = $sr['nama_customer'];
                $row[] = $sr['no_invoice'];
                $row[] = $sr['keterangan'];
                $row[] = number_format($sr['total_retur'], '0', ',', '.');
               if (session()->get('level') == "1") {
                $row[] =
                    '<a href="' . base_url('SalesRtn/edit/' . $sr['no_retur']) . '" class="btn btn-success btn-xs mr-2"></i>Edit</a>' .
                    '<a href="' . base_url('SalesRtn/detail/' . $sr['no_retur']) . '" class="btn btn-info btn-xs mr-2">Detail</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"hapusSr('" . $sr['no_retur'] . "','" . $sr['nama_customer'] . "') \">Delete</button>";
               } else {
                    '<a href="' . base_url('SalesRtn/detail/' . $sr['no_retur']) . '" class="btn btn-info btn-xs mr-2">See Detail</a>';
               }
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataSalesRtn->count_all(),
                "recordsFiltered" => $this->ModelDataSalesRtn->count_filtered(),
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
        $nomor  = str_pad(strval(($ctr['sr'])), 5, '0', STR_PAD_LEFT);
        $no_retur = 'SR-' . $nomor .  '-' . date('y');
        $no_random = rand();
        $data = [
            'no_retur'   => $no_retur,
            'no_random'  => $no_random,
            'tgl_retur'  => $tgl_retur,
            'customer'   => $this->ModelCustomer->alldata(),
            'validation' => \config\Services::validation()
        ];
        $this->ModelSalesRtn->clearCart($no_random);
        return view('salesrtn/v_add', $data);
    }


    public function ambil_si()
    {
        $kode_customer = $this->request->getPost('kode_customer');
        $data = $this->ModelSalesRtn->ambildatasi($kode_customer);
        session()->set('kodecust', $kode_customer);
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
            $dtl      = $this->ModelSalesRtn->getCart($no_retur);
            $data  = [
                'datadetail' => $dtl
            ];

            $msg = [
                'data' => view('salesrtn/v_harga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function get_bycust()
    {
        $kode_customer = $this->request->getPost('kode_customer');
        $data = $this->ModelCustomer->detail($kode_customer);
        session()->set('kodecust', $kode_customer);
        echo json_encode($data);
    }

    public function get_byinvoice()
    {
        $no_invoice = $this->request->getPost('no_invoice');
        $data = $this->ModelSalesInv->detail($no_invoice);
        echo json_encode($data);
    }

    public function get_datainvoice() {
        if ($this->request->isAJAX()) {
            $no_invoice = $this->request->getPost('no_invoice');
            $no_random = $this->request->getPost('no_random');
            $this->ModelSalesRtn->clearCart($no_random);
            $datainvoice = $this->ModelSalesRtn->get_invbybrg($no_invoice);
            foreach ($datainvoice as $list) {
                $isikeranjang = [
                    'no_retur'    => $no_random,
                    'id_barang'   => $list['id_barang'],
                    'kode_barang' => $list['kode_barang'],
                    'harga'       => $list['harga'],
                    'qty'         => $list['qty'],
                    'subtotal'    => $list['harga'] * $list['qty']
                ];
                $this->ModelSalesRtn->addCart($isikeranjang);
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
                'viewmodal' => view('salesrtn/v_caribarang', $data)
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
                $tkeranjang = $this->db->table('keranjangsr');
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
            $id_salesrtn  = $this->request->getPost('id_salesrtn');
            $no_retur     = $this->request->getPost('no_retur');
            $kode_barang  = $this->request->getPost('kode_barang');
            $nama_barang  = $this->request->getPost('nama_barang');
            $kode_satuan  = $this->request->getPost('kode_satuan');
            $qty          = $this->request->getPost('qty');
            $harga        = $this->request->getPost('harga');
            $subtotal     = $this->request->getPost('subtotal');

            $data = [
                'id_salesrtn' => $id_salesrtn,
                'no_retur'    => $no_retur,
                'kode_barang' => $kode_barang,
                'nama_barang' => $nama_barang,
                'kode_satuan' => $kode_satuan,
                'qty'         => $qty,
                'harga'       => $harga,
                'subtotal'    => $subtotal,
            ];
        
            $msg = [
                'viewmodal' => view('salesrtn/v_editharga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updateHarga()
    {
        if ($this->request->isAJAX()) {
            $id_salesrtn   = $this->request->getPost('id_salesrtn');
            $no_retur      = $this->request->getPost('no_retur');
            $qty           = str_replace(',', '', $this->request->getPost('qty'));
            $harga         = str_replace(',', '', $this->request->getPost('harga'));
            $subtotal      = str_replace(',', '', $qty * $harga);

            $data = array(
                'id_salesrtn' => $id_salesrtn,
                'no_retur'    => $no_retur,
                'qty'         => $qty,
                'harga'       => $harga,
                'subtotal'    => $subtotal,
            );
            $this->ModelSalesRtn->editCart($data);

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
            $kode_customer = $this->request->getPost('kode_customer');
            $keterangan    = $this->request->getPost('keterangan');
            $no_invoice    = $this->request->getPost('no_invoice');
            $total_dpp     = str_replace(",", "", $this->request->getPost('total_dpp'));
            $total_ppn     = str_replace(",", "", $this->request->getPost('total_ppn'));
            $total_retur   = str_replace(",", "", $this->request->getPost('total_retur'));
            $customer      = $this->ModelCustomer->detail($kode_customer);

            $ctr = $this->ModelCounter->allData();
            $sr = $ctr['sr'];
            $datactr = [
                'sr' => $sr
            ];
            $this->ModelCounter->updctr($datactr);
            $ctr    = $this->ModelCounter->allData();
            $nomor  = str_pad(strval($ctr['sr']), 5, '0', STR_PAD_LEFT);
            $no_retur = 'SR-' . $nomor .  '-' . date('y');

            if (empty($kode_customer)) {
                $msg = [
                    'error' => 'Maaf, Kode Customer Harus diisi !!!!'
                ];
                echo json_encode($msg);
            } else {
                $data = [
                    'no_retur'       => $no_retur,
                    'tgl_retur'      => $tgl_retur,
                    'kode_customer'  => $kode_customer,
                    'keterangan'     => $keterangan,
                    'no_invoice'     => $no_invoice,
                    'total_dpp'      => $total_dpp,
                    'total_ppn'      => $total_ppn,
                    'total_retur'    => $total_retur,
                ];

                $this->ModelSalesRtn->add($data);
                $ctr = $this->ModelCounter->allData();
                $inv = $ctr['sr'] + 1;
                $datactr = [
                    'sr' => $inv
                ];
                $this->ModelCounter->updctr($datactr);

                $ambildatakeranjang = $this->ModelSalesRtn->getCart($no_random);

                foreach ($ambildatakeranjang as $row) :
                    $datasr = array(
                        'no_retur'     => $no_retur,
                        'id_barang'    => $row['id_barang'],
                        'kode_barang'  => $row['kode_barang'],
                        'qty'          => $row['qty'],
                        'harga'        => $row['harga'],
                        'subtotal'     => $row['subtotal']
                    );
                    $this->ModelSalesRtn->add_detail($datasr);
                endforeach;

                // Insert Jurnal

                $codejurnal = 'Sales Return';
                $keterangan = 'RETUR PENJUALAN - ' . $customer['nama_customer'];

                $data2 = [
                    'no_voucher'     => $no_retur,
                    'tgl_voucher'    => $tgl_retur,
                    'kode_account'   => session()->get('acctrtrjl'),
                    'debet'          => $total_dpp,
                    'prime_debet'    => $total_dpp,
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'keterangan'     => $keterangan,
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data2);

                if ($total_ppn > 0) {
                    $data3 = [
                        'no_voucher'     => $no_retur,
                        'tgl_voucher'    => $tgl_retur,
                        'kode_account'   => session()->get('acctppnk'),
                        'debet'          => $total_ppn,
                        'prime_debet'    => $total_ppn,
                        'credit'         => 0,
                        'prime_credit'   => 0,
                        'keterangan'     => $keterangan,
                        'codejurnal'     => $codejurnal,
                    ];
                    $this->ModelJurnal->add_detail($data3);
                }

                $data1 = [
                    'no_voucher'     => $no_retur,
                    'tgl_voucher'    => $tgl_retur,
                    'kode_account'   => session()->get('acctar'),
                    'debet'          => 0,
                    'prime_debet'    => 0,
                    'credit'         => $total_retur,
                    'prime_credit'   => $total_retur,
                    'keterangan'     => $keterangan,
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data1);

                $this->ModelSalesRtn->clearCart($no_random);

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menambah Retur Penjualan : ' . $no_retur,
                ];
                $this->ModelLogHistory->add($datalog);


                $msg = [
                    'sukses' => 'Sales return has been added !!'
                ];
                echo json_encode($msg);
            }
        }
    }

    public function edit($no_retur)
    {
        $dsr = $this->ModelSalesRtn->detail_sr($no_retur);
        $this->ModelSalesRtn->clearCart($no_retur);

        foreach ($dsr as $dbl) {
            $datakeranjang = array(
                'id_salesrtn' => $dbl['id_salesrtn'],
                'no_retur'    => $dbl['no_retur'],
                'id_barang'   => $dbl['id_barang'],
                'kode_barang' => $dbl['kode_barang'],
                'qty'         => $dbl['qty'],
                'harga'       => $dbl['harga'],
                'subtotal'    => $dbl['subtotal'],
            );
            $this->ModelSalesRtn->addCart($datakeranjang);
        }
        $sr = $this->ModelSalesRtn->detail($no_retur);
        $data = [
            'sr'  => $sr,
        ];
        return view('salesrtn/v_edit', $data);
    }


    public function updateData()
    {
        if ($this->request->isAJAX()) {
            date_default_timezone_set('Asia/Jakarta');
            $no_retur       = $this->request->getPost('no_retur');
            $tgl_retur      = $this->request->getPost('tgl_retur');
            $kode_customer  = $this->request->getPost('kode_customer');
            $keterangan     = $this->request->getPost('keterangan');
            $no_invoice     = $this->request->getPost('no_invoice');
            $total_dpp      = str_replace(',', '', $this->request->getPost('total_dpp'));
            $total_ppn      = str_replace(',', '', $this->request->getPost('total_ppn'));
            $total_retur    = str_replace(",", "", $this->request->getPost('total_retur'));
            $customer      = $this->ModelCustomer->detail($kode_customer);

            $data = [
                'no_retur'      => $no_retur,
                'tgl_retur'     => $tgl_retur,
                'kode_customer' => $kode_customer,
                'keterangan'    => $keterangan,
                'no_invoice'    => $no_invoice,
                'total_dpp'     => $total_dpp,
                'total_ppn'     => $total_ppn,
                'total_retur'   => $total_retur,
            ];

            $this->ModelSalesRtn->edit($data);
            $this->ModelSalesRtn->delete_detail($no_retur);

            $ambildatakeranjang = $this->ModelSalesRtn->getCart($no_retur);

            foreach ($ambildatakeranjang as $row) :
                $data2 = array(
                    'id_salesrtn'  => $row['id_salesrtn'],
                    'no_retur'     => $row['no_retur'],
                    'id_barang'    => $row['id_barang'],
                    'kode_barang'  => $row['kode_barang'],
                    'qty'          => $row['qty'],
                    'harga'        => $row['harga'],
                    'subtotal'     => $row['subtotal']
                );
                $this->ModelSalesRtn->add_detail($data2);
            endforeach;

            $this->ModelJurnal->delete_detail($no_retur);
            // Insert Jurnal

            $codejurnal = 'Sales Return';
            $keterangan = 'RETUR PENJUALAN - ' . $customer['nama_customer'];

            $data2 = [
                'no_voucher'     => $no_retur,
                'tgl_voucher'    => $tgl_retur,
                'kode_account'   => session()->get('acctrtrjl'),
                'debet'          => $total_dpp,
                'prime_debet'    => $total_dpp,
                'credit'         => 0,
                'prime_credit'   => 0,
                'keterangan'     => $keterangan,
                'codejurnal'     => $codejurnal,
            ];
            $this->ModelJurnal->add_detail($data2);

            if ($total_ppn > 0) {
                $data3 = [
                    'no_voucher'     => $no_retur,
                    'tgl_voucher'    => $tgl_retur,
                    'kode_account'   => session()->get('acctppnk'),
                    'debet'          => $total_ppn,
                    'prime_debet'    => $total_ppn,
                    'credit'         => 0,
                    'prime_credit'   => 0,
                    'keterangan'     => $keterangan,
                    'codejurnal'     => $codejurnal,
                ];
                $this->ModelJurnal->add_detail($data3);
            }

            $data1 = [
                'no_voucher'     => $no_retur,
                'tgl_voucher'    => $tgl_retur,
                'kode_account'   => session()->get('acctar'),
                'debet'          => 0,
                'prime_debet'    => 0,
                'credit'         => $total_retur,
                'prime_credit'   => $total_retur,
                'keterangan'     => $keterangan,
                'codejurnal'     => $codejurnal,
            ];
            $this->ModelJurnal->add_detail($data1);

            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Merubah Retur Penjualan : ' . $no_retur,
            ];
            $this->ModelLogHistory->add($datalog);


            $this->ModelSalesRtn->clearCart($no_retur);

            $msg = [
                'sukses' => 'Sales Return has been Updated'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $this->ModelSalesRtn->deleteCart($id);
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
            $this->ModelSalesRtn->delete_master($noretur);
            $this->ModelSalesRtn->delete_detail($noretur);
            $this->ModelJurnal->delete_detail($noretur);
            
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Retur Penjualan : ' . $noretur,
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
            'title' => 'Sales Return',
            'sr'   => $this->ModelSalesRtn->detail($no_retur),
            'dsr'  => $this->ModelSalesRtn->detail_sr($no_retur),
        ];
        return view('salesrtn/v_list', $data);
    }
}
