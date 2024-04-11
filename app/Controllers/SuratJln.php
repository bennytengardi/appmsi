<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelBarang;
use App\Models\ModelDataBrg;
use App\Models\ModelDivisi;
use App\Models\ModelSuratJln;
use App\Models\ModelDataSuratJln;
use App\Models\ModelCounter;
use App\Models\ModelLogHistory;

use Config\Services;

class SuratJln extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelSuratJln = new ModelSuratJln();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelDivisi   = new ModelDivisi();
        $this->ModelCounter  = new ModelCounter();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date_format(date_create("2023-01-01"), "Y-m-d");
        session()->set('tglawlsj', $date);
        session()->set('tglakhsj', date('Y-m-d'));
        session()->set('cust1', 'ALL');
        $data = [
            'customer'    => $this->ModelCustomer->allData2(),
        ];
        return view('suratjln/v_index', $data);
    }

    public function index2($id_sj)
    {
        $ma = $this->ModelSuratJln->detail($id_sj);
        $no_suratjln = $ma['no_suratjln'];
        $this->ModelSuratJln->clearCart($no_suratjln);
        $data = [
            'customer'    => $this->ModelCustomer->allData2(),
        ];
        return view('suratjln/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataSuratJln = new ModelDataSuratJln($request);
        if ($request->getMethod(true) == 'POST') {
            $SuratJln = $this->ModelDataSuratJln->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($SuratJln as $sl) {
                $row = [];
                $row[] = $no++;
                $row[] = $sl['no_suratjln'];
                $row[] = date('d-m-Y', strtotime($sl['tgl_suratjln']));
                $row[] = $sl['nama_customer'];
                $row[] = $sl['no_so'];
                if (empty($sl['no_invoice'])) {
                    $row[] = "";
                } else {
                    $row[] = "<span class=\"badge badge-pill badge-success\" style=\"border-radius: 12px; padding: 5px\">INVOICE</span>";
                }
                $row[] = $sl['project'];
                $row[] = $sl['kode_divisi'];
                if (session()->get('level') == "1") {
                    $row[] =
                        '<a href="' . base_url('SuratJln/edit/' . $sl['id_sj']) . '" class="btn btn-success btn-xs mr-2" style="font-size: 10px;height: 18px;">Edit</a>' .
                        '<a href="' . base_url('SuratJln/detail/' . $sl['id_sj']) . '" class="btn btn-info btn-xs mr-2" style="font-size: 10px;height: 18px;">Detail</a>' .
                        '<a href="' . base_url('SuratJln/printsj/' . $sl['id_sj']) . '" class="btn btn-warning btn-xs mr-2" style="font-size: 10px;height: 18px;">Print</a>' .
                        "<button type=\"button\" class=\"btn btn-danger btn-xs\" style=\"font-size: 10px;height: 18px;\" onclick=\"hapusSuratJln('" . $sl['no_suratjln'] . "','" . $sl['nama_customer'] . "') \">Delete</button>";
                } else {
                    $row[] =
                        '<a href="' . base_url('SuratJln/detail/' . $sl['id_sj']) . '" class="btn btn-info btn-xs mr-2" style="font-size: 10px;height: 18px;">See Detail</a>' .
                        '<a href="' . base_url('SuratJln/printsj/' . $sl['id_sj']) . '" class="btn btn-danger btn-xs mr-2" style="font-size: 10px;height: 18px;">Print DO</a>';
                }
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataSuratJln->count_all(),
                "recordsFiltered" => $this->ModelDataSuratJln->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tgl_suratjln = date('Y-m-d');
        $no_random = rand();
        $no_suratjln  = '';
        $data = [
            'tgl_suratjln'  => $tgl_suratjln,
            'customer'      => $this->ModelCustomer->allData(),
            'divisi'        => $this->ModelDivisi->allData(),
            'no_suratjln'   => $no_suratjln,
            'no_random'     => $no_random,
            'validation'    => \config\Services::validation()
        ];
        $this->ModelSuratJln->clearCart($no_suratjln);
        return view('suratjln/v_add', $data);
    }

    public function setses()
    {
        if ($this->request->isAJAX()) {
            $tgl1 = $this->request->getPost('tgl1');
            $tgl2 = $this->request->getPost('tgl2');
            $cust1 = $this->request->getPost('cust');
            session()->set('tglawlsj', $tgl1);
            session()->set('tglakhsj', $tgl2);
            session()->set('cust1', $cust1);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }


    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $no_suratjln = $this->request->getPost('no_suratjln');
            $dtl        = $this->ModelSuratJln->getCart($no_suratjln);
            $data  = [
                'datadetail' => $dtl
            ];
            $msg = [
                'data' => view('suratjln/v_harga', $data)
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
                'viewmodal' => view('suratjln/v_caribarang', $data)
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
                    $row[] = "<button type=\"button\" class=\"btn btn-xs btn-info\" style=\"height: 22px; font-size: 10px;\"  onclick=\"pilihitem('" . $list['id_barang'] .  "','" . "')\" ><i class=\"fa fa-check\"></i></button>";
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


    public function simpanTemp()
    {
        if ($this->request->isAJAX()) {
            if (empty($this->request->getPost('qty'))) {
                $qty = 0;
            } else {
                $qty  = str_replace(',', '', $this->request->getPost('qty'));
            }
            $no_random   = $this->request->getPost('no_random');
            $id_barang   = $this->request->getPost('id_barang');
            $kode_barang = $this->request->getPost('kode_barang');
            $nama_barang = $this->request->getPost('nama_barang');
            $catatan = $this->request->getPost('catatan');
            if (strlen($nama_barang) > 0) {
                $tkeranjang = $this->db->table('keranjangsj');
                $isikeranjang = [
                    'no_suratjln'  => $no_random,
                    'id_barang'    => $id_barang,
                    'kode_barang'  => $kode_barang,
                    'qty'          => $qty,
                    'catatan'      => $catatan
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
            date_default_timezone_set('Asia/Jakarta');
            $no_random      = $this->request->getPost('no_random');
            $no_suratjln    = $this->request->getPost('no_suratjln');
            $tgl_suratjln   = $this->request->getPost('tgl_suratjln');
            $kode_customer  = $this->request->getPost('kode_customer');
            $kode_divisi    = $this->request->getPost('kode_divisi');
            $no_so          = $this->request->getPost('no_so');
            $no_po          = $this->request->getpost('no_po');
            $project        = $this->request->getpost('project');
            $remark     = $this->request->getPost('remark');
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'kode_customer' => [
                    'label' => 'Customer#',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
                'kode_divisi' => [
                    'label' => 'Kode Divisi',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
                'no_suratjln' => [
                    'label' => 'No DO',
                    'rules' => 'required|is_unique[tbl_suratjln.no_suratjln]',
                    'errors' => [
                        'required'  => '{field} is required',
                        'is_unique' => '{field} already exist'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorKodeCustomer' => $validation->getError('kode_customer'),
                        'errorKodeDivisi' => $validation->getError('kode_divisi'),
                        'errorNoSj'   => $validation->getError('no_suratjln'),
                    ]
                ];
                echo json_encode($msg);
            } else {
                $ambildatakeranjang = $this->ModelSuratJln->getCart($no_random);
                if (empty($ambildatakeranjang)) {
                    $msg = ['error' => 'Sorry, Shopping Cart is empty !!!!'];
                    echo json_encode($msg);
                } else {
                    $data = [
                        'no_suratjln'    => $no_suratjln,
                        'tgl_suratjln'   => $tgl_suratjln,
                        'kode_customer'  => $kode_customer,
                        'kode_divisi'    => $kode_divisi,
                        'no_so'          => $no_so,
                        'no_po'          => $no_po,
                        'project'        => $project,
                        'remark'     => $remark,
                    ];
                    $this->ModelSuratJln->add($data);
                    foreach ($ambildatakeranjang as $row) :
                        $datainv = array(
                            'no_suratjln'  => $no_suratjln,
                            'id_barang'    => $row['id_barang'],
                            'kode_barang'  => $row['kode_barang'],
                            'qty'          => $row['qty'],
                            'harga'        => $row['harga'],
                            'subtotal'     => $row['qty'] * $row['harga'],
                            'catatan'      => $row['catatan'],
                        );
                        $this->ModelSuratJln->add_detail($datainv);
                    endforeach;
                    $this->ModelSuratJln->clearCart($no_random);
                    
                    date_default_timezone_set('Asia/Jakarta');
                    $datalog = [
                        'username'  => session()->get('username'),
                        'jamtrx'    => date('Y-m-d H:i:s'),
                        'kegiatan'  => 'Menambah Surat Jalan : ' . $no_suratjln,
                    ];
                    $this->ModelLogHistory->add($datalog);
                    
                    $msg = ['sukses' => 'Deleviry Order has been added !!'];
                    echo json_encode($msg);
                }
            }
        }
    }

    public function edit($id_sj)
    {
        $msuratjln = $this->ModelSuratJln->detail($id_sj);
        $no_suratjln = $msuratjln['no_suratjln'];
        $dsuratjln = $this->ModelSuratJln->detail_sj($no_suratjln);
        $this->ModelSuratJln->clearCart($no_suratjln);
        foreach ($dsuratjln as $dsj) {
            $datakeranjang = array(
                'id_suratjln'  => $dsj['id_suratjln'],
                'no_suratjln'  => $dsj['no_suratjln'],
                'kode_barang'  => $dsj['kode_barang'],
                'qty'          => $dsj['qty'],
                
                'catatan'      => $dsj['catatan'],
            );
            $this->ModelSuratJln->addCart($datakeranjang);
        }

        $data = [
            'msj' => $msuratjln,
            'customer'  => $this->ModelCustomer->allData(),
            'divisi'  => $this->ModelDivisi->allData(),
        ];
        return view('suratjln/v_edit', $data);
    }

    public function viewEditHarga()
    {
        if ($this->request->isAJAX()) {
            $id_suratjln  = $this->request->getPost('id_suratjln');
            $no_suratjln  = $this->request->getPost('no_suratjln');
            $id_barang    = $this->request->getPost('id_barang');
            $kode_barang  = $this->request->getPost('kode_barang');
            $nama_barang  = $this->request->getPost('nama_barang');
            $kode_satuan  = $this->request->getPost('kode_satuan');
            $qty          = $this->request->getPost('qty');
            $catatan      = $this->request->getPost('catatan');

            $data = [
                'id_suratjln' => $id_suratjln,
                'no_suratjln' => $no_suratjln,
                'id_barang'   => $id_barang,
                'kode_barang' => $kode_barang,
                'nama_barang' => $nama_barang,
                'kode_satuan' => $kode_satuan,
                'qty'         => $qty,
                'catatan'     => $catatan,
            ];
            $msg = [
                'viewmodal' => view('suratjln/v_editharga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updateHarga()
    {
        if ($this->request->isAJAX()) {
            $id_suratjln   = $this->request->getPost('id_suratjln');
            $no_suratjln   = $this->request->getPost('no_suratjln');
            $qty           = $this->request->getPost('qty');
            $catatan       = $this->request->getPost('catatan');
            $data = array(
                'id_suratjln' => $id_suratjln,
                'no_suratjln' => $no_suratjln,
                'qty'         => $qty,
                'catatan'     => $catatan,
            );
            $this->ModelSuratJln->editCart($data);

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
            $no_suratjln    = $this->request->getPost('no_suratjln');
            $tgl_suratjln   = $this->request->getPost('tgl_suratjln');
            $kode_customer  = $this->request->getPost('kode_customer');
            $kode_divisi    = $this->request->getPost('kode_divisi');
            $no_po          = $this->request->getpost('no_po');
            $project        = $this->request->getpost('project');
            $remark      = $this->request->getPost('remark');

            $data = [
                'no_suratjln'    => $no_suratjln,
                'tgl_suratjln'   => $tgl_suratjln,
                'kode_customer'  => $kode_customer,
                'kode_divisi'    => $kode_divisi,
                'no_po'          => $no_po,
                'project'        => $project,
                'remark'         => $remark,
            ];
            $ambildatakeranjang = $this->ModelSuratJln->getCart($no_suratjln);
            $this->ModelSuratJln->edit($data);
            $this->ModelSuratJln->delete_detail($no_suratjln);
            foreach ($ambildatakeranjang as $row) :
                $datainv = array(
                    'no_suratjln'  => $row['no_suratjln'],
                    'id_barang'    => $row['id_barang'],
                    'kode_barang'  => $row['kode_barang'],
                    'qty'          => $row['qty'],
                    'harga'        => $row['harga'],
                    'subtotal'     => $row['qty'] * $row['harga'],
                    'catatan'      => $row['catatan'],
                );
                $this->ModelSuratJln->add_detail($datainv);
            endforeach;

            $this->ModelSuratJln->clearCart($no_suratjln);

            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Merubah Surat Jalan : ' . $no_suratjln,
            ];
            $this->ModelLogHistory->add($datalog);

            $msg = ['sukses' => 'Deleviry Order has been Updated !!'];
            echo json_encode($msg);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $this->ModelSuratJln->deleteCart($id);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function detail($id_sj)
    {
        $msjl   = $this->ModelSuratJln->detail($id_sj);
        $no_suratjln = $msjl['no_suratjln'];
        $data = [
            'msuratjln' => $msjl,
            'dsuratjln' => $this->ModelSuratJln->detail_sj($no_suratjln),
        ];
        return view('suratjln/v_list', $data);
    }

    public function printsj($id_sj)
    {
        $msjl   = $this->ModelSuratJln->detail3($id_sj);
        $no_suratjln = $msjl['no_suratjln'];
        $data = [
            'msuratjln'   => $msjl,
            'dsuratjln'   => $this->ModelSuratJln->detail_sj($no_suratjln),
        ];
        return view('suratjln/v_printsj', $data);
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $nosuratjln = $this->request->getVar('no_suratjln');
            $this->ModelSuratJln->delete_master($nosuratjln);
            $this->ModelSuratJln->delete_detail($nosuratjln);
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Surat Jalan : ' . $nosuratjln,
            ];
            $this->ModelLogHistory->add($datalog);
            
            $msg = ['sukses' => 'Data Surat Jalan berhasil dihapus'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }

    public function cari_nosuratjln()
    {
        $no_suratjln = $this->request->getPost('no_suratjln');
        $data = $this->ModelSuratJln->detail($no_suratjln);
        echo json_encode($data);
    }

    public function ambilSalesOrd()
    {
        $kode_customer = $this->request->getPost('kode_customer');
        $data = $this->ModelSuratJln->ambilDataSO($kode_customer);

        session()->set('kodecust', $kode_customer);
        $output = "<option value=''>PILIH NO SO</option>";
        foreach ($data as $row) {
            $output .= '<option value="' . $row['no_so'] . '">' . $row['no_so'] . '</option>';
        }
        echo json_encode($output);
    }

    public function get_dataso()
    {
        if ($this->request->isAJAX()) {
            $no_so = $this->request->getPost('no_so');
            $no_random = $this->request->getPost('no_random');
            $this->ModelSuratJln->clearCart($no_random);
            $dataso = $this->ModelSuratJln->get_sobybrg($no_so);

            foreach ($dataso as $list) {
                $isikeranjang = [
                    'no_suratjln' => $no_random,
                    'id_barang'   => $list['id_barang'],
                    'kode_barang' => $list['kode_barang'],
                    'harga'       => $list['harga'],
                    'qty'         => $list['qty'],
                    'subtotal'    => $list['subtotal']
                ];
                $this->ModelSuratJln->addCart($isikeranjang);
            }
            $msg = ['sukses' => 'berhasil'];
            echo json_encode($msg);
        }
    }
}
