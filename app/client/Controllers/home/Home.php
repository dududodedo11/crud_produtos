<?php

namespace Client\Controllers\home;

use Client\Controllers\Services\Controller;

class Home extends Controller {
    public function index(string|null $parameter) {
        $this->loadView("home.index", null);
    }
}