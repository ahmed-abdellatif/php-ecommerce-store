<?php
class paypalcheckout {

//==> Class Variables <==/
public $business;
public $currency;
public $cursymbol;
public $location;
public $returnurl;
public $returntxt;
public $cancelurl;
public $items;

//=======================================================================//
//==> Class constructor, with default settings that can be overridden <==//
//=======================================================================//
public function __construct($config=""){

//default settings
$settings = array(
'business' => 'almandinedesign@outlook.com', //paypal - merchant email address
'currency' => 'USD',                       //paypal currency
'cursymbol'=> '&#36;',                   //currency symbol
'location' => 'USA',                        //location code  (ex GB)
'returnurl'=> 'https://almandinedesign.com/thankyou.php',// page when transaction is done.
'returntxt'=> 'Return to the awesome site',         //What is written on the return button in paypal
'cancelurl'=> 'https://almandinedesign.com/cancelled.php',//Where to go if the user cancels.
'shipping' => 0,                           //Shipping Cost
'custom'   => ''                           //Custom attribute
);

	//overrride default settings
	if(!empty($config)){
		foreach($config as $key=>$val){
			if(!empty($val)){ $settings[$key] = $val; }
		}
	}

	//Set the class attributes
	$this->business  = $settings['business'];
	$this->currency  = $settings['currency'];
	$this->cursymbol = $settings['cursymbol'];
	$this->location  = $settings['location'];
	$this->returnurl = $settings['returnurl'];
	$this->returntxt = $settings['returntxt'];
	$this->cancelurl = $settings['cancelurl'];
	$this->shipping  = $settings['shipping'];
	$this->custom    = $settings['custom'];
	$this->items = array();
}

	// add one item to cart
	public function addSimpleItem($item){
		if( //Check the quantity and the name
		!empty($item['quantity'])
		&& is_numeric($item['quantity'])
		&& $item['quantity']>0
		&& !empty($item['name'])
		){ //And add the item to the cart if it is correct
			$items = $this->items;
			$items[] = $item;
			$this->items = $items;
		}
	}


	// add items to the cart
	public function addMultipleItems($items){
		if(!empty($items)){
			foreach($items as $item){ //lopp through the items
				$this->addSimpleItem($item);  //And add them 1 by 1
			}
		}
	}

	// place order form
	public function getCheckoutForm(){

		$form='
		<form id="paypal_checkout" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">';

		//==> Variables defining a cart, there shouldn't be a need to change those <==//
		$form.='
		<input type="hidden" name="cmd" value="_cart" />
		<input type="hidden" name="upload" value="1" />
		<input type="hidden" name="no_note" value="0" />
		<input type="hidden" name="bn" value="PP-BuyNowBF" />
		<input type="hidden" name="tax" value="0" />
		<input type="hidden" name="rm" value="2" />';

		//==> Personnalised variables, they get their values from the specified settings nd the class attributes <==//
		$form.='
		<input type="hidden" name="business" value="'.$this->business.'" />
		<input type="hidden" name="handling_cart" value="'.$this->shipping.'" />
		<input type="hidden" name="currency_code" value="'.$this->currency.'" />
		<input type="hidden" name="lc" value="'.$this->location.'" />
		<input type="hidden" name="return" value="'.$this->returnurl.'" />
		<input type="hidden" name="cbt" value="'.$this->returntxt.'" />
		<input type="hidden" name="cancel_return" value="'.$this->cancelurl.'" />
		<input type="hidden" name="custom" value="'.$this->custom.'" />';

		//==> The items of the cart <==//
		$cpt=1;
		if(!empty($this->items)){foreach($this->items as $item){
		$shipping=isset($item['shipping']) ? $item['shipping'] : "";
		$form.='
		<div id="item_'.$cpt.'" class="itemwrap">
		<input type="hidden" name="item_name_'.$cpt.'" value="'.$item['name'].'" />
		<input type="hidden" name="quantity_'.$cpt.'" value="'.$item['quantity'].'" />
		<input type="hidden" name="amount_'.$cpt.'" value="'.$item['price'].'" />
		<input type="hidden" name="shipping_'.$cpt.'" value="'.$shipping.'" />
		</div>';
		$cpt++;
		}}

		//==> The submit button, (you can specify here your own button) <==//
		$form.='
		<input id="ppcheckoutbtn" type="submit" value="Checkout" class="btn btn-success" />
		</form>';

		return $form;
	}
}


?>
