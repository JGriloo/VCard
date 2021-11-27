<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\VCard;
use App\Models\Transaction;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TransactionController extends Controller
{
    public function getTransactionsOfVCardSend(VCard $vcard)
    {
        return TransactionResource::collection($vcard->transactions);
    }

    public function getTransactionsOfVCardReceive(VCard $pair_vcard)
    {
        return TransactionResource::collection($pair_vcard->pairTransactions);
    }

    public function storeTransaction(StoreTransactionRequest $request, VCard $vcard)
    {
        DB::transaction(function () use ($request, $vcard){
            $newTransaction = Transaction::create($request->validated());
            $newTransaction->update([
                'old_balance' => VCard::where('phone_number', $newTransaction->vcard)->first()->balance,
                'new_balance' =>VCard::where('phone_number', $newTransaction->vcard)->first()->balance - $newTransaction->value
            ]);
            VCard::where('phone_number', $newTransaction->vcard)->update((['balance'=>($newTransaction->old_balance)-$newTransaction->value]));
            if($newTransaction->payment_type == 'VCARD'){
                $pairTransaction = Transaction::create([
                    'vcard' => $newTransaction->pair_vcard,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'datetime' => Carbon::now()->format('Y-m-d H:i:s'),
                    'type' => $newTransaction->type == 'C' ? 'D' : 'C',
                    'value' => $newTransaction->value,
                    'old_balance' => VCard::where('phone_number', $newTransaction->pair_vcard)->first()->balance,
                    'new_balance' => $newTransaction->type == 'C'
                    ? VCard::where('phone_number', $newTransaction->pair_vcard)->first()->balance - $newTransaction->value
                    : VCard::where('phone_number', $newTransaction->pair_vcard)->first()->balance + $newTransaction->value,
                    'payment_type' => $newTransaction->payment_type,
                    'payment_reference' => $newTransaction->vcard,
                    'pair_transaction' => $newTransaction->id,
                    'pair_vcard' => $newTransaction->vcard
                ]);
                $newTransaction->update([
                    'pair_transaction' => $pairTransaction->id
                ]);
                VCard::Where('phone_number', $pairTransaction->vcard)->update((['balance'=>$pairTransaction->new_balance]));
            }
        });

	return ["success" => "Data Inserted"];
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