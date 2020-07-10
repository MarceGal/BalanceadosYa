<?php 


//*****************************************************
//**ADD CSS ADICIONAL *********************************
//*****************************************************
/*
function BYA_enqueue_styles() {
	
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array('font-awesome'));

    if ( is_rtl() ) 
   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
}


add_action('wp_enqueue_scripts', 'BYA_enqueue_styles');
*/


//*****************************************************
//**FAVICONS ****************+*************************
//*****************************************************


function BYA_add_favicon(){ 

?>
    <!-- Custom Favicons -->	
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-114x114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-144x144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-60x60.png" />
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-120x120.png" />
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-76x76.png" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo get_stylesheet_directory_uri();?>/favicons/apple-icon-152x152.png" />
	
	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri();?>/favicons/favicon-196x196.png" sizes="196x196" />
	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri();?>/favicons/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri();?>/favicons/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri();?>/favicons/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri();?>/favicons/favicon-128.png" sizes="128x128" />
	
	<meta name="msapplication-square70x70logo" content="<?php echo get_stylesheet_directory_uri();?>/favicons/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="<?php echo get_stylesheet_directory_uri();?>/favicons/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="<?php echo get_stylesheet_directory_uri();?>/favicons/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="<?php echo get_stylesheet_directory_uri();?>/favicons/mstile-310x310.png" />
	
	<link rel="manifest" href="<?php echo get_stylesheet_directory_uri();?>/favicons/manifest.json">
	
	<meta name="application-name" content="BalanceadosYa!"/>
	<meta name="msapplication-TileColor" content="#FFE781">
	<meta name="msapplication-TileImage" content="<?php echo get_stylesheet_directory_uri();?>/favicons/ms-icon-144x144.png">
	<meta name="theme-color" content="#FFE781">



<?php }

add_action('wp_head','BYA_add_favicon');

//*****************************************************
//**GOOGLE ANALYTICS **********************************
//*****************************************************


function BYA_add_googleAnalyticsScript(){

?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-150064125-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-150064125-1');
</script>

<?php

}

add_action('wp_head','BYA_add_googleAnalyticsScript');


//*****************************************************
//**ONESIGNAL PUSH NOTIFICATIONS **********************
//*****************************************************


function BYA_add_onesignalScript(){

?>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  var OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "fbc7dcc4-4beb-43d9-9325-b9da2903dee0",
      notifyButton: {
        enable: false	,
      },
    });
  });
</script>
<?php

}

if($_SERVER["SERVER_NAME"]=="balanceadosya.com.ar" || $_SERVER["SERVER_NAME"]=="www.solfoto.com.ar")
{

    add_action('wp_head','BYA_add_onesignalScript');

}

//*****************************************************
//**FACEBOOK PIXEL ************************************
//*****************************************************


function BYA_add_facebookPixelScript(){

?>

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '242080206560811');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=242080206560811&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<?php

}

//add_action('wp_head','BYA_add_facebookPixelScript');

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
//**ADD JS *********************************************
//*****************************************************

function BYA_scripts() 
{
	/*	*/
	//$ua = getBrowser();
	//$yourbrowser= "Your browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] . " reports: <br >" . $ua['userAgent'];
	//print_r($yourbrowser);
	
	//wp_enqueue_style( 'bya-style', get_bloginfo('stylesheet_directory') .  '/css/checkout.css', array(), '1.1.0' , true );

	 
	wp_enqueue_script( 'bya-script', get_bloginfo('stylesheet_directory') .  '/js/script.js', array(), '1.1.0' , true );
	
}


add_action( 'wp_enqueue_scripts', 'BYA_scripts' );

//*****************************************************
//*****************************************************
//*****************************************************


function clean_white_spaces($str){
	$str = ltrim($str);
	$str = rtrim($str);
	return $str;
}

function mailMarce($message) 
{
	
	
	//php mailer variables
	$to = 'claudiomarcelogalarza@gmail.com';
	$subject = "Notificación de prueba de BalanceadosYa!";
	$headers = "From: BalanceadosYa! <no-contestar@balanceadosya.com>\r\n". "Reply-To:  no-contestar@balanceadosya.com\r\n";
	
	
	wp_mail($to, $subject, strip_tags($message), $headers);
	
}	

//*****************************************************
//*****************************************************
//*****************************************************

//include get_stylesheet_directory() . '/includes/admin-sign-in.php';

include get_stylesheet_directory() . '/includes/checkout.php';
include get_stylesheet_directory() . '/includes/my-account.php';
include get_stylesheet_directory() . '/includes/user-profile.php';
include get_stylesheet_directory() . '/includes/sign-up.php';
include get_stylesheet_directory() . '/includes/roles.php';
include get_stylesheet_directory() . '/includes/alta-mayoristas.php';
include get_stylesheet_directory() . '/includes/admin-menu.php';


?>