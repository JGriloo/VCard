<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VCard;
use App\Http\Resources\VCardResource;
use App\Http\Requests\StoreVCardRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class VCardController extends Controller
{
    public function index()
    {
        return VCardResource::collection(VCard::all());
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

    public function updateVCard(StoreVCardRequest $request, VCard $vcard)
    {
        $vcard->update($request->validated());
        return new VCardResource($vcard);
    }

    public function update_password(UpdateUserPasswordRequest $request, VCard $vcard)
    {
        /* if (!Hash::check($request['current_password'], $vcard->password)) {
            return false;
        } */
        $vcard->password = bcrypt($request->validated()['password']);
        $vcard->save();
        return new VCardResource($vcard);
    }

    public function update_confirmationCode(UpdateUserConfirmationCodeRequest $request, VCard $vcard)
    {
        $vcard->confirmation_code = bcrypt($request->validated()['confirmation_code']);
        $vcard->save();
        return new VCardResource($vcard);
    }

    //Soft delete, it will stay in the DB
    public function destroyVCard(vCard $vcard)
    {
        $vcard->delete();
        return new VCardResource($vcard);
    }

    public function getBalance(Request $request) {
        $balance = vCard::select('phone_number', 'balance')->where('phone_number', $request->user()->id)->first();
        return $balance;
    }
}