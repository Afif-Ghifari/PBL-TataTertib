<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pelaporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/HistoriPelanggaran.css">
    <link rel="icon" href="../../assets/img/LOGO BREN.pdf.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'Navbar.php'; ?>

    <main class="px-28 my-36">
        <h2 class="text-3xl text-center my-2">Form Pelaporan</h2>
        <p class="text-center">Silakan lengkapi form pelaporan ini dengan informasi yang sesuai dan jelas. Pastikan semua data yang dimasukkan valid agar laporan dapat diproses dengan baik.</p>

        <form class="w-full px-20 py-12 rounded-xl shadow-lg my-20" action="../../backend/UplaodForm.php" method="post" enctype="multipart/form-data">
            <!-- Upload File -->
            <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Upload Bukti Pelanggaran</label>
            <input class="form-control" id="file_input" type="file" name="bukti" accept=".jpg,.jpeg,.png,.pdf" required>
            <small class="text-gray-500">Format file yang diizinkan: JPG, JPEG, PNG, PDF (maksimal 5MB).</small>

            <!-- Nama Terlapor -->
            <div class="flex justify-between gap-24 w-full my-8">
                <span class="w-full">
                    <label for="NamaTerlapor">Nama Terlapor</label>
                    <input type="text" class="form-control" id="NamaTerlapor" name="NamaTerlapor" placeholder="Masukkan nama terlapor" required>
                </span>
            </div>

            <!-- Tempat dan Tanggal -->
            <div class="flex justify-between gap-24 w-full my-8">
                <span class="w-full">
                    <label for="Tempat">Tempat Kejadian</label>
                    <input type="text" class="form-control" id="Tempat" name="Tempat" placeholder="Masukkan lokasi kejadian" required>
                </span>
                <span class="w-full">
                    <label for="Tanggal">Tanggal Kejadian</label>
                    <input type="date" class="form-control" id="Tanggal" name="Tanggal" required>
                </span>
            </div>

            <!-- Jenis Pelanggaran -->
            <label for="JenisPelanggaran">Jenis Pelanggaran</label>
            <select name="JenisPelanggaran" class="form-control mb-8" id="JenisPelanggaran" required>
                <option value="" selected>Pilih Jenis Pelanggaran</option>
                <option value="1">Pelanggaran 1 - Deskripsi singkat</option>
                <option value="2">Pelanggaran 2 - Deskripsi singkat</option>
                <option value="3">Pelanggaran 3 - Deskripsi singkat</option>
                <option value="4">Pelanggaran 4 - Deskripsi singkat</option>
                <option value="5">Pelanggaran 5 - Deskripsi singkat</option>
            </select>

            <!-- Deskripsi -->
            <label for="Deskripsi">Deskripsi Pelanggaran</label>
            <textarea class="form-control" name="Deskripsi" id="Deskripsi" placeholder="Jelaskan kronologi kejadian" required></textarea>

            <!-- Submit Button -->
            <input type="submit" value="Kirim Laporan" class="btn btn-primary rounded-xl w-full mx-auto my-6 py-2">
        </form>
    </main>

    <?php include '../Footer.php'; ?>
</body>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const fileInput = document.getElementById("file_input");

        fileInput.addEventListener("change", (event) => {
            const file = event.target.files[0];
            const allowedExtensions = ["jpg", "jpeg", "png", "pdf"];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (file) {
                const fileExtension = file.name.split(".").pop().toLowerCase();
                if (!allowedExtensions.includes(fileExtension)) {
                    alert("Format file tidak valid. Hanya JPG, JPEG, PNG, atau PDF yang diperbolehkan.");
                    fileInput.value = ""; // Reset file input
                } else if (file.size > maxSize) {
                    alert("Ukuran file terlalu besar. Maksimal 5MB.");
                    fileInput.value = ""; // Reset file input
                }
            }
        });
    });
</script>

</html>
