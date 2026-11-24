<?php
namespace App\Services;

class OrderValidator
{
    // Возвращает массив ошибок. Если массив пустой — всё ок!
    public function validate(array $input, array $validDeliveryIds): array
    {
        $errors = [];

        // Очищаем от лишних пробелов
        $name = trim($input['name'] ?? '');
        $email = trim($input['email'] ?? '');
        $delivery = trim($input['delivery'] ?? '');

        if ($name === '') {
            $errors['name'] = 'Введите ваше имя';
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введите корректный email';
        }

        if (!in_array($delivery, $validDeliveryIds, true)) {
            $errors['delivery'] = 'Выберите способ доставки';
        }

        return $errors;
    }
}