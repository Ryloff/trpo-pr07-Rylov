<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Магазин') ?></title>
    <!-- Подключаем CSS -->
    <link rel="stylesheet" href="/style.css">
</head>
<body>

    <header>
        <!-- Выводим логотип -->
        <img src="/logo.svg" alt="Логотип">
        <a href="/"><?= htmlspecialchars($storeName ?? 'Магазин') ?></a>
    </header>

    <main>
        <?php require $viewFile; ?>
    </main>

    <footer>
        <p>&copy; Учебный проект, 2026</p>
    </footer>

</body>
</html>