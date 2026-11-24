<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Магазин') ?></title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <header style="display: flex; justify-content: space-between;">
        <div>
            <img src="/logo.svg" alt="Логотип" style="height: 40px; vertical-align: middle;">
            <a href="/"><?= htmlspecialchars($storeName ?? 'Магазин') ?></a>
        </div>
        <div>
            <!-- Счётчик корзины (п.10) -->
            <a href="/cart" style="color: white; text-decoration: none;">
                Корзина (<?= (new \App\Services\CartService())->getTotalCount() ?>)
            </a>
        </div>
    </header>

    <main>
        <!-- Flash-сообщение (п.13) -->
        <?php if (isset($_SESSION['flash'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                <?= htmlspecialchars($_SESSION['flash']) ?>
            </div>
            <?php unset($_SESSION['flash']); // Сообщение исчезает после показа ?>
        <?php endif; ?>

        <?php require $viewFile; ?>
    </main>

    <footer>
        <p>&copy; Учебный проект, 2026</p>
    </footer>
</body>
</html>