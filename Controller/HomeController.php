<?php
namespace App\Controller;
use App\Core\Controller;
use App\Core\Request;

class HomeController extends Controller {
    public function index(Request $request) {
        return $this->render('home', [
            'title' => 'Interview1 - Fixed',
            'message' => 'Dự án đã được refactor — welcome!'
        ]);
    }
}