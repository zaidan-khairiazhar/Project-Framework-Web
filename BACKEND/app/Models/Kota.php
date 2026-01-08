<?php

namespace App\Models; // [cite: 27]

use Illuminate\Database\Eloquent\Model; // [cite: 28]

class Kota extends Model // [cite: 29]
{
    protected $table = 'kota';
    protected $fillable = ['propinsi_id', 'nama_kota'];
    public function propinsi()
    {
        return $this->belongsTo(Propinsi::class, 'propinsi_id');
    }
}