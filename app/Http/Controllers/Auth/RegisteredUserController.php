<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Location;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function city($pref_code)
    {
        $client = new \GuzzleHttp\Client();
        
        $url = 'https://opendata.resas-portal.go.jp/api/v1/';
        
        $response = $client->request(
            'GET',
            $url."cities?prefCode=".$pref_code,
            array(
                "headers" => array(
                "X-API-KEY" => config('services.resas.key'),
                )
            )
        );
        $city_datas = json_decode($response->getBody(), true)['result'];
        
        return view('auth.register-city')->with([
            'city_datas' => $city_datas,
            ]);
    }
    
    
    public function create(): View
    {
        $client = new \GuzzleHttp\Client();
        
        $url = 'https://opendata.resas-portal.go.jp/api/v1/';
        
        $response = $client->request(
            'GET',
            $url."prefectures",
            array(
                "headers" => array(
                "X-API-KEY" => config('services.resas.key'),
                )
            )
        );
        $pref_datas = json_decode($response->getBody(), true)['result'];
        
        
        return view('auth.register')->with([
            'pref_datas' => $pref_datas,
            ]);
    }
    
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'select_prefecture' => ['required']
        ]);
        
        $pref_data = preg_split("/,/", $request->select_prefecture);
        $pref_code = $pref_data[0];
        $pref_name = $pref_data[1];
        
        $location = Location::create([
            'pref_code' => $pref_code,
            'pref_name' => $pref_name,
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        

        event(new Registered($user));

        Auth::login($user);
        
        //市区町村の登録ページに飛ぶ
        $city = RouteServiceProvider::CITY;
        return redirect($city.'/'.$pref_code);
    }
    
    public function storeCity(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'select_city' => ['required']
        ]);
        
        $city_data = preg_split("/,/", $request->select_city);
        $city_code = $pref_data[0];
        $city_name = $pref_data[1];
        
        $user->locations()->fill([
            'city_code' => $city_code,
            'city_name' => $city_name,
        ])->save();
        
        return redirect(RouteServiceProvider::city);
    }
}
