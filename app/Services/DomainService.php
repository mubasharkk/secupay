<?php

namespace App\Services;

use App\Models\FlagbitRef;
use App\Models\Transaction;
use App\Models\Zeitraum;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
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
        return Transaction::join(
            'vertragsverw_vertrag',
            'vertragsverw_vertrag.vertrag_id',
            '=',
            'transaktion_transaktionen.vertrag_id'
        )
            ->where(array_filter(['nutzer_id' => $userId, 'trans_id' => $transactionId]))
            ->get();
    }

    public function getFlagbits(): Collection
    {
        return FlagbitRef::with(['flagbit', 'datensatzTyp'])->get();
    }

    private function getFlatbitsTransactionsQuery(): Builder
    {
        return FlagbitRef::with(['flagbit', 'datensatzTyp'])
            ->join(
                'vorgaben_datensatz_typ',
                'vorgaben_datensatz_typ.datensatz_typ_id',
                '=',
                'stamd_flagbit_ref.datensatz_typ_id'
            )
            ->select(['stamd_flagbit_ref.*', 'transaktion_transaktionen.*', 'vertragsverw_vertrag.*'])
            ->leftJoin(
                'transaktion_transaktionen',
                'transaktion_transaktionen.trans_id',
                '=',
                'stamd_flagbit_ref.datensatz_id'
            )
            ->leftJoin(
                'vertragsverw_vertrag',
                'vertragsverw_vertrag.vertrag_id',
                '=',
                'transaktion_transaktionen.vertrag_id'
            );
    }

    public function getFlatbitsByTransactionId(int $transactionId): FlagbitRef
    {
        return $this->getFlatbitsTransactionsQuery()
            ->where(['datensatz_id' => $transactionId, 'vorgaben_datensatz_typ.beschreibung' => 'trans_id'])
            ->firstOrFail();
    }

    public function getFlatbitsByUser(int $userId, ?int $transactionId = null): Collection
    {
        return $this->getFlatbitsTransactionsQuery()
            ->where(
                array_filter([
                    'datensatz_id'                        => $transactionId,
                    'vorgaben_datensatz_typ.beschreibung' => 'trans_id',
                    'vertragsverw_vertrag.nutzer_id'      => $userId
                ])
            )
            ->get();
    }

    public function updateFlatbits(int $datesatzTypeId, int $datesatzId, int $flatbit, int $modus, int $creatorId): bool
    {
        \DB::statement(
            "call stamd_aendern_erstellen_flagbit_ref(?, ?, ?, ?, ?, @OUT_fehler_code, @OUT_fehler)",
            [$datesatzTypeId, $datesatzId, $flatbit, $modus, $creatorId]
        );

        $result = \DB::select('SELECT @OUT_fehler_code AS error_code, @OUT_fehler AS `error_message`');

        if ($result[0]->error_code) {
            throw new \Exception($result[0]->error_message, $result[0]->error_code);
        }

        return true;
    }

    public function removeFlagbit($refId)
    {
        return FlagbitRef::destroy($refId);
    }
}
