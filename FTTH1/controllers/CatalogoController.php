<?php
class CatalogoController extends Controller {
    public function index() {
        $data = ['title' => 'Catálogo'];
        $this->view('catalogo/index', $data);
    }
} 