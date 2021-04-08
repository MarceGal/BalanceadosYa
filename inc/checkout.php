<?php
	
/**
 * ADAPTAMOS EL FORMULARIO DE FACTURACIÓN 
 */

function antes_datos_facturacion( $checkout ) {

    echo '<div id="my_custom_checkout_field"><h2>' ."Antes de datos de facturación". '</h2>';

		woocommerce_form_field( 'my_field_name', array(
		'type'          => 'text',
		'class'         => array('my-field-class form-row-wide'),
		'label'         => __('Fill in this field'),
		'placeholder'   => __('Enter something'),
		'data-priority' => 30,
		));

    echo '</div>';

}

//add_action( 'woocommerce_checkout_billing', 'antes_datos_facturacion' );

/**
 * ADAPTAMOS EL FORMULARIO DE FACTURACIÓN 
 */

function sobrescribir_formulario_facturacion( $fields ) 
{
		
	$fields['billing_first_name']['class'] = array( 'form-row-wide' );	
	$fields['billing_last_name']['label'] = "Apellido";
	$fields['billing_last_name']['class'] = array( 'form-row-wide' );	
	
	//Pais
		
	//unset($fields['billing_country']);
		
	//CUIT
	
	$fields['billing_company']['label'] = 'CUIT';//'Razón social';
	$fields['billing_company']['placeholder'] = '##-########-#';//'Razón social';
	
	
	//Direcciones
	
	$fields['billing_address_1']['label'] = 'Dirección';
	$fields['billing_address_1']['placeholder'] = 'Calle y número';	
	//
	 
	$fields['billing_address_2']['label'] = 'Piso, Depto.';
	$fields['billing_address_2']['placeholder'] = '';
	
	
	$fields['billing_address_1']['class'] = array( 'form-row-wide' );	
	//$fields['billing_address_2']['class'] = array( 'form-row-wide' );
	
	
	//Ciudad
		
	$fields['billing_city']['label'] = 'Ciudad';
	$fields['billing_city']['default'] = 'Gualeguaychú';
	
	
	$fields['billing_city'] =  array(
		'label'     => 'Ciudad',
		'placeholder'   => 'Ciudad',
		'required'  => true,
		'clear'     => true,
		'type' => 'select',
		'class' => array( 'form-row-wide' ),
		'options' => array(
			'' => 'Seleccioná tu ciudad',
			'2820' => 'Gualeguaychú',
			'2852' => 'Pueblo Belgrano',
			'3260' => 'Concepción del Uruguay',
			'3240' => 'Villaguay',
			'2854' => 'Larroque',
		),
		'default' => '2820'
	);	
	
	//Provincia
		
	$fields['billing_state']['label'] = 'Provincia';
	$fields['billing_state']['default'] = 'E';
	
	//Código Postal
	
	$fields['billing_postcode']['default'] = '2820';
		
	//Teléfono
	
	$fields['billing_phone']['label'] = 'Teléfono (Whatsapp)';
	$fields['billing_phone']['placeholder'] = 'Ej: 03446-######';
	
	
	return $fields;
	
	
}

add_filter( 'woocommerce_billing_fields', 'sobrescribir_formulario_facturacion',10);

/**
 * FORMULARIO DE FACTURACIÓN 
 * MODIFICAMOS CAMPO DIRECCIÓN
 */

function custom_override_default_address_fields( $fields ) 
{
     
	//Direcciones
	$fields['address_1']['label'] = 'Dirección';
	$fields['address_1']['placeholder'] = 'Calle y número';	
	 
	$fields['address_2']['label'] = 'Piso, Depto.';
	$fields['address_2']['placeholder'] = '';	

    return $fields;
}

add_filter( 'woocommerce_default_address_fields' , 'custom_override_default_address_fields',10 );

/**
 * FORMULARIO DE FACTURACIÓN 
 * AGREGAMOS TURNOS Y FRANJAS HORARIAS
 */

