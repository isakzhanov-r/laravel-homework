<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Partner\PartnerRepositoryContract;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    protected $partners;

    public function __construct(PartnerRepositoryContract $partner_repository_contract)
    {
        $this->partners = $partner_repository_contract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->partners->getAll();

        return response()->json($data);
    }
}
