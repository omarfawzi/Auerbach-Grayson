<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Info(
 *     title="AGCO Research",
 *     version="1.0.0",
 *     description="API Documentation for AGCO",
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description= "Development Environment"
 * )
 * @OA\Server(
 *     url="https://virtserver.swaggerhub.com/omarfawzi/AGCO-Research/1.0.0",
 *     description= "SwaggerHub API Auto Mocking"
 * )
 * @OA\Schema(
 *     schema="ApiResponse",
 *     type="object",
 *     description="Response entity",
 *     @OA\Property(
 *         property="code",
 *         type="string",
 *         description= "response code"
 *     ),
 *     @OA\Property (property = "message", type = "string", description = "response result prompt")
 * )
 *
 *
 * @package App\Http\Controllers
 */
class SwaggerController
{

}
