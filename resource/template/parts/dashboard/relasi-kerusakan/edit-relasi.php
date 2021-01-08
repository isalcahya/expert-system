<?php
use Models\Kerusakan;
use Models\Gejala;
use Models\BasisPengetahuan;
if ( !isset( $_GET['id-kerusakan'] ) || empty( $_GET['id-kerusakan'] ) ) {
	echo 'tidak valid';
	exit;
}
$semuagejala = Gejala::all()->pluck( 'nama_gejala', 'id_gejala' )->toArray();
$table_kerusakan = Kerusakan::where( 'id_kerusakan', (int) $_GET['id-kerusakan']);
$kerusakan = $table_kerusakan->pluck( 'nama_kerusakan', 'id_kerusakan' )->toArray();
$id_kerusakan = key( $kerusakan );
$nama_kerusakan = $kerusakan[$id_kerusakan];

$table_relasi_kerusakan = BasisPengetahuan::where( 'id_kerusakan', (int) $_GET['id-kerusakan'] );
$relasi_gejala = $table_relasi_kerusakan->get()->toArray();
$ids_gejala = array_column($relasi_gejala, 'id_gejala');
// $data_relasi = $table_kerusakan->whereIn(  )
?>
<div class="row">
	<div class="col">
		<div class="card bg-white shadow">
			<div class="card-header bg-transparent border-0">
		      <h3 class="text-black mb-0"><?php _e( 'Edit Relasi', 'wpic' ) ?></h3>
		    </div>
		    <div class="table-responsive">
		    	<form action="<?php echo url( 'relasi-kerusakan' ) ?>" method="POST">
		    	<input type="hidden" name="wp_csrf_token" value="<?= csrf_token(); ?>">
		    	<input type="hidden" name="_request_page" value="simpan_relasi_kerusakan">
				<table class="table align-items-center table-hover table-flush">
					<thead class="thead-light">
			          <tr class="d-flex">
			            <th class="col-5 border-left border-right" scope="col">Kriteria</th>
			            <th class="col-2 border-left border-right" scope="col">MB</th>
			            <th class="col-2 border-left border-right" scope="col">MD</th>
			            <th class="col-3 border-left border-right" scope="col"><?php echo sprintf('K%d (%s)',$id_kerusakan,$nama_kerusakan); ?></th>
			          </tr>
		        	</thead>
			        <tbody class="list">
			        	<?php foreach ($semuagejala as $id => $gejala):
			        		if ( in_array( $id, $ids_gejala ) ) {
			        			${"relasi_$id"} = array_search($id, array_column($relasi_gejala, 'id_gejala'));
			        		}
			        	?>
			        		<tr class="d-flex">
				                <td class="col-sm-5 border-left border-right">
				                	<strong><?= sprintf( __( 'G%d', 'wpic' ), $id ) ?></strong>
				                	<div style="white-space: normal;word-break: break-all;display: block;">
				                		<?php echo $gejala; ?>
				                	</div>
				                </td>
				                <td class="col-sm-2 border-left border-right">
				                	<div class="row">
										<div class="col-lg-12">
										  <div class="form-group">
										    <input type="number" step="0.01" id="input-first-name" class="form-control" placeholder="-" name="relasi_kerusakan[K<?php echo $id_kerusakan ?>][G][ids][<?php echo $id ?>][mb]" value="<?php echo isset(${"relasi_$id"}) ? $relasi_gejala[${"relasi_$id"}]['mb'] : ''?>">
										  </div>
										</div>
									</div>
				                </td>
				                <td class="col-sm-2 border-left border-right">
				                	<div class="row">
										<div class="col-lg-12">
										  <div class="form-group">
										    <input type="number" step="0.01" id="input-first-name" class="form-control" placeholder="-" name="relasi_kerusakan[K<?php echo $id_kerusakan ?>][G][ids][<?php echo $id ?>][md]" value="<?php echo isset(${"relasi_$id"}) ? $relasi_gejala[${"relasi_$id"}]['md'] : ''?>">
										  </div>
										</div>
									</div>
				                </td>
				                <td class="col-sm-3 border-left border-right">
				                	<div class="row">
				                		<div class="col-sm-12">
					                		<div class="form-group">
							                	<select class="form-control" id="relasi-kerusakan" name="relasi_kerusakan[K<?php echo $id_kerusakan ?>][G][ids][<?php echo $id ?>][push]">
							                		<option><?php _e( 'NO', 'wpic'); ?></option>
							                		<option <?php echo isset( ${"relasi_$id"} ) ? 'selected' : '' ?>><?php _e( 'YES', 'wpic'); ?></option>
							                	</select>
						                	</div>
					                	</div>
				                	</div>
				                </td>
				            </tr>
			        	<?php endforeach ?>
			        </tbody>
			         <tfoot>
				        <tr class="d-flex">
				            <th class="col-5"></th>
				            <th class="col-2"></th>
				            <th class="col-2"></th>
				            <th class="col-3"><button type="submit" class="btn btn-primary"><?php _e( 'Simpan' ) ?></button></th>
				        </tr>
				    </tfoot>
				</table>
				</form>
			</div>
		</div>
	</div>
</div>