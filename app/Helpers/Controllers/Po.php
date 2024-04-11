<?php

namespace App\Controllers;

use App\Models\ModelSupplier;
use App\Models\ModelBarang;
use App\Models\ModelPurchOrd;
use App\Models\ModelDataPurchOrd;
use App\Models\ModelCounter;
use App\Models\ModelDataBrg;

use Config\Services;

class PurchOrd extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelPurchOrd = new ModelPurchOrd();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelCounter  = new ModelCounter();
    }

    public function index()
    {
        return view('purchord/v_index');
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataPurchOrd = new ModelDataPurchOrd($request);
        if ($request->getMethod(true) == 'POST') {
            $purchord = $this->ModelDataPurchOrd->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($purchord as $po) {
                $row = [];
                $row[] = $no++;
                $row[] = $po['no_po'];
                $row[] = date('d-m-Y', strtotime($po['tgl_po']));
                $row[] = $po['nama_supplier'];
                $row[] = $po['currency'];
                $row[] = number_format($po['total_po'], '2', ',', '.');
                if (session()->get('level') == "1") {
                    $row[] =
                        '<a href="' . base_url('PurchOrd/edit/' . $po['id_po']) . '" class="btn btn-success btn-xs mr-2"></i>EDIT</a>' .
                        '<a href="' . base_url('PurchOrd/detail/' . $po['id_po']) . '" class="btn btn-info btn-xs mr-2">DETAIL</a>' .
                        '<a href="' . base_url('PurchOrd/print/' . $po['id_po']) . '" class="btn btn-primary btn-xs mr-2">PRINT</a>' .
                        "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"hapusPurchOrd('" . $po['no_po'] . "','" . $po['nama_supplier'] . "') \">DELETE</button>";
                } else {
                    $row[] =
                        '<a href="' . base_url('PurchOrd/print/' . $po['id_po']) . '" class="btn btn-primary btn-xs mr-2">PRINT</a>' .
                        '<a href="' . base_url('PurchOrd/detail/' . $po['id_po']) . '" class="btn btn-info btn-xs mr-2">DETAIL</a>';
                }
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataPurchOrd->count_all(),
                "recordsFiltered" => $this->ModelDataPurchOrd->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tgl_po = date('Y-m-d');
        // $ctr    = $this->ModelCounter->allData();
        // $nomor  = str_pad(strval(($ctr['po'] + 1)), 4, '0', STR_PAD_LEFT);
        // $no_po  = $nomor . '-PO-' . date('m') . '-' . date('y');
        $data = [
            // 'no_po'   => $no_po,
            'tgl_po'  => $tgl_po,
            'supplier'     => $this->ModelSupplier->alldata(),
            'validation'   => \config\Services::validation()
        ];
        $this->ModelPurchOrd->clearCart();
        return view('purchord/v_add', $data);
    }

    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $no_po = $this->request->getPost('no_po');
            $status = $this->request->getPost('status');
            $dtl   = $this->ModelPurchOrd->getCart($no_po);
            $data  = [
                'datadetail' => $dtl,
                'status' => $status
            ];
        

            $msg = [
                'data' => view('purchord/v_harga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function dataDetailEdt()
    {
        if ($this->request->isAJAX()) {
            $no_po = $this->request->getPost('no_po');
            $dtl   = $this->ModelPurchOrd->getCart($no_po);
            $data  = [
                'datadetail' => $dtl
            ];

            $msg = [
                'data' => view('purchord/v_hargaedt', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function viewDatabarang()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getPost('keyword');

            $data = [
                'keyword' => $keyword,
            ];
            $msg = [
                'viewmodal' => view('purchord/v_caribarang', $data)
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
            $no_po         = $this->request->getPost('no_po');
            $kode_barang   = $this->request->getPost('kode_barang');
            $nama_barang   = $this->request->getPost('nama_barang');
            $kode_satua    = $this->request->getPost('kode_satuan');
            if (strlen($nama_barang) > 0) {
                $queryCekbarang = $this->db->table('tbl_barang')
                    ->where('kode_barang', $kode_barang)
                    ->where('nama_barang', $nama_barang)->get();
            } else {
                $queryCekbarang = $this->db->table('tbl_barang')
                    ->like('kode_barang', $kode_barang)
                    ->orLike('nama_barang', $kode_barang)->get();
            }
            $totalData = $queryCekbarang->getNumRows();

            if ($totalData > 1) {
                $msg = [
                    'totaldata' => 'banyak'
                ];
            } else if ($totalData == 1) {
                // insert ke keranjang
                $tkeranjang = $this->db->table('keranjangpo');
                $barang     = $queryCekbarang->getRowArray();
                $subtotal   = $qty * $harga;
                $isikeranjang = [
                    'no_po'       => $no_po,
                    'kode_barang' => $kode_barang,
                    'harga'       => $harga,
                    'qty'         => $qty,
                    'subtotal'    => $subtotal
                ];
                $tkeranjang->insert($isikeranjang);
                $msg = ['sukses' => 'berhasil'];
            } else {
                $msg = ['error' => 'Maaf barang ini tidak ditemukan'];
            }
            echo json_encode($msg);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $no_po         = $this->request->getPost('no_po');
            $tgl_po        = $this->request->getPost('tgl_po');
            $kode_supplier = $this->request->getPost('kode_supplier');
            $termin        = $this->request->getPost('termin');
            $keterangan    = $this->request->getpost('keterangan');
            $total_dpp     = str_replace(',', '', $this->request->getPost('total_dpp'));
            $total_ppn     = str_replace(',', '', $this->request->getPost('total_ppn'));
            $total_po      = str_replace(',', '', $this->request->getPost('total_po'));;
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'kode_supplier' => [
                    'label' => 'Kode Supplier',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'no_po' => [
                    'label' => 'No Po',
                    'rules' => 'required|is_unique[tbl_purchord.no_po]',
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
                        'errorNoPo'      => $validation->getError('no_po'),
                    ]
                ];
            } else {
                $data = [
                    'no_po'         => $no_po,
                    'tgl_po'        => $tgl_po,
                    'termin'        => $termin,
                    'keterangan'    => $keterangan,
                    'kode_supplier' => $kode_supplier,
                    'total_dpp'     => $total_dpp,
                    'total_ppn'     => $total_ppn,
                    'total_po'      => $total_po,
                ];

                $ambildatakeranjang = $this->ModelPurchOrd->ambilDataCart();
                if (empty($ambildatakeranjang)) {
                    $msg = [
                        'error' => 'Maaf, Data Transaksi masih Kosong !!!!'
                    ];
                    echo json_encode($msg);
                } else {
                    $this->ModelPurchOrd->add($data);
                    // $ctr = $this->ModelCounter->allData();
                    // $inv = $ctr['po'] + 1;
                    // $datactr = [
                        // 'po' => $inv
                    // ];
                    // $this->ModelCounter->updctr($datactr);

                    foreach ($ambildatakeranjang as $row) :
                        $datapo = array(
                            'no_po'        => $row['no_po'],
                            'kode_barang'  => $row['kode_barang'],
                            'qty'          => $row['qty'],
                            'harga'        => $row['harga'],
                            'subtotal'     => $row['subtotal'],
                        );
                        $this->ModelPurchOrd->add_detail($datapo);
                    endforeach;
                    $msg = [
                        'sukses' => 'Purchase Order has been Added !!!!'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    public function viewEditHarga()
    {
        if ($this->request->isAJAX()) {
            $id_purchord  = $this->request->getPost('id_purchord');
            $no_po        = $this->request->getPost('no_po');
            $id_barang    = $this->request->getPost('id_barang');
            $kode_barang  = $this->request->getPost('kode_barang');
            $nama_barang  = $this->request->getPost('nama_barang');
            $kode_satuan  = $this->request->getPost('kode_satuan');
            $qty          = $this->request->getPost('qty');
            $harga        = $this->request->getPost('harga');
            $subtotal     = $this->request->getPost('subtotal');

            $data = [
                'id_purchord' => $id_purchord,
                'no_po'       => $no_po,
                'id_barang'   => $id_barang,
                'kode_barang' => $kode_barang,
                'nama_barang' => $nama_barang,
                'kode_satuan' => $kode_satuan,
                'qty'         => $qty,
                'harga'       => $harga,
                'subtotal'    => $subtotal,
            ];

            $msg = [
                'viewmodal' => view('purchord/v_editharga', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function updateHarga()
    {
        if ($this->request->isAJAX()) {
            $id_purchord   = $this->request->getPost('id_purchord');
            $no_po         = $this->request->getPost('no_po');
            $qty           = str_replace(',', '', $this->request->getPost('qty'));
            $harga         = str_replace(',', '', $this->request->getPost('harga'));
            $subtotal      = str_replace(',', '', $qty * $harga);

            $data = array(
                'id_purchord' => $id_purchord,
                'no_po'       => $no_po,
                'qty'         => $qty,
                'harga'       => $harga,
                'subtotal'    => $subtotal,
            );
            $this->ModelPurchOrd->editCart($data);

            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function edit($id_po)
    {
        $po = $this->ModelPurchOrd->detail($id_po);
        $no_po   = $po['no_po'];
        $dpurchord = $this->ModelPurchOrd->detail_po($no_po);

        
        $this->ModelPurchOrd->clearCart();
        foreach ($dpurchord as $pord) {
            $datakeranjang = array(
                'id_purchord' => $pord['id_purchord'],
                'no_po'       => $pord['no_po'],
                'id_barang'   => $pord['id_barang'],
                'kode_barang' => $pord['kode_barang'],
                'qty'         => $pord['qty'],
                'harga'       => $pord['harga'],
                'subtotal'    => $pord['subtotal'],
            );
            $this->ModelPurchOrd->addCart($datakeranjang);
        }

        $data = [
            'po'=> $po,
            'supplier'     => $this->ModelSupplier->alldata(),
        ];
        return view('purchord/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            date_default_timezone_set('Asia/Jakarta');
            $id_po         = $this->request->getPost('id_po');
            $no_po         = $this->request->getPost('no_po');
            $tgl_po        = $this->request->getPost('tgl_po');
            $kode_supplier = $this->request->getPost('kode_supplier');
            $termin        = $this->request->getPost('termin');
            $keterangan    = $this->request->getpost('keterangan');
            $total_dpp     = str_replace(',', '', $this->request->getPost('total_dpp'));
            $total_ppn     = str_replace(',', '', $this->request->getPost('total_ppn'));
            $total_po      = str_replace(',', '', $this->request->getPost('total_po'));

            $data = [
                'id_po'         => $id_po,
                'no_po'         => $no_po,
                'tgl_po'        => $tgl_po,
                'termin'        => $termin,
                'keterangan'    => $keterangan,
                'kode_supplier' => $kode_supplier,
                'total_dpp'     => $total_dpp,
                'total_ppn'     => $total_ppn,
                'total_po'      => $total_po,
            ];

            $ambildatakeranjang = $this->ModelPurchOrd->ambilDataCart();
            // if (empty($ambildatakeranjang)) {
                // $msg = [
                    // 'error' => 'Maaf, Data Transaksi kosong !!!!'
                // ];
                // echo json_encode($msg);
            // } else {
                $this->ModelPurchOrd->edit($data);
                $this->ModelPurchOrd->delete_detail($no_po);
                foreach ($ambildatakeranjang as $row) :
                    $datapo = array(
                        'no_po'        => $row['no_po'],
                        'id_barang'    => $row['id_barang'],
                        'kode_barang'  => $row['kode_barang'],
                        'qty'          => $row['qty'],
                        'harga'        => $row['harga'],
                        'subtotal'     => $row['subtotal'],
                    );
                    $this->ModelPurchOrd->add_detail($datapo);
                endforeach;

                $this->ModelPurchOrd->clearCart();
                $msg = [
                    'sukses' => 'Purchase Order has been Updated !!'
                ];
                echo json_encode($msg);
            // }    
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $this->ModelPurchOrd->deleteCart($id);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function detail($id_po)
    {
        $po = $this->ModelPurchOrd->detail($id_po);
        $no_po   = $po['no_po'];

        $data = [
            'po'    => $po,
            'dpo'   => $this->ModelPurchOrd->detail_po($no_po),
        ];
        return view('purchord/v_list', $data);
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $nopo = $this->request->getVar('no_po');
            $this->ModelPurchOrd->delete_master($nopo);
            $this->ModelPurchOrd->delete_detail($nopo);
            $msg = ['sukses' => 'Data Purchase Order berhasil dihapuskan !!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }
    
    public function print($id_po)
    {
        $mnopo   = $this->ModelPurchOrd->detail($id_po);
        $no_po   = $mnopo['no_po'];
        $data = [
            'mpo'=> $mnopo,
            'dpo'   => $this->ModelPurchOrd->detail_po($no_po),
        ];
        return view('purchord/v_print', $data);
    }
}
