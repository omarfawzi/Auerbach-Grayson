<?php

namespace App\Schema\Output;

use OpenApi\Annotations as OA;

/**
 * Class NotFoundException
 * @OA\Schema(description="Not Found Exception Body")
 * @package App\Schema\Output
 */
class NotFoundException
{
    /**
     * @OA\Property(
     *     type="string",
     *     description= "Message",
     *     example="Not found"
     * )
     *
     * @var string $message
     */
    public $message;

    /**
     * @OA\Property(
     *     type="string",
     *     description= "Status",
     *     example="404"
     * )
     *
     * @var string $message
     */
    public $status;
}
