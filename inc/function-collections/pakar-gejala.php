<?php
use Models\Gejala;
function pakar_get_gejala_by_id( $id, $column ){
	 $gejala = Gejala::where( 'id_gejala', $id )->pluck( $column )->toArray();
	 return current( $gejala );
}