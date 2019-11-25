<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    // Nama tabel
    protected $table = 'city';
    // Primary key
    protected $primaryKey = 'code';
    // Matiin timestamps
    public $timestamps = false;
    // Matiin increment
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'description', 'provinceId',
    ];

    /**
     * Buat ngambil nilai dari province yang sesuai dengan provinceId
     */
    public function province()
    {
        return $this->hasOne(Province::class, 'code', 'provinceId');
    }
}
