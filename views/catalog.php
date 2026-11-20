<h1>Каталог товаров</h1>

<!-- Блок фильтрации и сортировки -->
<div class="filters">
    <strong>Категории:</strong>
    <a href="/catalog">Все</a>
    <?php foreach ($categories as $cat): ?>
        <a href="/catalog?category=<?= $cat->id ?>&sort=<?= $currentSort ?>">
            <?= htmlspecialchars($cat->name) ?>
        </a>
    <?php endforeach; ?>
    
    <br><br>
    
    <strong>Сортировка:</strong>
    <a href="/catalog?category=<?= $currentCategory ?? '' ?>&sort=name">По названию</a>
    <a href="/catalog?category=<?= $currentCategory ?? '' ?>&sort=price">По цене</a>
</div>

<hr>

<?php if (empty($products)): ?>
    <p>В этой категории пока нет товаров.</p>
<?php else: ?>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <a href="/product/<?= $product->id ?>">
                    <strong><?= htmlspecialchars($product->name) ?></strong>
                </a>
                — <?= $product->getFormattedPrice() ?> 
                (В наличии: <?= $product->stock ?> шт.)
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>