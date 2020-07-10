<?php 


//*****************************************************
//**JETPACK********************************************
//*****************************************************

/*
https://jetpack.com/support/contact-form/
https://developer.wordpress.org/reference/functions/wp_redirect/
*/

/*FORMULARIO ALTA DE MAYORISTAS*/

function jetpackcom_contact_confirmation()
{
	$conf ='';
	
	$conf .="<script>
				setTimeout(function(){
					window.location.href = '".home_url()."';
				}, 5000);
			</script>
			";
		
	$conf .='<p>Buenísimo!. Hemos enviado tu solicitud.</p>';
	
	$conf .="<p>Un momento por avor, te estamos redirigiendolo a nuestra pagina principal.</p>";
	
	return $conf;
	
}
add_filter( 'grunion_contact_form_success_message', 'jetpackcom_contact_confirmation' );
