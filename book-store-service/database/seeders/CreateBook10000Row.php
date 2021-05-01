<?php

namespace Database\Seeders;

use App\Models\Book;
use Exception;
use Faker\Factory;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CreateBook10000Row extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataBook = array();
        $dataElastic = array();

        $faker = Factory::create();

        for ($i = 100001; $i <= 200000; $i++) {
            $name = $faker->name;

            $dataBook[] = [
                'name' => $name,
                'year' => '2000'
            ];

            $dataElastic[] = [
                'id' => $i,
                'name' => $name,
                'year' => '2000'
            ];

            if ($i % 500 == 0) {

                Book::insert($dataBook);

                try {
                    $response = Http::post('http://localhost:8000/api/book', [
                        'data' => $dataElastic
                    ]);
                } catch (BadResponseException $e) {
                    print($e->getMessage());
                    continue;
                } catch (Exception $e) {
                    print($e->getMessage());
                    continue;
                }

                $dataBook = [];
                $dataElastic = [];
                print("Created 1000 data");
                sleep(1);
            }
        }
    }
}
