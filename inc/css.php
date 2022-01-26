<?php 

function bya_load_styles() 
{	
	
    //wp_enqueue_style( 'root-flatsome-css', get_template_directory_uri() . '/style.css', false);
    wp_enqueue_style( 'balanceadosYa-main-css', get_bloginfo('stylesheet_directory'). '/assets/css/style.css',true,'0.8.0','all');

}


add_action('wp_enqueue_scripts', 'bya_load_styles', 1000 );

?>