<?php
/**
 * Created by PhpStorm.
 * User: Angela Adams
 * Date: 12/22/2016
 */

// Get the Starships data from swapi
$swapi_url = 'http://swapi.co/api/starships/';
$curl = curl_init($swapi_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_response = curl_exec($curl);
curl_close($curl);

// Decode it into json array
$starships_json = json_decode($curl_response, true);

// Parse out just the results array
$starships_results = $starships_json['results'];

/*$starships_pretty = json_encode($starships_json['results'], JSON_PRETTY_PRINT);
echo "<pre>" . $starships_pretty . "</pre>";*/