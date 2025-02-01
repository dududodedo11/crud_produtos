<?php

namespace Client\Controllers\Services;

use Client\Views\Services\LoadView;

abstract class Controller {
    public function loadView(string $nameView, array|string|null $data) {
        $view = new LoadView($nameView, $data);
        $view->loadView();
    }
}