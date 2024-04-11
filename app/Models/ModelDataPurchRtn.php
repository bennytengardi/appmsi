<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;


class ModelDataPurchRtn extends Model
{
    protected $table = "tbl_purchrtn";
    protected $column_order = array(null, 'no_retur', 'tgl_retur', 'nama_supplier', 'no_invoice', 'keterangan', 'total_retur', false);
    protected $column_search = array('no_retur', 'tgl_retur', 'nama_supplier', 'no_invoice', 'total_retur');
    protected $order = array('no_retur' => 'desc');
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
        $this->dt = $this->db->table($this->table)->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_purchrtn.kode_supplier')->orderBy('tgl_retur', 'desc')->orderBy('no_retur', 'desc');

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
        $tbl_storage =  $this->db->table($this->table)->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_purchrtn.kode_supplier')->orderBy('tgl_retur', 'desc')->orderBy('no_reture', 'desc');
        return $tbl_storage->countAllResults();
    }
}
