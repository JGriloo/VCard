<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VCard;
use App\Models\Category;
use App\Models\PaymentType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'vcard',
        'date',
        'datetime',
        'type',
        'value',
        'old_balance',
        'new_balance',
        'payment_type',
        'payment_reference',
        'pair_transaction',
        'pair_vcard',
        'category_id',
        'description',
        'custom_data',
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

    public function payment_types()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type');
    }

    public function pairTransaction(){
        return $this->belongsTo(Transaction::class, 'pair_transaction');
    }
}