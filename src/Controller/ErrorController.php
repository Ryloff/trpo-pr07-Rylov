<?php

namespace App\Controller;
use \View;
final class ErrorController
{
    public function notFound(): void
    {
        http_response_code(404);
        
        View::render('404', ['title' => 'Страница не найдена']);
    }
}