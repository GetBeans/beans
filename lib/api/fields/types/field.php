<?php
/**
 * Renders the field's label and description.
 *
 * @package Beans\Framework\API\Fields\Types
 */

beans_add_smart_action( 'beans_field_wrap_prepend_markup', 'beans_field_label' );
/**
 * Render the field's label.
 *
 * @since 1.0.0
 *
 * @param array $field {
 *                     Array of data.
 *
 * @type string $label The field label. Default false.
 * }
 */
function beans_field_label( array $field ) {
	$label = beans_get( 'label', $field );

	if ( ! $label ) {
		return;
	}

	beans_open_markup_e( 'beans_field_label[_' . $field['id'] . ']', 'label' );
	echo esc_html( $field['label'] );
	beans_close_markup_e( 'beans_field_label[_' . $field['id'] . ']', 'label' );
}

beans_add_smart_action( 'beans_field_wrap_append_markup', 'beans_field_description' );
/**
 * Echo field description.
 *
 * @since 1.0.0
 *
 * @param array $field       {
 *                           Array of data.
 *
 * @type string $description The field description. The description can be truncated using <!--more--> as a delimiter.
 *       Default false.
 * }
 */
function beans_field_description( array $field ) {
	$description = beans_get( 'description', $field );

	if ( ! $description ) {
		return;
	}
	// Escape the description here.
	$description = wp_kses_post( $description );

	if ( preg_match( '#<!--more-->#', $description, $matches ) ) {
		list( $description, $extended ) = explode( $matches[0], $description, 2 );
	}

	beans_open_markup_e( 'beans_field_description[_' . $field['id'] . ']', 'div', array( 'class' => 'bs-field-description' ) );
		echo wp_kses_post( $description ); // @codingStandardsIgnoreStart - Generic.WhiteSpace.ScopeIndent.IncorrectExact - the indent is intentional to indicate HTML structure.

	if ( isset( $extended ) ) {
		include dirname( __FILE__ ) . '/views/field-description.php';
	}

	beans_close_markup_e( 'beans_field_description[_' . $field['id'] . ']', 'div' );
}
