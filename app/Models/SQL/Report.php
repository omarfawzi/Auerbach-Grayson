<?php

namespace App\Models\SQL;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * Class Report
 * @OA\Schema(description="Report Output Description")
 * @package App\Models\SQL
 */
class Report extends Model
{
    use Filterable;

    protected $connection = 'sqlsrv';

    protected $table = 'Report';

    protected $primaryKey = 'ReportID';

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
     *     description= "Report Title"
     * )
     *
     * @var string|null $title
     */
    public $title;

    /**
     * @OA\Property(
     *     type="string",
     *     description= "Report Description"
     * )
     *
     * @var string|null $synopsis
     */
    public $synopsis;

    /**
     * @OA\Property(
     *     type="string",
     *     description= "Report Date"
     * )
     *
     * @var string|null $date
     */
    public $date;

    /**
     * @OA\Property(
     *     type="integer",
     *     description="Report Number of Pages"
     * )
     *
     * @var int|null $pages
     */
    public $pages;

    /**
     * @OA\Property(
     *     type="string",
     *     description="Report Analyst"
     * )
     *
     * @var string|null $analyst
     */
    public $analyst;

    /**
     * @OA\Property(
     *     type="string",
     *     description="Report Type"
     * )
     *
     * @var string|null $type
     */
    public $type;

    public function type()
    {
        return $this->hasOne(Type::class,'TypeID','TypeID');
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'    => $this->ReportID,
            'title' => $this->Title,
            'synopsis' => $this->Synopsis,
            'date' => $this->ReportDate,
            'pages' => $this->Pages,
            'by' => $this->AnalystIndex,
            'type' => optional($this->type)->Type
        ];
    }
}
