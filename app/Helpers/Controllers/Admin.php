<?php

namespace App\Controllers;

use App\Models\ModelAdmin;

date_default_timezone_set('Asia/Jakarta');

class Admin extends BaseController
{
    public function __construct()
    {
        $this->ModelAdmin = new ModelAdmin();
    }

    public function index()
    {
        $data = [
            'title'        => 'Admin',
            'jual'         => $this->ModelAdmin->jualharini(),
            'jualbln'      => $this->ModelAdmin->jualblnini(),
            'belibln'      => $this->ModelAdmin->beliblnini(),
            'biayabln'     => $this->ModelAdmin->biayablnini(),
            // 'jml_user'     => $this->ModelAdmin->jml_user(),
        ];
        // dd($data);
        if (session()->get('level') == "1") {
            return view('v_admin', $data);
        }

        if (session()->get('level') == "2") {
            return view('v_admin2', $data);
        }
    }


    //--------------------------------------------------------------------

}
