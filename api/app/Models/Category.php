<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'vcard',
        'name',
        'type'
    ];

    public function vcard()
    {
        return $this->belongsTo(VCard::class, 'vcard');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}