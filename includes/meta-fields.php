<?php
/**
 * Generated by the WordPress Meta Box Generator
 * https://jeremyhixon.com/tool/wordpress-meta-box-generator/
 * 
 * Retrieving the values:
 * Enlace = get_post_meta( get_the_ID(), 'lato_linkenlace', true )
 * Estado = get_post_meta( get_the_ID(), 'lato_linkestado', true )
 * Origen = get_post_meta( get_the_ID(), 'lato_linkorigen', true )
 */
class Informacion_Del_Enlace {
	private $config = '{"title":"Informaci\u00f3n del enlace","prefix":"lato_link","domain":"informacion-del-enlace","class_name":"Informacion_Del_Enlace","context":"normal","priority":"default","cpt":"repair_link_post","fields":[{"type":"text","label":"Enlace","id":"lato_linkenlace"},{"type":"text","label":"Estado","id":"lato_linkestado"},{"type":"text","label":"Origen","id":"lato_linkorigen"}]}';

	public function __construct() {
		$this->config = json_decode( $this->config, true );
		$this->process_cpts();
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'save_post' ] );
	}

	public function process_cpts() {
		if ( !empty( $this->config['cpt'] ) ) {
			if ( empty( $this->config['post-type'] ) ) {
				$this->config['post-type'] = [];
			}
			$parts = explode( ',', $this->config['cpt'] );
			$parts = array_map( 'trim', $parts );
			$this->config['post-type'] = array_merge( $this->config['post-type'], $parts );
		}
	}

	public function add_meta_boxes() {
		foreach ( $this->config['post-type'] as $screen ) {
			add_meta_box(
				sanitize_title( $this->config['title'] ),
				$this->config['title'],
				[ $this, 'add_meta_box_callback' ],
				$screen,
				$this->config['context'],
				$this->config['priority']
			);
		}
	}

	public function save_post( $post_id ) {
		foreach ( $this->config['fields'] as $field ) {
			switch ( $field['type'] ) {
				default:
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = sanitize_text_field( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
			}
		}
	}

	public function add_meta_box_callback() {
		$this->fields_table();
	}

	private function fields_table() {
		?><table class="form-table" role="presentation">
			<tbody><?php
				foreach ( $this->config['fields'] as $field ) {
					?><tr>
						<th scope="row"><?php $this->label( $field ); ?></th>
						<td><?php $this->field( $field ); ?></td>
					</tr><?php
				}
			?></tbody>
		</table><?php
	}

	private function label( $field ) {
		switch ( $field['type'] ) {
			default:
				printf(
					'<label class="" for="%s">%s</label>',
					$field['id'], $field['label']
				);
		}
	}

	private function field( $field ) {
		switch ( $field['type'] ) {
			default:
				$this->input( $field );
		}
	}

	private function input( $field ) {
		printf(
			'<input class="regular-text %s" id="%s" name="%s" %s type="%s" value="%s">',
			isset( $field['class'] ) ? $field['class'] : '',
			$field['id'], $field['id'],
			isset( $field['pattern'] ) ? "pattern='{$field['pattern']}'" : '',
			$field['type'],
			$this->value( $field )
		);
	}

	private function value( $field ) {
		global $post;
		if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
			$value = get_post_meta( $post->ID, $field['id'], true );
		} else if ( isset( $field['default'] ) ) {
			$value = $field['default'];
		} else {
			return '';
		}
		return str_replace( '\u0027', "'", $value );
	}

}
new Informacion_Del_Enlace;


/**
 * Mostrar los datos en las columnas 
 */

add_filter('manage_repair_link_post_posts_columns', function($columns) {
    return array_merge($columns, ['url' => __('URL', 'textdomain')]);
});
add_filter('manage_repair_link_post_posts_columns', function($columns) {
    return array_merge($columns, ['estado' => __('Estado', 'textdomain')]);
});
add_filter('manage_repair_link_post_posts_columns', function($columns) {
    return array_merge($columns, ['origen' => __('Origen', 'textdomain')]);
});
 
add_action('manage_repair_link_post_posts_custom_column', function($column_key, $post_id) {
    if ($column_key == 'url') {
        $url_repair = get_post_meta( $post_id, 'lato_linkenlace', true );
            echo $url_repair;
    }
    if ($column_key == 'estado') {
        $estado_repair = get_post_meta( $post_id, 'lato_linkestado', true );
            echo $estado_repair;
    }
    if ($column_key == 'origen') {
        $origen_repair = get_post_meta( $post_id, 'lato_linkorigen', true );
            edit_post_link( __( 'Editar entrada', 'textdomain' ), '<p>', '</p>', $origen_repair, 'button butoon-primary' );
            //echo $origen_repair;
    }

}, 10, 2);
