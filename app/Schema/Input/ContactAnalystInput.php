<?php

namespace App\Schema\Input;

use OpenApi\Annotations as OA;

/**
 * Class ContactAnalystInput
 * @OA\Schema(description="Contact Analyst Input Description")
 * @package App\Schema
 */
class ContactAnalystInput
{

    /**
     * @OA\Property(
     *     type="string",
     *     description="The conference call date time"
     * )
     *
     * @var string $dateTime
     */
    public $dateTime;

    /**
     * @OA\Property(
     *     type="string",
     *     description="The calendar link"
     * )
     *
     * @var string $link
     */
    public $link;

    /**
     * @OA\Property(
     *     type="string",
     *     description="Message body"
     * )
     *
     * @var string $message
     */
    public $message;
}
