<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

#Main controller for sign up and login page

class Main extends CI_Controller {
	
	public function index() {
		
		//The default function
		// load the "login.php" page
		$this->login();
		
	}
	public function login() {
		
		// load the "login.php" page
		$this->load->view('login');
		
	}
	
	/* 
	 * Function that will write to the browser's console and can
	 * be used for debugging purposes
	 * 
	 * */
	public function debug_to_console( $data ) {
		if (is_array($data)) {
			$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
		} else {
			$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
		}
		
		echo $output;
	}

	public function login_validation(){

		$this->load->library('form_validation');

		$this->form_validation->set_rules('email','Email','
			required|trim|xss_clean|callback_validate_credientials');
		//'email' is the input form name, while 'Email' is the name when the web gives
		//feedback on login information
		$this->form_validation->set_rules('password','Password','required|md5|trim');
 
		if ($this->form_validation->run()){
			//if the username/password pass the validation test
			
			// ---------------------------------
			// Check if admin
			// ---------------------------------
			
			// load the model
			$this->load->model('model_users');
			
			// get the username from the form
			$adminDataIn['username'] = $this->input->post('email');
			
			// run query to check if user is admin
			$adminData['username'] = $this->model_users->getAdmin($adminDataIn);
			
			// run query to get the user's uid
			$adminData['uid'] = $this->model_users->getUid($adminDataIn);
			
			if ($adminData['username']->num_rows() > 0) {
				// the user exists and is an admin
				$data=array(
				'email'=>$this->input->post('email'),
				'uid' => $adminData['uid'],
				'is_logged_in'=>1,
				'admin'=>1
				);
			} else {
				// the user is not an admin
				$data=array(
				'email'=>$this->input->post('email'),
				'uid' => $adminData['uid'],
				'is_logged_in'=>1,
				);
			}
			
			// original code (Ye)
			/*
			$data=array(
				'email'=>$this->input->post('email'),
				'is_logged_in'=>1
				);
			**/
			
			$this->session->set_userdata($data);
			//session is constructed with the input form name 'email'

			//redirect ('index.php/welcome');
			redirect ('home');
			//$this->load->view('home_view');
		} else{
			
			$this->load->view('pleaseLogin');
			//if the validation test failed, redirect to the 'restricted page'
		}

	}
	
	public function members(){
		if($this->session->userdata('is_logged_in')){
			redirect ('index.php/welcome');
		}else{
			$this->load->view('pleaseLogin');
		}
		
	}


	public function restricted(){
		$this->load->view('pleaseLogin');
	}



	public function validate_credientials(){
		$this->load->model('model_users');

		if($this->model_users->can_log_in()){
			return true;
			// connect to the database to validate the username and password 
		}	else{
			$this->form_validation-> set_message('validate_credientials','Incorect 
				username/password');
			return false;
		}
	}

	public function logout(){
		
		$this->session->sess_destroy();
		//destroy the session when logout

		//redirect('index.php/main/login');
		redirect(base_url());
	}


	public function signup() {
        
        $this->load->view('signup');
		// this page redirects to the sign up page but does not pass any info
	}

	public function signup_validation(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','Email','required|
			trim|valid_email|is_unique[User.username]');

		//input form 'email' must be an valid email address, moreover, it cannot occur
		//in the database

		$this->form_validation->set_rules('password','Password','required|
			trim');

		$this->form_validation->set_rules('cpassword','Confirm Password','required|
			trim|matches[password]');
		$this->form_validation->set_rules('fn','First Name','required|
			trim');
		$this->form_validation->set_rules('ln','Last Name','required|
			trim');

		$this->form_validation->set_message('is_unique','That email address already exists.');
		//override the default meaningless error message

		if($this->form_validation->run()){
			
			//generate a random key
			$key=md5(uniqid());
			//send an email to the user
			
			$this->load->model('model_users');
			$message="<p> Thank you for signing up!</p>";
			$message.="<p><a href='".base_url()."index.php/main/register_user/$key' 
			> Click here </a>to confirm your account</p>";

			
				// add them to the database
			if ($this->model_users->add_user($key)){
			
				echo $message;				
					

			}else{
				echo "Problem adding to database";
			}
		}
			
			
		else{
			
			$this->load->view('signup');
		}
	
	}

	public function register_user($key){

		$this->load->model('model_users');

		if ($this->model_users->is_key_valid($key)){
			
			if($newemail=$this->model_users->add_permanent_user($key)){
				
				// pass in the email
				$adminDataIn['username'] = $newemail;
				
				// run query to get the user's uid
				$uid = $this->model_users->getUid($adminDataIn);
				
				$data=array(
					'uid' => $uid,
					'email'=>$newemail,
					'is_logged_in'=>true);
				$this->session->set_userdata($data);
				redirect('/profile');	

				echo 'success';}else{
					echo "failed, please try again";
			}
		
		}else{
			echo "invalid key";
		}
	}

    //all the function/pages below need to check if the user is logged in yet;if they are not logged in
	//redirect to the restricted view 
	}
	


