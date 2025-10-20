<?php

namespace App\Controllers\API\Roles;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\RolesModel;

class RolesAPIController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    protected $format = 'json';
    protected $modelName = RolesModel::class;

    public function index()
    {
        //
    }

    public function getListRoles()
    {
        $roles = $this->model->getListRoles();

        return $this->respond([
            'status' => 'success',
            'data' => $roles,
        ]);
    }
}
