<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bitcoin extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('coin_model');
        $this->load->library('javascript'); 
        $this->load->library('javascript/jquery');
        $this->load->helper('url');
        
    }

	
	
	public  function index()
    {
        $data['library_src'] = $this->jquery->script(); 
    	$data = array();
        if($query = $this->coin_model->get_coin())
        {
        	$data['record'] = $query;
        }

        $data['result'] = $this->coin_model->partial();
        $data['fill'] = $this->coin_model->fill();
        $this->load->view('bitcoin_index', $data);
       
            // $this->db->select('*');
            // $this->db->from('bittrex');
            // $this->db->like('FillType', 'PARTIAL_FILL');
            // $pa=$this->db->count_all_results();
            // echo $pa;
           
    }

    public function partial()
    {
        $this->load->model('coin_model');
       
        $data['result'] = $this->coin_model->partial();
      
        $this->load->view('bitcoin_index', $data);
    }
    // $this->load->model('Some_model');
    // $data['num_results'] = $this->Some_model->some_model_function();
    // $this->load->view('some_view', $data);
    public function fill()
    {
        $this->load->model('coin_model');
       
        $data['fill'] = $this->coin_model->fill();
      
        $this->load->view('bitcoin_index', $data);
    }
   
    

    }
   


