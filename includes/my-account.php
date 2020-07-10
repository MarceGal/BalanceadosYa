<?php

/*

https://docs.woocommerce.com/wc-apidocs/hook-docs.html

https://stackoverflow.com/questions/38666414/how-to-disable-downloadable-product-functionality-in-woocommerce

https://martin.click/woocommerce/como-personalizar-la-pagina-de-mi-cuenta-en-woocommerce/

*/
 
/*BORRAR DESCARGABLES DEL PERFIL*/

function CM_woocommerce_account_menu_items_callback($items) {
    
	unset( $items['downloads'] );
    return $items;	
	
}

add_filter('woocommerce_account_menu_items', 'CM_woocommerce_account_menu_items_callback', 10, 1);


/*MOSTRAR INFORMACIÓN ADICIONAL EN EL PERFIL DE USUARIO DESDE VISTA DE USUARIO*/

function wooc_mostrar_info_adicional() {
	
    $user = wp_get_current_user();
	
    ?>
	
        <h3>Información adicional</h3>
		
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			
			<label for="user_mascota">Mascota</label>
			
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="user_mascota" id="user_mascota" value="<?php echo esc_attr( $user->user_mascota ); ?>" />
			
		
		</p>		
		
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			
			<label for="user_mascota">Fecha de nacimiento de tu mascota</label>
			
			<input type="date" class="woocommerce-Input woocommerce-Input--text input-text" name="user_mascota_birth_date" id="user_mascota_birth_date" value="<?php echo esc_attr( $user->user_mascota_birth_date ); ?>" />			
		
		</p>
		
		<!--
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			
			<label for="billing_myfield4">CUIT</label>
			
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_myfield4" id="billing_myfield4" value="<?php echo esc_attr( $user->billing_myfield4 ); ?>" />			
		
		</p>
		-->		
		
    <?php	


}

/* 
function update_account_address( $array ) {

	// Let's use a Switch statement to know which address we are updating
	switch ( $load_address ) {
		case 'billing':
			// Send billing info to Salesforce
			break;

		case 'shipping':
			// Send shipping info to Salesforce
			break;
	}
}
*/

add_action( 'woocommerce_edit_account_form', 'wooc_mostrar_info_adicional' );

add_action( 'woocommerce_save_account_details', 'BYA_guardar_informacion_adicional_usuario', 12, 1 );

// add_action( "woocommerce_after_edit_account_address_form",'update_account_address',1,2);





