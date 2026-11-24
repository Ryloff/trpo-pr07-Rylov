<h1>Оформление заказа</h1>
<p>Сумма товаров: <strong><?= number_format($total, 0, ',', ' ') ?> ₽</strong></p>

<form action="/checkout" method="POST" style="max-width: 400px; margin-top: 20px;">
    <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
    
    <div style="margin-bottom: 15px;">
        <label>Ваше имя:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" style="width: 100%; padding: 8px;">
        <?php if (isset($errors['name'])): ?><br><span style="color:red; font-size: 14px;"><?= $errors['name'] ?></span><?php endif; ?>
    </div>

    <div style="margin-bottom: 15px;">
        <label>Email:</label><br>
        <input type="text" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" style="width: 100%; padding: 8px;">
        <?php if (isset($errors['email'])): ?><br><span style="color:red; font-size: 14px;"><?= $errors['email'] ?></span><?php endif; ?>
    </div>

    <div style="margin-bottom: 15px;">
        <label>Способ доставки:</label><br>
        <select name="delivery" style="width: 100%; padding: 8px;">
            <?php foreach ($methods as $m): ?>
                <option value="<?= $m['id'] ?>" <?= (isset($old['delivery']) && $old['delivery'] === $m['id']) ? 'selected' : '' ?>>
                    <?= $m['title'] ?> (<?= $m['price'] > 0 ? '+ ' . $m['price'] . ' ₽' : 'бесплатно' ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['delivery'])): ?><br><span style="color:red; font-size: 14px;"><?= $errors['delivery'] ?></span><?php endif; ?>
    </div>

    <button type="submit" style="padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer;">Подтвердить заказ</button>
</form>