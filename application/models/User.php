<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model{
    
    function __construct() {
        // Set table name
        $this->table = 'student';
    }
    
    /*
     * Fetch student data from the database
     * @param array filter data based on the passed parameters
     */
    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from($this->table);
        if(array_key_exists("id", $params)){
            $this->db->where('s_id', $params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            $query = $this->db->get();
            $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
        }
        
        // Return fetched data
        return $result;
    }
    
    /*
     * Insert users data into the database
     * @param $data data to be insert based on the passed parameters
     */
    public function insert($data = array()) {
        if(!empty($data)){
            // Add created and modified date if not included
            if(!array_key_exists("updated_date", $data)){
                $data['updated_date'] = date("Y-m-d H:i:s");
            }
            
            // Insert users data
            $insert = $this->db->insert($this->table, $data);
            
            // Return the status
            return $insert?$this->db->insert_id():false;
        }
        return false;
    }
    
    /*
     * Update users data into the database
     * @param $data array to be update based on the passed parameters
     * @param $id num filter data
     */
    public function update($data, $id) {
        if(!empty($data) && !empty($id)){
            // Add modified date if not included
            if(!array_key_exists("updated_date", $data)){
                $data['updated_date'] = date("Y-m-d H:i:s");
            }
            
            // Update users data
            $update = $this->db->update($this->table, $data, array('s_id' => $id));
            
            // Return the status
            return $update?true:false;
        }
        return false;
    }
    
    /*
     * Delete users data from the database
     * @param num filter data based on the passed parameter
     */
    public function delete($id){
        // Delete users data
        $delete = $this->db->delete($this->table, array('s_id' => $id));
        
        // Return the status
        return $delete?true:false;
    }
}