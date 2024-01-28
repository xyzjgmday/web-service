<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *   title="Web Service - Api Docs",
     *   version="1.0",
     *   description="Api ini dibuat untuk memenuhi tugas Interoperability",
     *   @OA\Contact(
     *     email="daysubhiz@gmail.com",
     *     name="daysubhiz"
     *   )
     * )
     */

    /**
     * @OA\SecurityScheme(
     *     securityScheme="bearerAuth",
     *     type="apiKey",
     *     name="Authorization",
     *     in="header",
     * )
     */
}
