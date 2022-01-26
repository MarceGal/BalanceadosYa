<?php 

//*****************************************************
//**ADD JS THEME FUNCION**********************
//*****************************************************
// https://developer.wordpress.org/reference/functions/wp_enqueue_script/
// https://stackoverflow.com/questions/19263390/wordpress-loading-multiple-scripts-with-enqueue
	
function bya_load_scripts() 
{
	
	wp_enqueue_script( 'bya-script', get_bloginfo('stylesheet_directory') .  '/assets/js/script.js', array(), '1.1.0' , true );
	
}


//*****************************************************
// Esta función declara la variable "now" utilizado por
// la función de JS "turno_change_handler" en el archivo assets\js\script.js
//*****************************************************

function setTimeZone() 
{
	// $timeZone= "America/Chicago"; -3 HS
	$timeZone= "America/Argentina/Buenos_Aires";
	date_default_timezone_set($timeZone);
	$timestamp = time();
	$now = date("Y,m,d,H,i,s", $timestamp);	

	// jQuery

    ?>

    <script type="text/javascript">

        let now = new Date(<?php echo ($now) ;?>);
		//console.log('Current date and local time on this server is <?=$now?> ');
		
	</script>

    <?php

	
}

add_action( 'wp_footer', 'setTimeZone');
add_action( 'wp_enqueue_scripts', 'bya_load_scripts', 100 );

?>