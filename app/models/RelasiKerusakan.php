<?php
Namespace Models;
use Illuminate\Database\Eloquent\Model;
/**
 *
 */
class RelasiKerusakan extends Model {
	protected $table = 'basis_pengetahuan';
	protected $fillable = array( 'id_gejala', 'id_kerusakan' );
}