<?php

namespace Database\Seeders;


// tom-tom



use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Controller\Admin\ApartmentController;
use Illuminate\Support\Str;
use App\Models\Apartment;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;


class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function () {

            Apartment::truncate();
        });
        $apartmentName = config('db.allNameApartments');
        $apartmentAccomodation = config('db.allTypeOfAccomodation');
        $apartmentAddress = config('db.addressesWithCoordinates');

        $imagePath = Storage::disk('public')->files('img');

        $client = new Client([
            'verify' => false, // Impostare a true per abilitare la verifica del certificato SSL
             // Specificare il percorso del certificato CA
        ]);

            for ($i = 0; $i < count($apartmentName); $i++) {

                if ($i > 0 && ($i + 1) %5 == 0){
                    sleep(1);
                }

                $apartment = new Apartment();
                $apartment->name =  $apartmentName[$i];
                $apartment->type_of_accomodation = $apartmentAccomodation[Rand(0, 9)];
                $apartment->mq = rand(20, 150);
                $apartment->n_guests = fake()->numberBetween(1, 10);
                $apartment->n_rooms = fake()->numberBetween(1, 6);
                $apartment->n_beds = fake()->numberBetween(1, 9);
                $apartment->n_baths = fake()->numberBetween(1, 3);
                $apartment->price = fake()->randomFloat(2, 1, 1000);
                $apartment->slug = Str::slug($apartmentName[$i]);
                $response = $client->get('https://api.tomtom.com/search/2/geocode/query='. $apartmentAddress[$i]['address'].' '.$apartmentAddress[$i]['city'].'.json?key=QX6VTsLjPwGWSrTRX4kLg6X3qyp5WDlt' );
                $data = json_decode($response->getBody(), true);
                $apartment->latitude = $data['results'][0]['position']['lat'];
                $apartment->longitude = $data['results'][0]['position']['lon'];
                $apartment->address = $data['results'][0]['address']['freeformAddress'];
                $apartment->img_cover_path = $imagePath[$i];
                    $user = User::inRandomOrder()->first();
                    $apartment->user_id = $user->id;
                    $apartment->save();
            }
        }
    }

