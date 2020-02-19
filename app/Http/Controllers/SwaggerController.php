<?php

namespace App\Http\Controllers;

use OpenApi\Annotations\Contact;
use OpenApi\Annotations\Info;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;
use OpenApi\Annotations\Server;

/**
 *
 * @Info(
 *     title="AGCO API",
 *     version="1.0.0",
 *     description="This is a demo service, which provides the function of demonstrating the swagger api",
 * )
 *
 * @Server(
 *     url="http://localhost:8000/api",
 *     description= "development environment"
 * )
 *
 * @Schema(
 *     schema="ApiResponse",
 *     type="object",
 *     description="Response entity, response result uses this structure uniformly",
 *     @Property(
 *         property="code",
 *         type="string",
 *         description= "response code"
 *     ),
 *     @Property (property = "message", type = "string", description = "response result prompt")
 * )
 *
 *
 * @package App\Http\Controllers
 */
class SwaggerController
{

}
