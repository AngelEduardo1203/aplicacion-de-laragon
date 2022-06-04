<?php

namespace App\Controllers;
use Dompdf\Dompdf;
use App\Controllers\BaseController;
use App\Models\NewsModel;
use App\Models\CategoriaModel;
use App\Models\Staff;
use App\Models\PeriodistaModel;


class NewsController extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);
        $categoriaModel = model(CategoriaModel::class);
        $periodistaModel = model(PeriodistaModel::class);
        $staffModel = model(Staff::class);
        $data = [
            'title' => 'Noticias',
            'categoria' => $categoriaModel->where('id', 'categoria')->find(),
            'news'  => $model->getNews()
        ];

        echo view('news/index', $data);
    }

    public function cards()
    {
        $model = model(NewsModel::class);

        $data = [
            'title' => 'Noticias en versión CARD',
            'news'  => $model->getNews()
        ];

        return view('news/cards', $data);
    }

    // Aquí comienza la función create()
    public function create() 
    {
        $model = model(NewsModel::class);
        $categoriaModel = model(CategoriaModel::class);
        $periodistaModel = model(PeriodistaModel::class);
        $staffModel = model(StaffModel::class);

        


        if ($this->request->getMethod() === 'post' && $this->validate([
            'categoria'     => 'required',
            'periodista'    => 'required',
            'staff'         => 'required',
            'title'         => 'required|min_length[3]|max_length[255]',
            'body'          => 'required'
        ])) {
            

            $data = [
                'categoria' => $this->request->getPost('categoria'),
                'periodista' => $this->request->getPost('periodista'),
                'staff' => $this->request->getPost('staff'),
                'title' => $this->request->getPost('title'),
                'slug'  => url_title($this->request->getPost('title'), '-', true),
                'body'  => $this->request->getPost('body')
            ];

            $model->insert($data);

            return redirect()->to('/news');
        } else {
            $model = model(NewsModel::class);
            $categoriaModel = model(CategoriaModel::class);
            $periodistaModel = model(PeriodistaModel::class);
            $staffModel = model(StaffModel::class);

            $data = [
                'title' => 'añador Noticai',
                'categorias' => $categoriaModel->findAll(),
                'staffs'    =>  $staffModel->findAll(),
                'periodistas'    => $periodistaModel->findAll()
            ];
            return view('/news/create', $data);
        }
    }
    // Aquí finaliza la función create()


    public function edit($id = null)
    {
        $model = NewsModel();

    }

    public function update()
    {
        $model = model(NewsModel::class);

        $id = $this->request->getVar('id');

        if ($this->request->getMethod() === 'put' && $this->validate([
                'title' => 'required|min_length[3]|max_length[255]',
                'body'  => 'required'
            ])) {

            $data = [
                'title' => $this->request->getPost('title'),
                'slug'  => url_title($this->request->getPost('title'), '-', true),
                'body'  => $this->request->getPost('body')
            ];

            $model->update($id, $data);

            return redirect()->to('/news');
        } else {
            $model = model(NewsModel::class);
            $categoriaModel = model(CategoriaModel::class);
            $periodistaModel = model(PeriodistaModel::class);
            $staffModel = model(Staff::class);

            $data = [
                'categorias' => $categoriaModel->findAll(),
                'staffs'    => $staffModel->findAll(),
                'peridistas'    => $periodistaModel->findAll()
            ];
            return view('/news/edit');
        }
    }
    
    
    public function pdf()
    {
        

// instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml('hello world');

// (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
        $dompdf->render();

// Output the generated PDF to Browser
        $dompdf->stream();
    
      
    }
}

