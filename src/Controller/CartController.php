<?php
namespace App\Controller;

use App\Services\CartService;
use App\Repositories\ProductRepository;
use \View;

class CartController
{
    public function __construct(
        private CartService $cart,
        private ProductRepository $repo
    ) {}

    // Показать страницу корзины (GET /cart)
    public function index(): void
    {
        $data = $this->cart->getCartItems($this->repo);
        
        View::render('cart', [
            'title' => 'Корзина',
            'items' => $data['items'],
            'total' => $data['total']
        ]);
    }

    // Добавить товар (POST /cart/add)
    public function add(): void
    {
        $id = (int)($_POST['product_id'] ?? 0);
        if ($id > 0 && $this->repo->findById($id) !== null) {
            $this->cart->add($id);
            $_SESSION['flash'] = "Товар добавлен в корзину"; // Flash-сообщение
        }
        
        // POST -> Redirect -> GET
        header('Location: /cart');
        exit;
    }

    // Удалить (POST /cart/remove)
    public function remove(): void
    {
        $id = (int)($_POST['product_id'] ?? 0);
        if ($id > 0) {
            $this->cart->remove($id);
            $_SESSION['flash'] = "Товар удален из корзины";
        }
        header('Location: /cart');
        exit;
    }

    // Обновить количество (POST /cart/update)
    public function update(): void
    {
        $id = (int)($_POST['product_id'] ?? 0);
        $qty = (int)($_POST['qty'] ?? 1);
        if ($id > 0) {
            $this->cart->update($id, $qty);
        }
        header('Location: /cart');
        exit;
    }
}