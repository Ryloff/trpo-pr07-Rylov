<?php

final class ErrorController
{
    public function notFound(): void
    {
        // Устанавливаем статус 404
        http_response_code(404);
        
        // Показываем вид 404
        View::render('404', ['title' => 'Страница не найдена']);
    }
}