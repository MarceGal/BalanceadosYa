<?php
/**
 * MANEJAR METODOS DE PAGO SEGUN REGIÓN DE ENVIO
 * VILLAGUAY NO INCORPORA COD
 *
 * CODIGOS DE METODOS DE PAGO
 * 
 * cod  -> Cash on Delivery -> Pago contrarembolso  
 * bacs -> Direct Bank Transfer -> Pago transferencia bancaria
 * https://docs.woocommerce.com/documentation/plugins/woocommerce/getting-started/sell-products/core-payment-options/ 
 * 
 */

function conditional_hiding_payment_gateway($available_gateways) {

  	
	if(is_null(WC()->session)) return false;	

	//var_dump(WC()->session);

	$_customer = WC()->session->get('customer'); 
	
	$_postcode  = $_customer['postcode'];

	$_chosen_payment_method = WC()->session->get('chosen_payment_method');

	// mostrar_detalles($_chosen_payment_method);
	
	if( $_postcode == VILLAGUAY_POSTCODE || $_postcode == LARROQUE_POSTCODE){
		
		// Larroque y Villaguay no cuentan con  "Pago contrarembolso / al recibir"  

		unset($available_gateways['cod']);

	} else {
		
		// Desabilitamos "Pago por transferencia bancaria" en todos  exepto  en  Larroque y Villaguay 	
		// unset($available_gateways['bacs']);
	}

    return $available_gateways;

}

add_filter('woocommerce_available_payment_gateways', 'conditional_hiding_payment_gateway', 1, 1);
