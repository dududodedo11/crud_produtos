<?php

namespace Client\Controllers\home;

use Client\Controllers\Services\Controller;

final class Home extends Controller {
    public function index(string|null $parameter) {
        $this->view("home.index", null);
    }
}