<?php

namespace App\Controllers;

use Config\Services;
use App\Controllers\BaseController;
use Ifsnop\Mysqldump\Mysqldump;

class Backup extends BaseController
{

    public function index()
    {
        return view('backup/v_index');
    }

    public function doBackup() 
    {
        try{
            $tglsekarang = date('dmy');
            $dump = new Mysqldump('mysql:host=localhost;dbname=n1571962_dbmsi;port=3306','n1571962_msi','KM]7B2lmKM*~');
            $dump->start('database/backup/dbbackup-' . $tglsekarang . '.sql');
            $pesan = 'Backup Data Berhasil !!!';
            session()->setFlashdata('pesan',$pesan);

            return redirect()->to('/admin');
        } catch(\Exception $e) {
            $pesan = 'mysqldump php error' . $e->getMessage() ;
            session()->setFlashdata('pesan',$pesan);
            return redirect()->to('/admin');
        }
    }
}
