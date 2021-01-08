<?php
/**
 *
 */
class DashboardApp {
	protected $pathDist;

	// if you want to activated this class just set from unregister to register
	public function register(){
		$this->pathDist = untrailingslashit( WCIC()->get_path( 'dist', true ) );
	}

	public function init(){
		add_action( 'admin_init', array( $this, 'add_admin_dashboard_page' ) );
		add_filter( 'dashboard_content_callback', array( $this, 'pakar_custom_callback' ) );
		add_action( 'init', array( $this, 'pakar_register_scripts' ) );
		add_action( 'wpic_on_render', array( $this, 'pakar_admin_init' ) );
		add_action( 'pakar_after_delete_kerusakan', array( $this, 'pakar_after_delete_kerusakan' ) );
		add_action( 'pakar_after_delete_gejala', array( $this, 'pakar_after_delete_gejala' ) );
	}

	public function pakar_after_delete_kerusakan($id_kerusakan){
		if ( ! $id_kerusakan ) return;
		$removes = \Models\RelasiKerusakan::where( 'id_kerusakan', $id_kerusakan )->delete();
		if ( ! $removes ) {
			throw new Exception("Error Delete Gejala where id {$id_kerusakan}", 1);
		}
	}

	public function pakar_after_delete_gajala($id_gejala){
		if ( ! $id_gejala ) return;
		$removes = \Models\RelasiKerusakan::where( 'id_gejala', $id_gejala )->delete();
		if ( ! $removes ) {
			throw new Exception("Error Delete Gejala where id {$id_gejala}", 1);
		}
	}

	public function add_admin_dashboard_page(){
		add_dashboard_page('gejala', __( 'Data Gejala' ), 'manage', 'data-gejala', array($this, 'gejala_callback'), 'ni ni-album-2');
		add_dashboard_page('kerusakan', __( 'Data Kerusakan' ), 'manage', 'data-kerusakan', array($this, 'kerusakan_callback'), 'ni ni-album-2');
		// add_dashboard_page('basis-pengetahuan', __( 'Basis Pengetahuan' ), 'manage', 'basis-pengetahuan', array($this, 'basis_pengetahuan_callback'), 'ni ni-album-2');
		add_dashboard_page('relasi-kerusakan', __( 'Relasi Kerusakan' ), 'manage', 'relasi-kerusakan', array($this, 'relasi_kerusakan_callback'), 'ni ni-album-2');
	}

	public function pakar_admin_init(  ){
		wp_enqueue_script( 'pakardatatablebs4' );
		// wp_enqueue_style( 'pakardatatablecss' );
	}

	public function pakar_register_scripts(){
		wp_register_script( 'pakardatatable', $this->pathDist . '/assets/vendor/datatables.net/js/jquery.dataTables.min.js', array( 'jquery', 'bootstrap' ), false, true );
		wp_register_script( 'pakardatatablebs4', $this->pathDist . '/assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js', array( 'pakardatatable' ), false, true );
		wp_register_style( 'pakarbootscss', $this->pathDist . '/css/bootstrap4.css', false, false, true );
		wp_register_style( 'pakardatatablecss', $this->pathDist . '/assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css', array( 'pakarbootscss' ), false, true );
	}

	public function pakar_custom_callback( $callback ){
		return array(
			$this,
			'pakar_dashboard_content'
		);
	}

	public function basis_pengetahuan_callback(){
		view()->render( 'parts/dashboard/pakar-basis-pengetahuan-content' );
	}

	public function relasi_kerusakan_callback(){
		view()->render( 'parts/dashboard/pakar-relasi-content' );
	}

	public function kerusakan_callback(){
		view()->render( 'parts/dashboard/pakar-kerusakan-content' );
	}

	public function gejala_callback(){
		view()->render( 'parts/dashboard/pakar-gejala-content' );
	}

	public function pakar_dashboard_content(){
		view()->render( 'parts/dashboard/pakar-main-content' );
	}
}