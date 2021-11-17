<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
=======
use App\Models\VCard;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

>>>>>>> a0c8f9e02fc6586ac3c29865e2649609e267f30b

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'payment_type',
<<<<<<< HEAD
        'payment_reference'
    ];

    public function pair_vcard()
    {
=======
        'payment_reference',
        'description',
        'pair_transaction'
    ];

    public function pairVCard(){
>>>>>>> a0c8f9e02fc6586ac3c29865e2649609e267f30b
        return $this->belongsTo(VCard::class, 'pair_vcard');
    }

    public function mainVCard()
    {
        return $this->belongsTo(VCard::class, 'vcard');
    }

<<<<<<< HEAD
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_ype');
    }
=======
>>>>>>> a0c8f9e02fc6586ac3c29865e2649609e267f30b
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
<<<<<<< HEAD
=======

    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type');
    }

    public function pairTransaction(){
        return $this->belongsTo(Transaction::class, 'pair_transaction');
    }
>>>>>>> a0c8f9e02fc6586ac3c29865e2649609e267f30b
}