<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * Class Region
 * @OA\Schema(description="Region Output Description")
 * @package App\Models\SQL
 */
class Region extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'Region';

    protected $primaryKey = 'RegionId';

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
     *     description= "Region Name"
     * )
     *
     * @var string $name
     */
    public $name;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->RegionId,
            'name' => $this->Region
        ];
    }
}
