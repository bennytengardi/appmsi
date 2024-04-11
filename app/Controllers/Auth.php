<?php

namespace App\Controllers;

use App\Models\ModelAuth;
use App\Models\ModelCompany;
use App\Models\ModelUser;

class Auth extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelAuth = new ModelAuth();
        $this->ModelCompany = new ModelCompany();
        $this->ModelUser = new ModelUser();
    }

    public function index()
    {
        $data = [
            'title' => 'Login',
            'isi' => 'v_login'
        ];
        return view('v_login', $data);
    }

    public function cek_login()
    {
        if ($this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi'
                ]
            ],

            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi'
                ]
            ],
        ])) {
            // jika valid
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $cek_user = $this->ModelAuth->login_user($username, $password);
            $company  = $this->ModelCompany->allData();

            if ($cek_user) {
                // jika data cocok
                session()->set('iduser', $cek_user['id_user']);
                session()->set('username', $cek_user['username']);
                session()->set('fullname', $cek_user['fullname']);
                session()->set('foto',     $cek_user['foto']);
                session()->set('level',    $cek_user['level']);
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
                return redirect()->to(base_url('admin'));
            } else {
                session()->setFlashdata('pesan', 'Login Gagal, Username/Password salah');
                return redirect()->to(base_url('auth'));
            }
        } else {
            session()->setFlashdata('errors', \config\Services::validation()->getErrors());
            return redirect()->to(base_url('auth'));
        }
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth'));
    }

    public function changePassword()
    {
        $id_user = session()->get('iduser');
        $data = [
            'title' => "Change Password",
            'user'  => $this->ModelUser->detail($id_user),
        ];
        return view('v_changepassword', $data);
    }
}
