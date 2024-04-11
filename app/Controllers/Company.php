<?php

namespace App\Controllers;

use App\Models\ModelCompany;
use App\Models\ModelAccount;

class Company extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelAccount = new ModelAccount();
        $this->ModelCompany = new ModelCompany();
    }

    public function index()
    {
        $data = [
            'title' => 'Company',
            'company' => $this->ModelCompany->allData(),
            'account' => $this->ModelAccount->allDataDetail(),
            'isi' => 'admin/v_company'
        ];
        return view('admin/v_company', $data);
    }

    public function edit()
    {
        $data = [
            'nama_company'  => $this->request->getPost('nama_company'),
            'address1'      => $this->request->getPost('address1'),
            'address2'      => $this->request->getPost('address2'),
            'address3'      => $this->request->getPost('address3'),
            'telephone'     => $this->request->getPost('telephone'),
            'facsimile'     => $this->request->getPost('facsimile'),
            'email'         => $this->request->getPost('email'),
            'npwp'          => $this->request->getPost('npwp'),
            'tanda_tangan'  => $this->request->getPost('tanda_tangan'),
            'acctar'        => $this->request->getPost('acctar'),
            'acctap'        => $this->request->getPost('acctap'),
            'acctjual'      => $this->request->getPost('acctjual'),
            'acctinvt'      => $this->request->getPost('acctinvt'),
            'accthpp'       => $this->request->getPost('accthpp'),
            'acctppnk'      => $this->request->getPost('acctppnk'),
            'acctppnm'      => $this->request->getPost('acctppnm'),
            'acctdisc'      => $this->request->getPost('acctdisc'),
            'acctrtrjl'     => $this->request->getPost('acctrtrjl'),
            'acctumuka'     => $this->request->getPost('acctumuka'),
            'bank'          => $this->request->getPost('bank'),
            'noac'          => $this->request->getPost('noac'),
            'atasnama'      => $this->request->getPost('atasnama'),
        ];
        $this->ModelCompany->edit($data);
        $company = $this->ModelCompany->allData();

        session()->set('nama_company', $company['nama_company']);
        session()->set('address1',     $company['address1']);
        session()->set('address2',     $company['address2']);
        session()->set('address3',     $company['address3']);
        session()->set('telephone',    $company['telephone']);
        session()->set('facsimile',    $company['facsimile']);
        session()->set('email',        $company['email']);
        session()->set('startingdate', $company['starting_date']);
        session()->set('npwp',         $company['npwp']);
        session()->set('tanda_tangan', $company['tanda_tangan']);
        session()->set('acctar',       $company['acctar']);
        session()->set('acctap',       $company['acctap']);
        session()->set('acctjual',     $company['acctjual']);
        session()->set('accthpp',      $company['accthpp']);
        session()->set('acctppnk',     $company['acctppnk']);
        session()->set('acctppnm',     $company['acctppnm']);
        session()->set('acctdisc',     $company['acctdisc']);
        session()->set('acctrtrjl',    $company['acctrtrjl']);
        session()->set('acctinvt',     $company['acctinvt']);
        session()->set('acctumuka',    $company['acctumuka']);
        session()->set('bank',         $company['bank']);
        session()->set('noac',         $company['noac']);
        session()->set('atasnama',     $company['atasnama']);
        
        session()->setFlashdata('pesan', 'Data Company berhasil diUpdate !!!');
        return redirect()->to(base_url('admin'));
    }
}
