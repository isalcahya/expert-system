<?php
use Models\Gejala;
use Models\Kerusakan;
use Models\RelasiKerusakan;
use Models\BasisPengetahuan;
use Delight\Cookie\Session;
use Illuminate\Database\Capsule\Manager as Capsule;
/**
 *
 */
class WpicPostHandler {
	public function register(){

	}

	public function init(){
		add_action( 'parse_request', array( $this, 'parse_request_handler' ) );
		add_action( 'parse_request', array( $this, 'debug' ) );
		add_action( 'wp_ajax_pakar_gejala_remover', array( $this, 'pakar_gejala_remover' ) );
		add_action( 'wp_ajax_pakar_kerusakan_remover', array( $this, 'pakar_kerusakan_remover' ) );
	}

	public function debug(){
		if ( ! isset( $_GET['debug'] ) ) return;
		dd('debug');
	}

	public function pakar_kerusakan_remover( ){
		if ( ! isset( $_POST['action'] ) || ! isset( $_POST['id'] ) ) {
			wp_die( 'action tidak valid', 400);
		}
		$kerusakan_id = intval( $_POST['id'] );
		try {
			$deleted = kerusakan::where( 'id_kerusakan', $kerusakan_id )->delete();
			if ( $deleted ) {
				do_action( 'pakar_after_delete_kerusakan', $kerusakan_id );
				wp_send_json( array( 'sukses' => true, 'message' => 'Data berhasil di hapus' ) );
			}
		} catch (Exception $e) {
			wp_send_json( array( 'sukses' => false, 'data' => null ) );
		}
	}

	public function pakar_gejala_remover( ){
		if ( ! isset( $_POST['action'] ) || ! isset( $_POST['id'] ) ) {
			wp_die( 'action tidak valid', 400);
		}
		$gejala_id = intval( $_POST['id'] );
		try {
			$deleted = Gejala::where( 'id_gejala', $gejala_id )->delete();
			if ( $deleted ) {
				do_action( 'pakar_after_delete_gejala', $gejala_id );
				wp_send_json( array( 'sukses' => true, 'message' => 'Data berhasil di hapus' ) );
			}
		} catch (Exception $e) {
			wp_send_json( array( 'sukses' => false, 'data' => null ) );
		}
	}

