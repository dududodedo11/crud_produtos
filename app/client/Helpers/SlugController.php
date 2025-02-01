<?php

namespace Client\Helpers;

class SlugController {
    public static function slugController(string $slugController):string {
        $slugController = strtolower($slugController);

        $slugController = str_replace("-", " ", $slugController);

        $slugController = ucwords($slugController);

        $slugController = str_replace(" ", "", $slugController);

        return $slugController;
    }
}