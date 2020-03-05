<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Partners\PartnerResource;
use App\Models\Partner;
use App\Repositories\Partner\PartnerRepositoryContract;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        return PartnerResource::collection(Partner::all());
    }
}
