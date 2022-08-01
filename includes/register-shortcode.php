<?php
/**
 * Creacion del shortcode
 * [extraquotes] retorna las citas adicionales del post actual
 * [extraquotes post="x"] retorna las citas del post con el id "x"
 */

add_shortcode( 'extraquotes', 'extraquotes_short' );
function extraquotes_short( $atts ){
 
    $a = shortcode_atts( array(
        'post' => get_the_ID()
        ), $atts );
        //$output = get_post_meta( $a['post'], 'extra_quote_citas', true );
        return get_post_meta( $a['post'], 'extra_quote_citas', true );
 
}
//add_action('init', 'extra_quote_init');


?>