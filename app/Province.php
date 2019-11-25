<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    // Nama Tabel
    protected $table = 'province';
    // Nama Primary Key
    protected $primaryKey = 'code';
    // Matiin timestamps
    public $timestamps = false;
    // Matiin incrementing
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'description',
    ];

    /**
     * Ngambil kota
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'code', 'provinceId');
    }
}
