<?php
Namespace Models;
use Illuminate\Database\Eloquent\Model;
/**
 *
 */
class Kerusakan extends Model {
	protected $table = 'kerusakan';
	protected $fillable = array( 'id_kerusakan', 'nama_kerusakan', 'solusi' );
}