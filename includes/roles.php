<?php 

				
//*****************************************************
//**ROLES *********************************************
//*****************************************************

// https://codex.wordpress.org/Function_Reference/add_role
// https://wordpress.org/support/article/roles-and-capabilities

$user_roles = array();

function BYA_get_user_role() {
	
    global $current_user;
	global $user_roles;
	
	if(count($user_roles) > 0) return $user_role;
	
    $user_roles = $current_user->roles;
	
    $user_role = array_shift($user_roles);
	
    return $user_role;
	
}

function BYA_is_admin() {
	
	$roles = BYA_get_user_role();
	return in_array($roles, array('administrator')); 	
	
}

function BYA_is_shop_manager() {
	
    $roles = BYA_get_user_role();
	return in_array($roles, array('shop_manager')); 	
}

function BYA_is_distributor () 
{
	return current_user_can( 'distributor' );	
}
	

$capabilities = array(
	
	'create_sites'	=> false,
	'delete_sites'	=> false,
	'manage_network'	=> false,
	'manage_sites'	=> false,
	'manage_network_users'	=> false,
	'manage_network_plugins'	=> false,
	'manage_network_themes'	=> false,
	'manage_network_options'	=> false,
	'upgrade_network'	=> false,
	'setup_network'	=> false,
	'activate_plugins'	=> false,
	'delete_others_pages'	=> false,
	'delete_others_posts'	=> false,
	'delete_pages'	=> false,
	'edit_posts'	=> false,
	'create_posts'	=> false,
	'delete_posts'	=> false,
	'delete_private_pages'	=> false,
	'delete_private_posts'	=> false,
	'delete_published_pages'	=> false,
	'delete_published_posts'	=> false,
	'edit_dashboard'	=> false,
	'edit_others_pages'	=> false,
	'edit_others_posts'	=> false,
	'edit_pages'	=> false,
	'edit_private_pages'	=> false,
	'edit_private_posts'	=> false,
	'edit_published_pages'	=> false,
	'edit_published_posts'	=> false,
	'edit_theme_options'	=> false,
	'export'	=> false,
	'import'	=> false,
	'list_users'	=> false,
	'manage_categories'	=> false,
	'manage_links'	=> false,
	'manage_options'	=> false,
	'moderate_comments'	=> false,
	'promote_users'	=> false,
	'publish_pages'	=> false,
	'publish_posts'	=> false,
	'read_private_pages'	=> false,
	'read_private_posts'	=> false,
	'read'	=> false,
	'remove_users'	=> false,
	'switch_themes'	=> false,
	'upload_files'	=> false,
	'customize'	=> false,
	'delete_site'	=> false,
	'update_core'	=> false,
	'update_plugins'	=> false,
	'update_themes'	=> false,
	'install_plugins'	=> false,
	'install_themes'	=> false,
	'delete_themes'	=> false,
	'delete_plugins'	=> false,
	'edit_plugins'	=> false,
	'edit_themes'	=> false,
	'edit_files'	=> false,
	'edit_users'	=> false,
	'add_users'	=> false,
	'create_users'	=> false,
	'delete_users'	=> false,
	'unfiltered_html'	=> false,
	'read_private_page'	=> false,
	'read'	=> false
	
);

remove_role( 'subscriber' );
remove_role( 'editor' );
remove_role( 'contributor' );
remove_role( 'author' );


add_role( 'distributor', 'Distribuidor', $capabilities );
add_role( 'featured_client', 'Cliente destacado', $capabilities );

// Ocultar barras administrativas

function BYA_admin_bar ($show) 
{	
	$distribuidor = BYA_is_distributor();
	
	if ( $distribuidor ) {
		
		return false;
	}
	
	return $show;
	
}


add_filter( 'show_admin_bar', 'BYA_admin_bar' );


// Agraga roles a los estiles css de la etiqueta body


function BYA_class_names($classes) 
{
    $classes[] = BYA_get_user_role();
    return $classes;
}

add_filter('body_class','BYA_class_names');


function BYA_changeUIbyRole(){
	
	?>
	
	<style>
	
		.product.product_cat-ofertas-destacadas-mayoristas,
		.product-categories .cat-item.cat-item-178,
		.product-categories .cat-item.cat-item-179
		{
			display: none;
		}
		
	</style>
	
	<?php
	/*
	$a = BYA_is_admin;
	$sm = BYA_is_shop_manager();
	$d = BYA_is_distributor();
	*/
	
	
	if ( BYA_is_distributor() ) {
	
		?>
		
		<script>
			
			jQuery( document ).ready(function() {
	
				jQuery(".nav li.ofertas a").attr("href", "https://balanceadosya.com.ar/producto-cat/ofertas-destacadas-mayoristas/");
			
			});
		   
		</script>
		
		<style>
	
			.product.product_cat-ofertas-destacadas-mayoristas,
			.product-categories .cat-item.cat-item-178
			{
				display: flex;
			}
			
		</style>
				
		<?php
		
		
	}
	
	if ( BYA_is_admin() || BYA_is_shop_manager() ) {
	
		
		?>

		<style>
	
			.product.product_cat-ofertas-destacadas-mayoristas,
			.product-categories .cat-item.cat-item-178,
			.product-categories .cat-item.cat-item-179
			{
				display: flex;
			}
			
		</style>
		
		
		<?php
	
	}
}

add_action('wp_head','BYA_changeUIbyRole');

// Redirect user after login.

function wc_custom_user_redirect( $redirect, $user ) {
    
	// Get the first of all the roles assigned to the user    
	
	$role = $user->roles[0];
    $dashboard = admin_url();       

    if (in_array($role, array('administrator'))) {
		
        $redirect = $dashboard;    
		
    } elseif (in_array($role, array('shop_manager'))) {
		
        $redirect = site_url('/wp-admin/admin.php?page=wc-admin');  
        
    } elseif (in_array($role, array('distributor', 'customer', 'subscriber'))) {
		
        $redirect = $_SERVER["HTTP_REFERER"];  
        
    } else {
		
        $redirect = $_SERVER["HTTP_REFERER"];  
		
    }
	
	
	$redirect = $_SERVER["HTTP_REFERER"];

    return $redirect;

}

add_filter( 'woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2 );


    