<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        // Load user model
        $this->load->model('user');
        
        // Load form helper and library
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
    
    public function index(){
        $data = array();
        
        // Get messages from the session
        if($this->session->userdata('success_msg')){
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if($this->session->userdata('error_msg')){
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');
        }
        
        $conditions = array();
        $data['userdata'] = $this->user->getRows($conditions);
        $data['title'] = 'User List';
        
        // Load the list page view
        $this->load->view('users/index', $data);
    }
    
    public function add(){
        $data = array();
        $frmData = array();
        
        // If add request is submitted
        if($this->input->post('userSubmit')){
            // Form field validation rules
            $this->form_validation->set_rules('s_name', 'Enter your name', 'required');
            $this->form_validation->set_rules('s_class', 'Enter your class', 'required');

            //Check whether user upload picture
            if(!empty($_FILES['picture']['name'])){
                $config['upload_path'] = 'upload/images/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['picture']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('picture')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $picture = 'default-picture.png';
                }
            }else{
                $picture = 'default-picture.png';
            }
            
            // Prepare member data
            $frmData = array(
                's_name'    => $this->input->post('s_name'),
                's_class'   => $this->input->post('s_class'),
                's_profile' => $picture
            );
            
            // Validate submitted form data
            if($this->form_validation->run() == true){
                // Insert user data
                $insert = $this->user->insert($frmData);

                if($insert){
                    $this->session->set_userdata('success_msg', 'User has been added successfully.');
                    redirect('users');
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }
        }
        
        $data['userdata'] = $frmData;
        $data['title'] = 'Add User';
        
        // Load the add page view
        $this->load->view('users/add-edit', $data);
    }
    
    public function edit($id){
        $data = array();
        
        // Get member data
        $frmData = $this->user->getRows(array('id' => $id));
        
        // If update request is submitted
        if($this->input->post('userSubmit')){
            // Form field validation rules
            $this->form_validation->set_rules('s_name', 'Enter your name', 'required');
            $this->form_validation->set_rules('s_class', 'Enter your class', 'required');

            //Check whether user upload picture
            if(!empty($_FILES['picture']['name'])){
                $config['upload_path'] = 'upload/images/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['picture']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('picture')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $picture = $this->input->post('picture_name');
                }
            }else{
                $picture = $this->input->post('picture_name');
            }
            
            // Prepare member data
            $frmData = array(
                's_name'    => $this->input->post('s_name'),
                's_class'   => $this->input->post('s_class'),
                's_profile' => $picture
            );
            
            // Validate submitted form data
            if($this->form_validation->run() == true){
                // Update member data
                $update = $this->user->update($frmData, $id);

                if($update){
                    $this->session->set_userdata('success_msg', 'User has been updated successfully.');
                    redirect('users');
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }
        }

        $data['userdata'] = $frmData;
        $data['title'] = 'Update users';
        
        // Load the edit page view
        $this->load->view('users/add-edit', $data);
    }
    
    public function delete($id){
        // Check whether users id is not empty
        if($id){
            // Delete users
            $delete = $this->user->delete($id);
            
            if($delete){
                $this->session->set_userdata('success_msg', 'User has been removed successfully.');
            }else{
                $this->session->set_userdata('error_msg', 'Some problems occured, please try again.');
            }
        }
        
        // Redirect to the list page
        redirect('users');
    }
}