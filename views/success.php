<h1>Спасибо за заказ!</h1>
<p>Ваш заказ <strong>№<?= htmlspecialchars($order['id']) ?></strong> успешно оформлен.</p>
<p>Способ доставки: <strong><?= htmlspecialchars($deliveryTitle) ?></strong></p>
<p>Итоговая сумма к оплате: <strong><?= number_format($order['total'], 0, ',', ' ') ?> ₽</strong></p>

<br>
<a href="/catalog">Вернуться в каталог</a>