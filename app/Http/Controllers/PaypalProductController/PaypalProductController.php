<?php

namespace App\Http\Controllers\PaypalProductController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaypalProduct\PaypalProduct;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Auth;
class PaypalProductController extends Controller
{   
    private $access_token;
    private $paypal_client_id;
    private $paypal_secret;
    private $url;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $paypayProduct = PaypalProduct::all();
      return response()->json(['products' => $paypayProduct]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $query = \DB::transaction(function () use($request){

        $this->setConfigs();
        //Access Token
        $this->access_token = $this->getAccessToken($this->paypal_client_id, $this->paypal_secret, $this->url);
        //Datos del producto
        $product = collect($request->all())->filter(function ($item, $key){
          return $key !== "mode";
        });
        //Crea un producto en paypal
        return $this->createPaypalProduct($request->mode, $product->all());
      });
      return $query;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      //
    }

    /**
     * Create a paypal plan
     * @param \Illuminate\Http\Request $request
     * 
     */
    public function createPlan(Request $request) {
      $this->setConfigs();
      $authenticationPaypal = $this->getAccessToken($this->paypal_client_id, $this->paypal_secret, $this->url);
      $this->access_token = $authenticationPaypal['access_token'];
    }

    /**
     * Get access token
     * @param  string $client_id
     * @param  string $secret
     * @return object
     */
    public function getAccessToken($paypal_client_id, $paypal_secret, $url) {
      $client = new GuzzleClient(['base_uri' => $url]);
      $response = $client->request('POST', '/v1/oauth2/token', [
        'headers' => [
          'Accept' => 'application/json',
          'Content-Type' => 'application/x-www-form-urlencoded',
        ],
        'body' => 'grant_type=client_credentials',
        'auth' => [
          $paypal_client_id, $paypal_secret, 'basic'
        ]
      ]);
      $data = json_decode($response->getBody(), true);
      return $data['access_token'];
    }

    /**
     * Create a new paypal product
     * @param  array $product
     * @param string $mode
     * @return array
     */
    public function createPaypalProduct($mode, $product) {
      $url = "https://api-m.sandbox.paypal.com/v1/catalogs/products";
      $client = new GuzzleClient(['base_uri' => $url]);
      $response = $client->request('POST', '/v1/catalogs/products', [
        'headers' => $this->getHeaders(),
        'json' => $product
      ]);
      $paypalProduct = json_decode($response->getBody(), true);
      $paypalProduct['paypal_product_identifier'] = $paypalProduct['id'];
      $paypalProduct['paypal_mode'] = $mode;
      $paypalProduct['user_id'] = Auth::id();
      $paypalProduct['created_by'] = Auth::id();
      $paypalProduct['updated_by'] = Auth::id();
      PaypalProduct::create($paypalProduct);
      return $paypalProduct;
    }

    public function setConfigs() {
      if(config('app.env') == 'production') {
        $this->paypal_client_id = config('paypal.live.client_id');
        $this->paypal_secret = config('paypal.live.secret');
        $this->url = 'https://api.paypal.com/v1/oauth2/token';
      } else {
        $this->paypal_client_id = config('paypal.sandbox.client_id');
        $this->paypal_secret = config('paypal.sandbox.secret');
        $this->url = 'https://api-m.sandbox.paypal.com/v1/oauth2/token';
      }
    }

    /**
     * Get headers
     * @return array
     */
    public function getHeaders() {
      return [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer '.$this->access_token,
      ];
    }
}
