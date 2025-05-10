<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class ImportLocationData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:location-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import countries, states, and cities from JSON';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $path = storage_path('app/public/countries+states+cities.json');
        $json = json_decode(file_get_contents($path), true);

        $countries = [];
        $states = [];
        $cities = [];

        foreach ($json as $countryData) {
            $countries[] = ['country_name' => $countryData['country']];
        }

        DB::transaction(function () use ($json, &$countries, &$states, &$cities) {
            DB::table('countries')->insertOrIgnore($countries);
            $countryMap = DB::table('countries')->pluck('id', 'country_name');

            foreach ($json as $countryData) {
                $countryId = $countryMap[$countryData['country']];

                foreach ($countryData['states'] as $stateData) {
                    $states[] = [
                        'country_id' => $countryId,
                        'state_name' => $stateData['state']
                    ];
                }
            }

            DB::table('states')->insertOrIgnore($states);
            $stateMap = DB::table('states')->pluck('id', 'state_name');

            foreach ($json as $countryData) {
                foreach ($countryData['states'] as $stateData) {
                    $stateId = $stateMap[$stateData['state']];
                    foreach ($stateData['cities'] as $city) {
                        $cities[] = [
                            'state_id' => $stateId,
                            'city_name' => $city
                        ];
                    }
                }
            }

            DB::table('cities')->insertOrIgnore($cities);
        });

        $this->info('Data imported successfully.');
    }

}
