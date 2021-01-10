<?php view()->render( 'pakar-header-diagnosa' ); ?>
<!-- Hero -->
<section class="section-header pt-7 pb-9 pb-lg-12 bg-primary text-white">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-sm-10 text-center">
                <div class="row mb-3">
                    <div class="col-sm-12 d-flex" style="justify-content: space-between;">
                        <a href="<?= url( null, null, [ 'command' => 'reset' ] ) ?>" class="btn btn-danger">Mulai ulang</a>
                        <a href="<?= url( 'home.page' ) ?>" class="btn btn-danger">Keluar</a>
                    </div>
                </div>
                <div class="card bg-neutral">
                	<div class="card-header bg-transparent">
                		<div class="row align-items-center">
                			<div class="col-sm-12">
                				<h5 class="h3 text-black mt-4"><?php echo sprintf( __( 'G%s - %s', 'WPIC' ), $gejala['id_gejala'], $gejala['nama_gejala'] ); ?></h5>
                			</div>
                		</div>
                	</div>
                	<div class="card-body text-black">
                		<form action="<?= url() ?>" method="GET">
                			<div class="row justify-content-center">
                				<div class="col-sm-12">
                					<div class="form-group">
										<div class="input-group" style="display: flex;justify-content:space-around;">
											<div>
												<div class="input-group-text">
												  <input type="radio" name="command" value="accept" checked>
												</div>
												<span><?php _e( 'Ya' ) ?></span>
											</div>
											<div>
												<div class="input-group-text">
												  <input type="radio" name="command" value="dispatch">
												</div>
												<span><?php _e( 'Tidak' ) ?></span>
											</div>
										</div>
									</div>
                				</div>
                			</div>
                			<div class="row justify-content-center">
                				<div class="col-sm-8">
                					<div class="form-group mt-3">
										<button class="col-sm-6 btn btn-primary" type="submit"><?php _e( 'Simpan Jawaban' ) ?></button>
									</div>
                				</div>
                			</div>
                		</form>
                	</div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php view()->render( 'pakar-footer-diagnosa' ); ?>