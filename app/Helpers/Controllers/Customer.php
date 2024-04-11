<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelDataCustomer;
use App\Models\ModelSalesman;
use App\Models\ModelDivisi;
use App\Models\ModelCounter;
use App\Models\ModelLogHistory;
use Config\Services;

class Customer extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelCustomer  = new ModelCustomer();
        $this->ModelSalesman  = new ModelSalesman();
        $this->ModelDivisi  = new ModelDivisi();
        $this->ModelCounter = new ModelCounter();
        $this->ModelLogHistory = new ModelLogHistory();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Customer',
        ];
        return view('customer/v_index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $this->ModelDataCustomer = new ModelDataCustomer($request);
        if ($request->getMethod(true) == 'POST') {
            $customer = $this->ModelDataCustomer->get_datatables();
            $data = [];
            $no = $request->getPost("start") + 1;
            foreach ($customer as $cus) {
                $row = [];
                $row[] = $no++;
                $row[] = $cus['kode_customer'];
                $row[] = $cus['nama_customer'];
                $row[] = $cus['address1'];
                $row[] = $cus['telephone'];
                $row[] = number_format($cus['awal'] + $cus['debet'] - $cus['credit'], 0, '.', ',');
                $row[] =
                    '<a href="' . base_url('customer/edit/' . $cus['kode_customer']) . '" class="btn btn-success btn-xs mr-2">EDIT</a>' .
                    "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"hapusCustomer('" . $cus['kode_customer'] .  "','" . $cus['nama_customer'] . "') \">DELETE</button>" .
                    '<a href="' . base_url('customer/saldoawal/' . $cus['kode_customer']) . '" class="btn btn-info btn-xs ml-1">SALDO AWAL</a>';
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $this->ModelDataCustomer->count_all(),
                "recordsFiltered" => $this->ModelDataCustomer->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add()
    {
        $ctr = $this->ModelCounter->allData();
        $kode_customer = 'CS-' . str_pad(strval(($ctr['customer'] + 1)), 4, '0', STR_PAD_LEFT);
        $data = [
            'title'      => 'Tambah Customer',
            'kode_customer' => $kode_customer,
            'salesman'      => $this->ModelSalesman->allData(),
            'validation'  => \config\Services::validation()
        ];
        return view('customer/v_add', $data);
    }


    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $kode_customer    = $this->request->getPost('kode_customer');
            $nama_customer    = $this->request->getPost('nama_customer');
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
            $termin           = $this->request->getPost('termin');
            // $kode_salesman    = $this->request->getPost('kode_salesman');
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'nama_customer' => [
                    'label' => 'Customer Na,e',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
                'address1' => [
                    'label' => 'Alamat Customer',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNamaCustomer'   => $validation->getError('nama_customer'),
                        'errorAddress1'       => $validation->getError('address1'),
                    ]
                ];
            } else {
                $data = [
                    'kode_customer'   => $kode_customer,
                    'nama_customer'   => $nama_customer,
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
                    'termin'          => $termin,
                    // 'kode_salesman'   => $kode_salesman,
                ];

                $this->ModelCustomer->add($data);
                $ctr = $this->ModelCounter->allData();
                $inv = $ctr['customer'] + 1;
                $data = [
                    'customer' => $inv
                ];
                $this->ModelCounter->updctr($data);

                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Menambah Tabel Customer : ' . $nama_customer,
                ];
                $this->ModelLogHistory->add($datalog);

                $msg = [
                    'sukses' => 'Data Customer has been added'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function edit($kode_customer)
    {
        $data = [
            'customer'    => $this->ModelCustomer->detail($kode_customer),
            'salesman'    => $this->ModelSalesman->allData(),
            'validation'  => \config\Services::validation()
        ];

        return view('customer/v_edit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $kode_customer    = $this->request->getPost('kode_customer');
            $nama_customer    = $this->request->getPost('nama_customer');
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
            $termin           = $this->request->getPost('termin');
            // $kode_salesman    = $this->request->getPost('kode_salesman');

            $validation =  \Config\Services::validation();
            $valid = $this->validate([
                'nama_customer' => [
                    'label' => 'Customer Name',
                    'rules' => 'required',
                    'errors' => [
                        'required'  => '{field} is required'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorNamaCustomer'   => $validation->getError('nama_customer'),
                    ]
                ];
            } else {
                $data = [
                    'kode_customer'   => $kode_customer,
                    'nama_customer'   => $nama_customer,
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
                    'termin'          => $termin,
                    // 'kode_salesman'   => $kode_salesman
                ];

                $this->ModelCustomer->edit($data);
                
                date_default_timezone_set('Asia/Jakarta');
                $datalog = [
                    'username'  => session()->get('username'),
                    'jamtrx'    => date('Y-m-d H:i:s'),
                    'kegiatan'  => 'Merubah Tabel Customer : ' . $nama_customer,
                ];
                $this->ModelLogHistory->add($datalog);
                
                $msg = [
                    'sukses' => 'Data Customer has been updated'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function saldoawal($kode_customer)
    {
        $saldoawal = $this->ModelCustomer->detail_saldo($kode_customer);
        $this->ModelCustomer->clearCart();
        foreach ($saldoawal as $pinv) {
            $datakeranjang = array(
                'no_invoice'    => $pinv['no_invoice'],
                'tgl_invoice'   => $pinv['tgl_invoice'],
                'kode_customer' => $pinv['kode_customer'],
                'total_invoice' => $pinv['total_invoice'],
                'total_bayar'   => $pinv['total_bayar'],
                'awal'          => $pinv['awal'],
                'kode_divisi'   => $pinv['kode_divisi']
            );
            $this->ModelCustomer->addCart($datakeranjang);
        }

        $invawal = $this->ModelCustomer->detail_saldo($kode_customer);

        $data = [
            'customer' => $this->ModelCustomer->detail($kode_customer),
            'divisi'   => $this->ModelDivisi->allData(),
            'invawal'  => $invawal
        ];
        return view('customer/v_saldo', $data);
    }


    public function updatesaldoawal()
    {
        if ($this->request->isAJAX()) {
            date_default_timezone_set('Asia/Jakarta');
            $no_invoice    = $this->request->getPost('no_invoice');
            $tgl_invoice   = $this->request->getPost('tgl_invoice');
            $kode_customer = $this->request->getPost('kode_customer');
            $kode_divisi   = $this->request->getPost('kode_divisi');
            $total_invoice = str_replace(',', '', $this->request->getPost('total_invoice'));

            $data = [
                'no_invoice'     => str_replace('/','-',$no_invoice),
                'tgl_invoice'    => $tgl_invoice,
                'kode_customer'  => $kode_customer,
                'kode_divisi'    => $kode_divisi,
                'total_invoice'  => $total_invoice,
                'awal'           => 1
            ];


            $this->ModelCustomer->delete_salesinv($kode_customer);

            $ambildatakeranjang = $this->ModelCustomer->ambilDataCart();
            $saldoawal = 0;
            foreach ($ambildatakeranjang as $row) :
                $saldoawal = $saldoawal + $row['total_invoice'];
                $datainv = array(
                    'no_invoice'    => $row['no_invoice'],
                    'tgl_invoice'   => $row['tgl_invoice'],
                    'total_invoice' => $row['total_invoice'],
                    'total_bayar'   => $row['total_bayar'],
                    'kode_customer' => $row['kode_customer'],
                    'kode_divisi'   => $row['kode_divisi'],
                    'awal'          => 1,
                );
                $this->ModelCustomer->add_salesinv($datainv);
            endforeach;

            $this->ModelCustomer->clearCart();
            $msg = [
                'sukses' => 'Data Saldo Awal has been updated'
            ];
            echo json_encode($msg);
        }
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $kode_customer = $this->request->getVar('kode_customer');
            $nama_customer = $this->request->getVar('nama_customer');
            $this->ModelCustomer->hapus($kode_customer);
            
            date_default_timezone_set('Asia/Jakarta');
            $datalog = [
                'username'  => session()->get('username'),
                'jamtrx'    => date('Y-m-d H:i:s'),
                'kegiatan'  => 'Menghapus Tabel Customer : ' . $nama_customer,
            ];
            $this->ModelLogHistory->add($datalog);
            
            $msg = ['sukses' => 'Data Customer has been deleted !!!'];
            echo json_encode($msg);
        } else {
            exit('Maaf, tidak dapat diproses');
        }
    }

    public function cari_kodecustomer()
    {
        $kode_customer = $this->request->getPost('kode_customer');
        $data = $this->ModelCustomer->detail($kode_customer);
        session()->set('kdcus', $data['kode_customer']);
        session()->set('vat', $data['ppn']);
        echo json_encode($data);
    }

    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $kode_customer = $this->request->getPost('kode_customer');
            $dtl           = $this->ModelCustomer->getCart($kode_customer);
            $data  = [
                'datadetail' => $dtl
            ];
            $msg = [
                'data' => view('customer/v_harga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpantemp()
    {
        if ($this->request->isAJAX()) {
            $kode_customer    = $this->request->getPost('kode_customer');
            $kode_divisi      = $this->request->getPost('kode_divisi');
            $no_invoice       = str_replace('/','-',$this->request->getPost('no_invoice'));
            $tgl_invoice      = $this->request->getPost('tgl_invoice');
            $total_invoice    = str_replace(',', '', $this->request->getPost('total_invoice'));

            $data = [
                'kode_customer' => $kode_customer,
                'kode_divisi' => $kode_divisi,
                'no_invoice'    => $no_invoice,
                'tgl_invoice'   => $tgl_invoice,
                'total_invoice' => $total_invoice,
                'total_bayar'   => 0,
                'awal'          => 1,
            ];

            $this->ModelCustomer->addCart($data);

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
            $kode_divisi  = $this->request->getPost('kode_divisi');
            $total_invoice = $this->request->getPost('total_invoice');
            $total_bayar   = $this->request->getPost('total_bayar');

            $data = [
                'no_invoice'  => $no_invoice,
                'tgl_invoice' => $tgl_invoice,
                'kode_divisi' => $kode_divisi,
                'total_invoice'   => $total_invoice,
                'total_bayar' => $total_bayar,
                'divisi'   => $this->ModelDivisi->allData(),
            ];

            // print_r($data);
            $msg = [
                'viewmodal' => view('customer/v_editharga', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {

            $noinvoice = $this->request->getPost('no_invoice');
            $this->ModelCustomer->deleteCart($noinvoice);
            $msg = [
                'sukses' => 'berhasil'
            ];
            echo json_encode($msg);
        }
    }

    public function deleteCart($id)
    {
        $this->db->table('keranjangawalpiu')
            ->where('no_invoice', $id)
            ->delete();
    }

    public function updateHarga()
    {

        if ($this->request->isAJAX()) {

            $no_invoice    = $this->request->getPost('no_invoice');
            $tgl_invoice   = $this->request->getPost('tgl_invoice');
            $kode_divisi   = $this->request->getPost('kode_divisi');
            $total_invoice = str_replace(',', '', $this->request->getPost('total_invoice'));
            $total_bayar   = str_replace(',', '', $this->request->getPost('total_bayar'));

            $data = array(
                'no_invoice'  => $no_invoice,
                'tgl_invoice' => $tgl_invoice,
                'kode_divisi' => $kode_divisi,
                'total_invoice' => $total_invoice,
                'total_bayar' => $total_bayar
            );

            $this->ModelCustomer->editCart($data);

            $msg = [
                'sukses' => 'berhasil'
            ];

            echo json_encode($msg);
        }
    }


    public function cari_customer()
    {
        $kode_customer = $this->request->getPost('kode_customer');
        $data = $this->ModelCustomer->detail($kode_customer);
        echo json_encode($data);
    }

    public function ambilDataCustomer()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getPost('search');
            $datacustomer = $this->ModelCustomer->caricustomer($search);
            foreach ($datacustomer as $row) :
                $list[]= [
                  'id' => $row['kode_customer'],
                  'text' => $row['nama_customer'],
                ];
            endforeach;
            echo json_encode($list);
        }
    }

    public function ambilDataCustomer2()
    {
        if ($this->request->isAJAX()) {
            $datacustomer = $this->ModelAccount->allDataCustomer();
            $isidata = "<option value='' selected>-- Choose Customer --</option>";
            foreach ($datacustomer as $row) :
                $isidata .= '<option value="' . $row['kode_customer'] . '">' . $row['nama_customer'] . ' </option>';
            endforeach;
            $msg = [
                'data' => $isidata
            ];
            echo json_encode($msg);
        }
    }

}
