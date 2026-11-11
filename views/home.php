<h1><?= htmlspecialchars($storeName) ?></h1>

<?php if ($tagline !== ''): ?>
    <p><?= htmlspecialchars($tagline) ?></p>
<?php endif; ?>

<?php if (!empty($benefits)): ?>
    <section>
        <h2>Почему мы</h2>
        <ul>
            <?php foreach ($benefits as $benefit): ?>
                <li><?= htmlspecialchars($benefit) ?></li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>