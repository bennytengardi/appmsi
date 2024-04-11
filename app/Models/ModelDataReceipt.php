<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;


class ModelDataReceipt extends Model
{
    protected $table = "tbl_receipt";
    protected $column_order = array(null, 'no_receipt', 'tgl_receipt', 'nama_customer', 'no_giro', 'tgl_giro', 'total_bayar', 'nama_account', false);
    protected $column_search = array('no_receipt', 'tgl_receipt', 'nama_customer', 'no_giro', 'total_bayar');
    protected $order = array('no_receipt' => 'desc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    private function _get_datatables_query()
    {
        if (session()->get('cust2') == 'ALL') {
            $this->dt = $this->db->table($this->table)
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_receipt.kode_customer')
                ->join('tbl_account', 'tbl_account.kode_account = tbl_receipt.kode_account')
                ->where('tgl_receipt >=', session()->get('tglawlrcp'))
                ->where('tgl_receipt <=', session()->get('tglakhrcp'))
                ->orderBy('tgl_receipt', 'desc')
                ->orderBy('no_receipt', 'desc');
        } else {
            $this->dt = $this->db->table($this->table)
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_receipt.kode_customer')
                ->join('tbl_account', 'tbl_account.kode_account = tbl_receipt.kode_account')
                ->where('tgl_receipt >=', session()->get('tglawlrcp'))
                ->where('tgl_receipt <=', session()->get('tglakhrcp'))
                ->where('tbl_receipt.kode_customer =', session()->get('cust2'))
                ->orderBy('tgl_receipt', 'desc')
                ->orderBy('no_receipt', 'desc');
        }


        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResultArray();
    }


    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }
    
    public function count_all()
    {
        if (session()->get('cust2') == 'ALL') {
            $tbl_storage =  $this->dt = $this->db->table($this->table)
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_receipt.kode_customer')
                ->join('tbl_account', 'tbl_account.kode_account = tbl_receipt.kode_account')
                ->where('tgl_receipt >=', session()->get('tglawlrcp'))
                ->where('tgl_receipt <=', session()->get('tglakhrcp'))
                ->orderBy('tgl_receipt', 'desc')
                ->orderBy('no_receipt', 'desc');
        } else {
            $tbl_storage =  $this->dt = $this->db->table($this->table)
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_receipt.kode_customer')
                ->join('tbl_account', 'tbl_account.kode_account = tbl_receipt.kode_account')
                ->where('tgl_receipt >=', session()->get('tglawlrcp'))
                ->where('tgl_receipt <=', session()->get('tglakhrcp'))
                ->where('tbl_receipt.kode_customer =', session()->get('cust2'))
                ->orderBy('tgl_receipt', 'desc')
                ->orderBy('no_receipt', 'desc');
        }
        
    }
}
