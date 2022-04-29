<?php

/*
* Aplicamos descuentos cuando se selecciona 
* transferencia bancaria como metodo de pago
*
* Metodos de pagos posibles:
*
* Transferencia bancaria: Direct Bank Transfer (bacs), 
* Contrarembolso: Cash on Delivery (cod)  
* Cheque: Check payments (cheque), 
*
*/

function calcular_descuentos_por_metodo_de_pago( WC_Cart $cart ) 
{
    if ( ( is_admin() && ! defined( 'DOING_AJAX' ) ) || is_cart() ) return; // Only on checkout

    $label_text= "";

    $percent = 0; 

    // $cart->subtotal_ex_tax = subtotal + impuestos
    
    if(!$cart->subtotal_ex_tax) return false; 
    
    if( ! canUserHaveDiscounts() ){
		
		// No hay descuentos en estas ciudades
        return false;

    }
    
    $cart_total = $cart->subtotal_ex_tax;

    $chosen_payment_method = getUserPaymentMethod();

    $percent = 0; 

    switch( $chosen_payment_method) {           

        case "bacs": // Direct Bank Transfer  
            $percent = BACS_DISCOUNT;
            $label_text = BACS_DISCOUNT_LEYEND;
            break; 

        case "cod": //Cash on Delivery
            
            if (isCustumerUser() || ! isUserLoggedIn()) {            
                
                $percent = COD_DISCOUNT;    
                $label_text = COD_DISCOUNT_LEYEND;
                
            } 

            break;
    
        default:
            
            $label_text = 'Sin descuentos';
            break;

    }

    if ($percent<1) return true;

    $discount = number_format(($cart_total / 100) * $percent, 2); // Calculating percentage
    
    $cart->add_fee( $label_text, -$discount, false ); // Adding the discount    

}


function cargar_scripts_adicionales(){

    // jQuery
    ?>

    <script type="text/javascript">

        (function($){

            $( 'form.checkout' ).on( 'change', 'input[name^="payment_method"]', function() {

                try {
                    jQuery(document.body).trigger('update_checkout');   	
                } catch (error) {
                   console.log(error); 
                }

            });            

        })(jQuery);
        </script>

    <?php

}

function calcular_descuentos_por_metodo_de_envio() 
{


    if( !canUserHaveDiscounts() )
    {

        removeDiscounts();

        return refreshCheckoutFrontEnd();
    
    }
    
    $chosen_payment_method = getUserPaymentMethod();

	//print_r('<script type="text/javascript">console.log("Metodo de pago elegido: '.$chosen_payment_method.'");</script>');
            
    if( $chosen_payment_method != "bacs") {           
		
		removeDiscounts();

    }else {
                
        $discount = number_format((WC()->cart->subtotal_ex_tax / 100) * BACS_DISCOUNT, 2); // Calculating percentage
    
        WC()->cart->add_fee( BACS_DISCOUNT_LEYEND, -$discount, false ); // Adding the discount

	}

	return refreshCheckoutFrontEnd();

}

add_action( 'woocommerce_cart_calculate_fees','calcular_descuentos_por_metodo_de_pago', 20, 1 );

add_action( 'wp_footer', 'cargar_scripts_adicionales' ); // Ajax / jQuery script

add_action( 'woocommerce_review_order_after_shipping', 'calcular_descuentos_por_metodo_de_envio', 20 );



/*
* Lectura sugerida:
* https://www.tychesoftwares.com/how-to-add-charges-or-discounts-for-different-payment-methods-in-woocommerce/
* Plugin -> https://wordpress.org/plugins/woocommerce-payment-discounts/
*   GIT -> https://github.com/claudiosanches/woocommerce-payment-discounts
* Plugin -> https://es.wordpress.org/plugins/woo-payment-discounts/
*
*/