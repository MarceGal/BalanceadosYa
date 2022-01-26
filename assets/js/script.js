/*
Theme Name: Balanceados Ya
Author: Claudio Marcelo Galarza
Author URI: https://linkedin.com/in/marcelogalarza/
Version: 0.3
*/


/*CHECKOUT*/

var ciudades = [];
var current_ciudad = null;

function getCiudadById(id) {

    ciudad = false;

    jQuery.each(ciudades, function(i, obj) {

        if (obj.cp == id) {
            ciudad = obj;
            return false;
        }

    });

    return ciudad;

}

function mostrar_rangos() {
    jQuery("#shipping_franja-horaria-desde_field").css('display', 'block');
    jQuery("#shipping_franja-horaria-hasta_field").css('display', 'block');
}

function ocultar_rangos() {
    jQuery("#shipping_franja-horaria-desde_field").css('display', 'none');
    jQuery("#shipping_franja-horaria-hasta_field").css('display', 'none');
}

function turno_change_handler() {

    setRangos(false);

    if (!current_ciudad) return false;

    var current_turno = jQuery("#shipping_turno").val();
    
    jQuery.each(current_ciudad.turnos, function(key, turno) {

        if (current_turno == turno.label) {

            setRangos(turno.rango);

            return true;

        }

    });

    //////
    
    
    if(current_turno){

        jQuery("#shipping_turno_field .ayuda-checkout-shipping").remove();    

        // "now" es declarada en el server. js.php        
        // Console.log( 'La hora local actual en el server es ' + now );
        let hour = now.getHours();
        let minutes = now.getMinutes();
        let deliveryforToday = false;
        let turno = current_turno.toLowerCase();
        let when = 'mañana';
        let msg = '';
        
        if(hour < 10){
            
            deliveryforToday  = true;
            when =  'hoy' ;

        } else {

            if( turno=="tarde" ){

                if(current_ciudad.cp == "2820" || current_ciudad.cp == "2852"){
                    
                    var time1430 = new Date(now);
                    // "time1430" es declarada en el server. js.php
                    time1430.setHours(14); 
                    time1430.setMinutes(30);
                    console.log( 'La hora time1430 en el server es ' + time1430 );
                    ///console.log(now, time1430, now.getTime() <= time1430.getTime());
                    
                    if( now.getTime() <= time1430.getTime() ){

                        when =  'hoy' ;
                    
                    }                

                }

            }
            
        }

        //console.log(current_ciudad);
        //msg += '<p>Hora: '+hour+':'+minutes+'</p>';    
        //msg += '<p>'+'Ciudad : '+current_ciudad.nombre+' ('+current_ciudad.cp+')<p>';
        //msg += '<p>'+'Turno : '+turno+'<p>';
        msg += '<label>¡ 📦 Tu pedido estará llegando <strong>';
        msg += when.toUpperCase();
        msg += '</strong> por la '+turno;
        msg += ', de ' +jQuery("#shipping_franja-horaria-desde").val() + ' a ' + jQuery("#shipping_franja-horaria-hasta").val();
        msg += ' ! </label>';
        
        jQuery("#shipping_turno_field").append(jQuery('<div class="ayuda-checkout-shipping">'+msg+'</div>'));

    }

    //////
    

}

function city_change_handler() {

    var ciudad_Id = jQuery("#billing_city").val();

    if (ciudad_Id === undefined || ciudad_Id === null) {
        return false;
    }

    jQuery("#billing_postcode").val(ciudad_Id);
    
    current_ciudad = getCiudadById(ciudad_Id);
    
    jQuery("#billing_state").val("E"); // Forzamos Entre Ríos como unica provincia.

    jQuery("#shipping_turno").empty();

    jQuery("#shipping_turno").append(jQuery('<option value="">Seleccioná un turno para tu entrega</option>'));
    
    jQuery("#shipping_turno_field .ayuda-checkout-shipping").remove();    

    jQuery.each(current_ciudad.turnos, function(key, turno) {

        jQuery("#shipping_turno").append(jQuery('<option value="' + turno.label + '">' + turno.label + '</option>'));

    });

    
    if (current_ciudad.turnos.length > 0) {
        mostrar_turnos();
    } else {
        ocultar_turnos();
    }

    turno_change_handler();

    jQuery(document.body).trigger("update_checkout");    
    
    //console.log('Recalculando...');

}


function mostrar_turnos() {
    jQuery("#shipping_turno_field").css('display', 'block');
    //jQuery("#shipping_turno_field").css('display', 'block');    
    jQuery("#shipping_turno_field").addClass('validate-required');

}

function ocultar_turnos() {
    jQuery("#shipping_turno_field").css('display', 'none');
    //jQuery("#shipping_turno_field").css('display', 'none');
    jQuery("#shipping_turno_field").removeClass('validate-require');


}

function setRangos(rango) {

    jQuery("#shipping_franja-horaria-desde").empty();
    jQuery("#shipping_franja-horaria-hasta").empty();
    

    if (!rango) {

        ocultar_rangos();
        return false;
    }

    jQuery.each(rango, function(key, value) {

        jQuery("#shipping_franja-horaria-desde").append(jQuery('<option value="' + value + '">' + value + '</option>'));
        jQuery("#shipping_franja-horaria-hasta").append(jQuery('<option value="' + value + '">' + value + '</option>'));

    });

    jQuery("#shipping_franja-horaria-hasta").val(rango[rango.length - 1]);

    mostrar_rangos();    

}

function init_checkout() {

    var gualeguachu = {
        cp: "2820",
        nombre: "Gualeguaychú",
        turnos: [
            { label: 'Mañana', rango: ['11:00', '13:00'] },
            { label: 'Tarde', rango: ['18:00', '20:00'] }
        ]
    };

    var pueblo_belgrano = {
        cp: "2852",
        nombre: "Pueblo Belgrano",
        turnos: [
            { label: 'Mañana', rango: ['11:00', '13:00'] },
            { label: 'Tarde', rango: ['18:00', '20:00'] }
        ]
    };

    var cDelU = {
        cp: "3260",
        nombre: "Concepción del Uruguay",
        turnos: [
            { label: 'Tarde', rango: ['15:30', '18:00'] }
        ]
    };

    var villaguay = {
        cp: "3240",
        nombre: "Villaguay",
        turnos: []
    };

    var larroque = {
        cp: "2854",
        nombre: "Larroque",
        turnos: []
    };

    ciudades.push(gualeguachu);
    ciudades.push(pueblo_belgrano);
    ciudades.push(cDelU);
    ciudades.push(villaguay);
    ciudades.push(larroque);

    jQuery("#billing_city").on('change', city_change_handler);

    jQuery("#shipping_turno_field .optional").css('display', 'none');

    jQuery("#shipping_turno").on('change', turno_change_handler);

    city_change_handler();

}


function mostrar_leyenda_puntos_de_entrega() {

    var tmp = '<p class="ayuda-checkout-shipping">👆 <b>Recuerda</b>: Si no podés esperar el pedido en tu casa, podés elegir un punto de entrega y retirar tu compra cuando puedas.</p>';
    //jQuery(tmp).insertBefore( jQuery( "#order_review #payment" ) );
    jQuery( "#shipping_method").append( tmp );
    //console.log(tmp);

}

jQuery(document).ready(function() {

    init_checkout();

});

jQuery(document).load(function() {
    //alert(jQuery("#turno"));
});