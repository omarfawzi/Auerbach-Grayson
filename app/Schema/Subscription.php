<?php


namespace App\Schema;

use OpenApi\Annotations as OA;

/**
 * Class Subscription
 * @OA\Schema(description="Subscriptions Output Description")
 * @package App\Schema
 */
class Subscription
{
    /**
     * @OA\Property(
     *     type="integer",
     *     description="ID"
     * )
     *
     * @var int $id
     */
    public $id;

    /**
     * @OA\Property(
     *     type="string",
     *     description= "Subscribable Name"
     * )
     *
     * @var string $subscribable
     */
    public $subscribable;
}
