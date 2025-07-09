<?php

namespace App\Services;

use App\Models\FlagbitRef;
use App\Models\Transaction;
use App\Models\Zeittraum;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DomainService
{
    public function createZeitraum(Carbon $von, Carbon $bis): Zeittraum
    {
        \DB::statement(
            "call erstelle_zeitraum(?, ?, @output_zeitraum_id)",
            [$von, $bis]
        );

        $result = \DB::select('SELECT @output_zeitraum_id AS zeitraum_id');

        return Zeittraum::findOrFail($result[0]->zeitraum_id);
    }

    public function getTransactionsByUser(int $userId, ?int $transactionId = null): Collection
    {
        return Transaction::join('vertragsverw_vertrag', 'vertragsverw_vertrag.vertrag_id', '=', 'transaktion_transaktionen.vertrag_id')
            ->where(array_filter(['nutzer_id' => $userId, 'trans_id' => $transactionId]))
            ->get();
    }
}
