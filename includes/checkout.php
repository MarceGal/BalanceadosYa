<?php

/*

https://docs.woocommerce.com/document/tutorial-customising-checkout-fields-using-actions-and-filters

https://hollerwp.com/customize-woocommerce-checkout-page/

https://wordpress.org/plugins/woocommerce-checkout-manager/

https://www.cloudways.com/blog/custom-field-woocommerce-checkout-page/#WooCommerce-Checkout-Manager

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
			'3260' => 'Concepción del Uruguay',
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

function custom_override_default_address_fields( $fields ) 
{
     
	//Direcciones
	$fields['address_1']['label'] = 'Dirección';
	$fields['address_1']['placeholder'] = 'Calle y número';	
	 
	$fields['address_2']['label'] = 'Piso, Depto.';
	$fields['address_2']['placeholder'] = '';	

    return $fields;
}

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
		'required'  => true,
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


function my_custom_checkout_field_process() {
    
	
	// Chequeamos si podemos enviar a la zona.
	
	$_POST['billing_state'] = sanitize_text_field($_POST['billing_state']);
	$_POST['billing_city'] = sanitize_text_field($_POST['billing_city']);
	$_POST['billing_postcode'] = sanitize_text_field($_POST['billing_postcode']);
	
	
	if ( isset( $_POST['billing_state'] ) &&
		! empty( $_POST['billing_state']) &&
		$_POST['billing_state'] !='E') {
		$ntc .= "😿 Lamentablemente no tenemos cobertura en tu provincia. ";
		$ntc .= " 😺 Recuerdá que solo entregamos en la ciudad de Gualeguaychú";
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
	
	/*
	if ( isset( $_POST['billing_postcode'] ) &&
		! empty( $_POST['billing_postcode']) &&
		$_POST['billing_postcode'] !="2820") {
		$ntc .= "El código postal es incorrecto. ";
		$ntc .= "Recuerdá que solo entregamos en la ciudad de Gualeguaychú";
		wc_add_notice( $ntc, 'error' );
	
	}
	*/	
	
}


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


//https://www.skyverge.com/blog/how-to-add-a-custom-woocommerce-email/

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

/*
 * Cuando se cambia la orden a completada, evaluamos cuantas ordenes ha completado. En el caso de tener más de 5 ordenes cambiamos su estatus de comprador.
 */
 
function despues_de_orden_completada($order_id) 
{
	
	$order = new WC_Order( $order_id );
	$user_id = $order->get_user_id();
	$customer_orders = wc_get_customer_order_count($user_id );
	
	//mailMarce('$customer_orders:'.$customer_orders);
	
	if ( $customer_orders > 5 ) {
		
        
		$user = new WP_User( $user_id );		

		// Get all the user roles for this user as an array.
		$user_roles = $user->roles;

		// Check if the specified role is present in the array.
		
		if ( in_array( 'customer', $user_roles, true ) ) {
			
			// el usuario es un Cliente
			
			// Remove role
			$user->remove_role( 'customer' ); 
			
			// Add role
			$user->add_role( 'featured_client' );
			
			//mailMarce(serialize($user));
		
		} 		
		
		/*
		
		elseif ( in_array( 'shop_manager', $user_roles, true ) ) {
			
			// el usuario es un Administrador de tienda
		
		} elseif ( in_array( 'distributor', $user_roles, true ) ) {
			
			// el usuario es un Distribuidor
		
		} elseif ( in_array( 'featured_client', $user_roles, true) ) {
			
			// el usuario es un Cliente destacado
		} 
		
		*/
		
    }
	
}
 
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


add_filter( 'woocommerce_billing_fields', 'sobrescribir_formulario_facturacion',10);

add_filter( 'woocommerce_default_address_fields' , 'custom_override_default_address_fields',10 );

add_filter( 'woocommerce_checkout_fields' , 'sobrescribir_formulario_locacion');

//add_action( 'woocommerce_after_checkout_validation', 'validación_personalizada', 9999, 2);

add_action( 'woocommerce_checkout_update_order_meta', 'actualizar_info_usuario' );

add_action( 'woocommerce_checkout_process', 'my_custom_checkout_field_process');

add_action( 'woocommerce_order_status_completed', 'despues_de_orden_completada' );

//add_action( 'woocommerce_after_order_notes', 'despues_datos_adicionales' );

//add_action( 'woocommerce_checkout_billing', 'antes_datos_facturacion' );