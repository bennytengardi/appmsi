<?php

namespace App\Controllers;

use App\Models\ModelSupplier;
use App\Models\ModelDataSupplier;
use App\Models\ModelCounter;
use App\Models\ModelCurrency;
use App\Models\ModelLogHistory;
use Config\Services;

class Supplier extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelSupplier  = new ModelSupplier();
        $this->ModelCurrency = new ModelCurrency();
        $this->ModelLogHistory = new ModelLogHistory();
        $this->ModelCounter = new ModelCounter();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Supplier',
        ];
        return view('supplier/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataSupplier = new ModelDataSupplier($request);
        if ($request->getMethod(true) == 'POST') {
            $supplier = $this->ModelDataSupplier->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($supplier as $cus) {
                $row = [];
                $row[] = $no++;
                $row[] = $cus['kode_supplier'];
                $row[] = $cus['nama_supplier'];
                $row[] = $cus['address1'];
                $row[] = $cus['telephone'];
                $row[] = $cus['currency'];
                $row[] = number_format($cus['awal'] + $cus['debet'] - $cus['credit'], 0, '.', ',');
                $row[] =
                    '<a href="' . base_url('supplier/edit/' . $cus['kode_supplier']) . '" class="btn btn-success btn-xs mr-1">EDIT</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-xs\"  onclick=\"hapusSupplier('" . $cus['kode_supplier'] .  "','" . $cus['nama_supplier'] . "') \">DELETE</button>" .
                    '<a href="' . base_url('supplier/saldoawal/' . $cus['kode_supplier']) . '" class="btn btn-info btn-xs ml-1">SALDO AWAL</a>';
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataSupplier->count_all(),
                "recordsFiltered" => $this->ModelDataSupplier->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        $ctr = $this->ModelCounter->allData();
        $kode_supplier = 'SP-' . str_pad(strval(($ctr['supplier'] + 1)), 4, '0', STR_PAD_LEFT);
        $data = [
            'title'      => 'Tambah Supplier',
            'kode_supplier' => $kode_supplier,
            'currency'  => $this->ModelCurrency->allData(),
            'validation'  => \config\Services::validation()
        ];
        $this->ModelSupplier->clearCart();
        return view('supplier/v_add', $data);
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $kode_supplier    = $this->request->getPost('kode_supplier');
            $nama_supplier    = $this->request->getPost('nama_supplier');
            $telephone        = $this->request->getPost('telephone');
            $facsimile        = $this->request->getPost('facsimile');
            $address1         = $this->request->getPost('address1');
            $address2         = $this->request->getPost('address2');
            $address3         = $this->request->getPost('address3');
            $email            = $this->request->getPost('email');
            $npwp             = $this->request->getPost('npwp');
            $personal_kontak  = $this->request->getPost('personal_kontak');
            $no_hp            = $this->request->getPost('no_hp');
            $status           = $this->request->getPost('status');
            $currency         = $this->request->getPost('currency');

            $validation =  \Config\Services::validation();
            $valid = $this->validate([
                'nama_supplier' => [
                    'label' => 'Supplier Name',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNamaSupplier'   => $validation->getError('nama_supplier'),
                    ]
                ];
            } else {
                $data = [
                    'kode_supplier'   => $kode_supplier,
                    'nama_supplier'   => $nama_supplier,
                    'telephone'       => $telephone,
                    'facsimile'       => $facsimile,
                    'address1'        => $address1,
                    'address2'        => $address2,
                    'address3'        => $address3,
                    'email'           => $email,
                    'npwp'            => $npwp,
                    'personal_kontak' => $personal_kontak,
                    'no_hp'           => $no_hp,
                    'status'          => $status,
                    'currency'        => $currency,
                ];

                $this->ModelSupplier->add($data);
                $ambildatakeranjang = $this->ModelSupplier->ambilDataCart();
                foreach ($ambildatakeranjang as $row) :
                    $databeli = array(
                        'kode_supplier' => $row['kode_supplier'],
                        'no_invoice'    => $row['no_invoice'],
                        'tgl_invoice'   => $row['tgl_invoice'],
                        'total_invoice' => $row['total_invoice'],
                        'awal'          => $row['awal'],
                    );
                    $this->ModelSupplier->addDetail($databeli);
                endforeach;

                // Update Counter Supplier
                $ctr = $this->ModelCounter->allData();
                $inv = $ctr['supplier'] + 1;
                $data = [
                    'supplier' => $inv
                ];
                $this->ModelCounter->updctr($data);
                
                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menambah Tabel Supplier : ' . $nama_supplier,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Supplier has been added'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function updateHarga()
    {

        if ($this->request->isAJAX()) {

            $no_invoice    = $this->request->getPost('no_invoice');
            $tgl_invoice   = $this->request->getPost('tgl_invoice');
            $total_invoice = str_replace(',', '', $this->request->getPost('total_invoice'));
            $total_bayar   = str_replace(',', '', $this->request->getPost('total_bayar'));


            $data = array(
                'no_invoice'  => $no_invoice,
                'tgl_invoice' => $tgl_invoice,
                'total_invoice' => $total_invoice,
                'total_bayar' => $total_bayar
            );

            $this->ModelSupplier->editCart($data);

            $msg = [
                'sukses' => 'berhasil'
            ];

            echo json_encode($msg);
        }
    }


    public function edit($kode_supplier)
    {
        $data = [
            'supplier'    => $this->ModelSupplier->detail($kode_supplier),
            'currency'  => $this->ModelCurrency->allData(),
            'validation'  => \config\Services::validation()
        ];

        return view('supplier/v_edit', $data);
    }

    public function updatetemp()
    {
        if ($this->request->isAJAX()) {
            $this->ModelSupplier->clearCart();
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $kode_supplier    = $this->request->getPost('kode_supplier');
            $nama_supplier    = $this->request->getPost('nama_supplier');
            $telephone        = $this->request->getPost('telephone');
            $facsimile        = $this->request->getPost('facsimile');
            $address1         = $this->request->getPost('address1');
            $address2         = $this->request->getPost('address2');
            $address3         = $this->request->getPost('address3');
            $email            = $this->request->getPost('email');
            $npwp             = $this->request->getPost('npwp');
            $personal_kontak  = $this->request->getPost('personal_kontak');
            $no_hp            = $this->request->getPost('no_hp');
            $status           = $this->request->getPost('status');
            $currency         = $this->request->getPost('currency');

            $validation =  \Config\Services::validation();
            $valid = $this->validate([
                'nama_supplier' => [
                    'label' => 'Nama Supplier',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNamaSupplier'   => $validation->getError('nama_supplier'),
                    ]
                ];
            } else {
                $data = [
                    'kode_supplier'   => $kode_supplier,
                    'nama_supplier'   => $nama_supplier,
                    'telephone'       => $telephone,
                    'facsimile'       => $facsimile,
                    'address1'        => $address1,
                    'address2'        => $address2,
                    'address3'        => $address3,
                    'email'           => $email,
                    'npwp'            => $npwp,
                    'personal_kontak' => $personal_kontak,
                    'no_hp'           => $no_hp,
                    'status'          => $status,
                    'currency'        => $currency,
                ];
                $this->ModelSupplier->edit($data);
                
                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Tabel Supplier : ' . $nama_supplier,
                ];
                $this->ModelLogHistory->add($datalog);
                
                $msg = [
                    'sukses' => 'Supplier has been updated'
                ];
            }
            echo json_encode($msg);
        }
    }


    public function updatesaldoawal()
    {
        if ($this->request->isAJAX()) {
            date_default_timezone_set('Asia/Jakarta');
            $no_invoice    = $this->request->getPost('no_invoice');
            $tgl_invoice   = $this->request->getPost('tgl_invoice');
            $kode_supplier = $this->request->getPost('kode_supplier');
            $total_invoice = str_replace(',', '', $this->request->getPost('total_invoice'));

            $data = [
                'no_invoice'     => str_replace('/','-',$no_invoice),
                'tgl_invoice'    => $tgl_invoice,
                'kode_supplier'  => $kode_supplier,
                'total_invoice'  => $total_invoice,
                'awal'           => 1
            ];


            $this->ModelSupplier->delete_purchinv($kode_supplier);

            $ambildatakeranjang = $this->ModelSupplier->ambilDataCart();
            $saldoawal = 0;
            foreach ($ambildatakeranjang as $row) :
                $saldoawal = $saldoawal + $row['total_invoice'];
                $datainv = array(
                    'no_invoice'    => $row['no_invoice'],
                    'tgl_invoice'   => $row['tgl_invoice'],
                    'total_invoice' => $row['total_invoice'],
                    'total_bayar'   => $row['total_bayar'],
                    'kode_supplier' => $row['kode_supplier'],
                    'awal'          => 1,
                );
                $this->ModelSupplier->add_purchinv($datainv);
            endforeach;

            // $data2 = array(
            //     'kode_supplier' => $kode_supplier,
            //     'awal' => $saldoawal
            // );

            // $this->ModelSupplier->edit($data2);

            $this->ModelSupplier->clearCart();
            $msg = [
                'sukses' => 'Data Saldo Awal berhasil diupdate'
            ];

            echo json_encode($msg);
        }
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $kode_supplier = $this->request->getVar('kode_supplier');
            $nama_supplier = $this->request->getVar('nama_supplier');
            $this->ModelSupplier->hapus($kode_supplier);
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Tabel Supplier : ' . $nama_supplier,
            ];
            $this->ModelLogHistory->add($datalog);
            
            
            $msg = ['sukses' => 'Supplier has been deleted !!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }

    public function cari_kodesupplier()
    {
        $kode_supplier = $this->request->getPost('kode_supplier');
        $data = $this->ModelSupplier->detail($kode_supplier);
        session()->set('vat', $data['ppn']);
        echo json_encode($data);
    }

    public function saldoawal($kode_supplier)
    {
        $saldoawal = $this->ModelSupplier->detail_saldo($kode_supplier);
        $this->ModelSupplier->clearCart();
        foreach ($saldoawal as $pinv) {
            $datakeranjang = array(
                'no_invoice'    => $pinv['no_invoice'],
                'tgl_invoice'   => $pinv['tgl_invoice'],
                'kode_supplier' => $pinv['kode_supplier'],
                'total_invoice' => $pinv['total_invoice'],
                'total_bayar'   => $pinv['total_bayar'],
                'awal'          => $pinv['awal'],

            );
            $this->ModelSupplier->addCart($datakeranjang);
        }

        $invawal = $this->ModelSupplier->detail_saldo($kode_supplier);

        $data = [
            'supplier' => $this->ModelSupplier->detail($kode_supplier),
            'invawal'  => $invawal
        ];
        return view('supplier/v_saldo', $data);
    }

    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $kode_supplier = $this->request->getPost('kode_supplier');
            $dtl           = $this->ModelSupplier->getCart($kode_supplier);
            $data  = [
                'datadetail' => $dtl
            ];
            $msg = [
                'data' => view('supplier/v_harga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpantemp()
    {
        if ($this->request->isAJAX()) {
            $kode_supplier    = $this->request->getPost('kode_supplier');
            $no_invoice       = $this->request->getPost('no_invoice');
            $tgl_invoice      = $this->request->getPost('tgl_invoice');
            $total_invoice    = str_replace(',', '', $this->request->getPost('total_invoice'));

            $data = [
                'kode_supplier' => $kode_supplier,
                'no_invoice'    => $no_invoice,
                'tgl_invoice'   => $tgl_invoice,
                'total_invoice' => $total_invoice,
                'total_bayar'   => 0,
                'awal'          => 1,
            ];


            $this->ModelSupplier->addCart($data);

            $msg = [
                'sukses' => 'berhasil'
            ];
        }
        echo json_encode($msg);
    }


    public function viewEditHarga()
    {
        if ($this->request->isAJAX()) {
            $no_invoice   = $this->request->getPost('no_invoice');
            $tgl_invoice  = $this->request->getPost('tgl_invoice');
            $total_invoice = $this->request->getPost('total_invoice');
            $total_bayar   = $this->request->getPost('total_bayar');

            $data = [
                'no_invoice'  => $no_invoice,
                'tgl_invoice' => $tgl_invoice,
                'total_invoice'   => $total_invoice,
                'total_bayar' => $total_bayar
            ];

            $msg = [
                'viewmodal' => view('supplier/v_editharga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {

            $noinvoice = $this->request->getPost('no_invoice');
            $this->ModelSupplier->deleteCart($noinvoice);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function deleteCart($id)
    {
        $this->db->table('keranjangawal')
            ->where('no_invoice', $id)
            ->delete();
    }


    public function cari_supplier()
    {
        $kode_supplier = $this->request->getPost('kode_supplier');
        $data = $this->ModelSupplier->detail($kode_supplier);
        echo json_encode($data);
    }
}
