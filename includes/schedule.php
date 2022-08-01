<?php
/**
 * Registrar SCHEDULE para el cron
*/
add_filter( 'cron_schedules', 'lato_add_cron_interval' );

function lato_add_cron_interval( $schedules ) {
 $schedules['lato_one_hour'] = array(
 'interval' => 3600,
 'display' => esc_html__( 'Lato - cada 1 hora' ),
 );
return $schedules;
 }

// Unless an event is already scheduled, create one.
 
add_action( 'wp', 'lato_custom_cron_job' );
 
function lato_custom_cron_job() {
   if ( ! wp_next_scheduled( 'check_links_one_hour' ) ) {
      wp_schedule_event( time(), 'lato_one_hour', 'check_links_one_hour' );
   }
}

// Ejecutar funcion cuando corre el schedule_event
 
add_action( 'check_links_one_hour', 'update_lato_function' );

 ?>