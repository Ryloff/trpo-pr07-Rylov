<?php
namespace App\Services;

use App\Repositories\ProductRepository;

class CartService
{
    public function __construct()
    {
        // Если корзины нет в сессии, создаем пустой массив
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Добавить товар (или увеличить количество, если уже есть)
    public function add(int $productId, int $qty = 1): void
    {
        $current = $_SESSION['cart'][$productId] ?? 0;
        $_SESSION['cart'][$productId] = $current + $qty;
    }

    // Удалить товар
    public function remove(int $productId): void
    {
        unset($_SESSION['cart'][$productId]);
    }

    // Изменить количество (п.7: проверка на положительное число)
    public function update(int $productId, int $qty): void
    {
        if ($qty <= 0) {
            $this->remove($productId);
        } else {
            $_SESSION['cart'][$productId] = $qty;
        }
    }

    // Получить общее количество товаров для счетчика в шапке
    public function getTotalCount(): int
    {
        return array_sum($_SESSION['cart']);
    }

    // Получить детализированный список для страницы корзины
    public function getCartItems(ProductRepository $repo): array
    {
        $items = [];
        $totalSum = 0;

        foreach ($_SESSION['cart'] as $id => $qty) {
            $product = $repo->findById($id);
            if ($product) {
                $lineTotal = $product->price * $qty;
                $items[] = [
                    'product' => $product,
                    'qty' => $qty,
                    'lineTotal' => $lineTotal
                ];
                $totalSum += $lineTotal;
            }
        }

        return ['items' => $items, 'total' => $totalSum];
    }
}