<?php 

class GatewayPayment {
	
	protected $CI;
	
	protected $publicKey = "7f80da31c8e0808f6ccc3bc362e2747a";
	protected $privateKey =  "88d12db7f24f9d265d3ec25082e6e06a";
	protected $default = true;
	
	// We'll use a constructor, as you can't directly call a function
	// from a property definition.
	public function __construct()
	{
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
	}
	
	public function executeEpayco() {
		$epayco = new Epayco\Epayco(array(
				"apiKey" => $this->publicKey,
				"privateKey" => $this->privateKey,
				"lenguage" => "ES",
				"test" => true
		));
		return $epayco;
	}
	
	public function createToken($epayco, $cNumber, $cExpYear, $cExpMonth, $cvc) {
		$token = $epayco->token->create(array(
				"card[number]" => $cNumber,
				"card[exp_year]" => $cExpYear,
				"card[exp_month]" => $cExpMonth,
				"card[cvc]" => $cvc
		));
		return $token;
	}
	
	public function createCustomer($epayco, $token, $name, $lastName=null, $email, $city = null,
			$address= null, $phone= null, $cell_phone = null) {
		$customer = $epayco->customer->create(array(
				"token_card" => $token,
				"name" => $name,
				"last_name" => $lastName, //This parameter is optional
				"email" => $email,
				"default" => $this->default,
				//Optional parameters: These parameters are important when validating the credit card transaction
				"city" => $city,
				"address" => $address,
				"phone" => $phone,
				"cell_phone"=> $cell_phone,
		));
		return $customer;
	}
}