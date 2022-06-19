<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Number
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_number extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {
      if( isset( $this->field['settings'] ) ) { extract( $this->field['settings'] ); }
      $min = $min  = ( isset( $min  ) ) ? $min  : null;
      $max = $max  = ( isset( $max  ) ) ? $max  :null;
    echo $this->element_before();
    $unit = ( isset( $this->field['unit'] ) ) ? '<em>'. $this->field['unit'] .'</em>' : '';
    echo '<input type="number" name="'. $this->element_name() .'" value="'. $this->element_value().'"'. $this->element_class() . $this->element_attributes() .' min="'.$min.'" max="'.$max.'"/>'. $unit;
    echo $this->element_after();

  }

}
