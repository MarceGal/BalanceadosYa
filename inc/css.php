<?php 


//*****************************************************
//**FAVICONS ******************************************
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

function bya_load_styles() 
{	
	
    //wp_enqueue_style( 'root-flatsome-css', get_template_directory_uri() . '/style.css', false);
    wp_enqueue_style( 'balanceadosYa-main-css', get_bloginfo('stylesheet_directory'). '/assets/css/style.css',true,'0.8.0','all');

}

add_action('wp_enqueue_scripts', 'bya_load_styles', 1000 );


?>