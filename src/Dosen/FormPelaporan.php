<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pelaporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/HistoriPelanggaran.css">
    <link rel="icon" href="../../assets/img/LOGO BREN.pdf.png" />
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
            <label class="block mb-2 text-sm font-medium text-gray-900 " for="file_input">Upload file</label>
            <input class="form-control" id="file_input" type="file" name="bukti" required>

            <div class="flex justify-between gap-24 w-full my-8">
                <span class="w-full">
                    <label for="">Nama Terlapor</label>
                    <input type="text" class="form-control" id="NamaTerlapor" name="NamaTerlapor" required>
                </span>
                <span class="w-full">
                    <label for="">Admin Yang Akan Menangani</label>
                    <input type="text" class="form-control" id="Admin" name="Admin" required>
                </span>
            </div>

            <div class="flex justify-between gap-24 w-full my-8">
                <span class="w-full">
                    <label for="">Tempat Kejadian</label>
                    <input type="text" class="form-control" id="Tempat" name="Tempat" required>
                </span>
                <span class="w-full">
                    <label for="">Tanggal Kejadian</label>
                    <input type="date" class="form-control" id="Tanggal" name="Tanggal" required>
                </span>
            </div>

            <label for="">Jenis Pelanggaran</label>
            <select name="JenisPelanggaran" class="form-control mb-8" id="JenisPelanggaran" required>
                <option value="" selected>Pilih Jenis Pelanggaran</option>
                <option value="Pelanggaran 1">Pelanggaran 1</option>
                <option value="Pelanggaran 2">Pelanggaran 2</option>
                <option value="Pelanggaran 3">Pelanggaran 3</option>
                <option value="Pelanggaran 4">Pelanggaran 4</option>
                <option value="Pelanggaran 5">Pelanggaran 5</option>
            </select>

            <label for="">Deskripsi</label>
            <textarea class="form-control" name="Deskripsi" id="Deskripsi" required></textarea>

            <input type="submit" value="Submit" class="btn btn-primary rounded-xl w-full mx-auto my-6 py-2">
        </form>
    </main>

    <?php include '../Footer.php' ?>
</body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const faqItems = document.querySelectorAll(".faq-item");

        faqItems.forEach(item => {
            const header = item.querySelector(".faq-header");
            const content = item.querySelector(".faq-content");
            const icon = header.querySelector(".icon");

            header.addEventListener("click", () => {
                faqItems.forEach(i => {
                    const otherContent = i.querySelector(".faq-content");
                    const otherIcon = i.querySelector(".icon");
                    if (otherContent !== content && otherContent.classList.contains("show")) {
                        otherContent.classList.remove("show");
                        otherContent.style.maxHeight = null;
                        otherIcon.classList.remove("rotate");
                    }
                });

                if (content.classList.contains("show")) {
                    content.classList.remove("show");
                    content.style.maxHeight = null;
                    icon.classList.remove("rotate");
                } else {
                    content.classList.add("show");
                    content.style.maxHeight = content.scrollHeight + "px";
                    icon.classList.add("rotate");
                }
            });
        });
    });
</script>
</html>
