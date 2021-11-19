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

    public function store(StoreVCardRequest $request)
    {
        $newVCard = VCard::create($request->validated());
        return new VCardResource($newVCard);
    }
}
