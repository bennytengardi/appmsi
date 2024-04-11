<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelBarang;
use App\Models\ModelDivisi;
use App\Models\ModelSalesOrd;
use App\Models\ModelDataSalesOrd;
use App\Models\ModelDataBrg;
use App\Models\ModelLogHistory;

// use CodeIgniter\CLI\Console;
use Config\Services;

class SalesOrd extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelSalesOrd = new ModelSalesOrd();
        $this->ModelDivisi   = new ModelDivisi();
        $this->ModelBarang   = new ModelBarang();
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
        return view('salesord/v_index', $data);
    }

    // public function index2($id_so)
    // {
    //     date_default_timezone_set('Asia/Jakarta');
    //     $date = date_format(date_create("2023-01-01"), "Y-m-d");
    //     session()->set('tglawlinv', $date);
    //     session()->set('tglakhinv', date('Y-m-d'));
    //     session()->set('cust1', 'ALL');

    //     $mb = $this->ModelSalesOrd->detail($id_so);
    //     $no_so = $mb['no_so'];
    //     $this->ModelSalesOrd->clearCart($no_so);

    //     $data = [
    //         'customer'    => $this->ModelCustomer->allData2(),
    //     ];
    //     return view('salesord/v_index', $data);
    // }

    public function index2($id_so)
    {
        $ma = $this->ModelSalesOrd->detail($id_so);
        
        $no_so = $ma['no_so'];
        $this->ModelSalesOrd->clearCart($no_so);
        $data = [
            'customer'    => $this->ModelCustomer->allData2(),
        ];
        return view('salesord/v_index', $data);
    }




    public function listData()
    {
        $request = Services::request();
        $this->ModelDataSalesOrd = new ModelDataSalesOrd($request);
        if ($request->getMethod(true) == 'POST') {
            $salesord = $this->ModelDataSalesOrd->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($salesord as $sl) {
                $row = [];
                $row[] = $no++;
                $row[] = $sl['no_so'];
                $row[] = date('d-m-Y', strtotime($sl['tgl_so']));
                $row[] = $sl['nama_customer'];
                $row[] = $sl['no_po'];
                $row[] = $sl['kode_divisi'];
                $row[] = number_format($sl['total_so'], '0', '.', ',');
                if (session()->get('level') == "1") {
                    $row[] =
                        '<a href="' . base_url('SalesOrd/edit/' . $sl['id_so']) . '" class="btn btn-success btn-xs mr-2"></i>Edit</a>' .
                        '<a href="' . base_url('SalesOrd/detail/' . $sl['id_so']) . '" class="btn btn-info btn-xs mr-2">Detail</a>' .
                        '<a href="' . base_url('SalesOrd/print/' . $sl['id_so']) . '" class="btn btn-primary btn-xs mr-2">Print</a>' .
                        "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"hapusSalesOrd('" . $sl['no_so'] . "','" . $sl['nama_customer'] . "') \">Delete</button>";
                } else {
                    $row[] =
                        '<a href="' . base_url('SalesOrd/detail/' . $sl['id_so']) . '" class="btn btn-info btn-xs mr-2">Detail</a>' .
                        '<a href="' . base_url('SalesOrd/print/' . $sl['id_so']) . '" class="btn btn-success btn-xs mr-2">Print</a>'  ;
                }
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataSalesOrd->count_all(),
                "recordsFiltered" => $this->ModelDataSalesOrd->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
        
    public function add()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tgl_so = date('Y-m-d');
        $no_random = rand();
        $no_so = '';
        $data = [
            'tgl_so'       => $tgl_so,
            'due_date'     => $tgl_so,
            'divisi'       => $this->ModelDivisi->allData(),
            'barang'       => $this->ModelBarang->allData(),
            'customer'     => $this->ModelCustomer->allData(),
            'no_so'        => $no_so,
            'no_random'    => $no_random,
            'validation'   => \config\Services::validation()
        ];
        $this->ModelSalesOrd->clearCart($no_random);
        return view('salesord/v_add', $data);
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
                'viewmodal' => view('salesord/v_caribarang', $data)
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
            $no_so = $this->request->getPost('no_so');
            $dtl   = $this->ModelSalesOrd->getCart($no_so);
            
            $data  = [
                'datadetail' => $dtl
            ];
        
            $msg = [
                'data' => view('salesord/v_harga', $data)
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
                $tkeranjang = $this->db->table('keranjangso');
                $barang     = $queryCekBarang->getRowArray();
                $subtotal   = $qty * $harga;
                $isikeranjang = [
                    'no_so'       => $no_random,
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
            $no_random      = $this->request->getPost('no_random');
            $no_so          = $this->request->getPost('no_so');
            $tgl_so         = $this->request->getPost('tgl_so');
            $kode_customer  = $this->request->getPost('kode_customer');
            $no_po          = $this->request->getPost('no_po');
            $kode_divisi    = $this->request->getPost('kode_divisi');
            $nama_pemesan   = $this->request->getPost('nama_pemesan');
            $no_handphone   = $this->request->getPost('no_handphone');
            $nama_proyek    = $this->request->getPost('nama_proyek');
            $tgl_kirim      = $this->request->getPost('tgl_kirim');
            $lokasi_kirim   = $this->request->getPost('lokasi_kirim');
            $catatan1       = $this->request->getPost('catatan1');
            $catatan2       = $this->request->getPost('catatan2');
            $catatan3       = $this->request->getPost('catatan3');
            $catatan4       = $this->request->getPost('catatan4');
            $pembayaran     = $this->request->getPost('pembayaran');
            $total_amount   = str_replace(',', '', $this->request->getPost('total_amount'));
            $total_ppn      = str_replace(',', '', $this->request->getPost('total_ppn'));
            $total_so       = str_replace(',', '', $this->request->getPost('total_so'));
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
                'kode_divisi' => [
                    'label' => 'Kode Divisi',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi'
                    ]
                ],
                'no_so' => [
                    'label' => 'No SO',
                    'rules' => 'required|is_unique[tbl_salesord.no_so]',
                    'errors' => [
                        'required'  => '{field} harus diisi',
                        'is_unique' => '{field} sudah ada'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorKodeCustomer' => $validation->getError('kode_customer'),
                        'errorNoSo'         => $validation->getError('no_so'),
                        'errorKodeDivisi'   => $validation->getError('kode_divisi'),
                    ]
                ];
                echo json_encode($msg);
            } else {
                $ambildatakeranjang = $this->ModelSalesOrd->getCart($no_random);
                if (empty($ambildatakeranjang)) {
                    $msg = [
                        'error' => 'Maaf, Belum diisi transaksi !!!!'
                    ];
                    echo json_encode($msg);
                } else {
                    $data = [
                        'no_so'          => $no_so,
                        'tgl_so'         => $tgl_so,
                        'kode_customer'  => $kode_customer,
                        'nama_pemesan'   => $nama_pemesan,
                        'no_handphone'   => $no_handphone,
                        'nama_proyek'    => $nama_proyek,
                        'pembayaran'     => $pembayaran,
                        'no_po'          => $no_po,
                        'tgl_kirim'      => $tgl_kirim,
                        'lokasi_kirim'   => $lokasi_kirim,
                        'kode_divisi'    => $kode_divisi,
                        'catatan1'       => $catatan1,
                        'catatan2'        => $catatan2,
                        'catatan3'        => $catatan3,
                        'catatan4'        => $catatan4,
                        'total_amount'   => $total_amount,
                        'total_ppn'      => $total_ppn,
                        'total_so'       => $total_so,
                    ];           
                    $this->ModelSalesOrd->add($data);

                    foreach ($ambildatakeranjang as $row) :
                        $dataso = array(
                            'no_so'        => $no_so,
                            'id_barang'    => $row['id_barang'],
                            'kode_barang'  => $row['kode_barang'],
                            'qty'          => $row['qty'],
                            'harga'        => $row['harga'],
                            'subtotal'     => $row['subtotal'],
                        );
                        $this->ModelSalesOrd->add_detail($dataso);
                    endforeach;

                    $this->ModelSalesOrd->clearCart($no_random);

                    date_default_timezone_set('Asia/Jakarta');
                    $datalog = [
                        'username'  => session()->get('username'),
                        'jamtrx'    => date('Y-m-d H:i:s'),
                        'kegiatan'  => 'Menambah Sales Order : ' . $no_so,
                    ];
                    $this->ModelLogHistory->add($datalog);

                    $msg = [
                        'sukses' => 'Sales Order has been Added'
                    ];
                    echo json_encode($msg);
                }
            }
        }
    }

    public function edit($id_so)
    {
        $msalesord  = $this->ModelSalesOrd->detail($id_so);
        $no_so      = $msalesord['no_so'];
        $dsalesord  = $this->ModelSalesOrd->detail_so($no_so);
        $this->ModelSalesOrd->clearCart($no_so);
    
        foreach ($dsalesord as $sinv) {
            $datakeranjang = array(
                'id_salesord' => $sinv['id_salesord'],
                'no_so'       => $sinv['no_so'],
                'id_barang'   => $sinv['id_barang'],
                'kode_barang' => $sinv['kode_barang'],
                'qty'         => $sinv['qty'],
                'harga'       => $sinv['harga'],
                'subtotal'    => $sinv['subtotal'],
            );
            $this->ModelSalesOrd->addCart($datakeranjang);
        }

        $data = [
            'msalesord'      => $msalesord,
            'customer'       => $this->ModelCustomer->allData(),
            'barang'         => $this->ModelBarang->allData(),
            'divisi'         => $this->ModelDivisi->allData(),
        ];
        return view('salesord/v_edit', $data);
    }

    public function viewEditHarga()
    {
        if ($this->request->isAJAX()) {
            $id_salesord  = $this->request->getPost('id_salesord');
            $no_so        = $this->request->getPost('no_so');
            $id_barang    = $this->request->getPost('id_barang');
            $kode_barang  = $this->request->getPost('kode_barang');
            $nama_barang  = $this->request->getPost('nama_barang');
            $kode_satuan  = $this->request->getPost('kode_satuan');
            $qty          = $this->request->getPost('qty');
            $harga        = $this->request->getPost('harga');
            $subtotal     = $this->request->getPost('subtotal');

            $data = [
                'id_salesord' => $id_salesord,
                'no_so'       => $no_so,
                'id_barang'   => $id_barang,
                'kode_barang' => $kode_barang,
                'nama_barang' => $nama_barang,
                'kode_satuan' => $kode_satuan,
                'qty'         => $qty,
                'harga'       => $harga,
                'subtotal'    => $subtotal,
            ];
            $msg = [
                'viewmodal' => view('salesord/v_editharga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updateHarga()
    {
        if ($this->request->isAJAX()) {
            $id_salesord   = $this->request->getPost('id_salesord');
            $no_so         = $this->request->getPost('no_so');
            $qty           = $this->request->getPost('qty');
            $harga         = str_replace(',', '', $this->request->getPost('harga'));
            $subtotal      = str_replace(',', '', $qty * $harga);
            $data = array(
                'id_salesord' => $id_salesord,
                'no_so'  => $no_so,
                'qty'         => $qty,
                'harga'       => $harga,
                'subtotal'    => $subtotal,
            );
            $this->ModelSalesOrd->editCart($data);

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
            $id_so         = $this->request->getPost('id_so');
            $no_so          = $this->request->getPost('no_so');
            $tgl_so         = $this->request->getPost('tgl_so');
            $kode_customer  = $this->request->getPost('kode_customer');
            $no_po          = $this->request->getPost('no_po');
            $nama_pemesan   = $this->request->getPost('nama_pemesan');
            $no_handphone   = $this->request->getPost('no_handphone');
            $nama_proyek    = $this->request->getPost('nama_proyek');
            $tgl_kirim      = $this->request->getPost('tgl_kirim');
            $lokasi_kirim   = $this->request->getPost('lokasi_kirim');
            $kode_divisi    = $this->request->getPost('kode_divisi');
            $catatan1       = $this->request->getPost('catatan1');
            $catatan2       = $this->request->getPost('catatan2');
            $catatan3       = $this->request->getPost('catatan3');
            $catatan4       = $this->request->getPost('catatan4');
            $pembayaran     = $this->request->getPost('pembayaran');
            $total_amount   = str_replace(',', '', $this->request->getPost('total_amount'));
            $total_ppn      = str_replace(',', '', $this->request->getPost('total_ppn'));
            $total_so       = str_replace(',', '', $this->request->getPost('total_so'));

            $data = [
                'id_so'          => $id_so,
                'no_so'          => $no_so,
                'tgl_so'         => $tgl_so,
                'kode_customer'  => $kode_customer,
                'nama_pemesan'   => $nama_pemesan,
                'no_handphone'   => $no_handphone,
                'nama_proyek'    => $nama_proyek,
                'kode_divisi'    => $kode_divisi,
                'pembayaran'     => $pembayaran,
                'no_po'          => $no_po,
                'tgl_kirim'      => $tgl_kirim,
                'lokasi_kirim'   => $lokasi_kirim,
                'catatan1'       => $catatan1,
                'catatan2'       => $catatan2,
                'catatan3'       => $catatan3,
                'catatan4'       => $catatan4,
                'total_amount'   => $total_amount,
                'total_ppn'      => $total_ppn,
                'total_so'       => $total_so,
            ];           

            $ambildatakeranjang = $this->ModelSalesOrd->getCart($no_so);
            if (empty($ambildatakeranjang)) {
                $msg = [
                    'error' => 'Maaf, Belum diisi transaksi !!!!'
                ];
                echo json_encode($msg);
            } else {
                $this->ModelSalesOrd->edit($data);
                $this->ModelSalesOrd->delete_detail($no_so);
                
                foreach ($ambildatakeranjang as $row) :
                    $dataso = array(
                        'no_so'        => $row['no_so'],
                        'id_barang'    => $row['id_barang'],
                        'kode_barang'  => $row['kode_barang'],
                        'qty'          => $row['qty'],
                        'harga'        => $row['harga'],
                        'subtotal'     => $row['subtotal'],
                    );
                    $this->ModelSalesOrd->add_detail($dataso);
                endforeach;

                $this->ModelSalesOrd->clearCart($no_so);

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Sales Order : ' . $no_so,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Sales Order has been Updated'
                ];
                echo json_encode($msg);
            }
        }
    }


    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $this->ModelSalesOrd->deleteCart($id);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function detail($id_so)
    {
        $minv   = $this->ModelSalesOrd->detail($id_so);
        $no_so = $minv['no_so'];
        $data = [
            'msalesord' => $minv,
            'dsalesord' => $this->ModelSalesOrd->detail_so($no_so),
        ];
        return view('salesord/v_list', $data);
    }

    public function print($id_so)
    {
        $minv   = $this->ModelSalesOrd->detail($id_so);
        $no_so = $minv['no_so'];
        $data = [
            'msalesord' => $minv,
            'dsalesord' => $this->ModelSalesOrd->detail_so($no_so),
        ];
        return view('salesord/v_print', $data);
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $noso = $this->request->getVar('no_so');
            $this->ModelSalesOrd->delete_master($noso);
            $this->ModelSalesOrd->delete_detail($noso);

            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Sales Order : ' . $noso,
            ];
            $this->ModelLogHistory->add($datalog);

            $msg = ['sukses' => 'Sales Order has been Deleted'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }

    public function cari_noso()
    {
        $no_so = $this->request->getPost('no_so');
        $data = $this->ModelSalesOrd->detailSo($no_so);
        echo json_encode($data);
    }


    public function hitungTotalBelanja()
    {
        if ($this->request->isAJAX()) {
            $no_so = $this->request->getPost('no_random');
            $status = $this->request->getPost('status');
            $tkeranjang = $this->db->table('keranjangso');
            $queryTotal = $tkeranjang->select('SUM(subtotal) as totalAmount')->where('no_so', $no_so)->get();
            $rowTotal   = $queryTotal->getRowArray();
            $totamt     = $rowTotal['totalAmount'];
            if ($status == 'PKP') {
                $totppn     = $totamt * 0.11;
            } else {
                $totppn = 0;
            }
            $totso    = $totamt + $totppn;
            $msg = [
                'totalamount' =>  number_format($totamt, 0, '.', ','),
                'totalppn' =>  number_format($totppn, 0, '.', ','),
                'totalso' =>  number_format($totso, 0, '.', ',')
            ];
            echo json_encode($msg);
        }
    }

    public function hitungTotalBelanja2()
    {
        if ($this->request->isAJAX()) {
            $no_so = $this->request->getPost('no_so');
            $status = $this->request->getPost('status');

            $tkeranjang = $this->db->table('keranjangso');
            $queryTotal = $tkeranjang->select('SUM(subtotal) as totalAmount')->where('no_so', $no_so)->get();
            $rowTotal   = $queryTotal->getRowArray();
            $totamt     = $rowTotal['totalAmount'];
            if ($status == 'PKP') {
                $totppn     = $totamt * 0.11;
            } else {
                $totppn = 0;
            }
            $totso      = $totamt + $totppn;
            $msg = [
                'totalamount' =>  number_format($totamt, 0, '.', ','),
                'totalppn' =>  number_format($totppn, 0, '.', ','),
                'totalso' =>  number_format($totso, 0, '.', ',')
            ];
            echo json_encode($msg);
        }
    }
    

}
