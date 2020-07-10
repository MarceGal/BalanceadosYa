<?php

/*MOSTRAR INFORMACIÓN ADICIONAL EN EL PERFIL DE USUARIO DESDE VISTA DE ADMINISTRADOR*/

function BYA_mostrar_informacion_adicional_usuario( $user ) {
	
	?>
	
	<h3>Información adicional del cliente</h3>

	<table class="form-table">
		
		
		<tr>
			<th><label for="user_mascota">Mascota</label></th>
			
			<td>
				
				<?php //echo esc_html( get_the_author_meta( 'user_mascota', $user->ID ) ); ?>
			
				<input type="text" class="regular-text" name="user_mascota" id="user_mascota" value="<?php echo get_the_author_meta( 'user_mascota', $user->ID );?>" />
			
			</td>
		
		</tr>
		
		<tr>
			
			<th><label for="user_mascota">Fecha de nacimiento de mascota</label></th>
			
			<td>
				
				<input type="date" class="regular-text" name="user_mascota_birth_date" id="user_mascota_birth_date" value="<?php echo get_the_author_meta( 'user_mascota_birth_date', $user->ID );?>" />
			
			</td>
		
		</tr>
		
		
		<?php
		/*

		<tr>
			
			<th><label for="billing_myfield4">CUIT</label></th>
			
			<td>
			
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_myfield4" id="billing_myfield4" value="<?php echo get_the_author_meta( 'billing_myfield4', $user->ID );?>" />
			
			</td>
		
		</tr>
		
		*/
		?>

	</table>
	
	<?php
	
}

/*GUARDAR INFORMACIÓN ADICIONAL DESDE EL PERFIL DE USUARIO Y DESDE VISTA DE LA CUENTA DEL USUARIO EN WOO*/

function BYA_guardar_informacion_adicional_usuario( $user_id )
{
	if( isset( $_POST['user_mascota'] ) ) {
       
		update_user_meta( $user_id, 'user_mascota', sanitize_text_field( $_POST['user_mascota'] ) );
	}
	
	if( isset( $_POST['user_mascota_birth_date'] ) ) {
       
		update_user_meta( $user_id, 'user_mascota_birth_date', sanitize_text_field( $_POST['user_mascota_birth_date'] ) );
	}
	/*
	if( isset( $_POST['billing_myfield4'] ) ) {
       
		update_user_meta( $user_id, 'billing_myfield4', sanitize_text_field( $_POST['billing_myfield4'] ) );
	}
    */
}


add_action( 'show_user_profile', 'BYA_mostrar_informacion_adicional_usuario' );
add_action( 'edit_user_profile', 'BYA_mostrar_informacion_adicional_usuario' );
add_action( 'edit_user_profile_update', 'BYA_guardar_informacion_adicional_usuario', 12, 1 );
