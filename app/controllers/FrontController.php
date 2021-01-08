<?php
namespace Controllers;
use Models\Users;
use Models\Gejala;
use Delight\Cookie\Session;
use Illuminate\Database\Capsule\Manager as Capsule;
/**
 *
 */
class FrontController {

	public function __construct(){
		if ( in_array( $method = request()->getMethod(), array( 'post', 'put', 'patch' ) ) ) {
			switch ( strtolower($method) ) {
				case 'post':
					$postdata = $_POST;
					unset( $_POST );
					break;
				case 'put':
					$postdata = $_PUT;
					unset( $_PUT );
					break;
				case 'patch':
					$postdata = $_PATCH;
					unset($_PATCH);
					break;
			}
			$page = request()->getLoadedRoute()->getName();
			$page = explode( '.', $page );
 			$page = isset($page[0]) ? $page[0] : 0;
			do_action( 'front_post_handler', $page, $postdata );
		}
	}

	public function home(){
		view()->render( 'pakar-home' );
	}

	public function login(){
		do_action( 'wcic-render-login' );
		view()->render( 'pages/login' );
	}

	public function register(){
		do_action( 'wcic-setup-register-page' );
		view()->render( 'pages/register' );
	}

	public function logout(){
		try {
			if ( ! ( $auth = get_wpauth() ) ){
				throw new \Exception("Error Processing Request", 1);
			}
			$token = input()->get( 'wp_csrf_token' );
			if ( empty($token) || !is_object($token) ) {
				throw new \Exception("Error Processing Request", 1);
			}
			$token = $token->value;
			// manualy verifier for get request
			wp_token_verifier( $token );

			// already logout
    		$auth->logOut();

    		// finnaly redirect to login page
    		redirect(url('login.page'));

		} catch (\Exception $e) {
			die($e->getMessage());
		} catch (\Delight\Auth\NotLoggedInException $e) {
		    die('Not logged in');
		}
	}

	public function diagnosa(){
		if ( pakar_destroy() ) {
			pakar_reset_diagnosa_process();
		}
		view()->render( 'pages/diagnosa' );
	}

