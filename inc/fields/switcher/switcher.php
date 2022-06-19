<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Switcher
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_switcher extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {
      if( isset( $this->field['settings'] ) ) { extract( $this->field['settings'] ); }
      $on = $on  = ( isset( $on  ) ) ? $on  : __( 'on', 'cs-framework' );
      $off = $off  = ( isset( $off  ) ) ? $off  : __( 'off', 'cs-framework' );
    echo $this->element_before();
    $label = ( isset( $this->field['label'] ) ) ? '<div class="cs-text-desc">'. $this->field['label'] . '</div>' : '';
    echo '<label><input type="checkbox" name="'. $this->element_name() .'" value="1"'. $this->element_class() . $this->element_attributes() . checked( $this->element_value(), 1, false ) .'/><em data-on="'. $on .'" data-off="'. $off .'"></em><span></span></label>' . $label;
    echo $this->element_after();

  }

}
