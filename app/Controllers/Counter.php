<?php

namespace App\Controllers;

use App\Models\ModelCounter;

class Counter extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelCounter = new ModelCounter();
    }

    public function index()
    {
        $data = [
            'title'   => 'Set Counter',
            'counter' => $this->ModelCounter->allData(),
            'isi' => 'admin/v_counter'
        ];
        return view('admin/v_counter', $data);
    }

    public function edit()
    {
        $data = [
            'customer'    => $this->request->getPost('customer'),
            'supplier'    => $this->request->getPost('supplier'),
            'barang'      => $this->request->getPost('barang'),
            'salesman'    => $this->request->getPost('salesman'),
            'po'          => $this->request->getPost('po'),
            'pi'          => $this->request->getPost('pi'),
            'pr'          => $this->request->getPost('pr'),
            'vp'          => $this->request->getPost('vp'),
            'inv'         => $this->request->getPost('inv'),
            'non'         => $this->request->getPost('non'),
            'cr'          => $this->request->getPost('cr'),
            'sr'          => $this->request->getPost('sr'),
            'adjustment'  => $this->request->getPost('adjustment'),
            'othpay'      => $this->request->getPost('othpay'),
            'othrcv'      => $this->request->getPost('othrcv'),
            'jurnal'      => $this->request->getPost('jurnal'),
            'tt'          => $this->request->getPost('tt'),
        ];
        $this->ModelCounter->edit($data);
        session()->setFlashdata('pesan', 'Data Coounter berhasil diUpdate !!!');
        return redirect()->to(base_url('admin'));
    }
}
