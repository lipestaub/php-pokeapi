<?php
    function getPokemons(int $limit) : array {
        $url = "https://pokeapi.co/api/v2/pokemon?limit=$limit";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $result = curl_exec($curl);
        curl_close($curl);

        $pokemons = json_decode($result, true)['results'];

        return $pokemons;
    }
?>