function sobrescribir_formulario_locacion( $fields ) {
	
	
	$opcions = array(
		'7' => '07:00',
		'8' => '08:00',
		'9' => '09:00',
		'10' => '10:00',
		'11' => '11:00',
		'12' => '12:00',
		'13' => '13:00',
		'14' => '14:00',
		'15' => '15:00',
		'16' => '16:00',
		'17' => '17:00',
		'18' => '18:00',
		'19' => '19:00',
		'20' => '20:00'
	);


	/*
	$fields['shipping']['options'] = array(
		'label'     => 'CUIT',
		'placeholder'   => 'CUIT',
		'required'  => false,
		'clear'     => true,
		'type' => 'input',
		'class' => array( 'form-row-wide' ),
		'data-priority' => 3,
		'default' => ''
	);
	*/
	
	$fields['order']['shipping_turno'] =  array(
		'label'     => 'Turno de entrega',
		'placeholder'   => 'Turno',
		'required'  => false,
		'clear'     => true,
		'type' => 'select',
		'class' => array( 'form-row-wide' ),
		'options' => array(
			'' => 'Seleccioná un turno para tu entrega',
			'Mañana' => 'Mañana',
			'Tarde' => 'Tarde',
		),
		'default' => ''
	);
	
	$fields['order']['shipping_franja-horaria-desde'] =  array(
		'label'     => 'Desde',
		'placeholder'   => '',
		'required'  => false,
		'clear'     => false,
		'custom_attributes' => array('disabled' =>'disabled', 'readonly'=> 'true' ),
		'type' => 'select',
		'options' => $opcions,
		'default' => '0'
	);	
	
	$fields['order']['shipping_franja-horaria-hasta'] =  array(
		'label'     => 'Hasta',
		'placeholder'   => '',
		'required'  => false,
		'clear'     => false,
		'custom_attributes' => array('disabled' =>'disabled', 'readonly'=> 'true' ),
		'type' => 'select',
		'options' => $opcions,
		'default' => '12'
	);	
	
	$fields['order']['order_comments']['label'] = 'Comentarios:';
	$fields['order']['order_comments']['placeholder'] = '¿Tenés alguna consideración que querés que tengamos presente al momento de la entrega en tu domicilio?';
    $fields['order']['order_comments']['required'] = false;
		
	return $fields;
}


add_filter( 'woocommerce_checkout_fields' , 'sobrescribir_formulario_locacion');


/**
 * FORMULARIO DE FACTURACIÓN 
 * Chequeamos si podemos enviar a la zona.
 */

function my_custom_checkout_field_process() {
    
	
	
	$_POST['billing_state'] = sanitize_text_field($_POST['billing_state']);
	$_POST['billing_city'] = sanitize_text_field($_POST['billing_city']);
	
	$ppc = sanitize_text_field($_POST['billing_postcode']);
	
	if ( isset( $ppc ) && !empty( $ppc) )	{

		if( ($ppc == "2820") || ($ppc == "3260") || ($ppc == "2852")) {

			if ( isset( $_POST['shipping_turno'] ) && empty( $_POST['shipping_turno']  )) {			

				$ntc .= "😺 ¿En qué momento podemos dejarte el envío?. 👇 Buscá el campo \"Turno de entrega\" y completálo." ;
				wc_add_notice( $ntc, 'error' );						

			}
		}
	}

	if ( isset( $_POST['billing_state'] ) &&
		! empty( $_POST['billing_state']) &&
		$_POST['billing_state'] !='E') {
		$ntc .= "😿 Lamentablemente no tenemos cobertura en tu provincia. ";
		$ntc .= " 😺 Recuerdá que solo entregamos en la ciudad de Gualeguaychú.";
		wc_add_notice( $ntc, 'error' );
	
	}
	
	/*
	if ( isset( $_POST['billing_city'] ) &&
		! empty( $_POST['billing_city']) &&
		$_POST['billing_city'] !='Gualeguaychú') {
		$ntc .= "Lamentablemente no tenemos cobertura en tu ciudad. ";
		$ntc .= "Recuerdá que solo entregamos en la ciudad de Gualeguaychú";
		wc_add_notice( $ntc, 'error' );
	
	}
	*/	
	
}

