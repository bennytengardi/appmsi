<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;


class ModelDataSalesOrd extends Model
{
    protected $table = "tbl_salesord";
    protected $column_order = array(null, 'no_so', 'tgl_so', 'nama_customer', 'no_po', 'total_so', false);
    protected $column_search = array('no_so', 'tgl_so', 'nama_customer', 'total_so');
    protected $order = array('no_so' => 'desc');
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
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesord.kode_customer')
                ->where('tgl_so >=', session()->get('tglawlinv'))
                ->where('tgl_so <=', session()->get('tglakhinv'))
                ->orderBy('tgl_so', 'desc')
                ->orderBy('no_so', 'desc');
        } else {
            $this->dt = $this->db->table($this->table)
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesord.kode_customer')
                ->where('tgl_so >=', session()->get('tglawlinv'))
                ->where('tgl_so <=', session()->get('tglakhinv'))
                ->where('tbl_salesord.kode_customer =', session()->get('cust1'))
                ->orderBy('tgl_so', 'desc')
                ->orderBy('no_so', 'desc');
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
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesord.kode_customer')
                ->where('tgl_so >=', session()->get('tglawlinv'))
                ->where('tgl_so <=', session()->get('tglakhinv'))
                ->orderBy('tgl_so', 'desc')
                ->orderBy('no_so', 'desc');
        } else {
            $tbl_storage = $this->db->table($this->table)
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesord.kode_customer')
                ->where('tgl_so >=', session()->get('tglawlinv'))
                ->where('tgl_so <=', session()->get('tglakhinv'))
                ->where('tbl_salesord.kode_customer =', session()->get('cust1'))
                ->orderBy('tgl_so', 'desc')
                ->orderBy('no_so', 'desc');
        }
        return $tbl_storage->countAllResults();
    }
}
