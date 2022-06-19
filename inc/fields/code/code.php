<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.

/**
 *
 * Field: Color Picker
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_code extends CSFramework_Options
{

    public function __construct($field, $value = '', $unique = '')
    {
        parent::__construct($field, $value, $unique);
    }

    public function output()
    {
        if( isset( $this->field['settings'] ) ) { extract( $this->field['settings'] ); }

        $mode  = ( isset( $mode  ) ) ? $mode  : 'html';

        wp_enqueue_code_editor(array('type' => 'text/html'));
        echo $this->element_before();
        echo '<textarea id="'. $this->element_name().'" data-codeeditor="true" data-mode="'.$mode.'" rows="5" name="'. $this->element_name().'" class="widefat textarea">'.wp_unslash( $this->element_value() ).'</textarea>   ';
        echo $this->element_after();

    }



}
