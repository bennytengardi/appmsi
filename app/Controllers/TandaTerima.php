<?php

namespace App\Controllers;

use App\Models\ModelPurchInv;
use App\Models\ModelSupplier;
use App\Models\ModelCounter;
use App\Models\ModelTandaTerima;
use App\Models\ModelDataTandaTerima;
use Config\Services;

class TandaTerima extends BaseController
{
    public function __construct()
    {
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelPurchInv = new ModelPurchInv();
        $this->ModelCounter  = new ModelCounter();
        $this->ModelTandaTerima  = new ModelTandaTerima();
    }

    public function index()
    {
        return view('tandaterima/v_index');
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataTandaTerima = new ModelDataTandaTerima($request);
        if ($request->getMethod(true) == 'POST') {
            $tandaterima = $this->ModelDataTandaTerima->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($tandaterima as $tt) {
                $row = [];
                $row[] = $no++;
                $row[] = $tt['no_tandaterima'];
                $row[] = date('d-m-Y', strtotime($tt['tgl_tandaterima']));
                $row[] = $tt['nama_supplier'];
                $row[] = number_format($tt['total_potongan'], '0', ',', '.');
                $row[] = number_format($tt['total_bayar'], '0', ',', '.');
                $row[] =
                    '<a href="' . base_url('TandaTerima/edit/' . $tt['no_tandaterima']) . '" class="btn btn-success btn-xs mr-2"></i>EDIT</a>' .
                    '<a href="' . base_url('TandaTerima/detail/' . $tt['no_tandaterima']) . '" class="btn btn-info btn-xs mr-2">DETAIL</a>' .
                    '<a href="' . base_url('TandaTerima/print/' . $tt['no_tandaterima']) . '" class="btn btn-primary btn-xs mr-2">PRINT</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"hapusTandaTerima('" . $tt['no_tandaterima'] . "','" . $tt['nama_supplier'] . "') \">DELETE</button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataTandaTerima->count_all(),
                "recordsFiltered" => $this->ModelDataTandaTerima->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        date_default_timezone_set('Asia/Jakarta');
        $ctr    = $this->ModelCounter->allData();
        $nomor  = str_pad(strval(($ctr['tt'] + 1)), 5, '0', STR_PAD_LEFT);
        $no_tandaterima  = 'TT-' .  date('Y') . '-' . $nomor;
        $tgl_tandaterima = date('Y-m-d');
        $data = [
            'tgl_tandaterima'  => $tgl_tandaterima,
            'supplier'     => $this->ModelSupplier->alldata(),
            'no_tandaterima'   => $no_tandaterima,
            'validation'   => \config\Services::validation()
        ];
        return view('tandaterima/v_add', $data);
    }

    public function get_data_tt()
    {
        $kode_supplier = $this->request->getPost('kode_supplier');
        $data = $this->ModelTandaTerima->get_pibysupp($kode_supplier);
        echo json_encode($data);
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $no_tandaterima  = $this->request->getPost('no_tandaterima');
            $tgl_tandaterima = $this->request->getPost('tgl_tandaterima');
            $kode_supplier   = $this->request->getPost('kode_supplier');
            $total_potongan  = str_replace(',', '', $this->request->getPost('total_potongan'));
            $total_bayar     = str_replace(',', '', $this->request->getPost('total_bayar'));

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'kode_supplier' => [
                    'label' => 'Nama Supplier',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorSupplier'   => $validation->getError('kode_supplier'),
                    ]
                ];
            } else {
                if ($total_bayar == 0) {
                    $msg = ['error2' => 'Data TandaTerima is empty!!!! '];
                } else {
                    $data = [
                        'no_tandaterima'  => $no_tandaterima,
                        'tgl_tandaterima' => $tgl_tandaterima,
                        'kode_supplier'   => $kode_supplier,
                        'total_potongan'  => $total_potongan,
                        'total_bayar'     => $total_bayar,
                    ];
                    $this->ModelTandaTerima->add($data);

                    $ctr = $this->ModelCounter->allData();
                    $inv = $ctr['tt'] + 1;
                    $datactr = [
                        'tt' => $inv
                    ];
                    $this->ModelCounter->updctr($datactr);

                    $totitem = $this->request->getPost('totalitem');
                    for ($i = 1; $i <= $totitem; $i++) {
                        $data1 = [
                            'no_tandaterima'  => $no_tandaterima,
                            'no_invoice'      => $this->request->getPost('no_invoice' . $i),
                            'jumlah_bayar'    => str_replace(',', '', $this->request->getPost('jumlah_bayar' . $i)),
                            'potongan'        => str_replace(',', '', $this->request->getPost('potongan' . $i)),
                        ];

                        if ($data1['jumlah_bayar'] > 0 || $data1['potongan'] > 0) {
                            $this->ModelTandaTerima->add_detail($data1);
                        }
                    }
                    $msg = [
                        'sukses' => 'Data Tanda Terima berhasil ditambahkan'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    public function edit($no_tandaterima)
    {
        $data = [
            'tandaterima'  => $this->ModelTandaTerima->detail($no_tandaterima),
            'dtandaterima' => $this->ModelTandaTerima->detail_tt($no_tandaterima),
            'purchinv'     => $this->ModelPurchInv->allData(),
        ];

        return view('tandaterima/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $no_tandaterima      = $this->request->getPost('no_tandaterima');
            $tgl_tandaterima     = $this->request->getPost('tgl_tandaterima');
            $kode_supplier   = $this->request->getPost('kode_supplier');
            $total_potongan  = str_replace(',', '', $this->request->getPost('total_potongan'));
            $total_bayar     = str_replace(',', '', $this->request->getPost('total_bayar'));

            $data = [
                'no_tandaterima'      => $no_tandaterima,
                'tgl_tandaterima'     => $tgl_tandaterima,
                'kode_supplier'   => $kode_supplier,
                'total_potongan'  => $total_potongan,
                'total_bayar'     => $total_bayar,
            ];
            $this->ModelTandaTerima->edit($data);


            $totitem = $this->request->getPost('totalitem');
            for ($i = 1; $i <= $totitem; $i++) {
                $data = array(
                    'id_tandaterima'     => $this->request->getPost("id_tandaterima" . $i),
                    'potongan'           => str_replace(',', '', $this->request->getPost("potongan" . $i)),
                    'jumlah_bayar'       => str_replace(',', '', $this->request->getPost("jumlah_bayar" . $i))
                );
                $this->ModelTandaTerima->edit_detail($data);
            }

            $msg = ['sukses' => 'Data Tanda Terima berhasil diupdate'];
            echo json_encode($msg);
        }
    }

    public function detail($no_tandaterima)
    {
        $data = [
            'tandaterima'    => $this->ModelTandaTerima->detail($no_tandaterima),
            'dtandaterima'   => $this->ModelTandaTerima->detail_tt($no_tandaterima),
        ];
        return view('tandaterima/v_list', $data);
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $no_tandaterima = $this->request->getVar('no_tandaterima');
            $this->ModelTandaTerima->delete_master($no_tandaterima);
            $this->ModelTandaTerima->delete_detail($no_tandaterima);
            $msg = ['sukses' => 'Data Tanda Terima berhasil dihapus'];

            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }

    public function print($no_tandaterima)
    {
        $data = [
            'tandaterima'   => $this->ModelTandaTerima->detail($no_tandaterima),
            'dtandaterima'   => $this->ModelTandaTerima->detail_tt($no_tandaterima),
        ];
        return view('tandaterima/v_print', $data);
    }
}
