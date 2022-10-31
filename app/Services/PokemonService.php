<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class PokemonService
{
    public function getPokemons($limit, $offset): Response
    {
        return Http::get('https://pokeapi.co/api/v2/pokemon' . '?limit=' . ($limit ? $limit : '20') . '&offset=' . ($offset ? $offset : '0'));
    }
}
