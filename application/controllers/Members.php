<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        // Load member model
        $this->load->model('member');
        
        // Load form helper and library
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // Load pagination library
        $this->load->library('pagination');
        
        // Per page limit
        $this->perPage = 2;
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
        
        // If search request submitted
        if($this->input->post('submitSearch')){
            $inputKeywords = $this->input->post('searchKeyword');
            $searchKeyword = strip_tags($inputKeywords);
            if(!empty($searchKeyword)){
                $this->session->set_userdata('searchKeyword',$searchKeyword);
            }else{
                $this->session->unset_userdata('searchKeyword');
            }
        }elseif($this->input->post('submitSearchReset')){
            $this->session->unset_userdata('searchKeyword');
        }
        $data['searchKeyword'] = $this->session->userdata('searchKeyword');
        
        // Get rows count
        $conditions['searchKeyword'] = $data['searchKeyword'];
        $conditions['returnType']    = 'count';
        $rowsCount = $this->member->getRows($conditions);
        
        // Pagination config
        $config['base_url']    = base_url().'members/index/';
        $config['uri_segment'] = 3;
        $config['total_rows']  = $rowsCount;
        $config['per_page']    = $this->perPage;
        
        // Initialize pagination library
        $this->pagination->initialize($config);
        
        // Define offset
        $page = $this->uri->segment(3);
        $offset = !$page?0:$page;
        
        // Get rows
        $conditions['returnType'] = '';
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $data['members'] = $this->member->getRows($conditions);
        $data['title'] = 'Members List';
        
        // Load the list page view
        $this->load->view('templates/header', $data);
        $this->load->view('members/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($id){
        $data = array();
        
        // Check whether member id is not empty
        if(!empty($id)){
            $data['member'] = $this->member->getRows(array('id' => $id));;
            $data['title']  = 'Member Details';
            
            // Load the details page view
            $this->load->view('templates/header', $data);
            $this->load->view('members/view', $data);
            $this->load->view('templates/footer');
        }else{
            redirect('members');
        }
    }
    
    public function add(){
        $data = array();
        $memData = array();
        
        // If add request is submitted
        if($this->input->post('memSubmit')){
            // Form field validation rules
            $this->form_validation->set_rules('first_name', 'first name', 'required');
            $this->form_validation->set_rules('last_name', 'last name', 'required');
            $this->form_validation->set_rules('email', 'email', 'required|valid_email');
            $this->form_validation->set_rules('gender', 'gender', 'required');
            $this->form_validation->set_rules('country', 'country', 'required');
            
            // Prepare member data
            $memData = array(
                'first_name'=> $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email'     => $this->input->post('email'),
                'gender'    => $this->input->post('gender'),
                'country'   => $this->input->post('country')
            );
            
            // Validate submitted form data
            if($this->form_validation->run() == true){
                // Insert member data
                $insert = $this->member->insert($memData);

                if($insert){
                    $this->session->set_userdata('success_msg', 'Member has been added successfully.');
                    redirect('members');
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }
        }
        
        $data['member'] = $memData;
        $data['title'] = 'Add Member';
        
        // Load the add page view
        $this->load->view('templates/header', $data);
        $this->load->view('members/add-edit', $data);
        $this->load->view('templates/footer');
    }
    
    public function edit($id){
        $data = array();
        
        // Get member data
        $memData = $this->member->getRows(array('id' => $id));
        
        // If update request is submitted
        if($this->input->post('memSubmit')){
            // Form field validation rules
            $this->form_validation->set_rules('first_name', 'first name', 'required');
            $this->form_validation->set_rules('last_name', 'last name', 'required');
            $this->form_validation->set_rules('email', 'email', 'required|valid_email');
            $this->form_validation->set_rules('gender', 'gender', 'required');
            $this->form_validation->set_rules('country', 'country', 'required');
            
            // Prepare member data
            $memData = array(
                'first_name'=> $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email'     => $this->input->post('email'),
                'gender'    => $this->input->post('gender'),
                'country'   => $this->input->post('country')
            );
            
            // Validate submitted form data
            if($this->form_validation->run() == true){
                // Update member data
                $update = $this->member->update($memData, $id);

                if($update){
                    $this->session->set_userdata('success_msg', 'Member has been updated successfully.');
                    redirect('members');
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }
        }

        $data['member'] = $memData;
        $data['title'] = 'Update Member';
        
        // Load the edit page view
        $this->load->view('templates/header', $data);
        $this->load->view('members/add-edit', $data);
        $this->load->view('templates/footer');
    }
    
    public function delete($id){
        // Check whether member id is not empty
        if($id){
            // Delete member
            $delete = $this->member->delete($id);
            
            if($delete){
                $this->session->set_userdata('success_msg', 'Member has been removed successfully.');
            }else{
                $this->session->set_userdata('error_msg', 'Some problems occured, please try again.');
            }
        }
        
        // Redirect to the list page
        redirect('members');
    }
}