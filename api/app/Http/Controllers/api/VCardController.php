<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VCard;
use App\Http\Resources\VCardResource;
use App\Http\Requests\StoreVCardRequest;

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

    public function storeVcard(StoreVCardRequest $request)
    {
        $newVCard = VCard::create($request->validated());
        return new VCardResource($newVCard);
    }

    public function updateVCard(StoreVCardRequest $request, VCard $vcard)
    {
        $vcard->update($request->validated());
        return new VCardResource($vcard);
    }

    //Soft delete, it will stay in the DB
    public function destroyVCard(VCard $vcard)
    {
        $vcard->delete();
        return new VCardResource($vcard);
    }
}