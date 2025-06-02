<?php
class NoticiasController extends Controller {
    public function index() {
        $data = [
            'title' => 'Noticias - SOLUFIBER S.R.L.',
            'currentSection' => 'noticias'
        ];
        $this->view('sections/noticias', $data);
    }
} 