<h1>Ваша корзина</h1>

<?php if (empty($items)): ?>
    <!-- Состояние пустой корзины (п.9) -->
    <p>Ваша корзина пуста. <a href="/catalog">Перейти в каталог</a></p>
<?php else: ?>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr style="background: #eee; text-align: left;">
            <th style="padding: 10px;">Товар</th>
            <th style="padding: 10px;">Цена</th>
            <th style="padding: 10px;">Кол-во</th>
            <th style="padding: 10px;">Сумма</th>
            <th style="padding: 10px;"></th>
        </tr>
        <?php foreach ($items as $item): ?>
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 10px;"><?= htmlspecialchars($item['product']->name) ?></td>
                <td style="padding: 10px;"><?= $item['product']->getFormattedPrice() ?></td>
                <td style="padding: 10px;">
                    <!-- Форма изменения количества -->
                    <form action="/cart/update" method="POST" style="display: flex; gap: 5px;">
                        <input type="hidden" name="product_id" value="<?= $item['product']->id ?>">
                        <input type="number" name="qty" value="<?= $item['qty'] ?>" min="1" style="width: 60px; padding: 5px;">
                        <button type="submit">ОК</button>
                    </form>
                </td>
                <td style="padding: 10px;"><?= number_format($item['lineTotal'], 0, ',', ' ') ?> ₽</td>
                <td style="padding: 10px;">
                    <!-- Форма удаления -->
                    <form action="/cart/remove" method="POST">
                        <input type="hidden" name="product_id" value="<?= $item['product']->id ?>">
                        <button type="submit" style="color: red;">Удалить</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Итого к оплате: <?= number_format($total, 0, ',', ' ') ?> ₽</h3>
    <!-- Добавь это в конец таблицы корзины -->
    <div style="margin-top: 20px;">
        <a href="/checkout" style="display: inline-block; padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;">Перейти к оформлению</a>
    </div>
    <a href="/catalog">Продолжить покупки</a>
<?php endif; ?>