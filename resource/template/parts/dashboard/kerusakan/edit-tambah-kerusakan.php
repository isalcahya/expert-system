<?php
use Models\Kerusakan;
if ( isset( $_GET['edit-kerusakan'] ) && ! empty( $_GET['edit-kerusakan'] ) ) {
	$id_kerusakan = $_GET['edit-kerusakan'];
	$kerusakan = Kerusakan::where( 'id_kerusakan', $id_kerusakan )->first();
}
?>
<div class="col-xl-6">
	<div class="card bg-neutral">
		 <div class="card-header bg-transparent">
		 	<div class="row align-items-center">
	          <div class="col">
	            <h5 class="h3 text-black mb-0"><?php _e( 'Tambah Kerusakan Baru', 'WPIC' ); ?></h5>
	          </div>
	        </div>
		</div>
		<div class="card-body">
			<form action="<?= url('kerusakan') ?>" method="POST">
				<input type="hidden" name="wp_csrf_token" value="<?= csrf_token(); ?>">
				<input type="hidden" name="_request_page" value="<?php echo ! isset($kerusakan) ? 'tambah_kerusakan' : 'edit_kerusakan' ?>">
				<div class="row">
					<div class="col-lg-12">
					  <div class="form-group">
					    <label class="form-control-label" for="input-username"><?php _e( 'Kode', 'wpic' ); ?></label>
					    <input type="text" id="input-username" class="form-control" placeholder="Kode xxx" name="kerusakan[kode]" value="<?php echo isset($kerusakan->id_kerusakan) ? sprintf('K%d', $kerusakan->id_kerusakan) : 'K..'?>">
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
					  <div class="form-group">
					    <label class="form-control-label" for="input-first-name"><?php _e( 'Nama', 'wpic' ); ?></label>
					    <input type="text" id="input-first-name" class="form-control" placeholder="Name" name="kerusakan[nama]" value="<?php echo isset($kerusakan->nama_kerusakan) ? $kerusakan->nama_kerusakan : ''?>">
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
					  <div class="form-group">
					    <label class="form-control-label" for="input-first-name"><?php _e( 'Solusi Perbaikan', 'wpic' ); ?></label>
					    <textarea id="input-first-name" class="form-control" placeholder="Perbaikan" name="kerusakan[solusi]"><?php echo isset($kerusakan->solusi) ? $kerusakan->solusi : ''?></textarea>
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<button type="submit" class="btn btn-md btn-success"><?php _e( 'Submit', 'wpic' ); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>