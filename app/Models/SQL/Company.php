<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * Class Company
 * @OA\Schema(description="Company Output Description")
 *
 * @package App\Models\SQL
 */
class Company extends Model
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
     *     description="Company Title"
     * )
     *
     * @var string $title
     */
    public $title;
    /**
     * @OA\Property(
     *     type="string",
     *     description="Company Ticker"
     * )
     *
     * @var string $ticker
     */
    public $ticker;
    protected $connection = 'sqlsrv';
    protected $table = 'Company';
    protected $primaryKey = 'CompanyID';

    /**
     * @return string
     */
    public function getTicker(): string
    {
        return $this->Bloomberg;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'     => $this->CompanyID,
            'title'  => $this->Company,
            'ticker' => $this->getTicker(),
        ];
    }
}
