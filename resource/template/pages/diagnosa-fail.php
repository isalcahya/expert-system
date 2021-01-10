<?php view()->render( 'pakar-header-diagnosa' ); ?>
<!-- Hero -->
<section class="section-header pt-70 pb-10 pb-lg-12 bg-primary">
	 <div class="col-sm-12 d-flex" style="justify-content: space-between;">
		<a href="<?= url( "diagnosa.start", null, [ 'command' => 'reset' ] ) ?>" class="btn btn-danger">Mulai ulang</a>
		<a href="<?= url( 'home.page' ) ?>" class="btn btn-danger">Keluar</a>
	</div>
    <div style="margin-top:15px">
			<ul class="list-group">
			  <li class="list-group-item active"><h1 style="text-align:center;">Mohon Maaf Kami Tidak Dapat Menemukan Kerusakan dan Solusi Yang Dialami Mobil Anda</h1></li>
			</ul>
    </div>
</section>
<?php view()->render( 'pakar-footer-diagnosa' ); ?>