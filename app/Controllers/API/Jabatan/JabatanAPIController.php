<?php

namespace App\Controllers\API\Jabatan;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\JabatanModel;

class JabatanAPIController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    protected $format = 'json';
    protected $modelName = JabatanModel::class;

    public function index()
    {
        //
    }

    public function getListJabatan()
    {
        $roles = $this->model->getListJabatan();

        return $this->respond([
            'status' => 'success',
            'data' => $roles,
        ]);
    }
}
