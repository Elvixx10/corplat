<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');
     
class Payment extends REST_Controller {
	private $login;
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
//        $this->load->library('GatewayPayment');
       $this->setLogin($this->gatewaypayment->executeEpayco());
    }
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
	public function token_post(){
		//TODO: required parameters validation
		$cNumber = $this->input->post('number'); 
		$cExpYear =  $this->input->post('year'); 
		$cExpMonth = $this->input->post('month'); 
		$cvc =$this->input->post('cvc');
		
		$token = $this->gatewaypayment->createToken($this->getLogin(), $cNumber, $cExpYear, $cExpMonth, $cvc);
		$this->response(array('token' => $token->id, 'json' => $token), REST_Controller::HTTP_OK);
	}
    
	public function customer_post(){
		//TODO: required parameters validation
		$token = $this->input->post('token');
		$name = $this->input->post('name');
		$lastName=$this->input->post('lastname');
		$email = $this->input->post('email'); 
		$city = $this->input->post('city');
		$address= $this->input->post('address'); 
		$phone= $this->input->post('phone'); 
		$cell_phone = $this->input->post('cellphone');
		
		$customer = $this->gatewaypayment->createCustomer($this->getLogin(), $token, $name, $lastName, $email, $city,
				$address, $phone, $cell_phone);
		
		$this->response(array('customer' => $customer, 'id'=>$customer->data->customerId), REST_Controller::HTTP_OK);
	}
	
	
	/*
	 * getter and setter
	 */
	public function setLogin($login) {
		$this->login = $login;
	}
	
	public function getLogin() {
		return $this->login;
	}
}