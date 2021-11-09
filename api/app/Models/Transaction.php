<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'payment_type',
        'payment_reference'
    ];

    public function pair_vcard()
    {
        return $this->belongsTo(VCard::class, 'pair_vcard');
    }

    public function mainVCard()
    {
        return $this->belongsTo(VCard::class, 'vcard');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_ype');
    }
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}