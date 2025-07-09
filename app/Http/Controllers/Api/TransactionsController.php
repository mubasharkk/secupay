<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Services\DomainService;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function __construct(private DomainService $domainService)
    {

    }

    public function index(Request $request)
    {
        return TransactionResource::collection(
            $this->domainService->getTransactionsByUser(
                $request->user->nutzerdetails_id,
                $request->get('trans_id')
            )
        );
    }
}
