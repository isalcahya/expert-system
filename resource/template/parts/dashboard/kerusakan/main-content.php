<?php
use Models\Kerusakan;
$semuakerusakan = Kerusakan::all();
$i = 1;
?>
<div class="table-responsive">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th><?php _e( 'No' ) ?></th>
                <th><?php _e( 'Kode' ) ?></th>
                <th><?php _e( 'Nama' ) ?></th>
                <th><?php _e( 'Solusi Perbaikan' ) ?></th>
                <th><?php _e( 'opsi' ) ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($semuakerusakan as $key => $kerusakan): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?php echo sprintf( 'K%d', $kerusakan->id_kerusakan ) ?></td>
                    <td><?php echo $kerusakan->nama_kerusakan; ?></td>
                    <td><?php echo $kerusakan->solusi ?></td>
                    <td>
                        <a href="<?= url( null, null, [ 'edit-kerusakan' => $kerusakan->id_kerusakan ] ) ?>" type="button" class="btn btn-sm btn-warning">edit</a>
                        <a href="#" type="button" class="pakar-btn-remover btn btn-sm btn-danger" data-kerusakan-id="<?= $kerusakan->id_kerusakan ?>" data-selector="kerusakan"><?php _e( 'remove' ); ?></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th><?php _e( 'No' ) ?></th>
                <th><?php _e( 'Kode' ) ?></th>
                <th><?php _e( 'Nama' ) ?></th>
                <th><?php _e( 'Solusi Perbaikan' ) ?></th>
                <th><?php _e( 'opsi' ) ?></th>
            </tr>
        </tfoot>
    </table>
</div>