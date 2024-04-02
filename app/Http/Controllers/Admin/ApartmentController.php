<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
// Models
use App\Models\Apartment;
use App\Models\Sponsorship;
use App\Models\Service;
use App\Models\Message;

// Helpers
use Illuminate\Support\Str;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $apartments = Apartment::where('user_id',$user->id)->get();
        $sponsorhips = Sponsorship::all();
        $services = Service::all();
        $messages = Message::all();
        return view("admin.apartments.index", compact("apartments"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $apartments = Apartment::all();
        $accomodation = config('db.allTypeOfAccomodation');
        $sponsorships = Sponsorship::all();
        $services = Service::all();
        return view("admin.apartments.create",compact('apartments','sponsorships', 'services','accomodation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {   
        $validated_data = $request->validated();
        $user = Auth::user();
        $apartment = new Apartment($validated_data);
         $client = new Client([
            'verify' => false, // Impostare a true per abilitare la verifica del certificato SSL
             // Specificare il percorso del certificato CA
        ]);
        $response = $client->get('https://api.tomtom.com/search/2/geocode/query='. $apartment['address'].' '.$apartment['city'].'.json?key=03zxGHB5yWE9tQEW9M7m9s46vREYKHct' );
        $data = json_decode($response->getBody(), true);
        $apartment->name = $validated_data['name'];
        $apartment->user_id = $user->id;
        $apartment->type_of_accomodation = $validated_data['type_of_accomodation'];
        $apartment->n_guests = $validated_data['n_guests'];
        $apartment->n_rooms = $validated_data['n_rooms'];
        $apartment->n_beds = $validated_data['n_beds'];
        $apartment->n_baths = $validated_data['n_baths'];
        $apartment->price = $validated_data['price'];
        // $apartment->availability = $validated_data['availability'];
        $apartment->latitude = $data['results'][0]['position']['lat'];
        $apartment->longitude = $data['results'][0]['position']['lon'];
        $apartment->slug = Str::slug($validated_data['name']);
        $apartment->address = $validated_data['address'];
        $apartment->city = $validated_data['city'];
        $apartment->free_form_address = $data['results'][0]['address']['freeformAddress'];
        $apartment->img_cover_path = $validated_data['img_cover_path'];

        $apartment->save();

        return redirect()->route('admin.apartments.show', ['apartment' => $apartment->slug]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {   
        $apartment = Apartment::where('slug', $slug)->firstOrFail();
        $sponsorships = Sponsorship::all();
        return view("admin.apartments.show", compact("apartment", "sponsorships"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $apartment = Apartment::where("slug", $slug)->firstOrFail();
        $accomodation = config('db.allTypeOfAccomodation');
        $services = Service::all();
 
        return view("admin.apartments.edit", compact("apartment","accomodation","services"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, string $slug)
    {   
        $validated_data = $request->validated();
       
        $apartment = Apartment::where("slug", $slug)->firstOrFail();
        $client = new Client([
            'verify' => false, // Impostare a true per abilitare la verifica del certificato SSL
             // Specificare il percorso del certificato CA
        ]);
        $response = $client->get('https://api.tomtom.com/search/2/geocode/query='. $apartment['address'].' '.$apartment['city'].'.json?key=03zxGHB5yWE9tQEW9M7m9s46vREYKHct' );
        $data = json_decode($response->getBody(), true);

        
        $apartment->name = $validated_data['name'];
        $apartment->type_of_accomodation = $validated_data['type_of_accomodation'];
        $apartment->n_guests = $validated_data['n_guests'];
        $apartment->n_rooms = $validated_data['n_rooms'];
        $apartment->n_beds = $validated_data['n_beds'];
        $apartment->n_baths = $validated_data['n_baths'];
        $apartment->price = $validated_data['price'];
        // $apartment->availability = $validated_data['availability'];
        if(isset($data['results'][0]['position']['lat']) && isset($data['results'][0]['position']['lon']) != null){

           $apartment->latitude = $data['results'][0]['position']['lat'];
           $apartment->longitude = $data['results'][0]['position']['lon'];
        }
        $apartment->slug = Str::slug($validated_data['name']);
        $apartment->address = $validated_data['address'];
        $apartment->city = $validated_data['city'];
        $apartment->free_form_address = $data['results'][0]['address']['freeformAddress'];
        // $apartment->img_cover_path = $validated_data['img_cover_path'];

        $apartment->save();

        return redirect()->route('admin.apartments.show', ['apartment' => $apartment->slug]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $apartment = Apartment::where('slug', $slug)->firstOrFail();

        $apartment->delete();

        return redirect()->route('admin.apartments.index');
    }
    public function restore(string $slug)
    {
        $appartamento = Apartment::withTrashed()->findOrFail( $slug);
        $appartamento->restore();

        // Restituzione della risposta appropriata (ad esempio, reindirizzamento, conferma, ecc.)
        return redirect()->route('admin.apartments.show',compact("apartment"));
    }
}
