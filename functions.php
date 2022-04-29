<?php 
define("GUALEGUAYCHU_POSTCODE", "2820");
define("PUEBLO_BELGRANO_POSTCODE", "2852");
define("C_DEL_U_POSTCODE", "3260");
define("VILLAGUAY_POSTCODE", "3240");
define("LARROQUE_POSTCODE", "2854");
define("URDINARRAIN_POSTCODE", "2826");
define("CRESPO_POSTCODE", "3118");
define("PARANA_POSTCODE", "3100");
define("COLON_POSTCODE", "2720");
define("SANTA_FE_POSTCODE", "3000");

// Descuentos  para transferencias bancarias 
// Utilizado en checkout-discounts.php 

define("BACS_DISCOUNT", 5); // % Descuento en transferencia bancaria
define("BACS_DISCOUNT_LEYEND", '¡ 🎉 Tenemos un descuento del '.BACS_DISCOUNT.'% para transferencias bancarias !'); 
define("COD_DISCOUNT", 5); // % Descuento en pago en efectivo
define("COD_DISCOUNT_LEYEND", '¡ 🎉 Tenemos un descuento del '.COD_DISCOUNT.'% para pagos en efectivo !'); 


//*****************************************************
//**SVG UPLOAD SUPPORT ********************************
//*****************************************************

// Antes de subir un archivo hay que depurarlo en http://svg.enshrined.co.uk/

function cc_mime_types($mimes) {
 $mimes['svg'] = 'image/svg+xml';
 return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
 
//*****************************************************
//** UTILITIES ***************************************
//*****************************************************

//USER AGENT DETECTION

function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'   => $pattern
    );

} 


function clean_white_spaces($str){
	$str = ltrim($str);
	$str = rtrim($str);
	return $str;
}


function array2string($data)
{
    $log_a = "";

    foreach ($data as $key => $value) {

        if(is_array($value))  {
        
            $log_a .= "[".$key."] => (". array2string($value). ") \n";

        } else {

            $log_a .= "[".$key."] => ".$value."\n";

        }         
              
    }

    return $log_a;
}

function mailAdmin($message) 
{

	//php mailer variables
	$to = 'claudiomarcelogalarza@gmail.com';
	$subject = "Notificación desde BalanceadosYa!";
	$headers = "From: BalanceadosYa! <no-contestar@balanceadosya.com>\r\n". "Reply-To:  no-contestar@balanceadosya.com\r\n";
	wp_mail($to, $subject, strip_tags($message), $headers);
	
}	

function debug_to_console($data) 
{

    $output = $data;

    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";

}

//*****************************************************
//*WP Utilities ***************************************
//*****************************************************

function isUserLoggedIn()
{
	return is_user_logged_in();
}

function isCustumerUser()
{
	global $current_user;
    if (!isset($current_user->roles) || empty( $current_user->roles)) return false;
    $role = $current_user->roles[0];    
    return in_array($role, array('customer'));

}

function getUserPostCode() 
{
    if(is_null(WC()->session)) return false;

    $_customer = WC()->session->get('customer'); 
	
	return $_customer['postcode'];

}

/*Get the selected payment method*/

function getUserPaymentMethod() 
{
    $chosen_payment_method = WC()->session->get('chosen_payment_method'); 

    return $chosen_payment_method;

}

/* VALIDAMOS QUE LA CIUDAD DEL USUARIO TENGA DISPONIBLE DESCUENTOS */

function canUserHaveDiscounts() 
{
    $upc  = getUserPostCode() ;

    if( 
        $upc == URDINARRAIN_POSTCODE 
        || $upc == CRESPO_POSTCODE 
        || $upc == PARANA_POSTCODE
        || $upc == SANTA_FE_POSTCODE
        || $upc == COLON_POSTCODE
    ){
        
        // No hay descuentos en estas ciudades
        return false;

    }

    return true;

}

/* REMOVEMOS LOS DESCUENTOS EXISTENTES */

function removeDiscounts() 
{
    
    $fees = WC()->cart->get_fees();
            
    foreach ($fees as $key => $fee) {
        if($fees[$key]->name === BACS_DISCOUNT_LEYEND) {
            unset($fees[$key]);
        }
    }

    WC()->cart->fees_api()->set_fees($fees);

    return true;

}

/* REFRESCAMOS EL CHECKOUT */

function refreshCheckoutFrontEnd() 
{
    
    echo "<script type='text/javascript'> 
		
			(function($) { 
					try {
    					jQuery(document.body).trigger('update_checkout');   	
					} catch (error) {
						console.log(error); 
					}
				}
			)(jQuery); 

	</script>";
	
    return true;

}


//https://wpglorify.com/show-lowest-price-woocommerce-variable-products/ 

//add_filter( 'woocommerce_variable_sale_price_html', 'wpglorify_remove_variation_price', 20, 2 );
//add_filter( 'woocommerce_variable_price_html', 'wpglorify_remove_variation_price', 20, 2 );
 

function wpglorify_remove_variation_price( $price, $product  ) {     

    
    
    // Main Price

    
    $prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );

    if ( ! is_array($prices)) {        
        
        return $price;
        
    }

    // $price = $prices[0] !== $prices[1] ? sprintf( __( 'From: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
    $price = $prices[0] ;
   
    // Sale Price

    $regularPrices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
    
    sort( $regularPrices );

    //$saleprice = $regularPrices[0] !== $regularPrices[1] ? sprintf( __( 'From: %1$s', 'woocommerce' ), wc_price( $regularPrices[0] ) ) : wc_price( $regularPrices[0] );
    
    $saleprice = $regularPrices[0] > $price ? $price : 0 ;

    //if ( $price !== $saleprice ) {

        //$price = '<del>' . $saleprice . $product->get_price_suffix() . '</del> <ins>' . $price . $product->get_price_suffix() . '</ins>';
    
    //}

    $output ='';

    //$output .= '---------<br>';
    //$output .= 'Regular Prices: '.array2string($regularPrices);
    //$output .= '<br>---------<br>';
    //$output .= 'Current prices: '. array2string($prices);
    //$output .= '<br>---------<br>';
    //$output .= 'Regular price: '.wc_price($price);

    if($saleprice){

        //$output .= 'Antes: '.'<del>' . wc_price($regularPrices[0]) . $product->get_price_suffix() . '</del>';
        $output .= '<ins> Desde ' . wc_price($saleprice) . $product->get_price_suffix() . '</ins>';
        //echo $output;
        return $output;
    }

    return $price;

}


include get_stylesheet_directory() . '/inc/css.php';
include get_stylesheet_directory() . '/inc/js.php';
include get_stylesheet_directory() . '/inc/google-analytics.php';
include get_stylesheet_directory() . '/inc/facebook-pixel.php';
include get_stylesheet_directory() . '/inc/push-notifications.php';
//include get_stylesheet_directory() . '/inc/admin-sign-in.php';
include get_stylesheet_directory() . '/inc/sign-in.php';
include get_stylesheet_directory() . '/inc/seo.php';
include get_stylesheet_directory() . '/inc/checkout.php';
include get_stylesheet_directory() . '/inc/checkout-payments.php';
include get_stylesheet_directory() . '/inc/checkout-discounts.php';
include get_stylesheet_directory() . '/inc/my-account.php';
include get_stylesheet_directory() . '/inc/user-profile.php';
include get_stylesheet_directory() . '/inc/sign-up.php';
include get_stylesheet_directory() . '/inc/roles.php';
include get_stylesheet_directory() . '/inc/alta-mayoristas.php';
include get_stylesheet_directory() . '/inc/admin-menu.php';

?>