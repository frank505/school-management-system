<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH ."libraries/jwt/JWT.php";

use Firebase\JWT\JWT;

class Rest_Controller
{

    const STUDENT_KEY = "__StudentCred";
    const ISSUER_URL = "http://localhost/SchoolWebRestApi/StudentRest";

public static function set_allowed_headers()
{    
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
    header("Access-Control-Allow-Methods:PUT, GET, POST, DELETE, OPTIONS");
    
}

public static function create_token($id)
{
     // iss: The issuer of the token
    // sub: The subject of the token
    // aud: The audience of the token
    // exp: This will probably be the registered claim most often used. This will define the expiration in NumericDate value. The expiration MUST be after the current date/time.
    // nbf: Defines the time before which the JWT MUST NOT be accepted for processing
    // iat: The time the JWT was issued. Can be used to determine the age of the JWT
    // jti: Unique identifier for the JWT. Can be used to prevent the JWT from being replayed. This is helpful for a one time use token.

    $token = array(
        "iss" => Rest_Controller::ISSUER_URL,
        "aud" => "$id",
          "exp"=> time() + (86400 * 30),
        "iat" => time(),
    );
    $key = Rest_Controller::STUDENT_KEY;
    $jwt = JWT::encode($token, $key);    
    return $jwt;
}



public static function decode_token($jwt_token)
{
    $jwt_token = $jwt_token."";
    $key = Rest_Controller::STUDENT_KEY;
    $decoded = JWT::decode($jwt_token, $key, array('HS256')); 
    $decoded_array = (array) $decoded; //this is to convert the ob ject to an array as it returns an object instead
     return $decoded_array;
}




}