<?php
use Models\Gejala;
?>
<div class="table-responsive">
<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th><?php _e( 'No' ); ?></th>
            <th><?php _e( 'Kode' ) ?></th>
            <th><?php _e( 'Gejala' ) ?></th>
            <th><?php _e( 'OPSI' ) ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $semuagejala = Gejala::all();
        $i = 1;
        ?>
        <?php foreach ( $semuagejala as $key => $gejala ): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?php echo sprintf( 'G%d', $gejala->id_gejala ) ?></td>
                <td><?php _e( $gejala->nama_gejala ) ?></td>
                <td>
                    <a href="<?= url( null, null, [ 'edit-gejala' => $gejala->id_gejala ] ) ?>" type="button" class="btn btn-sm btn-warning"><?php _e( 'edit' ); ?></a>
                    <a href="#" type="button" class="pakar-btn-remover btn btn-sm btn-danger" data-gejala-id="<?= $gejala->id_gejala ?>" data-selector="gejala"><?php _e( 'remove' ); ?></a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
    <tfoot>
        <tr>
            <th><?php _e( 'No' ); ?></th>
            <th><?php _e( 'Kode' ) ?></th>
            <th><?php _e( 'Nama Gejala' ) ?></th>
            <th><?php _e( 'OPSI' ) ?></th>
        </tr>
    </tfoot>
</table>
</div>