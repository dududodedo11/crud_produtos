<?php

namespace Client\Views\Services;

use Client\Helpers\GenerateLog;

class LoadView {
    private string $pathView;
    private string $nameView;
    private array|string|null $data;

    public function __construct(string $nameView, array|string|null $data) {
        $this->nameView = $nameView;
        $this->data = $data;

        $this->nameView = str_replace(".", "/", $this->nameView);
        $this->pathView = "app/client/Views/$this->nameView.php";
    }

    public function loadView() {
        if(file_exists($this->pathView)) {
            $dataInView = $this->data;
            include $this->pathView;
        } else {
            GenerateLog::generateLog("critical", "View não encontrada", ['nameView' => $this->nameView, 'pathView' => $this->pathView]);
        }
    }
}