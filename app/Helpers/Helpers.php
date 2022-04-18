<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use App\Models\Localidad\Localidad;
use Illuminate\Http\Response;
class Helpers {
  public $first_key;
  public $second_key;
  public $cipher;

  public function __construct() {
    $this->first_key = "0gsvUK7PwIuHyCCM80cGE1QgBIDlUecqEN15wIKt";
    $this->second_key = "Qbpd7KaGiMfE6Da7vrKsvyMQTPj4ie87ow16HnpO";
    $this->cipher = "AES-128-CFB8";
  }

  /**
   * Encripta contraseña
   * @param string $first_key
   * @param string $second_key
   * @param string $cipher
   * @param string $password
   * @return string $password_encrypted
   */
  public function encrypt($password, $first_key, $second_key, $cipher) {
    $first_key = base64_decode($first_key);
    $second_key = base64_decode($second_key);
    $method = $cipher;   
    $iv_length = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($iv_length);
    $first_encrypted = openssl_encrypt($password, $method, $first_key, OPENSSL_RAW_DATA ,$iv);   
    $second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
    $output = base64_encode($iv.$second_encrypted.$first_encrypted);   
    return $output;
  }

  /**
   * Desencripta la contraseña
   * @param string $password_encrypted
   * @param string $first_key
   * @param string $second_key
   * @param string $cipher
   * @return string $password
   */
  public function decrypt($password, $first_key, $second_key, $cipher) {
    if($password) {
      $first_key = base64_decode($first_key);
      $second_key = base64_decode($second_key);           
      $mix = base64_decode($password);
      $method = $cipher;   
      $iv_length = openssl_cipher_iv_length($method);
      $iv = substr($mix,0,$iv_length);
      $second_encrypted = substr($mix,$iv_length,64);
      $first_encrypted = substr($mix,$iv_length+64);
      $data = openssl_decrypt($first_encrypted, $method, $first_key, OPENSSL_RAW_DATA, $iv);
      $second_encrypted_new = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
      if(hash_equals($second_encrypted,$second_encrypted_new)) {
        return $data;
      }else {
      return null;
      }
    }else {
      return null;
    }
  }
}