<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;
use App\Models\Category;

class vCard extends Model
{
    public $table = 'vcards';

    protected $primaryKey = 'phone_number';

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