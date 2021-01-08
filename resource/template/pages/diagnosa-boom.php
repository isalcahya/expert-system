<?php
	if ( ! defined( 'ABSPATH' ) || ! \Delight\Cookie\Session::has('s.current.kerusakan') ) {
		exit; // Exit if accessed directly
	}

	use Models\Kerusakan;
	use Models\Gejala;

	$id_kerusakan = \Delight\Cookie\Session::get( 's.current.kerusakan' );
	$status = \Delight\Cookie\Session::get( 's.status.gejala' );
	if ( $id_kerusakan ) {
		pakar_reset_diagnosa_process();
	}
	$i = 1;
	$gejala = new Gejala;
	$namaKerusakan = Kerusakan::where( 'id_kerusakan', $id_kerusakan )->first()->toArray();
	$gejala = $gejala->whereIn( 'id_gejala', array_keys($status) )->get()->pluck('nama_gejala','id_gejala')->toArray();
	$accepted = array_filter( $status, 'pakar_filter_command_accepted' );
	$pakarcf = pakar_calculate_certainly_fact( $id_kerusakan );
?>
<?php view()->render( 'pakar-header-diagnosa' ); ?>
<!-- Hero -->
<section class="section-header pt-5 pb-9 pb-lg-12 bg-primary">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-sm-10 text-center">
            	<div class="row mb-3">
                    <div class="col-sm-12 d-flex" style="justify-content: space-between;">
                        <a href="<?= url( 'diagnosa.start', null, [ 'command' => 'reset' ] ) ?>" class="btn btn-danger">Mulai ulang</a>
                        <a href="<?= url( 'diagnosa.page', null, [ 'command' => 'destroy' ] ) ?>" class="btn btn-danger">Keluar</a>
                    </div>
                </div>
                <div class="card bg-neutral">
                	<div class="card-body p-0">
                		<ul class="list-group">
						  <li class="list-group-item active"><?php _e('Hasil Identifikasi') ?></li>
						  <?php foreach ( $status as $id => $stat ): ?>
						  	<li class="list-group-item text-left"><?php echo sprintf( '%d ) <mark>G%s</mark> - %s | <mark>%s</mark>', $i++, $id, $gejala[$id], $stat ) ; ?></li>
						  <?php endforeach ?>
						</ul>
						<ul class="list-group">
						  <li class="list-group-item active"><?php _e('Maka kerusakan yang di alami mobil anda adalah') ?></li>
						  <li class="list-group-item text-left"> <?php echo $namaKerusakan['nama_kerusakan']; ?> </li>
						  <li class="list-group-item text-left"> <?php echo sprintf( __( 'Dengan tingkat keyakinan = <mark>%s<span>&#37</span></mark>' ), $pakarcf ) ?> </li>
						</ul>
						<ul class="list-group">
						  <li class="list-group-item active"><?php _e('Maka solusi dari kerusakan mobil anda adalah') ?></li>
						  <li class="list-group-item text-left"> <?php echo $namaKerusakan['solusi']; ?> </li>
						</ul>
                	</div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php view()->render( 'pakar-footer-diagnosa' ); ?>