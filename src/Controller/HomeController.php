<?php

final class HomeController
{
    public function index(): void
    {
        $path = __DIR__ . '/../../data/pages.json';

        $json  = file_get_contents($path);
        $pages = json_decode($json, true);

        $data = [
            'title'     => $pages['store_name'] ?? 'Магазин',
            'storeName' => $pages['store_name'] ?? 'Магазин',
            'tagline'   => $pages['tagline'] ?? '',
            'benefits'  => $pages['benefits'] ?? [],
        ];

        View::render('home', $data);
    }
}