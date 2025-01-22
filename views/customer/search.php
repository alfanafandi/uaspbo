<?php
require_once __DIR__ . '/../../model/restoran_model.php';
require_once __DIR__ . '/../../model/menu_model.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';
$restaurants = [];
$menus = [];

if ($query) {
    $modelRestoran = new RestoranModel();
    $modelMenu = new MenuModel($modelRestoran);
    $restaurants = $modelRestoran->searchRestoransByName($query);
    $menus = $modelMenu->searchByName($query);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="icon" href="image\logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/@heroicons/react/outline" rel="stylesheet">
    <script>
        function searchItems() {
            const query = document.getElementById('searchInput').value;
            fetch(`index.php?modul=search&query=${query}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('searchResults').innerHTML = new DOMParser().parseFromString(data, 'text/html').getElementById('searchResults').innerHTML;
                });
        }
    </script>
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <header class="sticky top-0 bg-white z-10">
        <?php include __DIR__ . '/../includes/navbar.php'; ?>
    </header>

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Cari Restoran atau Menu</h1>
        <form action="index.php?modul=search" method="GET" class="mb-4 flex items-center" onsubmit="event.preventDefault(); searchItems();">
            <span class="bg-gray-200 px-3 py-2 rounded-l-full h-full flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd" />
                </svg>
            </span>
            <input type="text" id="searchInput" name="query" placeholder="Cari restoran atau menu..." class="px-2 py-2 border rounded-r-full w-full h-full" oninput="searchItems()">
        </form>
        <h2 class="text-xl font-bold mb-4">Hasil Pencarian untuk: <?= htmlspecialchars($query); ?></h2>
        <div id="searchResults">
            <?php if (empty($restaurants) && empty($menus)): ?>
                <p class="text-gray-700">Tidak ada restoran atau menu yang ditemukan.</p>
            <?php else: ?>
                <?php if (!empty($restaurants)): ?>
                    <h3 class="text-lg font-bold mb-2">Restoran</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                        <?php foreach ($restaurants as $restaurant): ?>
                            <a href="/views/customer/resto.php?restoran_id=<?= $restaurant->restoran_id; ?>" class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition max-w-xs mx-auto">
                                <img src="<?= htmlspecialchars($restaurant->restoran_gambar); ?>" alt="<?= htmlspecialchars($restaurant->restoran_nama); ?>" class="w-full h-32 object-cover rounded-lg mb-2">
                                <h4 class="text-md font-bold"><?= htmlspecialchars($restaurant->restoran_nama); ?></h4>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($menus)): ?>
                    <h3 class="text-lg font-bold mb-2">Menu</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <?php foreach ($menus as $menu): ?>
                            <a href="/views/customer/menu.php?menu_id=<?= $menu->menu_id; ?>" class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition max-w-xs mx-auto">
                                <img src="<?= htmlspecialchars($menu->menu_gambar); ?>" alt="<?= htmlspecialchars($menu->menu_nama); ?>" class="w-full h-32 object-cover rounded-lg mb-2">
                                <h4 class="text-md font-bold"><?= htmlspecialchars($menu->menu_nama); ?></h4>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>