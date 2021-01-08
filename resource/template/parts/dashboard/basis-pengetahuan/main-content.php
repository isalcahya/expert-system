<?php
use Models\BasisPengetahuan;
$semuabasis = BasisPengetahuan::all();
$i = 1;
?>
<div class="table-responsive">
<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr class="d-flex">
            <th class="col-sm-1"><?php _e( 'No' ); ?></th>
            <th class="col-sm-4"><?php _e( 'Gejala' ) ?></th>
            <th class="col-sm-3"><?php _e( 'Kerusakan' ) ?></th>
            <th class="col-sm-2"><?php _e( 'Solusi' ) ?></th>
            <th class="col-sm-1"><?php _e( 'Mb' ) ?></th>
            <th class="col-sm-1"><?php _e( 'Md' ) ?></th>
            <?php /* <th class="col-sm-2"><?php _e( 'Opsi' ) ?></th> */ ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ( $semuabasis as $key => $basis ): ?>
            <tr class="d-flex">
                <td class="col-sm-1"><?= $i++ ?></td>
                <td class="col-sm-4">
                    <div style="white-space: normal;word-break: break-all;display: block;">
                        <?php echo pakar_get_gejala_by_id( $basis->id_gejala, 'nama_gejala' ); ?>
                    </div>
                </td>
                <td class="col-sm-3">
                    <div style="white-space: normal;word-break: break-all;display: block;">
                        <?php echo pakar_get_kerusakan_by_id( $basis->id_kerusakan, 'nama_kerusakan' ); ?>
                    </div>
                </td>
                <td class="col-sm-2">
                    <div style="white-space: normal;word-break: break-all;display: block;">
                        <?php echo pakar_get_kerusakan_by_id( $basis->id_kerusakan, 'solusi' ); ?>
                    </div>
                </td>
                <td class="col-sm-1"><?php echo $basis->mb ?></td>
                <td class="col-sm-1"><?php echo $basis->md ?></td>
                <?php
                /*
                <td class="col-sm-2">
                    <a href="<?= url( null, null, [ 'edit-basis-data' => $basis->id ] ) ?>" type="button" class="btn btn-sm btn-warning"><?php _e( 'edit' ); ?></a>
                    <a href="<?= url( null, null, [ 'remove-basis-data' => $basis->id ] ) ?>" type="button" class="btn btn-sm btn-danger"><?php _e( 'remove' ); ?></a>
                </td>
                 */
                ?>
            </tr>
        <?php endforeach ?>
    </tbody>
    <tfoot>
        <tr class="d-flex">
            <th class="col-sm-1"><?php _e( 'No' ); ?></th>
            <th class="col-sm-4"><?php _e( 'Gejala' ) ?></th>
            <th class="col-sm-3"><?php _e( 'Kerusakan' ) ?></th>
            <th class="col-sm-2"><?php _e( 'Solusi' ) ?></th>
            <th class="col-sm-1"><?php _e( 'Mb' ) ?></th>
            <th class="col-sm-1"><?php _e( 'Md' ) ?></th>
            <?php /* <th class="col-sm-2"><?php _e( 'Opsi' ) ?></th> */ ?>
        </tr>
    </tfoot>
</table>
</div>