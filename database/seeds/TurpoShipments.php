<?php

use App\Area;
use App\Government;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Seeder;

class TurpoShipments extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $headers = [
                'Accept' => 'application/json',
            ];
            $client = new Client([
                'headers' => $headers
            ]);
            $res = $client->get('https://backoffice.turbo-eg.com/external-api/get-government', ['authentication_key' => env('turbo_authentication_key')]);
            if ($res->getStatusCode() == 200) {
                $responseJSON = json_decode($res->getBody(), true);
                $list = [];
                foreach ($responseJSON['feed'] as $row) {
                    $list[] = ['name' => $row['name']];
                }
                Government::query()->insert($list);
            }

            $governmentList = Government::get();
            foreach ($governmentList as $gov) {
                $res = $client->get('https://backoffice.turbo-eg.com/external-api/get-area/' . $gov->id, ['authentication_key' => env('turbo_authentication_key')]);
                if ($res->getStatusCode() == 200) {
                    $responseJSON = json_decode($res->getBody(), true);
                    $list = [];
                    foreach ($responseJSON['feed'] as $row) {
                        $list[] = ['name' => $row['name'], 'government_id' => $gov->id];
                    }
                    Area::query()->insert($list);
                }
            }
        } catch (Exception $e) {
            dd('here', $e->getMessage());
        }
    }
}