<?php
class SpeedtestController extends Controller {
    public function index() {
        $data = [
            'title' => 'Speedtest',
            'active_page' => 'speedtest'
        ];
        $this->view('speedtest/index', $data);
    }
} 