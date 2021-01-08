<?php
use Models\Kerusakan;
function pakar_get_kerusakan_by_id( $id, $column ){
	$kerusakan = Kerusakan::where( 'id_kerusakan', $id )->pluck( $column )->toArray();
	return current( $kerusakan );
}