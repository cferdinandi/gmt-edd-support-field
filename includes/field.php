<?php

	/**
	 * Display plugin field at checkout
	 */
	function gmt_edd_display_support_fields() {
		$download = edd_get_option( 'gmt_edd_support_field_download', false );
		$items = edd_get_cart_contents();
		$show_field = false;
		foreach ($items as $item) {
			if ( intval( $item['id'] ) === intval( $download ) ) {
				$show_field = true;
				break;
			}
		}
		if ( empty($show_field) ) return;
	?>
		<p id="edd-support-wrap">
			<label class="edd-label" for="edd-support">
				<?php _e( 'Which plugin is this support plan for?', 'edd_support' ); ?>
			</label>
			<input class="edd-input" type="text" name="edd_support" id="edd-support" placeholder="Plugin Name">
		</p>
		<?php
	}
	add_action( 'edd_purchase_form_before_cc_form', 'gmt_edd_display_support_fields' );



	/**
	 * Make plugin field required
	 */
	function gmt_edd_required_support_fields( $required_fields ) {
		$download = edd_get_option( 'gmt_edd_support_field_download', false );
		$items = edd_get_cart_contents();
		$show_field = false;
		foreach ($items as $item) {
			if ( intval( $item['id'] ) === intval( $download ) ) {
				$required_fields['edd_support'] = array(
					'error_id' => 'invalid_support',
					'error_message' => 'Please enter a plugin.'
				);
				break;
			}
		}
		return $required_fields;
	}
	add_filter( 'edd_purchase_form_required_fields', 'gmt_edd_required_support_fields' );



	/**
	 * Set error if plugin field is empty
	 */
	function gmt_edd_validate_support_fields( $valid_data, $data ) {
		$download = edd_get_option( 'gmt_edd_support_field_download', false );
		$items = edd_get_cart_contents();
		$show_field = false;
		foreach ($items as $item) {
			if ( intval( $item['id'] ) === intval( $download ) ) {
				if ( empty( $data['edd_support'] ) ) {
					edd_set_error( 'invalid_support', 'Please enter a plugin.' );
				}
				break;
			}
		}
	}
	add_action( 'edd_checkout_error_checks', 'gmt_edd_validate_support_fields', 10, 2 );



	/**
	 * Store the custom field data into EDD's payment meta
	 */
	function gmt_edd_store_custom_support_fields( $payment_meta ) {

		if ( did_action( 'edd_purchase' ) ) {
			$payment_meta['support_field'] = isset( $_POST['edd_support'] ) ? sanitize_text_field( $_POST['edd_support'] ) : '';
		}

		return $payment_meta;
	}
	add_filter( 'edd_payment_meta', 'gmt_edd_store_custom_support_fields');



	/**
	 * Add the plugin name to the "View Order Details" page
	 */
	function gmt_edd_support_view_order_details( $payment_meta, $user_info ) {
		$support = isset( $payment_meta['support_field'] ) ? $payment_meta['support_field'] : 'none';
	?>
		<div class="column-container">
			<div class="column">
				<strong><?php _e( 'Plugin', 'edd_support' ); ?>: </strong>
				 <?php echo $support; ?>
			</div>
		</div>
	<?php
	}
	add_action( 'edd_payment_personal_details_list', 'gmt_edd_support_view_order_details', 10, 2 );



	/**
	 * Add a {plugin} tag for use in either the purchase receipt email or admin notification emails
	 */
	function gmt_edd_add_support_tag() {
		edd_add_email_tag( 'plugin', 'Plugin support was purchasd for', 'gmt_edd_email_tag_support' );
	}
	add_action( 'edd_add_email_tags', 'gmt_edd_add_support_tag' );



	/**
	 * The {plugin} email tag
	 */
	function gmt_edd_email_tag_support( $payment_id ) {
		$payment_data = edd_get_payment_meta( $payment_id );
		return $payment_data['support_field'];
	}