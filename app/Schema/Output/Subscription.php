<?php


namespace App\Schema\Output;

use OpenApi\Annotations as OA;

/**
 * Class Subscription
 * @OA\Schema(description="Subscriptions Output Description")
 * @package App\Schema\Output
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
     *     description="Subscribable Type"
     * )
     *
     * @var string $type
     */
    public $type;

    /**
     * @OA\Property(ref="#/components/schemas/Subscribable")
     *
     * @var Subscribable $subscribable
     */
    public $subscribable;
}
