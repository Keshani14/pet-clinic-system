<?php

class Controller {

    public function view($view, $data = []) {
        // Make all $data keys available as local variables inside the view
        extract($data);
        require_once "../app/views/$view.php";
    }

    public function model($model) {
        require_once "../app/models/$model.php";
        return new $model();
    }
}