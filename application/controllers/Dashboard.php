<?php
    
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    private $url = 'dashboard';
    
    public function __construct()
    {
        parent::__construct();
        $this->check_access();
        $this->load->library('Breadcrumbs');
        $this->load->library('table_template');
        $this->load->model(array('m_officers','m_assets','m_status'));
    }
    
    public function index()
    {
        $data['page_content'] = 'page/dashboard/index';

        $search = ($this->input->get('search') != null) ? $this->input->get('search') : false;


        if ($search) {
            // table props, change this base on table props
            $data['table_head'] = array(
                'nip' => 'NIP',
                'full_name' => 'Nama',
                'position' => 'Jabatan',
                'agency_name' => 'Instansi'
            );
           $data['table_content'] = $this->search_asn($search);
           if($data['table_content']!=false){
               $stat = $data['table_content'][0];
               if($stat->status_penguasaan=='digunakan'){
                    $data['table_head_asset'] = array(
                        'asset_code' => 'Kode Aset',
                        'type' => 'Jenis',
                        'brand' => "Merk",
                        'police_number' => "Nomor Polisi",
                        'chassis_number' => "Nomor Rangka",
                        'price' => "Harga",
                        'year_purchased' => "Tahun Pembelian",
                        'agency_name' => 'OPD'
                    );
                    $data['list_asset'] = $this->get_asset($stat->id);
               }
           }
           $data['search'] = $search;
        }
       

        //initialize breadcrumbs 
        $this->breadcrumbs->push('Dashboard', '/dashboard');
        $this->breadcrumbs->unshift('Home', '/');            
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['page_url'] = site_url($this->url);

        $this->load->view('index', $data);
    }

    public function get_asset($id){

        $fetch['select'] = array('*');
        $fetch['select_join'] = array(
            'a.name as agency_name',
            's1.status as asset_status',
            'o.full_name as officer_name'
        );
        $fetch['join'] = array(
            array(
                "table" => "agencies a",
                "join" => "left",
                "on" => "a.id = assets.agency_id"
            ),
            array(
                "table" => "asset_status s1",
                "join" => "left",
                "on" => "s1.asset_id = assets.id"
            ),
            array(
                "table" => "asset_status s2",
                "join" => "left outer",
                "on" => "(assets.id = s2.asset_id AND 
                            (s1.date_created < s2.date_created OR 
                                (s1.date_created  = s2.date_created AND s1.id < s2.id)))"
            ),
            array(
                "table" => "officers o",
                "join" => "left",
                "on" => "o.id = s1.officer_id"
            )

        );
        $fetch['where'] = array('s2.id IS NULL');
        if ($this->session->level != 1) array_push($fetch['where'], array('assets.agency_id' => $this->session->agency_id));
        array_push($fetch['where'], array('s1.officer_id' => $id));
        array_push($fetch['where'], array('s1.status' => 'digunakan'));
        return $this->m_assets->fetch($fetch);


    }

    public function search_asn($search=false){

        // table props, change this base on table props
        $data['table_head'] = array(
            'nip' => 'NIP',
            'full_name' => 'Nama',
            'position' => 'Jabatan',
            'agency_name' => 'Instansi'
        );

        if ($search!=false) {
            $fetch['like'] = array('name' => array('nip', 'full_name'), 'key' => $search);
            // SELECT o.*, (SELECT s.status FROM asset_status s WHERE s.officer_id=o.id 
            // ORDER BY s.date_created DESC LIMIT 1) as statusBebas FROM officers o

            $fetch['select'] = array('id', 'nip', 'full_name', 'position');
            $fetch['select_join'] = array(
                'a.name as agency_name',
                '(SELECT s.status FROM asset_status s WHERE s.officer_id=officers.id 
                ORDER BY s.date_created DESC LIMIT 1) as status_penguasaan'
            );
            $fetch['join'] = array(
                array(
                    "table" => "agencies a",
                    "on" => "officers.agency_id = a.id",
                    "join" => "left",

                )
            );
            $fetch['where'] = [];
            if ($this->session->level != 1) array_push($fetch['where'], array('officers.agency_id' => $this->session->agency_id));
            return $this->m_officers->fetch($fetch);
        }else{
            return false;
        }
        
    }


    public function count_asset(){
        $fetch['select'] = array('*');
        $fetch['where'] = [];
        if($this->session->level!=1) array_push($fetch['where'], array('assets.agency_id'=> $this->session->agency_id));
        $res = $this->m_assets->fetch($fetch,true);
        return $res;
    }
    public function count_officers(){
        $fetch['select'] = array('*');
        $fetch['where'] = [];
        if($this->session->level!=1) array_push($fetch['where'], array('officers.agency_id'=> $this->session->agency_id));
        $res = $this->m_officers->fetch($fetch,true);
        return $res;
    }

    public function count_asset_status($status='kembali'){
        $fetch['select'] = array('id','asset_code', 'type', 'brand');
        $fetch['select_join'] = array(
            'a.name as agency_name',
            's1.status as asset_status',
            'o.full_name as officer_name'
        );
        $fetch['join'] = array(
            array(
                "table" => "agencies a",
                "join" => "left",
                "on" => "a.id = assets.agency_id"
            ),
            array(
                "table" => "asset_status s1",
                "join" => "left",
                "on" => "s1.asset_id = assets.id"
            ),
            array(
                "table" => "asset_status s2",
                "join" => "left outer",
                "on" => "(assets.id = s2.asset_id AND 
                            (s1.date_created < s2.date_created OR 
                                (s1.date_created  = s2.date_created AND s1.id < s2.id)))"
            ),
            array(
                "table" =>"officers o",
                "join" => "left",
                "on" => "o.id = s1.officer_id"
            )

        );
        $fetch['where'] = array('s2.id IS NULL');
    
        if($status=='kembali'){
             array_push($fetch['where'], array('s1.status'=> 'kembali'));
             array_push($fetch['where'], array('s1.status'=> 'NULL'));
        }else{
            array_push($fetch['where'], "s1.status != 'kembali'");
        }
        if($this->session->level!=1) array_push($fetch['where'], array('assets.agency_id'=> $this->session->agency_id));
        //var_dump($this->m_assets->fetch($fetch,false,true));
        return $this->m_assets->fetch($fetch,true);
    }

    public function page()
    {
        $data['page_content'] = 'page/dashboard/index';

        //initialize breadcrumbs 
        $this->breadcrumbs->push('Dashboard', '/dashboard');
        $this->breadcrumbs->push('Page', '/page');
        $this->breadcrumbs->unshift('Admin', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->load->view('index', $data);
    }

}
    
    /* End of file Home.php */
