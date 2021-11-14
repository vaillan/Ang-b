<?php

namespace App\Http\Controllers\ServiceSelectedController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceSelected\ServiceSelected;

class ServiceSelectedController extends Controller
{
    public function createService($postClient, $servicesSelected) {
        $query = \DB::transaction(function () use($postClient, $servicesSelected) {
            foreach ($servicesSelected as $service) {
                ServiceSelected::create([
                  'service_id' => $service->id,
                  'post_client_id' => $postClient->id,
                ]);
            }
        });
        return $query;
    }
}
