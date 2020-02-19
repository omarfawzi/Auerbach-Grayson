<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use OpenApi\Annotations as OA;

/**
 * Class Sector
 * @OA\Schema(description="Sector Output Description")
 * @package App\Models\SQL
 */
class Sector extends Model
{
    use SerializesModels;

    protected $connection = 'sqlsrv';

    protected $table = 'GICS_Sector';

    protected $primaryKey = 'GICS_SectorId';

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
     *     description= "Sector Name"
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
            'id' => $this->GICS_SectorId,
            'name' => $this->GICS_Sector
        ];
    }
}
