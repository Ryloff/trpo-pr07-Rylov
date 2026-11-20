<h1><?= htmlspecialchars($product->name) ?></h1>
<p><strong>Цена:</strong> <?= $product->getFormattedPrice() ?></p>
<p><strong>На складе:</strong> <?= $product->stock ?> шт.</p>
<p><a href="/catalog">← Вернуться в каталог</a></p>