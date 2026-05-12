<?php

class HomeController extends Controller {

    public function index() {
        $this->view("home");
    }

    public function about() {
        $this->view("about");
    }
}