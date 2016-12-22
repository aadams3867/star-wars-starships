<?php
/**
 * Created by PhpStorm.
 * User: Angela Adams
 * Date: 12/22/2016
 */

// This function assembles the pic URL based on the ship's name,
// and then returns it, very helpfully.
function getPic($name){
    // Make all lowercase
    $lower_name = strtolower($name);

    // Turn the str into an array of the words
    $name_array = explode(" ", $lower_name);

    // Join the words back into a str, words separated by "-"
    $hyphen_name = implode("-", $name_array);

    // Assemble the pic URL
    $picURL = "/img/starships/" . $hyphen_name . ".png";

    return $picURL;
}