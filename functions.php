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
//**FAVICONS ****************+*************************
//*****************************************************


function BYA_add_favicon(){ 

?>
<!-- Custom Favicons -->
<link rel="apple-touch-icon-precomposed" sizes="57x57"
    href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-57x57.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114"
    href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-114x114.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72"
    href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-72x72.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144"
    href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-144x144.png" />
<link rel="apple-touch-icon-precomposed" sizes="60x60"
    href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-60x60.png" />
<link rel="apple-touch-icon-precomposed" sizes="120x120"
    href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-120x120.png" />
<link rel="apple-touch-icon-precomposed" sizes="76x76"
    href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-76x76.png" />
<link rel="apple-touch-icon-precomposed" sizes="152x152"
    href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-152x152.png" />

<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri();?>/favicons/favicon-196x196.png"
    sizes="196x196" />
<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri();?>/favicons/favicon-96x96.png"
    sizes="96x96" />
<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri();?>/favicons/favicon-32x32.png"
    sizes="32x32" />
<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri();?>/favicons/favicon-16x16.png"
    sizes="16x16" />
<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri();?>/favicons/favicon-128.png"
    sizes="128x128" />

<meta name="msapplication-square70x70logo"
    content="<?php echo get_stylesheet_directory_uri();?>/favicons/mstile-70x70.png" />
<meta name="msapplication-square150x150logo"
    content="<?php echo get_stylesheet_directory_uri();?>/favicons/mstile-150x150.png" />
<meta name="msapplication-wide310x150logo"
    content="<?php echo get_stylesheet_directory_uri();?>/favicons/mstile-310x150.png" />
<meta name="msapplication-square310x310logo"
    content="<?php echo get_stylesheet_directory_uri();?>/favicons/mstile-310x310.png" />

<link rel="manifest" href="<?php echo get_stylesheet_directory_uri();?>/favicons/manifest.json">

<meta name="application-name" content="BalanceadosYa!" />
<meta name="msapplication-TileColor" content="#FFE781">
<meta name="msapplication-TileImage"
    content="<?php echo get_stylesheet_directory_uri();?>/favicons/ms-icon-144x144.png">
<meta name="theme-color" content="#FFE781">

<?php }

add_action('wp_head','BYA_add_favicon');

include get_stylesheet_directory() . '/inc/google-analytics.php';

include get_stylesheet_directory() . '/inc/push-notifications.php';

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
//**USER AGENT DETECTION UTILITIES *********************
//*****************************************************


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

//*****************************************************
//*****************************************************
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

function clean_white_spaces($str){
	$str = ltrim($str);
	$str = rtrim($str);
	return $str;
}

function mailMarce($message) 
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

function canUserDiscounts() 
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





include get_stylesheet_directory() . '/inc/css.php';
include get_stylesheet_directory() . '/inc/js.php';
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