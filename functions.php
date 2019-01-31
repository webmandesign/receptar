<?php
/**
 * Receptar WordPress Theme
 *
 * @package    Receptar
 * @author     WebMan
 * @license    GPL-2.0+
 * @link       https://www.webmandesign.eu
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.7.0
 *
 * CONTENT:
 * - 0) Constants
 * - 1) Required files
 */





/**
 * 0) Constants
 */

	if ( ! defined( 'WM_THEME_SHORTNAME' ) ) define( 'WM_THEME_SHORTNAME', str_replace( array( '-lite', '-plus' ), '', get_template() ) );
	if ( ! defined( 'WM_INC_DIR' ) ) define( 'WM_INC_DIR', trailingslashit( 'inc' ) );





/**
 * 1) Required files
 */

	// Sanitizing methods
	require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'class-sanitize.php' );

	// Main theme action hooks
	require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'lib/hooks.php' );

	// Global functions
	require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'lib/core.php' );

	// SVG icons
	require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'class-svg.php' );

	// Theme setup
	require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'setup.php' );

	// Custom header
	require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'custom-header/custom-header.php' );

	// Customizer
	require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'setup-theme-options.php' );
	require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'customizer/customizer.php' );

	// Jetpack setup
	require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'jetpack/jetpack.php' );

	// Beaver Builder setup
	require_once( trailingslashit( get_template_directory() ) . WM_INC_DIR . 'beaver-builder/beaver-builder.php' );
