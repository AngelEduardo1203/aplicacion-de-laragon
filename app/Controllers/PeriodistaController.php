<?php

namespace App\Controllers;

use App\Models\PeriodistaModel;
use CodeIgniter\RESTful\ResourceController;

class PeriodistaController extends ResourceController
{

    public function index()
    {
        $periodistas = model(PeriodistaModel::class);

        $datos = [
            'titulo'        => 'Periodistas registrados en el sistema',
            'periodistas'   => $periodistas->getPeriodistas(),
        ];

        return view('/periodistas/index', $datos);
    }

    public function show($id = null)
    {
        return view('periodidtas/show');
    }

    public function new()
    {
        
    }

    public function create() 
    {
        $model = model(PeriodistaModel::class);

        if ($this->request->getMethod() === 'post' && $this->validate([

            'nombre'    => 'required|min_length[3]|max_length[50]',
            'apellidos' => 'required|min_length[3]|max_length[50]',
            'area'      => 'required|min_length[3]|max_length[50]',
            'bio'       => 'required|min_length[20]|max_length[2000]',
            'email'     => 'required|max_length[100]',
            'telefono'  => 'required|min_length[7]|max_length[15]'
        ])) {

            $data = [
                'nombre'    => $this->request->getPost('nombre'), 
                'slug'      => url_title($this->request->getPost('nombre'), '-', true),
                'apellidos' => $this->request->getPost('apellidos'),
                'area'      => $this->request->getPost('area'),
                'bio'       => $this->request->getPost('bio'),
                'email'     => $this->request->getPost('email'),
                'telefono'  => $this->request->getPost('telefono'),
            ];

            $model->insert($data);

            return redirect()->to('/periodista');
        } else {
            return view('/periodistas/create');
        }
    }

    public function edit($id = null)
    {
        //
    }

    public function update($id = null)
    {
        //
    }


    public function delete($id = null)
    {
        //
    }
}
