<?php

final class View
{
    public static function render(string $template, array $data = []): void
    {

        extract($data);

        $viewFile = __DIR__ . '/../../views/' . $template . '.php';

        require __DIR__ . '/../../views/layout.php';
    }
}