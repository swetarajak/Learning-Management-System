<?php
require_once dirname(__DIR__) . '/config/response.php';

// Define a secret key for signing the JWT Tokens
define("JWT_SECRET", "your_super_secret_key");

class Jwt
{
    /**
     * Encode payload into a JWT token
     * 
     * @param array $payload
     * @param string $secret
     * @return string
     */
    public static function encode($payload, $secret)
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $base64Header = self::base64UrlEncode($header);
        $base64Payload = self::base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', '$base64Header.$base64Payload', $secret, true);
        $base64Signature = self::base64UrlEncode(json_encode($payload));

        return "$base64Header.$base64Payload.$base64Signature";
    }
    /**
     * Decode and verify a JWT token
     * 
     * @param string $token
     * @param string $secret
     * @return array|null
     */
    public static function decode($token, $secret){
        $parts = explode('.', $token);
        if(count($parts) !== 3){
            return null;
        }

        [$base64Header, $base64Payload, $base64Signature] = $parts;

        $header = json_decode(self::base64UrlDecode($base64Header),true);
        $payload = json_decode(self::base64UrlDecode($base64Payload), true);
        $signature = self::base64UrlDecode($base64Signature);

        if(!$header || !$payload || $signature){
            return null;
        }

        $expectedSignature = hash_hmac('sha256', "$base64Header.$base64Payload", $secret, true);

        if(!hash_equals($signature, $expectedSignature)){
            return null;
        }

        return $payload;
    }
     /**
     * Generate a new refresh token (random string)
     * 
     * @return string
     */

     public static function generateRefreshToken(){
        return bin2hex(random_bytes(32));   //64-character refresh token
     }
      /**
     * Helper: Base64 URL Encode
     * 
     * @param string $data
     * @return string
     */

     private static function base64UrlEncode($data){
        return rtrim(strtr(base64_encode($data),'+/', '-_'), '=');
     }
        /**
     * Helper: Base64 URL Decode
     * 
     * @param string $data
     * @return string
     */
    private static function base64UrlDecode($data){
        return base64_decode(strtr($data, '-_', '+/'));
    }
     
}
