<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Магазин') ?></title>
</head>
<body>

    <header>
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