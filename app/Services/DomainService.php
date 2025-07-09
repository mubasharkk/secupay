<?php

namespace App\Services;

use App\Models\FlagbitRef;
use App\Models\Transaction;
use App\Models\Zeitraum;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DomainService
{
    public function createZeitraum(Carbon $von, Carbon $bis): Zeitraum
    {
        \DB::statement(
            "call erstelle_zeitraum(?, ?, @output_zeitraum_id)",
            [$von, $bis]
        );

        $result = \DB::select('SELECT @output_zeitraum_id AS zeitraum_id');

        return Zeitraum::findOrFail($result[0]->zeitraum_id);
    }

    public function getTransactionsByUser(int $userId, ?int $transactionId = null): Collection
    {
        return Transaction::join('vertragsverw_vertrag', 'vertragsverw_vertrag.vertrag_id', '=', 'transaktion_transaktionen.vertrag_id')
            ->where(array_filter(['nutzer_id' => $userId, 'trans_id' => $transactionId]))
            ->get();
    }

    public function getFlagbits(): Collection
    {
        return FlagbitRef::with(['flagbit', 'dataSetType'])->get();
    }

    public function getFlatbitsByTransactionId(int $transactionId): FlagbitRef
    {
        return FlagbitRef::with(['flagbit', 'dataSetType'])
            ->join('vorgaben_datensatz_typ', 'vorgaben_datensatz_typ.datensatz_typ_id', '=', 'stamd_flagbit_ref.datensatz_typ_id')
            ->where(['datensatz_id' => $transactionId, 'vorgaben_datensatz_typ.beschreibung' => 'trans_id'])
            ->select('stamd_flagbit_ref.*')
            ->firstOrFail();
    }

}
