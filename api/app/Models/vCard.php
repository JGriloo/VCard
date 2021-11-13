<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vCard extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'phone_number',
        'password',
        'name',
        'email',
        'photo_url',
        'confirmation_code'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class, 'vcard');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'vcard');
    }

    public function pair_transactions()
    {
        return $this->hasMany(Transaction::class, 'pair_vcard');
    }
}