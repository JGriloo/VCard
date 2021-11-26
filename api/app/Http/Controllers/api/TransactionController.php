<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\VCard;
use App\Models\Transaction;
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

    public function storeTransaction(StoreTransactionRequest $request)
    {
        $newTransaction = Transaction::create($request->validated());
        if($newTransaction->payment_type == 'VCARD'){
            //COMO CRIAR UMA PAIR TRANSACTION? COMO VAMOS DEVOLVER AS DUAS VARIÁVEIS?
        };
        return new TransactionResource($newTransaction);
    }

    //Useful to update the category of a transaction
    public function updateTransaction(StoreTransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->validated());
        return new TransactionResource($transaction);
    }

    //Soft delete, it will stay in the DB. It might be useful to hide a transaction in the frontend
    public function destroyTransaction(Transaction $transaction)
    {
        $transaction->delete();
        return new TransactionResource($transaction);
    }
}
