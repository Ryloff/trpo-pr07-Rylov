<?php

final class View
{
    // Подставляет данные в шаблон и выводит его
    public static function render(string $template, array $data = []): void
    {
        // Превращаем ключи массива в переменные:
        // ['message' => 'привет'] даст $message = 'привет'
        extract($data);

        // Подключаем HTML-шаблон из папки views/
        $viewFile = __DIR__ . '/../../views/' . $template . '.php';

        // ВОТ ГЛАВНАЯ СТРОКА: мы всегда подключаем layout!
        require __DIR__ . '/../../views/layout.php';
    }
}