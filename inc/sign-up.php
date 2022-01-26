<?php

/*

HOOKS


woocommerce_register_form
woocommerce_register_form_end	
woocommerce_register_form_start
woocommerce_register_form_tag


https://docs.woocommerce.com/wc-apidocs/hook-docs.html

https://www.cloudways.com/blog/add-woocommerce-registration-form-fields/

https://www.cssigniter.com/how-to-add-custom-fields-to-the-wordpress-registration-form/


*/

function formulario_registro_adaptado() {?>

		<p class="form-row form-row-first">
			
			<label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
			
			<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
		
		</p>
	   
		<p class="form-row form-row-last">
			
			<label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
			
			<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
			
		</p>
		
		
		<!-- 
		<p class="form-row form-row-wide">
	   
			<label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?><span class="required">*</span></label>
			
			<input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_phone'] ); ?>" />
      
		</p>
		-->
		
		   
		<div class="clear"></div>
		
		<p class="form-row form-row-wide">
	   
			<label for="user_mascota">¿ Cómo se llama tu mascota ?</label>
			
			<input type="text" class="input-text" name="user_mascota" id="user_mascota" value="<?php if ( ! empty( $_POST['user_mascota'] ) ) esc_attr_e( $_POST['user_mascota'] ); ?>" />
      
		</p>
		
		<p class="form-row form-row-wide">
	   
			<label for="user_mascota_birth_date">¿ En qué fecha nació tu mascota ?</label>
			
			<input type="date" class="input-date" name="user_mascota_birth_date" id="user_mascota_birth_date" value="<?php if ( ! empty( $_POST['user_mascota_birth_date'] ) ) esc_attr_e( $_POST['user_mascota_birth_date'] ); ?>" min="2000-01-01" max="<?php echo date("Y-m-d")?>"/>
      
		</p>
	   
 <?php }
 

function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) 
{
	if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
		
		 $validation_errors->add( 'billing_first_name_error','Necesitamos tu nombre para poder registrarte en cada operación. Muchas gracias por entender.'  );
		 
	}
	
	if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
		
		 $validation_errors->add( 'billing_last_name_error', 'Necesitamos tu Apellido para poder contactarte en caso que sea conveniente. Muchas gracias por entender.' );
		 
	}
	
	/*
	if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {
		
		 $validation_errors->add( 'billing_phone_error', 'Necesitamos tu teléfono para poder contactarte en el caso que sea conveniente. Muchas gracias por entender.' );
		 
	}
	
	if ( isset( $_POST['user_mascota'] ) && empty( $_POST['user_mascota'] ) ) {
		
		$validation_errors->add( 'user_mascota_error', 'Dejanos el nombre de tu mascota, por favor.');
		
	}
	
	if ( isset( $_POST['user_mascota_birth_date'] ) && empty( $_POST['user_mascota_birth_date'] ) ) {
		
		$validation_errors->add( 'user_mascota_birth_date_error', 'Dejanos la fecha de cumpleaños de tu mascota, por favor.' );
		
	}
	*/
	
	return $validation_errors;
	
}


function wooc_save_extra_register_fields( $customer_id ) 
{
    
	if ( isset( $_POST['billing_first_name'] ) ) {
		
		 //First name field which is by default
		 update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
		 // First name field which is used in WooCommerce
		 update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
		 
	}

	if ( isset( $_POST['billing_last_name'] ) ) {
		
		 // Last name field which is by default
		 update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
		 // Last name field which is used in WooCommerce
		 update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
		 
	}
	
	if ( isset( $_POST['billing_phone'] ) ) {
		
			 // Phone input filed which is used in WooCommerce
			 update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
			 
	}
	 
	if ( isset( $_POST['user_mascota'] ) ) {
		
		update_user_meta( $customer_id, 'user_mascota', sanitize_text_field( $_POST['user_mascota'] ) );
		
	}
	
	
	if ( isset( $_POST['user_mascota_birth_date'] ) ) {
		
		update_user_meta( $customer_id, 'user_mascota_birth_date', sanitize_text_field( $_POST['user_mascota_birth_date'] ) );
		
	}
	
	  
}

add_action( 'woocommerce_register_form', 'formulario_registro_adaptado' );
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );


function formulario_login_adaptado() {

	?>

<script>

	window.fbAsyncInit = function() {
		FB.init({
		appId      : '842968169733316',
		cookie     : true,
		xfbml      : true,
		version    : '1.0'
		});
		
		FB.AppEvents.logPageView();   
		
	};

	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "https://connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	</script>

	<fb:login-button 
	scope="public_profile,email"
	onlogin="checkLoginState();">
	</fb:login-button>

	<p class="form-row form-row-first"></p>
	
	<?php
	
};      

//add_action( 'woocommerce_login_form', 'formulario_login_adaptado', 10, 0 ); 