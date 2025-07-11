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
            $this->domainService->getFlatbitsByUser($request->user->nutzerdetails_id)
        );
    }

    public function show(Request $request, int $transId)
    {
        return new FlagBitResource(
            $this->domainService->getFlatbitsByTransactionId($transId)
        );
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'datensatz_typ_id' => 'required|integer',
            'datensatz_id'     => 'required|integer',
            'flagbit'          => 'required|integer|exists:vorgaben_flagbit,flagbit_id',
            'modus'            => 'required|integer|in:1,2',
            'bearbeiter_id'    => 'required|integer',
        ]);

        return $this->domainService->updateFlatbits(
            $validatedData['datensatz_typ_id'],
            $validatedData['datensatz_id'],
            $validatedData['flagbit'],
            $validatedData['modus'],
            $validatedData['bearbeiter_id'] ?? $request->user->nutzerdetails_id,
        );
    }

    public function destroy(Request $request, int $refId)
    {
        return $this->domainService->removeFlagbit($refId);
    }
}
