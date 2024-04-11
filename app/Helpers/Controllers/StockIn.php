<?php

namespace App\Controllers;

use App\Models\ModelSupplier;
use App\Models\ModelBarang;
use App\Models\ModelStockIn;
use App\Models\ModelDataStockIn;
use App\Models\ModelCounter;
use App\Models\ModelDataBrg;
use App\Models\ModelLogHistory;

use Config\Services;

class StockIn extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelStockIn  = new ModelStockIn();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelCounter  = new ModelCounter();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        return view('stockin/v_index');
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataStockIn = new ModelDataStockIn($request);
        if ($request->getMethod(true) == 'POST') {
            $stockin = $this->ModelDataStockIn->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($stockin as $stokin) {
                $row = [];
                $row[] = $no++;
                $row[] = $stokin['no_bukti'];
                $row[] = date('d-m-Y', strtotime($stokin['tgl_bukti']));
                $row[] = $stokin['nama_supplier'];
                $row[] = $stokin['keterangan'];
                if (session()->get('level') == "1") {
                    $row[] =
                        '<a href="' . base_url('StockIn/edit/' . $stokin['no_bukti']) . '" class="btn btn-success btn-xs mr-2"></i>Edit</a>' .
                        '<a href="' . base_url('StockIn/detail/' . $stokin['no_bukti']) . '" class="btn btn-info btn-xs mr-2">Detail</a>' .
                        "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"hapusStockIn('" . $stokin['no_bukti'] . "','" . $stokin['nama_supplier'] . "') \">Delete</button>";
                } else {
                    $row[] =
                        '<a href="' . base_url('StockIn/detail/' . $stokin['no_bukti']) . '" class="btn btn-info btn-xs mr-2">See Detail</a>';
                }
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataStockIn->count_all(),
                "recordsFiltered" => $this->ModelDataStockIn->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tgl_bukti = date('Y-m-d');
        $ctr    = $this->ModelCounter->allData();
        $nomor  = str_pad(strval(($ctr['pindah'] + 1)), 4, '0', STR_PAD_LEFT);
        $no_bukti  = $nomor . '-IN-' . date('Y');
        $data = [
            'no_bukti'   => $no_bukti,
            'tgl_bukti'  => $tgl_bukti,
            'supplier'     => $this->ModelSupplier->alldata(),
            'validation'   => \config\Services::validation()
        ];
        $this->ModelStockIn->clearCart();
        return view('stockin/v_add', $data);
    }

    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $no_bukti = $this->request->getPost('no_bukti');
            $dtl      = $this->ModelStockIn->getCart($no_bukti);
            $data  = [
                'datadetail' => $dtl,
            ];

            $msg = [
                'data' => view('stockin/v_harga', $data)
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
                'viewmodal' => view('stockin/v_caribarang', $data)
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
            $no_bukti      = $this->request->getPost('no_bukti');
            $id_barang     = $this->request->getPost('id_barang');
            $kode_barang   = $this->request->getPost('kode_barang');
            $nama_barang   = $this->request->getPost('nama_barang');
            $kode_satuan   = $this->request->getPost('kode_satuan');

            $tkeranjang = $this->db->table('keranjangstockin');
            $isikeranjang = [
                'no_bukti'    => $no_bukti,
                'id_barang'   => $id_barang,
                'kode_barang' => $kode_barang,
                'qty'         => $qty,
            ];
        
            $tkeranjang->insert($isikeranjang);
            $msg = ['sukses' => 'berhasil'];
            echo json_encode($msg);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $no_bukti    = $this->request->getPost('no_bukti');
            $tgl_bukti   = $this->request->getPost('tgl_bukti');
            $kode_supplier = $this->request->getPost('kode_supplier');
            $keterangan  = $this->request->getPost('keterangan');
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'kode_supplier' => [
                    'label' => 'Kode Supplier',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'no_bukti' => [
                    'label' => 'No Bukti',
                    'rules' => 'required|is_unique[tbl_stockin.no_bukti]',
                    'errors' => [
                        'is_unique' => '{field} sudah ada, coba dengan Nomor yang lain',
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorKodeSupplier'   => $validation->getError('kode_supplier'),
                        'errorNoInvoice'      => $validation->getError('no_bukti'),
                    ]
                ];
            } else {
                $data = [
                    'no_bukti'       => $no_bukti,
                    'tgl_bukti'      => $tgl_bukti,
                    'keterangan'     => $keterangan,
                    'kode_supplier'  => $kode_supplier,
                    'keterangan'     => $keterangan,
                ];

                $ambildatakeranjang = $this->ModelStockIn->ambilDataCart();
                if (empty($ambildatakeranjang)) {
                    $msg = [
                        'error' => 'Maaf, Data Transaksi masih Kosong !!!!'
                    ];
                    echo json_encode($msg);
                } else {
                    $this->ModelStockIn->add($data);
                    $ctr = $this->ModelCounter->allData();
                    $inv = $ctr['pindah'] + 1;
                    $datactr = [
                        'pindah' => $inv
                    ];
                    $this->ModelCounter->updctr($datactr);
                    foreach ($ambildatakeranjang as $row) :
                        $databeli = array(
                            'no_bukti'     => $row['no_bukti'],
                            'id_barang'    => $row['id_barang'],
                            'kode_barang'  => $row['kode_barang'],
                            'qty'          => $row['qty'],
                        );
                        $this->ModelStockIn->add_detail($databeli);
                    endforeach;

                    $this->ModelStockIn->clearCart();

                    date_default_timezone_set('Asia/Jakarta');
                    $datalog = [
                        'username'  => session()->get('username'),
                        'jamtrx'    => date('Y-m-d H:i:s'),
                        'kegiatan'  => 'Menambah Data Penerimaan Brg : ' . $no_bukti,
                    ];
                    $this->ModelLogHistory->add($datalog);

                    $msg = [
                        'sukses' => 'Item Receipt has been added'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    public function edit($no_bukti)
    {
        $dstockin = $this->ModelStockIn->detail_pi($no_bukti);
        $this->ModelStockIn->clearCart();
        foreach ($dstockin as $pinv) {
            $datakeranjang = array(
                'id_stockin'  => $pinv['id_stockin'],
                'no_bukti'    => $pinv['no_bukti'],
                'id_barang'   => $pinv['id_barang'],
                'kode_barang' => $pinv['kode_barang'],
                'qty'         => $pinv['qty'],
            );
            $this->ModelStockIn->addCart($datakeranjang);
        }
        $stkin = $this->ModelStockIn->detail($no_bukti);
        $data = [
            'supplier'  => $this->ModelSupplier->alldata(),
            'stkin'     => $stkin,
        ];
        return view('stockin/v_edit', $data);
    }

    public function viewEditHarga()
    {
        if ($this->request->isAJAX()) {
            $id_stockin  = $this->request->getPost('id_stockin');
            $no_bukti   = $this->request->getPost('no_bukti');
            $id_barang    = $this->request->getPost('id_barang');
            $kode_barang  = $this->request->getPost('kode_barang');
            $nama_barang  = $this->request->getPost('nama_barang');
            $kode_satuan  = $this->request->getPost('kode_satuan');
            $qty          = $this->request->getPost('qty');

            $data = [
                'id_stockin' => $id_stockin,
                'no_bukti'  => $no_bukti,
                'id_barang'   => $id_barang,
                'kode_barang' => $kode_barang,
                'nama_barang' => $nama_barang,
                'kode_satuan' => $kode_satuan,
                'qty'         => $qty,
            ];

            $msg = [
                'viewmodal' => view('stockin/v_editharga', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function updateHarga()
    {
        if ($this->request->isAJAX()) {
            $id_stockin   = $this->request->getPost('id_stockin');
            $no_bukti    = $this->request->getPost('no_bukti');
            $qty           = str_replace(',', '', $this->request->getPost('qty'));

            $data = array(
                'id_stockin' => $id_stockin,
                'no_bukti'  => $no_bukti,
                'qty'         => $qty,
            );
            $this->ModelStockIn->editCart($data);

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
            $no_bukti    = $this->request->getPost('no_bukti');
            $tgl_bukti   = $this->request->getPost('tgl_bukti');
            $kode_supplier = $this->request->getPost('kode_supplier');
            $keterangan  = $this->request->getPost('keterangan');

            $data = [
                'no_bukti'     => $no_bukti,
                'tgl_bukti'    => $tgl_bukti,
                'keterangan'   => $keterangan,
                'kode_supplier'  => $kode_supplier,
            ];

            $ambildatakeranjang = $this->ModelStockIn->ambilDataCart();
            if (empty($ambildatakeranjang)) {
                $msg = [
                    'error' => 'Maaf, Data Transaksi masih Kosong !!!!'
                ];
                echo json_encode($msg);
            } else {
                $this->ModelStockIn->edit($data);
                $this->ModelStockIn->delete_detail($no_bukti);
                foreach ($ambildatakeranjang as $row) :
                    $datainv = array(
                        'no_bukti'   => $row['no_bukti'],
                        'id_barang'    => $row['id_barang'],
                        'kode_barang'  => $row['kode_barang'],
                        'qty'          => $row['qty'],
                    );
                    $this->ModelStockIn->add_detail($datainv);
                endforeach;
                $this->ModelStockIn->clearCart();

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Data Penerimaan Brg : ' . $no_bukti,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Item Receipt has been Updated !!'
                ];
                echo json_encode($msg);
            }
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $this->ModelStockIn->deleteCart($id);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function detail($no_bukti)
    {
        $data = [
            'stkin'    => $this->ModelStockIn->detail($no_bukti),
            'dstkin'   => $this->ModelStockIn->detail_pi($no_bukti),
        ];
        return view('stockin/v_list', $data);
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $nobukti = $this->request->getVar('no_bukti');
            $this->ModelStockIn->delete_master($nobukti);
            $this->ModelStockIn->delete_detail($nobukti);
            
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Data Penerimaan Brg : ' . $nobukti,
            ];
            $this->ModelLogHistory->add($datalog);
            
            $msg = ['sukses' => 'Purchase Invoice has been deleted !!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }

    public function cari_nobukti()
    {
        $no_bukti = $this->request->getPost('no_bukti');
        $data = $this->ModelStockIn->detail($no_bukti);
        if ($data) {
            $msg = ['sukses' => 'berhasil'];
        } else {
            $msg = ['sukses' => 'gagal'];
        }
        echo json_encode($msg);
    }
}
