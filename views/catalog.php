<h1>Каталог товаров</h1>

<?php if (empty($products)): ?>
    <p>В каталоге пока нет товаров.</p>
<?php else: ?>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <strong><?= htmlspecialchars($product->title) ?></strong>
                — <?= htmlspecialchars((string)$product->price) ?> руб.
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>