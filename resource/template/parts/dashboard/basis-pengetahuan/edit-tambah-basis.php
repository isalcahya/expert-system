<?php
use Models\BasisPengetahuan;
use Models\Gejala;
use Models\Kerusakan;
if ( isset( $_GET['edit-basis-data'] ) && ! empty( $_GET['edit-basis-data'] ) ) {
	$id_basis_data = $_GET['edit-basis-data'];
	$basis_data = BasisPengetahuan::where( 'id', $id_basis_data )->first();
}
$semuaGejala = Gejala::all();
$semuaKerusakan = Kerusakan::all();
?>

<div class="col-xl-6">
	<div class="card bg-neutral">
		 <div class="card-header bg-transparent">
		 	<div class="row align-items-center">
	          <div class="col">
	            <h5 class="h3 text-black mb-0"><?php _e( 'Tambah Basis Data Baru', 'WPIC' ); ?></h5>
	          </div>
	        </div>
		</div>
		<div class="card-body">
			<form action="<?= url('basis-pengetahuan') ?>" method="POST">
				<input type="hidden" name="wp_csrf_token" value="<?= csrf_token(); ?>">
				<input type="hidden" name="_request_page" value="<?php echo ! isset($basis_data) ? 'tambah_basis_data' : 'edit_basis_data' ?>">
				<div class="row">
					<div class="col-lg-12">
					  <div class="form-group">
					  	<label class="form-control-label" for="input-username"><?php _e( 'Gejala', 'wpic' ); ?></label>
					  	<select class="form-control" id="relasi-kerusakan" name="basis_data[gejala]">
					  		<?php foreach ( $semuaGejala as $key => $gejala ): ?>
					  			<option value="<?php echo $gejala->id_gejala; ?>" <?php echo isset($basis_data) && $basis_data->id_gejala === $gejala->id_gejala ? 'selected' : '' ?>><?php echo $gejala->nama_gejala; ?></option>
					  		<?php endforeach ?>
	                	</select>
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
					  <div class="form-group">
					    <label class="form-control-label" for="input-username"><?php _e( 'Gejala', 'wpic' ); ?></label>
					  	<select class="form-control" id="relasi-kerusakan" name="basis_data[kerusakan]">
					  		<?php foreach ( $semuaKerusakan as $key => $kerusakan ): ?>
					  			<option value="<?php echo $kerusakan->id_kerusakan; ?>" <?php echo isset($basis_data) && $basis_data->id_kerusakan === $kerusakan->id_kerusakan ? 'selected' : '' ?>><?php echo $kerusakan->nama_kerusakan; ?></option>
					  		<?php endforeach ?>
	                	</select>
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
					  <div class="form-group">
					    <label class="form-control-label" for="input-first-name"><?php _e( 'Mb', 'wpic' ); ?></label>
					    <input type="number" step="0.01" id="input-first-name" class="form-control" placeholder="0.01" name="basis_data[mb]" value="<?php echo isset($basis_data->mb) ? $basis_data->mb : ''?>">
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
					  <div class="form-group">
					    <label class="form-control-label" for="input-first-name"><?php _e( 'Md', 'wpic' ); ?></label>
					    <input type="number" step="0.01" id="input-first-name" class="form-control" placeholder="0.01" name="basis_data[md]" value="<?php echo isset($basis_data->md) ? $basis_data->md : ''?>">
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