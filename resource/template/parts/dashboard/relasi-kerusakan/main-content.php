<?php
use Models\Gejala;
use Models\Kerusakan;
use Models\RelasiKerusakan;

$gejalaids = Gejala::all()->pluck( 'id_gejala' )->toArray();
$namakerusakan = Kerusakan::all()->pluck( 'nama_kerusakan', 'id_kerusakan' )->toArray();
$i = 1;
?>
<div class="row">
	<div class="col">
	  <div class="card bg-white shadow">
	    <div class="card-header bg-transparent border-0">
	      <h3 class="text-black mb-0"><?php _e( 'Data Gejala & Kerusakan', 'wpic' ) ?></h3>
	    </div>
	    <div class="table-responsive">
	      <table class="table align-items-center table-hover table-flush">
	        <thead class="thead-light">
	          <tr>
	            <th class="border-left border-right" scope="col"><?php _e( 'NO' ) ?></th>
	            <th class="border-left border-right" scope="col"><?php _e( 'ALTERNATIF' ) ?></th>
	            <?php foreach ( $gejalaids as $key => $gejala_id ): ?>
	            	<th class="border-left border-right" scope="col"><?php echo sprintf('G%d',$gejala_id); ?></th>
	            <?php endforeach ?>
	            <th class="border-left border-right" scope="col"><?php _e( 'OPSI' ) ?></th>
	          </tr>
	        </thead>
	        <tbody class="list">
	        	<?php foreach ($namakerusakan as $id_kerusakan => $kerusakan):
	        		$relation = RelasiKerusakan::where( 'id_kerusakan', $id_kerusakan )->pluck( 'id_gejala' )->toArray();
	        	?>
				<tr>
					<td class="border-left border-right"><?= $i++; ?></td>
					<td class="border-left border-right"><?php echo $kerusakan; ?></td>
					<?php foreach ( $gejalaids as $key => $gejala_id ): ?>
						<td class="border-left border-right"><?php echo in_array( $gejala_id, $relation ) ? 'YES' : '-' ?></td>
					<?php endforeach ?>
					<td>
						<a href="<?= url( null, null, [ 'part' => 'edit-relasi', 'id-kerusakan' => $id_kerusakan ] ) ?>" type="button" class="btn btn-sm btn-primary">edit</a>
					</td>
				</tr>
	        	<?php endforeach ?>
	        </tbody>
	      </table>
	    </div>
	  </div>
	</div>
</div>