<?php
/**
 * Shortcode
 *
 * @package Copy the Code
 * @since 2.2.0
 */

if ( ! class_exists( 'Copy_The_Code_Shortcode' ) ) :

	/**
	 * Shortcode
	 *
	 * @since 2.2.0
	 */
	class Copy_The_Code_Shortcode {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object Class Instance.
		 * @since 2.2.0
		 */
		private static $instance;

		/**
		 * Initiator
		 *
		 * @since 2.2.0
		 * @return object initialized object of class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'init_admin_settings' ) );
			add_shortcode( 'copy', array( $this, 'shortcode_markup' ) );
		}

		/**
		 * Shortcode markup
		 *
		 * @since 2.2.0
		 * @param array $atts Shortcode parameters.
		 * @param mixed $content Shortcode content.
		 * @return mixed
		 */
		public function shortcode_markup( $atts = array(), $content = '' ) {
			$atts = apply_filters(
				'copy_the_code_shortcode_atts',
				shortcode_atts(
					array(
						'target'      => '',
						'title'       => __( 'Copy to Clipboard', 'copy-the-code' ),
						'text'        => $content,
						'copied-text' => 'Copied to Clipboard',
						'tag'         => 'span',
						'class'       => '',
						'copy-as'     => 'text',
						'content'     => $content,
						'link'        => isset( $atts['link'] ) ? $atts['link'] : '',
						'style'		  => '',
						'color'  	  => '',
						'icon-color'  => '',
					),
					$atts
				)
			);

			$color = $atts['color'];
			$display_content = wp_kses_post( $atts['text'] );
			if ( 'icon' === $atts[ 'style' ] ) {
				$icon_color = ! empty( $atts['icon-color'] ) ? $atts['icon-color'] : '#b5b5b5';

				$display_content = '<svg style="fill: ' . $icon_color . '" viewBox="-21 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m186.667969 416c-49.984375 0-90.667969-40.683594-90.667969-90.667969v-218.664062h-37.332031c-32.363281 0-58.667969 26.300781-58.667969 58.664062v288c0 32.363281 26.304688 58.667969 58.667969 58.667969h266.664062c32.363281 0 58.667969-26.304688 58.667969-58.667969v-37.332031zm0 0"></path><path d="m469.332031 58.667969c0-32.40625-26.261719-58.667969-58.664062-58.667969h-224c-32.40625 0-58.667969 26.261719-58.667969 58.667969v266.664062c0 32.40625 26.261719 58.667969 58.667969 58.667969h224c32.402343 0 58.664062-26.261719 58.664062-58.667969zm0 0"></path></svg>';
			}

			return '<' . esc_html( $atts['tag'] ) . ' title="' . esc_attr( $atts['title'] ) . '" class="copy-the-code-shortcode ' . esc_attr( $atts['class'] ) . '" data-target="' . esc_attr( $atts['target'] ) . '" data-button-text="' . esc_attr( $atts['text'] ) . '" data-button-copy-text="' . esc_attr( $atts['copied-text'] ) . '" data-content="' . esc_attr( $atts['content'] ) . '" data-copy-as="' . esc_attr( $atts['copy-as'] ) . '" data-link="' . esc_attr( $atts['link'] ) . '" style="color: ' . esc_attr( $color ) . '" >' .  $display_content . '</' . esc_html( $atts['tag'] ) . '>';
		}

		/**
		 * Register menus
		 *
		 * @since 2.2.0
		 * @return void
		 */
		function init_admin_settings() {
			if ( current_user_can( 'edit_posts' ) ) {
				add_action( 'admin_menu', array( $this, 'register' ) );
				add_action( 'admin_footer', array( $this, 'hide_menus' ) );
			}
		}

		/**
		 * Hide menus
		 *
		 * @since 2.2.0
		 * @return void
		 */
		function hide_menus() {
			?>
			<style type="text/css">
				#adminmenu a[href="options-general.php?page=copy-to-clipboard-add-new"],
				#adminmenu a[href="options-general.php?page=copy-the-code"],
				#adminmenu a[href="options-general.php?page=copy-the-code-contact"],
				#adminmenu a[href="options-general.php?page=copy-the-code-wp-support-forum"],
				#adminmenu a[href="options-general.php?page=copy-the-code-pricing"],
				#adminmenu a[href="options-general.php?page=copy-the-code-account"] {
					display: none !important;
				}
			</style>
			<?php

			if ( ! isset( $_GET['post_type'] ) ) {
				return;
			}

			if ( 'copy-to-clipboard' !== $_GET['post_type'] ) {
				return;
			}

			wp_enqueue_script( 'jquery' );

			$menus = array(
				'copy-the-code-wp-support-forum' => 'Support Forum',
			);

			if ( ctc_fs()->is_not_paying() ) {
				$menus['copy-the-code-pricing'] = 'Upgrade';
			} else {
				$menus['copy-the-code-account'] = 'Account';
			}

			$menus = array_merge(
				$menus,
				array(
					'copy-the-code-contact' => 'Contact Us',
					'copy-the-code'         => 'Dashboard',
				)
			);

			?>
			<script>
				// Add button tag after class .page-title-action.
				jQuery( document ).ready( function( $ ) {
					let menus = <?php echo wp_json_encode( $menus ); ?>;
					$.each( menus, function( key, value ) {
						let target = '';
						if( 'copy-the-code-wp-support-forum' === key ) {
							target = 'target="_blank"';
						}
						$( '.wrap > .page-title-action' ).after( '<a ' + target + ' class="cta-sub-menu cta-sub-menu-'+key+'" href="<?php echo admin_url( 'options-general.php?page=' ); ?>' + key + '">' + value + '</a>' );
					} );
				} );
			</script>
			<style>
				.cta-sub-menu.cta-sub-menu-copy-the-code-wp-support-forum:after {
					content: "\f504";
					font-family: dashicons;
					display: inline-block;
					line-height: 1;
					font-weight: 400;
					font-style: normal;
					speak: never;
					text-decoration: inherit;
					text-transform: none;
					text-rendering: auto;
					-webkit-font-smoothing: antialiased;
					-moz-osx-font-smoothing: grayscale;
					width: 20px;
					height: 20px;
					font-size: 20px;
					vertical-align: top;
					text-align: center;
					transition: color 0.1s ease-in;
					text-decoration: none;
					font-size: 14px;
					vertical-align: sub;
				}
				.wrap .page-title-action {
					margin-right: 10px;
				}
				.cta-sub-menu {
					padding: 0 5px;
					display: inline-block;
					margin: 0;
					text-decoration: underline;
					top: -3px;
					position: relative;
				}
				</style>
			<?php
		}

		/**
		 * Registers the add new portfolio form admin menu for adding portfolios.
		 *
		 * @since 2.2.0
		 *
		 * @return void
		 */
		public function register() {
			add_submenu_page(
				'options-general.php',
				__( 'Add New', 'copy-the-code' ),
				__( ' → Add New', 'copy-the-code' ),
				'manage_options',
				'copy-to-clipboard-add-new',
				array( Copy_The_Code_Page::get_instance(), 'add_new_page' )
			);

			add_submenu_page(
				'options-general.php',
				__( 'Dashboard', 'copy-the-code' ),
				__( ' → Dashboard', 'copy-the-code' ),
				'manage_options',
				'copy-the-code',
				array( $this, 'dashboard_page_markup' )
			);
		}

		/**
		 * Shortcode page markup
		 *
		 * @since 2.2.0
		 * @return mixed
		 */
		public function dashboard_page_markup() {
			require_once COPY_THE_CODE_DIR . 'includes/dashboard.php';
		}

	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Copy_The_Code_Shortcode::get_instance();

endif;
