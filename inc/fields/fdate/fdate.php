<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Text
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_fdate extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output(){

    echo $this->element_before();
    echo '<input id="'. $this->element_name() .'" data-datetime="'. $this->element_name() .'" class="datepicker-demo" name="'. $this->element_name() .'" value="'. $this->element_value() .'" style="direction: ltr;"/> ';
    echo $this->element_after();

  }

}
