<?php
    class Coin_model extends CI_Model{
        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }
        public function get_coin(){
            $this->db->select('*');
            $this->db->from('bittrex');
            $query = $this->db->get();
            return $query->result();

        }
        function partial()
        {
            $this->db->select('*');
            $this->db->from('bittrex');
            $this->db->like('FillType', 'PARTIAL_FILL');
            return $num_rows = $this->db->count_all_results();
           
        }

        // function some_model_function() {	
        //     $this->db->from('table');
        //     return $num_rows = $this->db->count_all_results();
        //   }
        function fill()
        {
            $this->db->select('*');
            $this->db->from('bittrex');
            $this->db->like('FillType', 'FILL');
            return $num_rows = $this->db->count_all_results();
           
            // $fill = $this->db->count_all_results();
            // return $fill->result();
        }
        
        
    

    }
?>