	public function startDiagnosa(){
		// if ( ! Session::has( 'diagnosa.name' ) || ! Session::has( 'diagnosa.no' ) ) return;
		if ( pakar_reset() ) { pakar_reset_diagnosa_process(); }
			// forward chaining process
			if ( pakar_next() && Session::has('s.selected.gejala') && Session::has('s.origin.gejala') ) {
				$selector_gejala = Session::has('s.acc.gejala') ? Session::get('s.acc.gejala') : Session::get('s.selected.gejala');
				$diff_gejala = array_diff(array_keys(Session::get('s.origin.gejala')), $selector_gejala );
				if ( ! empty($diff_gejala) ) {
					$next_gejala = current($diff_gejala);
					$session_gejala = $selector_gejala;
					$session_gejala[] = $next_gejala;
					Session::set( 's.acc.gejala', $session_gejala );
					Session::set( 's.selected.gejala', array($next_gejala) );
				}
				request()->setRewriteUrl( url('diagnosa.render', [ 'id' => empty($diff_gejala) ? 0 : Session::get( 's.selected.gejala' ) ]) );
				return;
			}
			$whereInKerusakan = ! Session::has('s.selected.kerusakan') ? 1 : Session::get('s.selected.kerusakan');
			if ( Session::has('s.selected.gejala') && pakar_dispatch() ) {
				$selected_gejala 		= Session::has( 's.acc.gejala' ) ? Session::take( 's.acc.gejala' ) : Session::get('s.selected.gejala');
				$cur_selected_gejala 	= count($selected_gejala) > 1 ? end($selected_gejala) : current($selected_gejala);
				$cur_selected_kerusakan = implode( ',',array_values($whereInKerusakan));
				if ( Session::has('s.where.notin.gejala') ) {
					$notin_pusher = Session::get('s.where.notin.gejala');
					$data_gejala = array( $notin_pusher, $selected_gejala );
					$where_not_in_gejala = array_reduce($data_gejala, 'array_merge', []);
					$where_not_in_gejala = array_unique($where_not_in_gejala);
					Session::set('s.where.notin.gejala', $where_not_in_gejala);
				} else {
					Session::set('s.where.notin.gejala', $selected_gejala);
				}
				$where_not_in_kerusakan = array_values(Session::get('s.selected.kerusakan'));
				if ( Session::has('s.where.notin.kerusakan') ) {
					$notin_kerusakan_pusher = Session::get('s.where.notin.kerusakan');
					$data_kerusakan = array( $notin_kerusakan_pusher, $where_not_in_kerusakan );
					$where_not_in_kerusakan = array_reduce($data_kerusakan, 'array_merge', []);
					$where_not_in_kerusakan = array_unique($where_not_in_kerusakan);
					Session::set('s.where.notin.kerusakan', $where_not_in_kerusakan);
				} else {
					Session::set('s.where.notin.kerusakan', $where_not_in_kerusakan);
				}
				$whereInKerusakan = Capsule::select( Capsule::raw( "select id_gejala, id_kerusakan from basis_pengetahuan b_p where b_p.id_kerusakan = ( select id_kerusakan from basis_pengetahuan where id_gejala = {$cur_selected_gejala} && id_kerusakan not in({$cur_selected_kerusakan}) limit 1 )" ) );
				foreach ($whereInKerusakan as $key => $_kerusakan) {
					$where_in_gejala[] = $_kerusakan->id_gejala;
					$where_in_kerusakan[] = $_kerusakan->id_kerusakan;
				}
				if ( isset( $where_in_gejala ) && isset( $where_in_kerusakan ) ) {
					$_diff_gejala 		= array_diff($where_in_gejala, Session::get('s.where.notin.gejala'));
					$whereInKerusakan 	= current($where_in_kerusakan) === end($where_in_kerusakan) ? end($where_in_kerusakan) : 0;
					array_push($_diff_gejala, $cur_selected_gejala);
					$_intersect_gejala 	= array_intersect( array_keys(Session::get('s.origin.gejala')), $_diff_gejala );
					if ( count($_intersect_gejala) > 1 ) {
						$index_not_in = array_search( $cur_selected_kerusakan, $where_not_in_kerusakan );
						unset( $where_not_in_kerusakan[$index_not_in] );
						Session::set('s.where.notin.kerusakan', $where_not_in_kerusakan);
					}
				} else {
					$whereInKerusakan = 0;
				}
			}

			$forward_chain = Capsule::table('basis_pengetahuan')
			->join( Capsule::raw( '( select id_gejala, count(*) as jumlah from basis_pengetahuan group by id_gejala order by jumlah desc ) bp' ), 'basis_pengetahuan.id_gejala', '=', 'bp.id_gejala' );
			if ( pakar_dispatch() && isset( $where_not_in_kerusakan ) ) {
				$forward_chain = $forward_chain->whereNotIn( 'basis_pengetahuan.id_kerusakan', $where_not_in_kerusakan )
				->whereNotIn( 'basis_pengetahuan.id_gejala', isset($where_not_in_gejala) ? $where_not_in_gejala : $selected_gejala );
			}
			$forward_chain = $forward_chain
			->whereIn( 'basis_pengetahuan.id_kerusakan', is_array( $whereInKerusakan ) ? $whereInKerusakan : array( $whereInKerusakan ) )
			->select( 'basis_pengetahuan.id_kerusakan', 'basis_pengetahuan.id_gejala', 'jumlah' )
			->groupBy( 'basis_pengetahuan.id_gejala' )
			->orderByDesc('jumlah')
			->get()
			->pluck( 'id_kerusakan', 'id_gejala' )
			->toArray();

			if ( ! empty($forward_chain) ) {
				Session::set( 's.origin.gejala', $forward_chain );
				if ( ! pakar_next() ) {
					$origin_selected = array(current(array_keys($forward_chain)));
					$diff_gejala = array_diff(array_keys($forward_chain), $origin_selected);
					Session::set( 's.selected.gejala', $origin_selected );
					Session::set( 's.selected.kerusakan', array(current($forward_chain)) );
				}
				Session::set( 's.current.kerusakan', array(current($forward_chain)) );
			}
			// end forward chaining process
			request()->setRewriteUrl( url('diagnosa.render', [ 'id' => empty($forward_chain) ? 0 : $origin_selected ]) );
	}

	public function DiagnosaRenderView( $id ){
		// if ( ! Session::has( 'diagnosa.name' ) || ! Session::has( 'diagnosa.no' ) ) return;

		if ( Session::has('s.selector.gejala') ) {
			$dispatch_id = Session::get('s.selector.gejala');
			if ( Session::has( 's.status.gejala' ) ) {
				$dispatch = Session::get( 's.status.gejala' );
				$dispatch[$dispatch_id] = pakar_next() ? 'iya' : 'tidak';
				Session::set( 's.status.gejala', $dispatch );
			} else {
				Session::set( 's.status.gejala', array( $dispatch_id => pakar_next() ? 'iya' : 'tidak' ) );
			}
		}

		if ( empty($id) ) {
			if ( pakar_next() ) {
				redirect(url('diagnosa.boom'));
			} else if( pakar_dispatch() ){
				redirect(url('diagnosa.fail'));
			}
		}

		Session::set( 's.selector.gejala', $id );

		$gejala = Gejala::where( 'id_gejala', $id )->first()->toArray();

		view()->render( 'pages/diagnosa-procesed', array( 'gejala' => $gejala ) );
	}

	public function diagnosaBoom(){
		view()->render( 'pages/diagnosa-boom');
	}

	public function diagnosaFail(){
		echo "gagal";
	}

	public function landpage(){
		do_action( 'wcic-render-landpage' );
		view()->render( 'pages/landingpage' );
	}
}