add_action( 'woocommerce_checkout_process', 'my_custom_checkout_field_process');

/**
 * ACTUALIZACIÓN DE USUARIO
 * NOMBRE DE MASCOTA
 * FECHA DE NACIMIENTO DE MASCOTA
 * TURNO
 * FRANJA HORARIA
 */
 
function actualizar_info_usuario( $order_id ) 
{
   
	global $current_user; 
	
	//var_dump($_POST);
	
	$meta = get_user_meta( $current_user->ID );
	
	if ( isset( $_POST['user_mascota'] ) &&  ! empty( $_POST['user_mascota']  )) {
	
		update_user_meta( $current_user->ID, 'user_mascota', sanitize_text_field( $_POST['user_mascota'] ) );
	
	}
		
	if ( isset( $_POST['user_mascota_birth_date'] ) &&  ! empty( $_POST['user_mascota_birth_date']  )) {
		
		update_user_meta( $current_user->ID, 'user_mascota_birth_date', sanitize_text_field( $_POST['user_mascota_birth_date'] ) );
	}
	
	
	if ( isset( $_POST['shipping_turno'] ) &&  ! empty( $_POST['shipping_turno']  )) {
		
		update_post_meta( $order_id,'shipping_turno', sanitize_text_field( $_POST['shipping_turno'] ) );
		
		if ( isset( $_POST['shipping_franja-horaria-desde'] ) &&  ! empty( $_POST['shipping_franja-horaria-desde']  )) {
		
			update_post_meta( $order_id, 'shipping_franja-horaria-desde', sanitize_text_field( $_POST['shipping_franja-horaria-desde'] ) );
			
		}
		
		if ( isset( $_POST['shipping_franja-horaria-hasta'] ) &&  ! empty( $_POST['shipping_franja-horaria-hasta']  )) {
			
			update_post_meta( $order_id, 'shipping_franja-horaria-hasta', sanitize_text_field( $_POST['shipping_franja-horaria-hasta'] ) );
			
		}
	}
	
}

add_action( 'woocommerce_checkout_update_order_meta', 'actualizar_info_usuario' );

/*
 * ACTUALIZACIÓN DE NIVEL POR COMPRAS
 * 
 * Cuando se cambia la orden a completada, 
 * evaluamos cuantas ordenes ha completado. 
 * 
 * 
 * - Si el usuario tiene más de 5 compras subimos su nivel a "Cliente Nivel 1"
 * - Si el usuario tiene más de 10 compras subimos su nivel "Cliente Nivel 2"
 * 
 */
 
function despues_de_orden_completada($order_id) 
{
	
	$order = new WC_Order( $order_id );
	$user_id = $order->get_user_id();
	$customer_orders = wc_get_customer_order_count($user_id );
	
	//mailMarce('$customer_orders:'.$customer_orders);
	// Si el usuario tiene más de 5 compras podemos cambiar su nivel

	if ( $customer_orders > 5 ) {
		
        //consultamos el usuario a la ddbb
		$user = new WP_User( $user_id );		

		// Consultamos los roles del usuario.
		$user_roles = $user->roles;
		
		/*
	
		if ( in_array( 'customer', $user_roles, true ) ) {
			
			// el usuario es un cliente 
		
		} elseif ( in_array( 'shop_manager', $user_roles, true ) ) {
			
			// el usuario es un Administrador de tienda
		
		} elseif ( in_array( 'distributor', $user_roles, true ) ) {
			
			// el usuario es un Distribuidor
		
		} elseif ( in_array( 'featured_client', $user_roles, true) ) {
			
			// el usuario es un Cliente destacado
		} 
		
		*/

		switch ($customer_orders){

			case $customer_orders > 5;

				// Subimos el nivel de cliente.		

				if ( in_array( 'customer', $user_roles, true ) ) {
					
					// Sacamos el rol  "customer"
					$user->remove_role( 'customer' ); 
					
					// Asignamos el role "Cliente Nivel 1"
 					$user->add_role( 'client_level_1' );
				
				} 
				
				break;
	
			case $customer_orders > 10;

				// Subimos el nivel de cliente.	

				if ( in_array( 'client_level_1', $user_roles, true ) ) {
					
					// Sacamos el rol  "client_level_1"
					$user->remove_role( 'client_level_1' ); 
					
					// Asignamos el role "Cliente Nivel 2"
 					$user->add_role( 'client_level_2' );
				
				} 

				break;
				
			default:
				break;

		}
		
		//mailMarce(serialize($user));
		
	}
	
	
}

