<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VCard;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\StoreTransactionRequest;


class TransactionController extends Controller
{
    public function getTransactionsOfVCardSend(VCard $vcard)
    {
        return TransactionResource::collection($vcard->transactions);
    }

    public function getTransactionsOfVCardReceive(VCard $pair_vcard)
    {
        return TransactionResource::collection($pair_vcard->pair_transactions);
    }

    public function store(StoreTransactionRequest $request)
    {
        $newTransaction = Transaction::create($request->validated());
        return new TransactionResource($newTransaction);
    }
}