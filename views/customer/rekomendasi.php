<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekomendasi</title>
    <link rel="icon" href="image\logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <!-- Navbar -->
    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="bg-gray-200 py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Rekomendasi</h1>
            <p class="text-lg text-gray-600">Eksplor kumpulan resto best seller yang kami siapkan untuk berbagai kebutuhanmu</p>
        </div>
    </section>

    <!-- Recommendations Section -->
    <?php
    require_once __DIR__ . '/../../model/restoran_model.php';
    $modelRestoran = new RestoranModel();

    $query = "SELECT items FROM riwayat";
    $result = $modelRestoran->db->query($query);

    $restoranCount = [];
    while ($row = $result->fetch_assoc()) {
        $items = json_decode($row['items'], true);
        foreach ($items as $item) {
            $restoran_id = $item['restoran_id'];
            if (isset($restoranCount[$restoran_id])) {
                $restoranCount[$restoran_id]++;
            } else {
                $restoranCount[$restoran_id] = 1;
            }
        }
    }

    $recommendedRestorans = [];
    foreach ($restoranCount as $restoran_id => $count) {
        if ($count > 2) {
            $restoran = $modelRestoran->getRestoranById($restoran_id);
            if ($restoran) {
                $recommendedRestorans[] = $restoran;
            }
        }
    }
    ?>

    <div class="mt-6">
        <h3 class="text-lg font-semibold mb-3">Rekomendasi Restoran</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <?php if (!empty($recommendedRestorans)) : ?>
                <?php foreach ($recommendedRestorans as $restoran) : ?>
                    <a href="/index.php?modul=belanja&id=<?php echo $restoran->restoran_id; ?>" class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition max-w-xs mx-auto">
                        <img src="<?php echo $restoran->restoran_gambar; ?>" alt="<?php echo htmlspecialchars($restoran->restoran_nama); ?>" class="w-full h-32 object-cover rounded-lg mb-2">
                        <h4 class="text-md font-bold"><?php echo htmlspecialchars($restoran->restoran_nama); ?></h4>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-gray-500">Belum ada restoran tersedia.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>