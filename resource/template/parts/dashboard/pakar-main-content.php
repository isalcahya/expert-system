<div class="container-fluid pt-3">
	<div class="row">
		<div class="col-xl-12">
	    <div class="card bg-neutral">
	      <div class="card-header bg-transparent">
	        <div class="row align-items-center">
	          <div class="col">
	            <h5 class="h3 text-black mb-0"><?php _e( 'Data Diagnosa', 'WPIC' ); ?></h5>
	          </div>
	        </div>
	      </div>
	      <div class="card-body">
	      	<table id="example" class="table table-striped table-bordered" style="width:100%">
		        <thead>
		            <tr>
		                <th>No</th>
		                <th>Nama</th>
		                <th>NO.HP</th>
		                <th>KERUSAKAN</th>
		                <th>DETAIL</th>
		            </tr>
		        </thead>
		        <tbody>
		        	<?php for ($i=0; $i <120 ; $i++) : ?>
		        		<tr>
			                <td><?= $i ?></td>
			                <td>System Architect</td>
			                <td>Edinburgh</td>
			                <td>61</td>
			                <td>
			                	<a href="#" type="button" class="btn btn-sm btn-primary">P</a>
			                	<a href="#" type="button" class="btn btn-sm btn-danger">D</a>
			                </td>
			            </tr>
		        	<?php endfor ?>
		        </tbody>
		        <tfoot>
		            <tr>
		                <th>No</th>
		                <th>Nama</th>
		                <th>NO.HP</th>
		                <th>KERUSAKAN</th>
		                <th>DETAIL</th>
		            </tr>
		        </tfoot>
		    </table>
	      </div>
	    </div>
	  </div>
	</div>
</div>