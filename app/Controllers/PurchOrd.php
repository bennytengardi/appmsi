<?php

namespace App\Controllers;

use App\Models\ModelSupplier;
use App\Models\ModelBarang;
use App\Models\ModelPurchOrd;
use App\Models\ModelDataPurchOrd;
use App\Models\ModelCounter;
use App\Models\ModelDataBrg;
use App\Models\ModelLogHistory;

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
        $this->ModelLogHistory = new ModelLogHistory();
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
                        '<a href="' . base_url('PurchOrd/edit/' . $po['id_po']) . '" class="btn btn-success btn-xs mr-2" style="font-size: 10px; height: 18px;"></i>EDIT</a>' .
                        '<a href="' . base_url('PurchOrd/detail/' . $po['id_po']) . '" class="btn btn-info btn-xs mr-2" style="font-size: 10px; height: 18px;">DETAIL</a>' .
                        '<a href="' . base_url('PurchOrd/print/' . $po['id_po']) . '" class="btn btn-primary btn-xs mr-2" style="font-size: 10px; height: 18px;">PRINT</a>' .
                        "<button type=\"button\" class=\"btn btn-danger btn-xs\" style=\"font-size: 10px; height: 18px;\" onclick=\"hapusPurchOrd('" . $po['no_po'] . "','" . $po['nama_supplier'] . "') \">DELETE</button>";
                } else {
                    $row[] =
                        '<a href="' . base_url('PurchOrd/print/' . $po['id_po']) . '" class="btn btn-primary btn-xs mr-2" style="font-size: 10px; height: 18px;">PRINT</a>' .
                        '<a href="' . base_url('PurchOrd/edit/' . $po['id_po']) . '" class="btn btn-success btn-xs mr-2" style="font-size: 10px; height: 18px;"></i>EDIT</a>' .
                        '<a href="' . base_url('PurchOrd/detail/' . $po['id_po']) . '" class="btn btn-info btn-xs mr-2" style="font-size: 10px; height: 18px;">DETAIL</a>';
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
        $id_po = rand();
        $no_po = '';
        $data = [
            'no_po'        => $no_po,
            'tgl_po'       => $tgl_po,
            'id_po'        => $id_po,
            'supplier'     => $this->ModelSupplier->alldata(),
            'validation'   => \config\Services::validation()
        ];
        $this->ModelPurchOrd->clearCart($no_po);
        return view('purchord/v_add', $data);
    }

    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $id_po = $this->request->getPost('id_po');
            $status = $this->request->getPost('status');
            $dtl   = $this->ModelPurchOrd->getCart($id_po);
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
                    $row[] = "<button type=\"button\" class=\"btn btn-xs btn-primary\" style=\"height: 18px; font-size: 10px;\"  onclick=\"pilihitem('" . $list['id_barang'] .  "','" . "')\" ><i class=\"fa fa-check\"></i></button>";
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
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $rowid = '';
            for ($i = 0; $i < 16; $i++) {
                $rowid .= $characters[random_int(0, $charactersLength - 1)];
            } 
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
            $id_po         = $this->request->getPost('id_po');
            $no_po         = $this->request->getPost('no_po');
            $id_barang     = $this->request->getPost('id_barang');
            $kode_barang   = $this->request->getPost('kode_barang');
            $subtotal      = $qty * $harga;

            $tkeranjang = $this->db->table('keranjangpo');
            $isikeranjang = [
                'row_id'      => $rowid,
                'id_po'       => $id_po,
                'no_po'       => $no_po,
                'id_barang'   => $id_barang,
                'kode_barang' => $kode_barang,
                'harga'       => $harga,
                'qty'         => $qty,
                'subtotal'    => $subtotal,
                'stt'         => 'A'
            ];            
            $tkeranjang->insert($isikeranjang);
            $msg = ['sukses' => 'berhasil'];
            echo json_encode($msg);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $id_po         = $this->request->getPost('id_po');
            $no_po         = $this->request->getPost('no_po');
            $tgl_po        = $this->request->getPost('tgl_po');
            $kode_supplier = $this->request->getPost('kode_supplier');
            $addkrm1       = $this->request->getPost('addkrm1');
            $addkrm2       = $this->request->getPost('addkrm2');
            $addkrm3       = $this->request->getPost('addkrm3');
            $nama_up       = $this->request->getPost('nama_up');
            $telepon_up    = $this->request->getPost('telepon_up');
            $termin        = $this->request->getPost('termin');
            $tgl_kirim     = $this->request->getPost('tgl_kirim');
            $keterangan    = $this->request->getpost('keterangan');
            $proyek        = $this->request->getpost('proyek');
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
                    'addkrm1'       => $addkrm1,
                    'addkrm2'       => $addkrm2,
                    'addkrm3'       => $addkrm3,
                    'nama_up'       => $nama_up,
                    'telepon_up'    => $telepon_up,
                    'termin'        => $termin,
                    'tgl_kirim'     => $tgl_kirim,
                    'keterangan'    => $keterangan,
                    'proyek'        => $proyek,
                    'kode_supplier' => $kode_supplier,
                    'total_dpp'     => $total_dpp,
                    'total_ppn'     => $total_ppn,
                    'total_po'      => $total_po,
                ];
                
                $ambildatakeranjang = $this->ModelPurchOrd->getCart($id_po);
                if (empty($ambildatakeranjang)) {
                    $msg = [
                        'error' => 'Maaf, Data Transaksi masih Kosong !!!!'
                    ];
                    echo json_encode($msg);
                } else {
                    $this->ModelPurchOrd->add($data);
                    $mpo = $this->ModelPurchOrd->detailPo($no_po);
                    $id_ponew = $mpo['id_po'];
                    foreach ($ambildatakeranjang as $row) :
                        $datapo = array(
                            'row_id'       => $row['row_id'],
                            'id_po'        => $id_ponew,
                            'no_po'        => $row['no_po'],
                            'id_barang'    => $row['id_barang'],
                            'kode_barang'  => $row['kode_barang'],
                            'qty'          => $row['qty'],
                            'harga'        => $row['harga'],
                            'subtotal'     => $row['subtotal'],
                        );
                        $this->ModelPurchOrd->add_detail($datapo);
                    endforeach;

                    $this->ModelPurchOrd->clearCart($id_po);

                    date_default_timezone_set('Asia/Jakarta');
                    $datalog = [
                        'username'  => session()->get('username'),
                        'jamtrx'    => date('Y-m-d H:i:s'),
                        'kegiatan'  => 'Menambah Purchase Order : ' . $no_po,
                    ];
                    $this->ModelLogHistory->add($datalog);

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
            $row_id       = $this->request->getPost('row_id');
            $no_po        = $this->request->getPost('no_po');
            $id_po        = $this->request->getPost('id_po');
            $id_barang    = $this->request->getPost('id_barang');
            $kode_barang  = $this->request->getPost('kode_barang');
            $nama_barang  = $this->request->getPost('nama_barang');
            $kode_satuan  = $this->request->getPost('kode_satuan');
            $qty          = $this->request->getPost('qty');
            $harga        = $this->request->getPost('harga');
            $subtotal     = $this->request->getPost('subtotal');

            $data = [
                'row_id'      => $row_id,
                'id_po'       => $id_po,
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
            $row_id        = $this->request->getPost('row_id');
            $no_po         = $this->request->getPost('no_po');
            $id_po         = $this->request->getPost('id_po');
            $qty           = str_replace(',', '', $this->request->getPost('qty'));
            $harga         = str_replace(',', '', $this->request->getPost('harga'));
            $subtotal      = str_replace(',', '', $qty * $harga);

            $data = array(
                'row_id'      => $row_id,
                'no_po'       => $no_po,
                'id_po'       => $id_po,
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
        $po   = $this->ModelPurchOrd->detail($id_po);
        $dpo  = $this->ModelPurchOrd->detail_po($id_po);
        $no_po = $po['no_po'];
        $this->ModelPurchOrd->clearCart($id_po);
        foreach ($dpo as $pord) {
            $datakeranjang = array(
                'row_id'      => $pord['row_id'],
                'id_po'       => $id_po,
                'no_po'       => $no_po,
                'id_barang'   => $pord['id_barang'],
                'kode_barang' => $pord['kode_barang'],
                'qty'         => $pord['qty'],
                'harga'       => $pord['harga'],
                'subtotal'    => $pord['subtotal'],
                'stt'         => 'E'
            );
            $this->ModelPurchOrd->addCart($datakeranjang);
        }        
        $data = [
            'po'        => $po,
            'supplier'  => $this->ModelSupplier->alldata(),
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
            $addkrm1       = $this->request->getPost('addkrm1');
            $addkrm2       = $this->request->getPost('addkrm2');
            $addkrm3       = $this->request->getPost('addkrm3');
            $nama_up       = $this->request->getPost('nama_up');
            $telepon_up    = $this->request->getPost('telepon_up');
            $kode_supplier = $this->request->getPost('kode_supplier');
            $termin        = $this->request->getPost('termin');
            $tgl_kirim     = $this->request->getPost('tgl_kirim');
            $keterangan    = $this->request->getpost('keterangan');
            $proyek        = $this->request->getpost('proyek');
            $total_dpp     = str_replace(',', '', $this->request->getPost('total_dpp'));
            $total_ppn     = str_replace(',', '', $this->request->getPost('total_ppn'));
            $total_po      = str_replace(',', '', $this->request->getPost('total_po'));

            $data = [
                'id_po'         => $id_po,
                'no_po'         => $no_po,
                'tgl_po'        => $tgl_po,
                'addkrm1'       => $addkrm1,
                'addkrm2'       => $addkrm2,
                'addkrm3'       => $addkrm3,
                'nama_up'       => $nama_up,
                'telepon_up'    => $telepon_up,
                'termin'        => $termin,
                'termin'        => $termin,
                'tgl_kirim'     => $tgl_kirim,
                'keterangan'    => $keterangan,
                'proyek'        => $proyek,
                'kode_supplier' => $kode_supplier,
                'total_dpp'     => $total_dpp,
                'total_ppn'     => $total_ppn,
                'total_po'      => $total_po,
            ];

            $ambildatakeranjang = $this->ModelPurchOrd->ambilCart($id_po);

            $this->ModelPurchOrd->edit($data);
            
            foreach ($ambildatakeranjang as $row) :
                $stt   = $row['stt'];
                $rowid = $row['row_id'];
                $datapo = array(
                    'row_id'       => $rowid,
                    'id_po'        => $id_po,
                    'no_po'        => $row['no_po'],
                    'id_barang'    => $row['id_barang'],
                    'kode_barang'  => $row['kode_barang'],
                    'qty'          => $row['qty'],
                    'harga'        => $row['harga'],
                    'subtotal'     => $row['subtotal'],
                );
                if ($stt == 'A') {
                    $this->ModelPurchOrd->add_detail($datapo);
                }
                if ($stt == 'D') {
                    $this->ModelPurchOrd->deleteDetailInv($rowid);                   
                }
                if ($stt == 'E') {
                    $this->ModelPurchOrd->updateDetailInv($datapo);                   
                }
                
            endforeach;

            $this->ModelPurchOrd->clearCart($no_po);
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Merubah Purchase Order : ' . $no_po,
            ];
            $this->ModelLogHistory->add($datalog);

            $msg = [
                'sukses' => 'Purchase Order has been Updated !!'
            ];
            echo json_encode($msg);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $row_id = $this->request->getPost('row_id');
            $data = array(
                'row_id' => $row_id,
                'stt'    => 'D'
            );
            $this->ModelPurchOrd->editCart($data);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
        
    }

    public function detail($id_po)
    {
        $po   = $this->ModelPurchOrd->detail($id_po);
        $dpo  = $this->ModelPurchOrd->detail_po($id_po);

        $data = [
            'po'    => $po,
            'dpo'   => $dpo,
        ];
        return view('purchord/v_list', $data);
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $nopo = $this->request->getVar('no_po');
            $this->ModelPurchOrd->delete_master($nopo);
            $this->ModelPurchOrd->delete_detail($nopo);

            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Purchase Order : ' . $nopo,
            ];
            $this->ModelLogHistory->add($datalog);
            
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
    
    public function cari_nopo()
    {
        $no_po = $this->request->getPost('no_po');
        $data = $this->ModelPurchOrd->detailPo($no_po);
        echo json_encode($data);
    }

    public function updateIdPo()
    {
        $mpo   = $this->ModelPurchOrd->allData();

        foreach ($mpo as $row) :
            $idpo  = $row['id_po'];
            $nopo  = $row['no_po'];
            $dpo = $this->ModelPurchOrd->detail_po($nopo);
            foreach ($dpo as $row2) :
                $datapo = array(
                    'no_po'  => $nopo,
                    'id_po'  => $idpo 
                );
                $this->ModelPurchOrd->updateDetailPo($datapo);                   
            endforeach;            
        endforeach;        
    }
}
