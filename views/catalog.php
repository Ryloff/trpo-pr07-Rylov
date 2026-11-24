<h1>Каталог товаров</h1>

<?php if (empty($products)): ?>
    <p>Товаров пока нет.</p>
<?php else: ?>
    <ul style="list-style-type: none; padding: 0;">
        <?php foreach ($products as $product): ?>
            <li style="margin-bottom: 15px; padding: 10px; border: 1px solid #eee;">
                <a href="/product/<?= $product->id ?>">
                    <strong><?= htmlspecialchars($product->name) ?></strong>
                </a>
                — <?= $product->getFormattedPrice() ?> 
                
                <!-- Кнопка добавления в корзину (из 9-й работы) -->
                <form action="/cart/add" method="POST" style="display:inline; margin-left: 15px;">
                    <input type="hidden" name="product_id" value="<?= $product->id ?>">
                    <button type="submit">В корзину</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>