<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            'city_datas' => $city_datas,
            'pref_datas' => $pref_datas,
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
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
