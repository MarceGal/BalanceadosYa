<?php 


//*****************************************************
//****** Redirect user after login. *******************
//*****************************************************


function wc_custom_user_redirect( $redirect, $user ) {
    
	$role = $user->roles[0];
    $dashboard = admin_url();         
    $tienda = get_permalink( wc_get_page_id( 'shop' ) );
	$myaccount = get_permalink( wc_get_page_id( 'myaccount' ) );
    $redirect = $_SERVER["HTTP_REFERER"];
    
    return $myaccount;
    
    if (in_array($role, array('administrator'))) {
		
        $redirect = $dashboard;    
		
    } elseif (in_array($role, array('shop_manager'))) {
		
        $redirect = site_url('/wp-admin/admin.php?page=wc-admin');  
        
    } elseif (in_array($role, array('distributor', 'customer', 'subscriber'))) {
		
        //$redirect = $_SERVER["HTTP_REFERER"];  
        
    } else {
		
        //$redirect = $_SERVER["HTTP_REFERER"];  
		
    }	
	

    return $redirect;

}

add_filter( 'woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2 );


//*****************************************************
//******Skipear la confirmación en el logout *******
//*****************************************************

function logout_sin_confirmacion() {
	
    global $wp;

    if ( strstr($wp->request,'tienda/mi-cuenta/salir')) {
        wp_redirect( str_replace( '&amp;', '&', wp_logout_url( home_url() ) ) );
		//wp_redirect( str_replace( '&amp;', '&', wp_logout_url( wc_get_page_permalink( 'myaccount' ) ) ) );
		exit;
    }

}

add_action( 'template_redirect', 'logout_sin_confirmacion' );

