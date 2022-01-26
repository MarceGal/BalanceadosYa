<?php 

//*****************************************************
//**SEO - NO INDEX PAGES *********************
//*****************************************************

/*

OMITIMOS LA INDEXACIÓN DE PAGINAS QUE NO DESEAMOS SEAN INDEXADAS POR BOTS

Política de privacidad -> 3 -> https://balanceadosya.com.ar/?p=3
Terminos -> 3344 -> https://balanceadosya.com.ar/?p=3344
Reclamos -> 4417 -> https://balanceadosya.com.ar/?p=4417
Pago -> 627 -> https://balanceadosya.com.ar/?p=627
Pago pendiente -> 7625 -> https://balanceadosya.com.ar/?p=7625
compra exitosa -> 7649-> https://balanceadosya.com.ar/?p=7649
Pago rechazado -> 7642 -> https://balanceadosya.com.ar/?p=7642

*/

define("NO_INDEX_POSTS_IDS",  [3, 3344, 4417, 627, 7625, 7649, 7642] );

add_action( 'wp_head', function() {

    global $post;    

    foreach(NO_INDEX_POSTS_IDS as  $post_id)
    {
       if ($post->ID == $post_id ) {
            echo '<meta name="robots" content="noindex, nofollow">';
            return true;
       }
    } 

    return false;

 } );

 
?>