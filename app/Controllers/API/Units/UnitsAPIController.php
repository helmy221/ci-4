<?php

namespace App\Controllers\API\Units;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UnitModel;

class UnitsAPIController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    protected $format = 'json';
    protected $modelName = UnitModel::class;

    public function index()
    {
        //
    }

    public function getListUnits()
    {
        $units = $this->model->getListUnits();

        return $this->respond([
            'status' => 'success',
            'data' => $units,
        ]);
    }
}
