<?php

namespace App\Controllers;

use App\Models\ModelClear;
use Config\Services;

class Kosong extends BaseController
{
    function __construct()
    {
        $this->ModelClear = new ModelClear();
    }

    public function index()
    {
        $this->ModelClear->clearCart();
        return redirect()->to(base_url('admin'));
    }
}
