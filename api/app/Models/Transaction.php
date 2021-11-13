<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VCard;
use App\Models\Category;
use Illuminate\Support\Facades\DB;


class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'payment_type',
        'payment_reference',
        'description',
        'pair_transaction'
    ];

    public function pairVCard(){
        return $this->belongsTo(VCard::class, 'pair_vcard');
    }

    public function mainVCard()
    {
        return $this->belongsTo(VCard::class, 'vcard');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function payment_type()
    {
        return $this->belongsTo(PaymentType::Class, 'payment_type');
    }

    public function pairTransaction(){
        return $this->belongsTo(Transaction::class, 'pair_transaction');
    }
}