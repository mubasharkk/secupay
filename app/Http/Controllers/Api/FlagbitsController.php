<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FlagBitResource;
use App\Services\DomainService;
use Illuminate\Http\Request;

class FlagbitsController extends Controller
{

    public function __construct(private DomainService $domainService)
    {

    }

    public function index(Request $request)
    {
        return FlagBitResource::collection(
            $this->domainService->getFlagbits()
        );
    }

    public function show(Request $request, int $transId)
    {
        return new FlagBitResource(
            $this->domainService->getFlatbitsByTransactionId($transId)
        );
    }
}
