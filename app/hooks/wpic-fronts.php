<?php
use Delight\Cookie\Session;
/**
 *
 */
class WpicFronts {

	protected $pathDist;

	// if you want to activated this class just set from unregister to register
	public function register(){
		$this->pathDist = untrailingslashit( WCIC()->get_path( 'dist', true ) );
	}

	public function init(){
		add_action( 'init', array( $this, 'register_script' ) );
		add_action( 'wpic_on_render', array( $this, 'wpic_fronts_enqueue' ) );
		add_action( 'wcic-render-login', array( $this, 'remove_front_dependency' ) );
		add_action( 'wcic-setup-register-page', array( $this, 'remove_front_dependency' ) );
		add_action( 'wcic-render-landpage', array( $this, 'prepare_landpage' ) );
		add_action( 'wcic_navbar_template', array( $this, 'navbar_default_template' ) );
		add_action( 'pakar_navbar_template', array( $this, 'pakar_navbar_template' ) );
		add_action( 'front_post_handler', array( $this, 'front_auth_post_callback' ), 10, 2 );
 	}

 	public function pakar_navbar_template(){
 		view()->render( 'parts/pakar-navbar-header' );
 	}

 	public function front_auth_post_callback( $page, $postdata ){
 		if ( ( empty($page) && !is_string($page) ) || empty( $postdata ) ) {
			return;
		}
		if ( ! ( $auth = get_wpauth() ) ) {
			return;
		}
 		try {
 			switch ( $page ) {
 				case 'login':
 					if ( isset( $postdata['_login'] ) && $postdata['_login'] ) {
 						$auth->login($postdata['user_email'], $postdata['user_pass']);
 						if ( $auth->check() ) {
 							if ( $auth->hasRole(\Delight\Auth\Role::ADMIN) ) {
	 							redirect(redirect_by_role('admin'));
	 						}
	 						if ( $auth->hasRole(\Delight\Auth\Role::AUTHOR) ) {
	 							redirect(redirect_by_role('author'));
	 						}
 						}
			 		}
 					break;
 				case 'register':
 					if ( isset( $postdata['_register'] ) && $postdata['_register'] ) {
						$userId = $auth->register($postdata['user_email'], $postdata['user_pass'], $postdata['user_username']);
						# todo make email confirmation for registered user
						if ( $userId ) {
							// for this case , when user registered then set role for admin
							$auth->admin()->addRoleForUserById( $userId, \Delight\Auth\Role::ADMIN );
							$auth->login( $postdata['user_email'], $postdata['user_pass'] );
							if ( $auth->check() ) {
								redirect(WCIC()->get_path('', true).'wp-user/');
							}
						}
			 		}
 					break;
 				case 'diagnosa':
					$diagnosa_post_data = $postdata['diagnosa'];
					Session::set( 'diagnosa.name', $diagnosa_post_data['nama'] );
					Session::set( 'diagnosa.no', $diagnosa_post_data['no'] );
					if ( Session::has('diagnosa.name') && Session::has('diagnosa.no') ) {
						redirect(url('diagnosa.start'));
					}
					break;
 				default:
 					throw new \Exception("Error Processing Request", 1);
 					break;
 			}
		}
		catch (\Delight\Auth\InvalidEmailException $e) {
		    die('Invalid email address');
		}
		catch (\Delight\Auth\InvalidPasswordException $e) {
		    die('Invalid password');
		}
		catch (\Delight\Auth\UserAlreadyExistsException $e) {
		    die('User already exists');
		}
		catch (\Delight\Auth\TooManyRequestsException $e) {
		    die('Too many requests');
		}
		catch (\Exception $e) {
		    die($e->getMessage());
		}
 	}

	public function navbar_default_template(){
		view()->render( 'parts/navbar-home' );
	}

	public function navbar_landpage_template(){
		view()->render( 'parts/navbar-landpage' );
	}

	public function remove_front_dependency(){
		wp_dequeue_style('front');
		wp_enqueue_style('dashboard');
	}

	public function prepare_landpage(){
		remove_action( 'wcic_navbar_template', array( $this, 'navbar_default_template' ) );
		add_action( 'wcic_navbar_template', array( $this, 'navbar_landpage_template' ) );
	}

	public function register_script(){
		// scripts
		wp_register_script( 'wpicjs', $this->pathDist . '/js/test.js', array( 'jquery', 'bootstrap', 'sweatallert' ), false, true );
		wp_register_script( 'headroom', $this->pathDist . '/assets/vendor/headroom.js/dist/headroom.min.js', array( 'jquery', 'bootstrap' ), false, true );
		// styles
		wp_register_style( 'front', $this->pathDist . '/css/front.css', false, false, 'all' );
		wp_register_style( 'fontawesome-free', $this->pathDist . '/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css', false, false, 'all' );
		wp_register_style( 'prism', $this->pathDist . '/assets/vendor/prismjs/themes/prism.css', false, false, 'all' );
		wp_register_style( 'nucleo', $this->pathDist . '/assets/vendor/nucleo/css/nucleo.css', false, false, 'all' );

		wp_localize_script( 'wpicjs', 'WPIC', array(
			'admin_ajax_url' => admin_ajax_url( 'wp-ajax.php' ),
			'csrf_token' => csrf_token()
		) );
	}

	public function wpic_fronts_enqueue(){
		wp_enqueue_script('wpicjs');
		wp_enqueue_script('headroom');
		wp_enqueue_style('front');
		// wp_enqueue_style('fontawesome-free');
		wp_enqueue_style('nucleo');
		wp_enqueue_style('prism');
	}

}