<?php

	/**
	 * Add settings section
	 * @param array $sections The current sections
	 */
	function gmt_edd_support_field_settings_section( $sections ) {
		$sections['gmt_edd_support_field'] = __( 'Support Field', 'edd_support' );
		return $sections;
	}
	add_filter( 'edd_settings_sections_extensions', 'gmt_edd_support_field_settings_section' );



	/**
	 * Add settings
	 * @param  array $settings The existing settings
	 */
	function gmt_edd_support_field_settings( $settings ) {

		$support_field_settings = array(
			array(
				'id'    => 'gmt_edd_support_field_settings',
				'name'  => '<strong>' . __( 'Support Field Settings', 'edd_support' ) . '</strong>',
				'desc'  => __( 'Configure Support Field Settings', 'edd_support' ),
				'type'  => 'header',
			),
			array(
				'id'      => 'gmt_edd_support_field_download',
				'name'    => __( 'Support Field Download', 'edd_support' ),
				'desc'    => __( 'ID of Download to show support field for', 'edd_support' ),
				'type'    => 'text',
				'size'    => 'regular',
			),
		);
		if ( version_compare( EDD_VERSION, 2.5, '>=' ) ) {
			$support_field_settings = array( 'gmt_edd_support_field' => $support_field_settings );
		}
		return array_merge( $settings, $support_field_settings );
	}
	add_filter( 'edd_settings_extensions', 'gmt_edd_support_field_settings', 999, 1 );