<?php

CONST SHOPID = 'shopid';
CONST BASETOKEN = 'base64token=';

$header = json_encode([
    "alg" => "HS256",
    "typ" => "JWT"
]);

/**
 * Nepovinne polia: 
 * goodsAction
 * callback
 */

$payload = json_encode([
    "application" => [
        "orderNumber" => 12345,
        "applicant"   => [
            "firstName"        => "Meno",
            'lastName'         => "Priezvisko",
            'email'            => "email@mail.com",
            'mobile'           => "+421123456789",
            'permanentAddress' => [
                'addressLine' => "Nová 22",
                'city'        => "Novice",
                'zipCode'     => "12345",
                'country'     => "SVK"
            ],
        ],
        'subject'=> "Predmet predaja max na 250 znakov",
        'totalAmount'=> 22222,
        'goodsAction'=> null,
        'callback'=> "https://navratova-adresa.sk",
    ],
    'iat' => time()
]);

$signature = hash_hmac('sha256', base64UrlEncode($header).".".base64UrlEncode($payload), base64_decode(BASETOKEN), true);

$token     = base64UrlEncode($header).".".base64UrlEncode($payload).".".base64UrlEncode($signature);


// vysledny link
echo "https://quatroapi.vub.sk/stores/".SHOPID."/create-application?token=".$token;


function base64UrlEncode($text)
	{
		return str_replace(
			['+', '/', '='],
			['-', '_', ''],
			base64_encode($text)
		);
	}

?>