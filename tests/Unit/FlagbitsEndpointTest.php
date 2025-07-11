<?php

namespace Tests\Unit;

use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class FlagbitsEndpointTest extends TestCase
{

    use ApiKeyTestTrait;

    /**
     * A basic unit test example.
     */
    public function test_get_flagbits_for_api_user(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TEST_API_KEY,
        ])->get('/api/flagbits');

        $response->assertSuccessful();
        $response->assertJsonIsObject();

        $response->assertJson(fn(AssertableJson $json) => $json->has('data')
            ->has('data', 2)
            ->has('data.0', fn(AssertableJson $json) => $json->where('flagbit_ref_id', 100)
                ->where('flagbit.flagbit_id', 4)
                ->where('flagbit_name', 'TRANSACTION_FLAG_EXT_API')
                ->where('datensatz_typ.datensatz_typ_id', 2)
                ->where('datensatz_typ.beschreibung', 'trans_id')
                ->etc()
            )
            ->has('data.1', fn(AssertableJson $json) => $json->where('flagbit_ref_id', 102)
                ->where('flagbit.flagbit_id', 12)
                ->where('flagbit_name', 'TRANSACTION_FLAG_CHECKOUT')
                ->where('datensatz_typ.datensatz_typ_id', 2)
                ->where('datensatz_typ.beschreibung', 'trans_id')
                ->etc()
            )
        );
    }

    public function test_get_flagbits_for_api_user_via_trans_id()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TEST_API_KEY,
        ])->get('/api/flagbits/2');

        $response->assertSuccessful();
        $response->assertJsonIsObject();

        $response->assertJson(fn(AssertableJson $json) => $json->where('flagbit_ref_id', 101)
            ->where('flagbit.flagbit_id', 4)
            ->where('flagbit_name', 'TRANSACTION_FLAG_EXT_API')
            ->where('datensatz_typ.datensatz_typ_id', 2)
            ->where('datensatz_typ.beschreibung', 'trans_id')
            ->etc()
        );
    }
}