	public function parse_request_handler($request){
		if ( !is_admin() ) return;
		$method = $request->getMethod();
		if ( strtolower($method) !== 'post' ) return;
		try {
			$input 	= $request->getInputHandler();
			$page 	= $input->post( '_request_page' );
			if ( empty($page) ) {
				throw new Exception("Error Processing Request | empty page request", 1);
			}
			switch ( strtolower($page) ) {
				case 'tambah_gejala':
					$gejala = $input->post( 'gejala' );
					$kode 	= $gejala['kode_gejala']->value;
					// SANITIZE
					$kode 	= trim( strtolower($kode), 'g' );
					if ( empty($kode) ) {
						throw new Exception("Error Processing Request", 1);
					}
					$nama 	= $gejala['nama_gejala']->value;
					$dbgejala = new Gejala;
					$dbgejala->id_gejala = (int) $kode;
					$dbgejala->nama_gejala = $nama;
					$saved = $dbgejala->save();
					if ( ! $saved ) {
						throw new Exception("Error menyimpan data", 1);
					}
					break;
				case 'edit_gejala':
					#todo edit gejala
					$gejala = $input->post( 'gejala' );
					$kode 	= $gejala['kode_gejala']->value;
					// SANITIZE
					$kode 	= trim( strtolower($kode), 'g' );
					if ( empty($kode) ) {
						throw new Exception("Error Processing Request", 1);
					}
					$nama 	= $gejala['nama_gejala']->value;
					$data_update = array(
						'id_gejala' => $kode,
						'nama_gejala' => $nama
					);
					$updated = Gejala::where( 'id_gejala', $kode )->update($data_update);
					if ( ! $updated ) {
						throw new Exception("Error menyimpan data", 1);
					}
					break;
				case 'tambah_kerusakan':
					$kerusakan = $input->post( 'kerusakan' );
					$kode 	= $kerusakan['kode']->value;
					$kode 	= trim( strtolower($kode), 'k' );
					if ( empty($kode) ) {
						throw new Exception("Error Processing Request", 1);
					}
					$nama 	= $kerusakan['nama']->value;
					$solusi = $kerusakan['solusi']->value;
					$dbkerusakan = new Kerusakan;
					$dbkerusakan->id_kerusakan = (int) $kode;
					$dbkerusakan->nama_kerusakan = $nama;
					$dbkerusakan->solusi = $solusi;
					$saved = $dbkerusakan->save();
					if ( ! $saved ) {
						throw new Exception("Error menyimpan data", 1);
					}
					break;
				case 'edit_kerusakan':
					$kerusakan = $input->post( 'kerusakan' );
					$kode 	= $kerusakan['kode']->value;
					// SANITIZE
					$kode 	= trim( strtolower($kode), 'k' );
					if ( empty($kode) ) {
						throw new Exception("Error Processing Request", 1);
					}
					$nama 	= $kerusakan['nama']->value;
					$solusi = $kerusakan['solusi']->value;
					$data_update = array(
						'id_kerusakan' => $kode,
						'nama_kerusakan' => $nama,
						'solusi' => $solusi
					);
					$updated = Kerusakan::where( 'id_kerusakan', $kode )->update($data_update);
					if ( ! $updated ) {
						throw new Exception("Error menyimpan data", 1);
					}
					break;
				case 'simpan_relasi_kerusakan':
					// get var post request
					$relasi_kerusakan = $_POST['relasi_kerusakan'];
					// unset global post
					unset( $_POST['relasi_kerusakan'] );
					// get key
					$relasi_kunci = key( $relasi_kerusakan );
					$postdata = current( $relasi_kerusakan );
					$postdata_gejala = isset($postdata['G']) ? $postdata['G'] : array();
					$primary_key = ltrim( strtolower($relasi_kunci), 'k' );
					if ( empty( $postdata_gejala ) || empty($primary_key) ) {
						throw new Exception("Error Processing Request", 1);
					}
					$relasiKerusakan = RelasiKerusakan::where( 'id_kerusakan', (int) $primary_key );
					$origin_data = $relasiKerusakan->pluck('id_gejala');
					if ( empty($origin_data) ) {
						throw new Exception("Error Processing Request", 1);
					}
					$origin_data = $origin_data->toArray();
					if ( !empty($origin_data) ) {
						$keys_update 	= array_intersect( array_keys($postdata_gejala['ids']), $origin_data );
						foreach ( $keys_update as $key ) {
							if ( strtolower($postdata_gejala['ids'][$key]['push']) === 'no' ) {
								$data_removes[$key] = $postdata_gejala['ids'][$key];
							}
						}
						if ( isset( $data_removes ) && !empty($data_removes) ) {
							$removed = $relasiKerusakan->whereIn( 'id_gejala', array_keys($data_removes) )->delete();
							if ( $removed ) {
								do_action( 'pakar_after_delete_relation', $data_removes );
							}
						}
						$insert_data_keys	= array_diff( array_keys($postdata_gejala['ids']), $origin_data );
						foreach ( $insert_data_keys as $key ) {
							if ( strtolower($postdata_gejala['ids'][$key]['push']) === 'yes' ) {
								$data_inserts[$key] = $postdata_gejala['ids'][$key];
								$data_inserts[$key]['id_gejala'] = $key;
								$data_inserts[$key]['id_kerusakan'] = (int) $primary_key;
								unset( $data_inserts[$key]['push'] );
								$get_the_data_insert[] = $data_inserts[$key];
								unset( $data_inserts[$key] );
								unset( $postdata_gejala['ids'][$key] );
							}
						}
						if ( isset( $get_the_data_insert ) && !empty($get_the_data_insert) ) {
							$inserted = RelasiKerusakan::insert( $get_the_data_insert );
							if ( $inserted ) {
								do_action( 'pakar_insert_relation', $primary_key );
							}
						}
					} else {
						foreach ( $postdata_gejala['ids'] as $key => $relasi ) {
							if ( strtolower($relasi['push']) === 'yes' ) {
								$data_inserts[$key] = $relasi;
								$data_inserts[$key]['id_gejala'] = $key;
								$data_inserts[$key]['id_kerusakan'] = (int) $primary_key;
								unset( $data_inserts[$key]['push'] );
								$get_the_data_insert[] = $data_inserts[$key];
								unset( $data_inserts[$key] );
								unset( $postdata_gejala['ids'][$key] );
							}
						}
						if ( isset( $get_the_data_insert ) && !empty($get_the_data_insert) ) {
							$inserted = RelasiKerusakan::insert( $get_the_data_insert );
							if ( $inserted ) {
								do_action( 'pakar_insert_relation', $primary_key );
							}
						}
					}

					break;
				case 'tambah_basis_data':
					$basis_data = $input->post( 'basis_data' );
					if ( empty($basis_data) ) {
						throw new Exception("Error Processing Request", 1);
					}
					$gejala_id 		= $basis_data['gejala']->value;
					$kerusakan_id 	= $basis_data['kerusakan']->value;
					$mb = $basis_data['mb']->value;
					$md = $basis_data['md']->value;
					$db_basis_data = new BasisPengetahuan;
					$db_basis_data->id_gejala = $gejala_id;
					$db_basis_data->id_kerusakan = $kerusakan_id;
					$db_basis_data->mb = $mb;
					$db_basis_data->md = $md;
					$saved = $db_basis_data->save();
					if ( ! $saved ) {
						throw new Exception("Error menyimpan data", 1);
					}
					break;
				default:
					# code...
					break;
			}
			} catch(\PDOException $e){
				dd( $e->getMessage() );
			} catch (\Exception $e) {
				die( $e->getMessage() );
			}
	}
}