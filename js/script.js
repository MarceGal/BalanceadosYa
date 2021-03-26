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

}

function city_change_handler() {

    var ciudad_Id = jQuery("#billing_city").val();

    if (ciudad_Id === undefined || ciudad_Id === null) {
        return false;
    }

    jQuery("#billing_postcode").val(ciudad_Id);

    current_ciudad = getCiudadById(ciudad_Id);

    jQuery("#shipping_turno").empty();

    jQuery("#shipping_turno").append(jQuery('<option value="">Seleccioná un turno para tu entrega</option>'));

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
            { label: 'Mañana', rango: ['11:00', '15:00'] }
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

jQuery(document).ready(function() {

    init_checkout();

});

jQuery(document).load(function() {
    //alert(jQuery("#turno"));
});