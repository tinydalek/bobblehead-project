<?php

// Array with names
$a[] = "Darth Vader";
$a[] = "Darth Maul";
$a[] = "Yoda";
$a[] = "Princess Leia";
$a[] = "Luke Skywalker";
$a[] = "Obi Wan Kenobi";
$a[] = "C3PO";
$a[] = "R2D2";
$a[] = "Chewbacca";
$a[] = "Jabba the Hutt";
$a[] = "Biker Scout";
$a[] = "TIE Fighter Pilot";
$a[] = "Finn";
$a[] = "Rey";
$a[] = "Unmasked Vader";
$a[] = "Luke Skywaker (X-Wing Pilot)";
$a[] = "Captain America";
$a[] = "Ghost Rider";
$a[] = "Deadpool";
$a[] = "Wolverine";
$a[] = "Dark Phoenix";
$a[] = "Spiderman";
$a[] = "Silver Surfer";
$a[] = "The Thing";
$a[] = "Hawkeye";
$a[] = "Hulk";
$a[] = "Iron Man";
$a[] = "Scarlet Witch";
$a[] = "Iron Man (Unmasked)";
$a[] = "Black Widow";
$a[] = "Thor";

// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($a as $name) {
        if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint;
?> 