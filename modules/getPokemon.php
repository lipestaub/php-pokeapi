<?php
    function getPokemon(string $pokemonName) : array {
        $url = "https://pokeapi.co/api/v2/pokemon/$pokemonName";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $result = curl_exec($curl);
        curl_close($curl);

        return json_decode($result, true);
    }
?>