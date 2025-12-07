<?php
/**
 * Plugin Menu Configuration Model
 * Called when the user is logged in as admin or with the proper capabilities
 *
 * @file  The Menu Model file
 * @package HMWP/MenuModel
 * @since 4.0.0
 */

defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class HMWP_Models_Menu {

	/**
	 * Get the admin Menu Tabs
	 *
	 * @return array
	 * @throws Exception
	 */
	public function getMenu() {

                $menu = array(
                        'hmwp_settings'   => array(
                                'name'       => esc_html__( "Overview", 'hide-my-wp' ),
                                'title'      => esc_html__( "Overview", 'hide-my-wp' ),
                                'capability' => HMWP_CAPABILITY,
                                'parent'     => 'hmwp_settings',
                                'function'   => array( HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Overview' ), 'init' ),
                        ),
                        'hmwp_permalinks' => array(
                                'name'       => esc_html__( "Hide Paths", 'hide-my-wp' ),
                                'title'      => esc_html__( "Hide Paths", 'hide-my-wp' ),
                                'capability' => HMWP_CAPABILITY,
                                'parent'     => 'hmwp_settings',
                                'function'   => array( HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init' ),
                        ),
                        'hmwp_tweaks'     => array(
                                'name'       => esc_html__( "Hide Elements", 'hide-my-wp' ),
                                'title'      => esc_html__( "Hide Elements", 'hide-my-wp' ),
                                'capability' => HMWP_CAPABILITY,
                                'parent'     => 'hmwp_settings',
                                'function'   => array( HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Settings' ), 'init' ),
                        ),
                );

                //Return the menu array
                return apply_filters( 'hmwp_menu', $menu );
	}

	/**
	 * Get the Submenu section for each menu
	 *
	 * @param  string  $current
	 *
	 * @return array|mixed
	 */
	public function getSubMenu( $current ) {
		$submenu = array();

                $subtabs = array(
                        'hmwp_permalinks' => array(
                                array(
                                        'title' => esc_html__( "Admin Path", 'hide-my-wp' ),
                                        'tab'   => 'newadmin',
                                ),
                                array(
                                        'title' => esc_html__( "Login Path", 'hide-my-wp' ),
                                        'tab'   => 'newlogin',
                                ),
                                array(
                                        'title' => esc_html__( "REST API", 'hide-my-wp' ),
                                        'tab'   => 'ajax',
                                ),
                        ),
                        'hmwp_tweaks'     => array(
                                array(
                                        'title' => esc_html__( "Visibility", 'hide-my-wp' ),
                                        'tab'   => 'behavior',
                                ),
                        ),
                );

		//Return all submenus
		if ( isset( $subtabs[ $current ] ) ) {
			$submenu = $subtabs[ $current ];
		}

		return apply_filters( 'hmwp_submenu', $submenu );
	}

	/**
	 *
	 *
	 * @var array with the menu content
	 *
	 * $page_title (string) (required) The text to be displayed in the title tags of the page when the menu is selected
	 * $menu_title (string) (required) The on-screen name text for the menu
	 * $capability (string) (required) The capability required for this menu to be displayed to the user. User levels are deprecated and should not be used here!
	 * $menu_slug (string) (required) The slug name to refer to this menu by (should be unique for this menu). Prior to Version 3.0 this was called the file (or handle) parameter. If the function parameter is omitted, the menu_slug should be the PHP file that handles the display of the menu page content.
	 * $function The function that displays the page content for the menu page. Technically, the function parameter is optional, but if it is not supplied, then WordPress will basically assume that including the PHP file will generate the administration screen, without calling a function. Most plugin authors choose to put the page-generating code in a function within their main plugin file.:In the event that the function parameter is specified, it is possible to use any string for the file parameter. This allows usage of pages such as ?page=my_super_plugin_page instead of ?page=my-super-plugin/admin-options.php.
	 * $icon_url (string) (optional) The url to the icon to be used for this menu. This parameter is optional. Icons should be fairly small, around 16 x 16 pixels for best results. You can use the plugin_dir_url( __FILE__ ) function to get the URL of your plugin directory and then add the image filename to it. You can set $icon_url to "div" to have WordPress generate <br> tag instead of <img>. This can be used for more advanced formating via CSS, such as changing icon on hover.
	 * $position (integer) (optional) The position in the menu order this menu should appear. By default, if this parameter is omitted, the menu will appear at the bottom of the menu structure. The higher the number, the lower its position in the menu. WARNING: if 2 menu items use the same position attribute, one of the items may be overwritten so that only one item displays!
	 * */
	public $menu = array();
	public $meta = array();

	/**
	 * Add a menu in WP admin page
	 *
	 * @param  array  $param
	 *
	 * @return void
	 */
	public function addMenu( $param ) {
		$this->menu = $param;

		if ( is_array( $this->menu ) ) {

			if ( $this->menu[0] <> '' && $this->menu[1] <> '' ) {

				if ( ! isset( $this->menu[5] ) ) {
					$this->menu[5] = null;
				}
				if ( ! isset( $this->menu[6] ) ) {
					$this->menu[6] = null;
				}

				/* add the menu with WP */
				add_menu_page( $this->menu[0], $this->menu[1], $this->menu[2], $this->menu[3], $this->menu[4], $this->menu[5], $this->menu[6] );
			}
		}
	}

	/**
	 * Add a submenumenu in WP admin page
	 *
	 * @param  array  $param
	 *
	 * @return void
	 */
	public function addSubmenu( $param = null ) {
		if ( $param ) {
			$this->menu = $param;
		}

		if ( is_array( $this->menu ) ) {

			if ( $this->menu[0] <> '' && $this->menu[1] <> '' ) {

				if ( ! isset( $this->menu[5] ) ) {
					$this->menu[5] = null;
				}
				if ( ! isset( $this->menu[6] ) ) {
					$this->menu[6] = null;
				}

				/* add the menu with WP */
				add_submenu_page( $this->menu[0], $this->menu[1], $this->menu[2], $this->menu[3], $this->menu[4], $this->menu[5], $this->menu[6] );
			}
		}
	}

	/**
	 * Load the Settings class when the plugin settings are loaded
	 * Used for loading the CSS and JS only in the settings area
	 *
	 * @param  string  $classes
	 *
	 * @return string
	 * @throws Exception
	 */
	public function addSettingsClass( $classes ) {
		if ( $page = HMWP_Classes_Tools::getValue( 'page' ) ) {

			$menu = $this->getMenu();
			if ( in_array( $page, array_keys( $menu ) ) ) {
				//Add the class when loading the plugin settings
				$classes = "$classes hmwp-settings";
			}

		}

		//Return the classes
		return $classes;
	}

	/**
	 * Add compatibility on CSS and JS with other plugins and themes
	 * Called in Menu Controller to fix teh CSS and JS compatibility
	 */
	public function fixEnqueueErrors() {

		$exclude = array(
			'boostrap',
			'wpcd-admin-js',
			'ampforwp_admin_js',
			'__ytprefs_admin__',
			'wpf-graphics-admin-style',
			'wwp-bootstrap',
			'wwp-bootstrap-select',
			'wwp-popper',
			'wwp-script',
			'wpf_admin_style',
			'wpf_bootstrap_script',
			'wpf_wpfb-front_script',
			'auxin-admin-style',
			'wdc-styles-extras',
			'wdc-styles-main',
			'wp-color-picker-alpha',  //collor picker compatibility
			'td_wp_admin',
			'td_wp_admin_color_picker',
			'td_wp_admin_panel',
			'td_edit_page',
			'td_page_options',
			'td_tooltip',
			'td_confirm',
			'thickbox',
			'font-awesome',
			'bootstrap-iconpicker-iconset',
			'bootstrap-iconpicker',
			'cs_admin_styles_css',
			'jobcareer_admin_styles_css',
			'jobcareer_editor_style',
			'jobcareer_bootstrap_min_js',
			'cs_fonticonpicker_bootstrap_css',
			'cs_bootstrap_slider_css',
			'cs_bootstrap_css',
			'cs_bootstrap_slider',
			'cs_bootstrap_min_js',
			'cs_bootstrap_slider_js',
			'bootstrap',
			'wp-reset',
			'buy-me-a-coffee',
			'mylisting-admin-general',
			'stm-admin-vmc-style'
		);

		//Exclude the styles and scripts that affects the plugin functionality
		foreach ( $exclude as $name ) {
			wp_dequeue_script( $name );
			wp_dequeue_style( $name );
		}
	}

}
