<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;


class ModelDataSalesInv extends Model
{
    protected $table = "tbl_salesinv";
    protected $column_order = array(null, 'no_invoice', 'tgl_invoice', 'nama_customer', 'no_suratjln', 'total_invoice', 'total_bayar', 'status', false);
    protected $column_search = array('no_invoice', 'tgl_invoice', 'nama_customer', 'total_invoice');
    protected $order = array('no_invoice' => 'desc');
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
        if (session()->get('cust1') == 'ALL') {
            $this->dt = $this->db->table($this->table)
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesinv.kode_customer')
                ->where('tgl_invoice >=', session()->get('tglawlinv'))
                ->where('tgl_invoice <=', session()->get('tglakhinv'))
                ->where('tbl_salesinv.awal', 0)
                ->orderBy('tgl_invoice', 'desc')
                ->orderBy('no_invoice', 'desc');
        } else {
            $this->dt = $this->db->table($this->table)
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesinv.kode_customer')
                ->where('tgl_invoice >=', session()->get('tglawlinv'))
                ->where('tgl_invoice <=', session()->get('tglakhinv'))
                ->where('tbl_salesinv.kode_customer =', session()->get('cust1'))
                ->where('tbl_salesinv.awal', 0)
                ->orderBy('tgl_invoice', 'desc')
                ->orderBy('no_invoice', 'desc');
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
        if (session()->get('cust1') == 'ALL') {
            $tbl_storage = $this->db->table($this->table)
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesinv.kode_customer')
                ->where('tgl_invoice >=', session()->get('tglawlinv'))
                ->where('tgl_invoice <=', session()->get('tglakhinv'))
                ->where('tbl_salesinv.awal', 0)
                ->orderBy('tgl_invoice', 'desc')
                ->orderBy('no_invoice', 'desc');
        } else {
            $tbl_storage = $this->db->table($this->table)
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesinv.kode_customer')
                ->where('tgl_invoice >=', session()->get('tglawlinv'))
                ->where('tgl_invoice <=', session()->get('tglakhinv'))
                ->where('tbl_salesinv.awal', 0)
                ->where('tbl_salesinv.kode_customer =', session()->get('cust1'))
                ->orderBy('tgl_invoice', 'desc')
                ->orderBy('no_invoice', 'desc');
        }
        return $tbl_storage->countAllResults();
    }
}