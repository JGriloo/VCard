<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VCard;
use App\Models\Transaction;
use App\Http\Resources\VCardResource;
use App\Http\Requests\StoreVCardRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateVCardRequest;
use App\Http\Requests\UpdateUserConfirmationCodeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VCardController extends Controller
{
    public function index(Request $request)
    {
        if($request->input('name') || $request->input('email')) {
        $vcards = vCard::query();
        if ($request->input('name')) {
            $vcards = $vcards->where('name', $request->input('name'));
        }
        if ($request->input('email')) {
            $vcards = $vcards->where('email', $request->input('email'));
            
        }
        $vcards = VCardResource::collection($vcards->orderBy('created_at', 'DESC')->get());

        return $vcards;
    } else {
        return VCardResource::collection(vCard::all());
    }
    }

    public function show(VCard $vcard)
    {
        return new VCardResource($vcard);
    }

    public function show_me(Request $request)
    {
        return new VCardResource($request->vcard());
    }

    public function storeVCard(StoreVCardRequest $request)
    {
        $dados = $request->validated();
        $dados['password'] = bcrypt($dados['password']);
        $newVCard = VCard::create($dados);
        return new VCardResource($newVCard);
    }

    public function updateVCard(UpdateVCardRequest $request, VCard $vcard)
    {
        $vcard->update($request->validated());
        return new VCardResource($vcard);
    }

    public function update_password(UpdateUserPasswordRequest $request, VCard $vcard)
    {
        /* if (!Hash::check($request['current_password'], $vcard->password)) {
            return false;
        } */
        $vcard->password = Hash::make($request->validated()['password']);
        $vcard->save();
        return new VCardResource($vcard);
    }

    public function update_confirmationCode(UpdateUserConfirmationCodeRequest $request, VCard $vcard)
    {
        $vcard->confirmation_code = Hash::make($request->validated()['confirmation_code']);
        $vcard->save();
        return new VCardResource($vcard);
    }

    //Soft delete, it will stay in the DB
    public function destroyVCard(vCard $vcard)
    {
        $transactions = Transaction::where('vcard', '=', $vcard->phone_number)->first();
        if($vcard->balance == 0 && $transactions == null) {
            $del = vCard::find($vcard->phone_number)->forceDelete();

            return response()->json(
                [
                    'message' => 'Deleted from database.'
                ]
            );
        } else if ($vcard->balance == 0){
            $vcard->delete();
            return new VCardResource($vcard);
        }
        /* if ($vcard->balance == 0) {
            $vcard->delete();
            return new VCardResource($vcard);
        } else{
            return $fail(__('Cant delete a vCard whose balance is not null!'));
        } */

        
    }

    public function blockVCard(Request $request, VCard $vcard)
    {

        $vcard = vCard::findOrFail($vcard->phone_number);
        $vcard->blocked = 1;
        $vcard->save();
    }

    public function unblockVCard(Request $request, VCard $vcard)
    {


        $vcard = vCard::findOrFail($vcard->phone_number);
        $vcard->blocked = 0;
        $vcard->save();
    }

    public function changeDebit(VCard $vcard) {
        $vcard = vCard::findOrFail($vcard->phone_number);

        $vcard->save();
    }

    public function getBalance(Request $request) {
        $balance = vCard::select('phone_number', 'balance')->where('phone_number', $request->user()->id)->first();
        return $balance;
    }
}