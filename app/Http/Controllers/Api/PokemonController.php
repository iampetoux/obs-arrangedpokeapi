<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PokemonService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function index(Request $request)
    {
        $pokemonsRequest = app(PokemonService::class)->getPokemons(limit: $request->input('limit'), offset: $request->input('offset'));

        $pokemons = collect(json_decode($pokemonsRequest->body())->results);

        $response = json_decode($pokemonsRequest->body(), true);
        $response['results'] = $pokemons->map(function ($pokemon) {
            $details = json_decode(Http::get($pokemon->url)->body());
            return [
                'name' => $details->name,
                'height' => $details->height,
                'weight' => $details->weight,
                'front_sprite' => $details->sprites->front_default,
                'types' => collect($details->types)->map(function ($type) {
                    return $type->type;
                })
            ];
        });
        $response['next'] = str_replace('https://pokeapi.co/api/v2/', 'http://127.0.0.1:8000/api/', $response['next']);
        $response['previous'] = str_replace('https://pokeapi.co/api/v2/', 'http://127.0.0.1:8000/api/', $response['previous']);

        return response()->json($response, Response::HTTP_OK);
    }
}
