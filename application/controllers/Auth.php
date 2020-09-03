<?php
    
  
  defined('BASEPATH') OR exit('No direct script access allowed');
  
  class Auth extends CI_Controller {
        
    public function __construct()
    {
        
        parent::__construct();
        //Do your magic here
        $this->load->model('m_users');
       
        
    }
        
    public function index()
    {
        if ($this->session->logged_in) {
            redirect('dashboard');
        }
        $this->load->view('auth/index');
    }

    public function check_user()
    {
        $email = $this->input->post('username');
        $password = $this->input->post('password');
       
        $user_data = $this->m_users->getWhere(array('email'=>$email));
        if(!empty($user_data)){
            $user_data = $user_data[0];
            if(password_verify($password, $user_data->password)){
                $new_user = array(
                    'username' => $user_data->username,
                    'level' => $user_data->level,
                    'email' => $user_data->email,
                    'logged_in' => true
                );
                $this->session->set_userdata($new_user);
                redirect('dashboard');
            }else{
                
                $this->session->set_flashdata('alert', $this->alert->set_alert('danger','Password yang anda masukan salah'));
                redirect('auth');
            }
        }else{
            $this->session->set_flashdata('alert', $this->alert->set_alert('danger', 'User tidak ditemukan'));
            redirect('auth');
        }
        
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');

    }
  }
  
  

  /* End of file Auth.php */
    

?>