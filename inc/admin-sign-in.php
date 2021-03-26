<?php 

//*****************************************************
//******BLOCK ADMINISTRATION LOGIN AND DASHBOARD*******
//*****************************************************
 
// http://natko.com/block-access-to-wp-admin-and-wordpress-dashboard/ 
 
/*
Si el usuario ingresó, se intenta abrir el dashboard, el usuario no puede editar entradas y el ingreso no es una llamada ajax, redirijimos a "mis paginas" 
*/   

function block_dashboard() {
       
    //$referrer = $_SERVER['HTTP_REFERER'];
       
    $file = basename($_SERVER['PHP_SELF']);
	if (is_user_logged_in() && is_admin() && !current_user_can('edit_posts') && $file != 'admin-ajax.php'){
        //wp_redirect( '//dsbox.com.ar/clientes/dashboard/');
		wp_redirect( home_url() );
        exit();
    }
}
 
function block_on_login_failed( $user ) {
        // check what page the login attempt is coming from
        $referrer = $_SERVER['HTTP_REFERER'];
 
        //die ( $referrer );
               
        // check that were not on the default login page
        if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) {
                // make sure we don't already have a failed login attempt
                if ( !strstr($referrer, '?login=failed' )) {
				// Redirect to the login page and append a querystring of login failed
                wp_redirect( $referrer . '?login=failed');
            } else {
				wp_redirect( $referrer );
            }
 
            exit;
        }
}

function block_on_blank_login( $user )
{
        function get_page_by_name($pagename)
        {
                $pages = get_pages();
                foreach ($pages as $page) if ($page->post_name == $pagename) return $page;
                return false;
        }
 
        $page = get_page_by_name('log-in');
		
        if (empty($page)) $page = get_page_by_name('ingresar');
       
        // check what page the login attempt is coming from
        $referrer = $_SERVER['HTTP_REFERER'];
 
        $error = false;
       
        if($page && !isset($_POST['pwd']) && !isset($_POST['log']))
        {
			
			wp_redirect( home_url() );
			exit();
        }
 
        if($_POST['log'] == '' || $_POST['pwd'] == '')
        {
                $error = true;
        }
       
        // check that were not on the default login page
        if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && !strstr($referrer,'admin') && $error ) {
			// make sure we don't already have a failed login attempt
        if ( !strstr($referrer, '?login=failed') ) {
			// Redirect to the login page and append a querystring of login failed
			wp_redirect( $referrer . '?login=failed' );
        } else {
			wp_redirect( $referrer );
        }
 
		exit;
 
        }
}

 
add_action('init', 'block_dashboard');
add_action( 'wp_login_failed', 'block_on_login_failed' ); // hook failed login
add_action( 'authenticate', 'block_on_blank_login'); //Shortcode para 

