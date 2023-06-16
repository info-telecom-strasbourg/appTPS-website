<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Client extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        'name',
        'fouaille_token'
    ];

    // public function getFouailleToken()
    // {
    //     if (!isset($this->fouaille_token)
    //         || HTTP::withToken($this->fouaille_token)
    //             ->get(env('FOUAILLE_APP_URL').'/api/tokenAvailable')
    //             ->status() != 200){
    //         $token = HTTP::acceptJson()
    //             ->post(env('FOUAILLE_APP_URL').'/api/login', [
    //                 'name' => $this->name,
    //                 'password' => env('PASSWORD_FOUAILLE_APP')
    //             ])->json()['token'];

    //         $this->update([
    //             'fouaille_token' => $token
    //         ]);
    //     }

    //     return $this->fouaille_token;
    // }
}
