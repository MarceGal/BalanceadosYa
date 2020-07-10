<?php
/*
Template Name: Reclamos
*/

// https://catswhocode.com/wordpress-contact-form-without-plugin/
// https://docs.woocommerce.com/wc-apidocs/class-WC_Order.html



if ( !is_user_logged_in()){	
	
	$tmp_url = '/tienda/mi-cuenta/?';
	//$tmp_url .= 'wp_http_referer='.$_SERVER['HTTP_REFERER'];
	wp_redirect( site_url($tmp_url) ) ;
	
	exit();
	
}
	
	
	
$order_id = intval($_GET['order_id']);

if( $order_id < 1 ) {
	
	$order_id = intval($_POST['order_id']);
	
}

if( $order_id < 1 ) {
	
	/*wp_redirect( home_url() );
	exit();*/
	$redirectAfterError = true;
	
}else {

	$order = new WC_Order( $order_id );
	$user = wp_get_current_user();
	$user_id = $user->ID ;
	$is_valid_claimer = false;
	$userData = $user->data;
	$redirectAfterError=false;

	if($user_id == $order->get_user_id())
	{
		$is_valid_claimer = true;
		
	}else{
		
		$commentError = '😺 El numero de orden no coincide con un pedido tuyo.';
		wc_add_notice( $commentError , 'error' );
		$redirectAfterError = true;
	}


	if(isset($_POST['submitted'])) {
		
		
		if(trim($_POST['comments']) === '') {
			
			$commentError = '😺 Por favor, necesitamos registrar tu reclamo. Completá el campo.';
			
			$hasError = true;
			
		} else {
			
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
			
		}

		if(!isset($hasError)) {
			
			
			//https://developer.wordpress.org/reference/functions/wp_mail/
			
			
			$emailTo = 'no-responder@balanceadosya.com.ar'; 
			
			$subject = '['.get_bloginfo( 'name' ).'] Nuevo Reclamo  - Pedido #('.$order_id.')' ;
							
			$headers[] ='Content-Type: text/html; charset=UTF-8';

			$headers[] ='From: '.get_bloginfo( 'name' ).' <'.$emailTo.'>';

			$headers[] ='Reply-To: ' . $userData ->user_email;
			
			$body = "<h1>IMPORTANTE: Nuevo Reclamo</h1>";
			
			$body .= "<br>";
			
			$body .= "Has recibido el siguiente reclamo de <strong><a href='".
			site_url('wp-admin/user-edit.php?user_id='.$order->get_user_id())."'>".$userData->display_name."</a></strong>";
			
			$body .= "<br>";
			
			$order_id = $_POST['order_id'];
			
			$body .= '<strong>Pedido #</strong>: <a href="https://balanceadosya.com.ar/wp-admin/post.php?post='.$order_id.'&action=edit">'.$order_id.'</a>';
			
			$body .= "<br>";
			
			$body .= "<strong>Comentario</strong>: $comments";
			
			wp_mail($emailTo, $subject, $body, $headers);
			
			$emailSent = true;
			
					
		}
		
		if($commentError != '') { 
		
			wc_add_notice( $commentError , 'error' );
			
		} 
		
		if(nameError != '') { 
		
			wc_add_notice( $nameError , 'error' );
			
		} 
		
		if(isset($emailSent) && $emailSent == true) { 
						
			wc_add_notice( 'Muchas Gracias. Hemos registrado tu reclamo. Nos pondremos en contacto a la brevedad.', 'success' );

		}
		
	} 

}
	
?>

<?php
/**
 * The template for displaying all pages.
 *
 * @package flatsome
 */

/*
if(flatsome_option('pages_template') != 'default') {
	
	// Get default template from theme options.
	get_template_part('page', flatsome_option('pages_template'));
	
	return;

} else {
*/

get_header();

do_action( 'flatsome_before_page' ); ?>

<div id="content" class="content-area page-wrapper" role="main">
	<div class="row row-main">
		<div class="large-12 col">
			<div class="col-inner">
				
				
				<header class="entry-header">
					<h1 class="entry-title mb uppercase"><?php the_title(); ?></h1>
				</header><!-- .entry-header -->
				
				
			<?php 
				
				
				while ( have_posts() ) : the_post(); ?>
				
					<?php do_action( 'flatsome_before_page_content' ); ?>
					
						<?php the_content(); ?>

						<?php if ( comments_open() || '0' != get_comments_number() ){
							comments_template(); } ?>

					<?php do_action( 'flatsome_after_page_content' ); ?>
				
			<?php endwhile; // end of the loop. ?>
				
			<?php
				
				
				if($redirectAfterError )
				{
					
					$conf .='<p>😺 Miaaaauu !!!. Operación invalida.</p>';
					
					if( !is_admin() ){
						
						$conf .="<script>
									setTimeout(function(){
										window.location.href = '".home_url()."';
									}, 5000);
								</script>
								";
						$conf .="<p>Aguardá unos segundos, estamos redirigiendote a la pagina principal.</p>";
					
					}
					
					print($conf);
					
				} else {
					
					
						?>					
						
							
						<?php 
						
						if(isset($emailSent) && $emailSent == true) { 
							
						?>	
							
							<p>🐶 Muchas gracias, <strong><?php echo $userData->display_name ;?></strong>. </p>	
							
							<script>
								setTimeout(function(){
									window.location.href = '<?php echo home_url(); ?>';
								}, 5000);
							</script>
									
							<p>Aguardá unos segundos, estamos redirigiendote a la pagina principal.</p>
						
						<?php 
						
						} else { ?>
						
							<p>Hola, <strong><?php echo $userData->display_name ;?></strong>. </p>	
						
							<p>🐶 Vamos a procesar tu reclamo. </p>	
							
							<p>Por favor, completá el formulario con los motivos de tu reclamo: </p>		
						
						
							<form action="<?php the_permalink(); ?>" id="contactForm" method="post" class="contact-form" >
								
								<div class="grunion-field-wrap grunion-field-text-wrap">
								
									<label for="commentsText">Motivo del reclamo <span>(obligatorio)</span>: </label>
									
									<textarea name="comments" class="input-text " id="commentsText" placeholder="¿Nos compartirías los detalles del inconveniente?" rows="2" cols="5" required aria-required="true"><?php 
										
										/*
										if(isset($_POST['comments'])) { 
										
											if(function_exists('stripslashes')) 
											{ 
												echo stripslashes($_POST['comments']); 
											
											} else { 
											
												echo $_POST['comments']; 
												
											} 
											
										} 
										*/
										
										?></textarea>
															
								
								</div>

								<p class="contact-submit">
								
									<button type="submit" class="pushbutton-wide"> 👉 Enviar </button>		
									
									<input type="hidden" id="submitted" name="submitted" value="true" />
									
									<input type="hidden" id="order_id" name="order_id" value="<?php echo $order_id ; ?>">
										
								</p>
						
						</form>
						
						<?php
						
						} 
						
						/*
						echo '<br>';	
						echo '---------';
						echo '<br>';	
						var_dump($user);
						echo '<br>';	
						echo '---------';
						echo '<br>';	
						var_dump($order);
						echo '<br>';	
						echo '---------';
						echo '<br>';	
						*/
						
				}
			?>
				
				
			</div><!-- .col-inner -->
		</div><!-- .large-12 -->
	</div><!-- .row -->
</div>

<?php
do_action( 'flatsome_after_page' );
get_footer();

//}

?>


	
