<?php
namespace App\Controller;

use App\Services\OrderValidator;
use App\Services\CartService;
use App\Repositories\ProductRepository;
use App\Model\OrderData;
use \View;

class CheckoutController
{
    public function __construct(
        private CartService $cart,
        private ProductRepository $repo
    ) {}

    // GET /checkout
    public function index(): void
    {
        $methods = json_decode(file_get_contents(__DIR__ . '/../../data/delivery_methods.json'), true);
        $cartData = $this->cart->getCartItems($this->repo);

        // Если корзина пуста, нельзя оформлять заказ
        if (empty($cartData['items'])) {
            header('Location: /cart');
            exit;
        }

        View::render('checkout', [
            'title' => 'Оформление заказа',
            'methods' => $methods,
            'total' => $cartData['total'],
            'errors' => [],
            'old' => []
        ]);
    }

    // POST /checkout
    public function process(): void
    {
        // 1. Проверка CSRF-токена (защита формы)
        if (!isset($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['csrf']) {
            die('Ошибка безопасности CSRF');
        }

        $methods = json_decode(file_get_contents(__DIR__ . '/../../data/delivery_methods.json'), true);
        $validIds = array_column($methods, 'id');
        $input = $_POST;

        // 2. Валидация
        $validator = new OrderValidator();
        $errors = $validator->validate($input, $validIds);

        $cartData = $this->cart->getCartItems($this->repo);

        // Если есть ошибки — возвращаем форму с ошибками и старыми данными
        if (!empty($errors)) {
            View::render('checkout', [
                'title' => 'Оформление заказа',
                'methods' => $methods,
                'total' => $cartData['total'],
                'errors' => $errors,
                'old' => $input // Передаем введенные данные обратно
            ]);
            return;
        }

        // 3. Считаем итоговую сумму с учетом доставки
        $deliveryPrice = 0;
        foreach ($methods as $m) {
            if ($m['id'] === $input['delivery']) {
                $deliveryPrice = $m['price'];
                break;
            }
        }
        $finalTotal = $cartData['total'] + $deliveryPrice;

        // 4. Создаем DTO только после успешной валидации
        $orderData = new OrderData(
            $input['name'],
            $input['email'],
            $input['delivery'],
            $finalTotal
        );

        // 5. Сохраняем заказ в JSON
        $orderArray = [
            'id' => uniqid('ORD-'), // Генерируем уникальный номер заказа
            'name' => $orderData->name,
            'email' => $orderData->email,
            'delivery' => $orderData->delivery,
            'total' => $orderData->total,
            'date' => date('Y-m-d H:i:s')
        ];

        $file = __DIR__ . '/../../data/orders_seed.json';
        $orders = json_decode(file_get_contents($file), true);
        $orders[] = $orderArray;
        file_put_contents($file, json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // 6. Очищаем корзину и сохраняем заказ в сессию для страницы успеха
        $_SESSION['cart'] = [];
        $_SESSION['last_order'] = $orderArray;

        // 7. POST -> Redirect -> GET
        header('Location: /checkout/success');
        exit;
    }

    // GET /checkout/success
    public function success(): void
    {
        if (!isset($_SESSION['last_order'])) {
            header('Location: /');
            exit;
        }

        $order = $_SESSION['last_order'];
        
        // Находим название доставки для вывода
        $methods = json_decode(file_get_contents(__DIR__ . '/../../data/delivery_methods.json'), true);
        $deliveryTitle = '';
        foreach ($methods as $m) {
            if ($m['id'] === $order['delivery']) $deliveryTitle = $m['title'];
        }

        View::render('success', [
            'title' => 'Заказ оформлен',
            'order' => $order,
            'deliveryTitle' => $deliveryTitle
        ]);
    }
}