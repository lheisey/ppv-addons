<?php

/**
 * Admin functions
 *
 * @link       http://picturesquephotoviews.com/
 * @since      2.3.0
 *
 * @package    Ppv_Addons
 * @subpackage Ppv_Addons/admin
 */

/**
 * Get the value of a settings field
 *
 * @since 2.3.0
 *
 * @param string  $option  settings field name
 * @param string  $section the section name this field belongs to
 * @param string  $default default text if it's not found
 * @return string
 */
function ppv_Get_Val( $option, $section, $default = '' ) {

    $options = get_option( $section );

    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }

    return $default;
}

