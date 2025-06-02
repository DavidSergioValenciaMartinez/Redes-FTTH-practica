<?php
class SoporteController extends Controller {
    public function index() {
        $data = ['title' => 'Soporte'];
        $this->view('soporte/index', $data);
    }
} 