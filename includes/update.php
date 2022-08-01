<?php

/**
 * Revisar los enlaces
 */

function update_lato_function() {

$encontrados = array();

if (!function_exists("get_http_code")) {
    function get_http_code($url) {
      $handle = curl_init($url);
      curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
      $response = curl_exec($handle);
      $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
      curl_close($handle);
      return $httpCode;         
    }    
  }

// Revisar si la entrada ha sido analizada
$repair_args = array(
	'post_type'              => array( 'repair_link_post' ),
);
$repair_query = new WP_Query( $repair_args );
$revisados = array();
if ( $repair_query->have_posts() ) {
	while ( $repair_query->have_posts() ) {
		$repair_query->the_post();
        $currentRepair = get_the_ID();
        $origenId = get_post_meta( $currentRepair, 'lato_linkorigen', true );
        array_push($revisados, $origenId);
    }
}

/**
 * Consultar entradas y obtener el contenido de cada una
 */

// Argumentos de la consulta
$args = array(
	'post_type'              => array( 'post' ),
);

// Consulta
$query = new WP_Query( $args );

// Loop
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
            // datos de cada entrada

            
            $titulo = get_the_title();
            $currentPostId = get_the_ID();
            if (in_array($currentPostId, $revisados)) {
                
            } else {
                $currentContent = get_post($currentPostId)->post_content;
                preg_match_all('/(?<=(href="))(\s*.*)(?=(">))/U', $currentContent, $matches);
                $enlacesEncontrados = $matches[0];


                foreach ($enlacesEncontrados as $link_single) {

                    $estado_validacion = '';
                    $test_link = get_http_code($link_single);
                    if (preg_match("/(https:\/)(\s*.*)/", $link_single)) {
                        if ($test_link == 0) {
                            $estado_validacion = 'Url que no funciona';
                        } else {
                        $estado_validacion = 'Codigo de error: ';
                        $estado_validacion .= $test_link;
                        }
                    } else {
                        if (preg_match("/(http:\/)(\s*.*)/", $link_single)){
                            $estado_validacion = 'Enlace no seguro';
                        } elseif (preg_match("/(\/\/)(\s*.*)/", $link_single)) {
                            $estado_validacion = 'Enlace con estructura desconocida';
                        } else {
                            $estado_validacion = 'Enlace con estructura desconocida';
                        }
                        
                    }
                    if (preg_match('/(20\d)/',$test_link)) {
                        
                    } else {
                        $current = array(
                            'titulo' => $titulo,
                            'idPost' => $currentPostId,
                            'validacion' => $estado_validacion,
                            'urlDetected' => $link_single
                        );
                        array_push($encontrados, $current);
                    }
            
                } // foreach
            } //else validacion si ya fue revisado
        }  //while de la consulta
	
} else {
	// no posts found
}



//wp_reset_postdata();

foreach ($encontrados as $post_item) {
    $my_post = array(
        'post_title'    => $post_item['titulo'],
        'post_status'   => 'publish',
        'post_type' => 'repair_link_post'
    );       
    // Crear el post
    $postId = wp_insert_post( $my_post );
    update_post_meta( $postId, 'lato_linkenlace', $post_item['urlDetected'] );
    update_post_meta( $postId, 'lato_linkestado', $post_item['validacion'] );
    update_post_meta( $postId, 'lato_linkorigen', $post_item['idPost']);
  }


}


 ?>