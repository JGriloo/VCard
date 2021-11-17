<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type'
    ];

    public function vcard()
    {
<<<<<<< HEAD
        return $this->belongsTo(VCard::class, 'vcard');
=======
        return $this->belongsTo(vCard::class, 'vcard');
>>>>>>> a0c8f9e02fc6586ac3c29865e2649609e267f30b
    }
}