add_action( 'woocommerce_order_status_completed', 'despues_de_orden_completada' );
 
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

  	
	$_customer = WC()->session->get('customer'); 
	
	$_postcode  = $_customer['postcode'];

	$_chosen_payment_method = WC()->session->get('chosen_payment_method');

	// mostrar_detalles($_chosen_payment_method);

	// VILLAGUAY
	
	if( $_postcode == VILLAGUAY_POSTCODE  || $_postcode == LARROQUE_POSTCODE){

		unset($available_gateways['cod']);

	}else{
		
		unset($available_gateways['bacs']);
		
	}

    return $available_gateways;

}

add_filter('woocommerce_available_payment_gateways', 'conditional_hiding_payment_gateway', 1, 1);

/**
 * INSPECCIONAR E IMPRIMIR.
 */

function mostrar_detalles($objeto = null)
{
	if ( !empty( $objeto) ){
		var_dump($objeto); 
		return false;
	}	
	var_dump(WC()->session);
}

// add_filter( 'woocommerce_review_order_after_payment', 'mostrar_detalles', 100 );

/**
 * FUNCIÓN EN DESUSO
 */

function refresh_payment_methods(){

    // jQuery code
	
    ?>

<script type="text/javascript">
(function($) {
    $('form.checkout').on('change', 'input[name^="payment_method"]', function() {
        $('body').trigger('update_checkout');
    });
})(jQuery);
</script>

<?php

}

// add_action( 'woocommerce_review_order_before_payment', 'refresh_payment_methods' );

/**
 * FUNCIÓN EN DESUSO
 */

function despues_datos_adicionales( $checkout ) {
	
	global $current_user; 
 
	$meta = get_user_meta( $current_user->ID );
	
	//var_dump( $meta );
	
	echo '<div id="additional_checkout_field"><h2>Información adicional</h2>';
 
		woocommerce_form_field( 'user_mascota', array(
			'type'          => 'text',
			'class'         => array('my-field-class form-row-wide'),
			'label'         => 'Mascota',
			'required'      => false,
			'placeholder'   => '¿ Cómo se llama tu mascota ?',
			),$meta ['user_mascota'][0]
		);		
		
		woocommerce_form_field( 'user_mascota_birth_date', array(
			'type'          => 'date',
			'class'         => array('my-field-class form-row-wide'),
			'label'         => '¿ En qué fecha nació tu mascota ?',
			'required'      => false,
			'min'   => '2000-01-01',
			'max'   => date("Y-m-d"),
			),$meta ['user_mascota_birth_date'][0]
		);
 
    echo '</div>';
 
}

//add_action( 'woocommerce_after_order_notes', 'despues_datos_adicionales' );

/**
 * FUNCIÓN EN DESUSO
 */

function validación_personalizada( $fields, $errors ){
 
	// if any validation errors
	if( !empty( $errors->get_error_codes() ) ) {
 
		// remove all of them
		foreach( $errors->get_error_codes() as $code ) {
			$errors->remove( $code );
		}
 
		// add our custom one
		$errors->add( 'validation', '👇 Necesitamos que completes los campos en rojo para procesar tu pedido' );
 
	}
 
}

//add_action( 'woocommerce_after_checkout_validation', 'validación_personalizada', 9999, 2);


/**
 * FUNCIÓN EN DESUSO
 */

