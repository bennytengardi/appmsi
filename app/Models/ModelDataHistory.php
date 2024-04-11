<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;
use PhpParser\Node\Stmt\Echo_;

class ModelDataHistory extends Model
{
    protected $table = "tbl_detail_jurnal";
    protected $column_order = array(null, 'tgl_voucher', 'codejurnal', 'no_voucher', 'kode_account', 'nama_account','keterangan','debet','credit');
    protected $column_search = array('no_voucher', 'tgl_voucher', 'tbl_detail_jurnal.kode_account', 'nama_account', 'keterangan');
    protected $order = array('tgl_voucher' => 'desc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    function _get_datatables_query()
    {
        if (session()->get('accthistory') == 'ALL' AND session()->get('srchistory') == 'All Source')  {
            $this->dt = $this->db->table($this->table)
            ->join('tbl_account', 'tbl_account.kode_account = tbl_detail_jurnal.kode_account')
            ->where('tgl_voucher >=', session()->get('tglawlhistory'))
            ->where('tgl_voucher <=', session()->get('tglakhhistory'))
            ->orderBy('tgl_voucher', 'desc')
            ->orderBy('no_voucher', 'desc');
        }

        if (session()->get('accthistory') == 'ALL' AND session()->get('srchistory') != 'All Source')  {
            $this->dt = $this->db->table($this->table)
            ->join('tbl_account', 'tbl_account.kode_account = tbl_detail_jurnal.kode_account')
            ->where('tgl_voucher >=', session()->get('tglawlhistory'))
            ->where('tgl_voucher <=', session()->get('tglakhhistory'))
            ->where('codejurnal =', session()->get('srchistory'))
            ->orderBy('tgl_voucher', 'desc')
            ->orderBy('no_voucher', 'desc');
        }    
        if (session()->get('accthistory') != 'ALL' AND session()->get('srchistory') == 'All Source')  {
            $this->dt = $this->db->table($this->table)
            ->join('tbl_account', 'tbl_account.kode_account = tbl_detail_jurnal.kode_account')
            ->where('tgl_voucher >=', session()->get('tglawlhistory'))
            ->where('tgl_voucher <=', session()->get('tglakhhistory'))
            ->where('tbl_detail_jurnal.kode_account =', session()->get('accthistory'))
            ->orderBy('tgl_voucher', 'desc')
            ->orderBy('no_voucher', 'desc');
        }    
        if (session()->get('accthistory') != 'ALL' AND session()->get('srchistory') != 'All Source')  {
            $this->dt = $this->db->table($this->table)
            ->join('tbl_account', 'tbl_account.kode_account = tbl_detail_jurnal.kode_account')
            ->where('tgl_voucher >=', session()->get('tglawlhistory'))
            ->where('tgl_voucher <=', session()->get('tglakhhistory'))
            ->where('codejurnal =', session()->get('srchistory'))
            ->where('tbl_detail_jurnal.kode_account =', session()->get('accthistory'))
            ->orderBy('tgl_voucher', 'desc')
            ->orderBy('no_voucher', 'desc');
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
        if (session()->get('accthistory') == 'ALL' AND session()->get('srchistory') == 'All Source')  {
            $tbl_storage = $this->db->table($this->table)
            ->join('tbl_account', 'tbl_account.kode_account = tbl_detail_jurnal.kode_account')
            ->where('tgl_voucher >=', session()->get('tglawlhistory'))
            ->where('tgl_voucher <=', session()->get('tglakhhistory'))
            ->orderBy('tgl_voucher', 'desc')
            ->orderBy('no_voucher', 'desc');
        }
        if (session()->get('accthistory') == 'ALL' AND session()->get('srchistory') != 'All Source')  {
            $tbl_storage = $this->db->table($this->table)
            ->join('tbl_account', 'tbl_account.kode_account = tbl_detail_jurnal.kode_account')
            ->where('tgl_voucher >=', session()->get('tglawlhistory'))
            ->where('tgl_voucher <=', session()->get('tglakhhistory'))
            ->where('codejurnal =', session()->get('srchistory'))
            ->orderBy('tgl_voucher', 'desc')
            ->orderBy('no_voucher', 'desc');
        }    
        if (session()->get('accthistory') != 'ALL' AND session()->get('srchistory') == 'All Source')  {
            $tbl_storage = $this->db->table($this->table)
            ->join('tbl_account', 'tbl_account.kode_account = tbl_detail_jurnal.kode_account')
            ->where('tgl_voucher >=', session()->get('tglawlhistory'))
            ->where('tgl_voucher <=', session()->get('tglakhhistory'))
            ->where('tbl_detail_jurnal.kode_account =', session()->get('accthistory'))
            ->orderBy('tgl_voucher', 'desc')
            ->orderBy('no_voucher', 'desc');
        }    
        if (session()->get('accthistory') != 'ALL' AND session()->get('srchistory') != 'All Source')  {
            $tbl_storage = $this->db->table($this->table)
            ->join('tbl_account', 'tbl_account.kode_account = tbl_detail_jurnal.kode_account')
            ->where('tgl_voucher >=', session()->get('tglawlhistory'))
            ->where('tgl_voucher <=', session()->get('tglakhhistory'))
            ->where('codejurnal =', session()->get('srchistory'))
            ->where('tbl_detail_jurnal.kode_account =', session()->get('accthistory'))
            ->orderBy('tgl_voucher', 'desc')
            ->orderBy('no_voucher', 'desc');
        }    
        return $tbl_storage->countAllResults();

    }
}
