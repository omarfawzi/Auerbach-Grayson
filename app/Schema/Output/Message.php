<?php


namespace App\Schema\Output;
use OpenApi\Annotations as OA;

/**
 * Class Message
 * @OA\Schema(description="Message Output")
 * @package App\Schema\Output
 */
class Message
{
    /**
     * @OA\Property(
     *     type="string",
     *     description= "Message"
     * )
     *
     * @var string $message
     */
    public $message;
}
