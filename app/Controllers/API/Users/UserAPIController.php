<?php

namespace App\Controllers\API\Users;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use Config\Services;

class UserAPIController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    protected $format = 'json';
    protected $modelName = UserModel::class;

    public function index()
    {

        // $page   = (int) $this->request->getGet('page') ?? 1;
        // $limit  = (int) $this->request->getGet('limit') ?? 10;
        $page = 1;
        $limit = 10;
        $search = $this->request->getGet('search') ?? null;
        $status = $this->request->getGet('status') ?? null;

        $offset = ($page - 1) * $limit;

        $users = $this->model->getAllUserList($limit, $offset, $search, $status);

        $total = $this->model->countUsersList($search, $status);
        // $test = ceil($total / $limit);
        // print_r($offset);
        // exit;
        // $users = $this->model->getAllUserList();

        return $this->respond([
            'status' => 'success',
            'data' => $users,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'pages' => ceil($total / $limit)
            ]
        ]);
    }

    public function softDeleteUser($userId)
    {
        $user = $this->model->find($userId);

        if (!$user) {
            return $this->response
                ->setJSON(['status' => 'error', 'message' => 'User not found'])
                ->setStatusCode(404);
        }

        if ($this->model->softDeleteUser($userId)) { // soft delete karena useSoftDeletes = true
            return $this->response
                ->setJSON(['status' => 'success', 'message' => 'User soft deleted successfully']);
        } else {
            return $this->response
                ->setJSON(['status' => 'error', 'message' => 'Failed to delete user'])
                ->setStatusCode(500);
        }
    }

    /**
     * Return the properties of a resource object.
     *  
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $users = $this->model->getAllUserList();
        $user = array_filter($users, fn($u) => $u['id'] == $id);

        if (!$user) {
            return $this->failNotFound("User with id $id not found");
        }

        return $this->respond([
            'status' => 'success',
            'data' => array_values($user)[0]
        ]);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
