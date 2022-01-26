<?php 

//*****************************************************
//**OCULTAR ELEMENTOS DEL MENU DE ADMINISTRACIÓN ******
//*****************************************************

//Ref:https://wordpress.stackexchange.com/questions/136058/how-to-remove-admin-menu-pages-inserted-by-plugins


function quitar_elementos_del_menu() 
{
	global $current_user; 
	global $menu ;
	
	if($current_user->user_login != "SuperBoxer")
	{
		//remove_menu_page( 'edit.php' );                   //Posts
		//remove_menu_page( 'upload.php' );                 //Media
		remove_menu_page( 'edit-comments.php' );          //Comments
		remove_menu_page( 'themes.php' );                 //Appearance
		//remove_menu_page( 'users.php' );                  //Users
		remove_menu_page( 'tools.php' );                  //Tools
		remove_menu_page( 'options-general.php' );        //Settings
		remove_menu_page( 'plugins.php' );				//Plugins
		remove_menu_page( 'jetpack', 'jetpack' );
		remove_menu_page( 'edit.php?post_type=blocks' );
		remove_menu_page( 'wpcf7' ); 

		//Flatsome
		
		remove_menu_page( 'flatsome-panel'); // wp-admin/admin.php?page=flatsome-panel
		
		
		//Super Socializer
		
		remove_menu_page( 'heateor-ss-general-options' );  // wp-admin/admin.php?page=heateor-ss-general-options
		
	};	

};


//*****************************************************
//**CAMBIAR NOMBRES DEL MENU DE ADMINISTRACIÓN ********
//*****************************************************

function actualizar_etiquetas_del_menu() 
{
	global $menu;
   
	foreach( $menu AS $key => $value ) {
		
		$tmp =  $value[0];
		
		switch( $tmp ) {
			
			case 'WooCommerce': 
				$tmp = 'Tienda';
				break;
				
			case 'Medios': 
				$tmp = 'Imágenes';
				break;
		
			case"YITH":
				$tmp = 'Reglas';
				break;
		
			case"All Export":
				$tmp = 'Exportar';
				break;
			
			case"Product Feed Pro":
				$tmp = 'Feeds';
				break;
				
		}
		
		$menu[$key][0] = $tmp;
		
	}
	
};

//*****************************************************
//**REMOVER ALERTAS EN EL BACKEND,  *******************
// EXEPTUANDO AL ROL SUPERADMINISTRADOR ***************
//*****************************************************

function remover_advertencias_backend() 
{
	$user = wp_get_current_user();
	$is_admin = is_super_admin();
	$is_super_admin = ($user->ID === 1);

	if ( !$is_super_admin){ 
		remove_all_actions('admin_notices');
		remove_all_actions('all_admin_notices');
	}	

};

add_action('in_admin_header', 'remover_advertencias_backend', 1000);

add_action( 'admin_menu', 'actualizar_etiquetas_del_menu', 999 );
	
add_action( 'admin_menu', 'quitar_elementos_del_menu', 999 );
