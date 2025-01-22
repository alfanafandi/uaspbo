<?php
$loggedInUserId = $_SESSION['user_id'];

require_once __DIR__ . '/../../model/transaksi_model.php';
$modelTransaksi = new TransaksiModel(new PenggunaModel());
$riwayatData = $modelTransaksi->getRiwayatByUserId($loggedInUserId);

// Membalikkan urutan array sehingga yang terbaru tampil di atas
$riwayatData = array_reverse($riwayatData);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Belanja</title>
    <link rel="icon" href="image\logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <header class="sticky top-0 bg-white z-10">
        <?php include __DIR__ . '/../includes/navbar.php'; ?>
    </header>
    <main class="p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Riwayat Belanja</h1>
        <section class="bg-white p-6 rounded-lg shadow-md">
            <?php if (empty($riwayatData)) : ?>
                <p class="text-gray-500 text-center">Tidak ada riwayat belanja.</p>
            <?php else : ?>
                <div class="space-y-6">
                    <?php foreach ($riwayatData as $riwayat) : ?>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm text-gray-600"><?php echo htmlspecialchars($riwayat['timestamp'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="text-lg font-semibold text-gray-800">Rp <?php echo number_format($riwayat['total_price'], 0, ',', '.'); ?></span>
                            </div>
                            <div class="space-y-2">
                                <?php foreach (json_decode($riwayat['items'], true) as $item) : ?>
                                    <div class="flex justify-between text-gray-700">
                                        <span><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?> x <?php echo $item['quantity']; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>

</html>