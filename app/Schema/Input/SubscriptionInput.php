<?php


namespace App\Schema\Input;

use OpenApi\Annotations as OA;

/**
 * Class SubscriptionInput
 * @OA\Schema(description="Subscription Input Description")
 * @package App\Schema
 */
class SubscriptionInput
{
    /**
     * @OA\Property(
     *     type="integer",
     *     description="The id of the subscribable object"
     * )
     *
     * @var int $id
     */
    public $id;

    /**
     * @OA\Property(
     *     type="string",
     *     description="The type of the subscribable object"
     * )
     *
     * @var string $type
     */
    public $type;
}
