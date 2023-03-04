<?php
/**
 * Theme Customizer
 *
 * @package sp
 */

function sp_customize_register( $wp_customize ) {
    $wp_customize->add_setting( 'admin_logo', array(
        'sanitize_callback' => 'esc_url',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'admin_logo', array(
        'label'    => __( 'Logo tela administrativa', 'sp' ),
        'section'  => 'title_tagline',
        'settings' => 'admin_logo',
    ) ) );

}
add_action( 'customize_register', 'sp_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function sp_customize_preview_js() {
    wp_enqueue_script( 'sp_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'sp_customize_preview_js' );