function mostrar_detalles_de_shipping() 
{
	
	$temp = ''; 

	$cart_subtotal             = WC()->cart->subtotal; // No need to remove the fee	
	$shipping_methods = array();
	$chosen_shipping_method_id = WC()->session->get( 'chosen_shipping_methods' )[0];

	foreach ( WC()->cart->get_shipping_packages() as $package_id => $package ) {
		// Check if a shipping for the current package exist
		if ( WC()->session->__isset( 'shipping_for_package_'.$package_id ) ) {
			// Loop through shipping rates for the current package
			
			foreach ( WC()->session->get( 'shipping_for_package_'.$package_id )['rates'] as $shipping_method  ) {

				/*
				$rate_id     = $shipping_method->get_id(); // same thing that $shipping_rate_id variable (combination of the shipping method and instance ID)
				$method_id   = $shipping_method->get_method_id(); // The shipping method slug
				$instance_id = $shipping_method->get_instance_id(); // The instance ID
				$label_name  = $shipping_method->get_label(); // The label name of the method
				$cost        = $shipping_method->get_cost(); // The cost without tax
				$tax_cost    = $shipping_method->get_shipping_tax(); // The tax cost
				$taxes       = $shipping_method->get_taxes(); // The taxes details (array)

				print($shipping_id->get_id().'<br>');
				
				*/

				array_push(	$shipping_methods, $shipping_method);

			}
			
		}
	}

	//print_r(count($shipping_methods));
	
	if ( empty( $chosen_shipping_method_id) ){

		return true;

	}	
	
	$chosen_shipping_method    = explode(':', $chosen_shipping_method_id)[0];
		
	$temp .= '{cart_subtotal: '.$cart_subtotal.'}</br>'; 
	$temp .= '{chosen_shipping_method: '.$chosen_shipping_method.'}</br>'; 

	// Si el metodo es "Envio gratuito" y tengo más de un metodo alternativo, muestro la leyenda.

	if ($chosen_shipping_method === "free_shipping" && count($shipping_methods)>1 ) {
	
		//echo '<tr class="shipping info"><td data-title="Delivery info" colspan="2">'.$temp.'</td></tr>';
		
		echo "<script type='text/javascript'> ( 
			function($) { 
				try {
					mostrar_leyenda_puntos_de_entrega();
				} catch (error) {
					//console.log(error); 
				}
			}
		)(jQuery); 
		</script>";
		
	}

	return true;

}

add_action( 'woocommerce_review_order_after_shipping', 'mostrar_detalles_de_shipping', 20 );


/**
 * FUNCIÓN EN DESUSO
 * Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 * https://docs.woocommerce.com/document/hide-other-shipping-methods-when-free-shipping-is-available/
 * @param array $rates Array of rates found for the package.
 * @return array
 */

function esconder_otros_metodos_cuando_hay_free_shipping( $rates )
{
	
	$session_customer = WC()->session->get('customer'); 
	
	$customer_postcode = $session_customer['postcode'];

	if ( !isset( $customer_postcode ) || empty( $customer_postcode) ) 
	{
		return $rates;
	}
	
	
	if($customer_postcode == VILLAGUAY_POSTCODE || $customer_postcode== LARROQUE_POSTCODE){

		$free = array();

		foreach ( $rates as $rate_id => $rate ) {
			if ( 'free_shipping' === $rate->method_id ) {
				$free[ $rate_id ] = $rate;
				break;
			}
		}

		return ! empty( $free ) ? $free : $rates;


	}
	
	return $rates;
	
}

add_filter( 'woocommerce_package_rates', 'esconder_otros_metodos_cuando_hay_free_shipping', 100 );


//https://www.skyverge.com/blog/how-to-add-a-custom-woocommerce-email/

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

/*

LECTURA RECOMENDADA

https://www.tychesoftwares.com/woocommerce-checkout-page-hooks-visual-guide-with-code-snippets/

https://www.wpdesk.net/blog/woocommerce-cart-hooks/

https://www.tychesoftwares.com/woocommerce-cart-page-hooks-visual-guide-with-code-examples/

https://docs.woocommerce.com/document/tutorial-customising-checkout-fields-using-actions-and-filters

https://hollerwp.com/customize-woocommerce-checkout-page/

https://www.cloudways.com/blog/custom-field-woocommerce-checkout-page/#WooCommerce-Checkout-Manager

*/