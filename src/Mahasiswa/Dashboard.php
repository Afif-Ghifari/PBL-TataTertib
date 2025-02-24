<?php
    session_start();
    if (!isset($_SESSION['NIM'])) {
        header("Location: ../Login.html");
    }
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/Dashboard.css">
    <link rel="icon" href="../../assets/img/LOGO BREN.pdf.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/faq-style.css">
</head>

<body>
    <?php include 'Navbar.php'; ?>

    <header class="flex flex-col justify-center items-center w-full h-full text-center text-white px-24">
        <h1 class="text-6xl font-bold text-blue-600 my-8">
            Campus Harmony<br /><span class="text-white">Begins With Clear Rules</span>
        </h1>
        <h6 class="my-8 text-xl">
            Terapkan Disiplin dan Ketertiban di Kampus, Rasakan Lingkungan Belajar
            yang <br />Harmonis dan Kondusif untuk Kesuksesan Anda.
        </h6>
        <a href="https://drive.google.com/file/d/1prQyYqHih3ZPUi7svXBZ6vQrx-Oyw47c/view" target="_blank" class="btn btn-primary items-center text-white px-9 py-2 rounded-lg"
            style="font-family: 'product Sans Bold'">View Book</a>
    </header>

    <section class="flex justify-center flex-wrap -mt-12 lg:-mt-32 gap-10 z-10" id="features">
        <div class="relative">
            <img src="../../assets/img/Vector_garis.png" class="relative w-52 z-10" alt="" /><img src="../../assets/img/Vector.png"
                class="absolute w-44 top-4 left-4 z-20" alt="" />
            <div class="absolute z-30 flex flex-col items-center gap-1" style="top: 55px; left: 50px">
                <img src="../../assets/img/Anonymity of Reporting.png" class="w-14" alt="" />
                <h6 class="text-center text-blue-600 text-base leading-5">
                    Anonymity of<br />Reporting
                </h6>
            </div>
        </div>
        <div class="relative">
            <img src="../../assets/img/Vector_garis.png" class="relative w-52 z-10" alt="" /><img src="../../assets/img/Vector.png"
                class="absolute w-44 top-4 left-4 z-20" alt="" />
            <div class="absolute z-30 flex flex-col items-center gap-1" style="top: 55px; left: 53px">
                <img src="../../assets/img/Transparansi Proses.png" class="w-14" alt="" />
                <h6 class="text-center text-blue-600 text-base leading-5">
                    Transparansi<br />proses
                </h6>
            </div>
        </div>
        <div class="relative">
            <img src="../../assets/img/Vector_garis.png" class="relative w-52 z-10" alt="" /><img src="../../assets/img/Vector.png"
                class="absolute w-44 top-4 left-4 z-20" alt="" />
            <div class="absolute z-30 flex flex-col items-center gap-1" style="top: 55px; left: 53px">
                <img src="../../assets/img/Akses Tanpa Batas.png" class="w-14" alt="" />
                <h6 class="text-center text-blue-600 text-base leading-5">
                    Akses Tanpa<br />Batas
                </h6>
            </div>
        </div>
        <div class="relative">
            <img src="../../assets/img/Vector_garis.png" class="relative w-52 z-10" alt="" /><img src="../../assets/img/Vector.png"
                class="absolute w-44 top-4 left-4 z-20" alt="" />
            <div class="absolute z-30 flex flex-col items-center gap-1" style="top: 55px; left: 47px">
                <img src="../../assets/img/Validasi Sanksi Terotomatisasi.png" class="w-14" alt="" />
                <h6 class="text-center text-blue-600 text-base leading-5">
                    Validasi Sanksi<br />Terotomasi
                </h6>
            </div>
        </div>
    </section>

    <!-- <section class="px-28 my-36" id="importantNotification">
        <div class="flex justify-between items-center w-full h-64 bg-gradient-to-r from-blue-900 to-black rounded-2xl">
            <div class="w-3/4 text-white px-12 flex flex-col gap-2">
                <h6 class="text-red-600">Warning</h6>
                <h3 class="text-3xl">Ketahuan merokok ditempat yang dilarang</h3>
                <p class="text-lg text-slate-200">Apakah itu anda dalam laporan tersebut?</p>
                <button class="btn btn-primary w-1/4">Lihat</button>
            </div>
            <div class="w-1/4"></div>
        </div>
    </section>

    <section class="flex flex-row justify-evenly gap-5 px-28 my-36" id="data">
        <div class="w-80 h-96 shadow-xl rounded-xl border flex flex-col justify-between px-10 py-6 text-center">
            <img src="../../assets/img/fine-cuate 1.png" class="-mt-36" alt="">
            <div class="flex flex-col">
                <h3 class="text-xl">Pelaksanaan Sanksi</h3>
                <p class="text-base text-slate-600">Jumlah hasil dari pelanggaran anda</p>
            </div>
            <h1 class="text-4xl">05</h1>
            <a href="" class="btn btn-primary" style="font-family: 'product Sans Bold'">Lihat</a>
        </div>
        <div class="w-80 h-96 shadow-xl rounded-xl border flex flex-col justify-between px-10 py-6 text-center">
            <img src="../../assets/img/Law firm-rafiki 1.png" class="-mt-36" alt="">
            <div class="flex flex-col">
                <h3 class="text-xl">Ajukan Banding</h3>
                <p class="text-base text-slate-600">Ajuan bading anda saat ini Dengan jumlah</p>
            </div>
            <h1 class="text-4xl">05</h1>
            <a href="" class="btn btn-primary" style="font-family: 'product Sans Bold'">Lihat</a>
        </div>
        <div class="w-80 h-96 shadow-xl rounded-xl border flex flex-col justify-between px-10 py-6 text-center">
            <img src="../../assets/img/All the data-rafiki 1.png" class="-mt-36" alt="">
            <div class="flex flex-col">
                <h3 class="text-xl">Total Pelanggaran</h3>
                <p class="text-base text-slate-600">Total dari semua pelanggaran dan juga banding</p>
            </div>
            <h1 class="text-4xl">05</h1>
            <a href="" class="btn btn-primary" style="font-family: 'product Sans Bold'">Lihat</a>
        </div>
    </section> -->

    <section class="flex justify-between gap-10 px-28 my-36" id="importantInfo">
        <div class="w-1/2 relative">
            <img src="../../assets/img/Important-Info-L.png" class="relative w-fit rounded-3xl" alt="">
            <div class="absolute top-16 left-0 flex flex-col gap-6 text-white pl-16 pr-10">
                <h1 class="text-6xl">Contact and Help</h1>
                <p class="text-xl">Hubungi kami jika ada pertanyaan terkait tata tertib atau butuh bantuan lebih lanjut.
                </p>
                <a href="https://wa.me/6281349630344?text=Halo%20Admin,%20Halo%20saya%20mau%20bertanya%20terkait%20tata%20tertib." class="btn btn-primary w-fit px-9 py-2" style="font-family: 'product Sans Bold'">Hubungi
                    Admin</a>
            </div>
        </div>

        <div class="w-1/2 relative">
            <img src="../../assets/img/Important-Info-R.png" class="relative w-fit rounded-3xl" alt="">
            <div class="absolute top-16 left-0 flex flex-col gap-6 text-white pl-16 pr-10">
                <h1 class="text-6xl">Full PDF of the rules</h1>
                <p class="text-xl">Silakan baca PDF ini untuk lebih lengkap nya dan agar mahasiswa lebih mengetahui
                    peraturan di kampus.</p>
                <a href="../PDF/BukuPedoman.pdf" target="_blank" class="btn btn-primary w-fit px-9 py-2" style="font-family: 'product Sans Bold'">View
                    Rules</a>
            </div>
        </div>
    </section>

    <section class="px-28 my-24" id="FAQJumbotron">
        <div class="flex justify-center items-center w-full h-64 rounded-3xl">
            <h1 class="text-white text-4xl">Frequently Asked Questions <span class="text-blue-600">(FAQ)</span></h1>
        </div>
    </section>

    <section class="flex flex-col items-center gap-10 px-28 my-12" id="FAQ">
        <h3 class="text-3xl my-10">Some <span class="text-blue-600">Questions</span> From <span
                class="text-blue-600">Students</span></h3>
        <div class="w-full flex flex-col items-center gap-10 px-14">

            <div class="faq-item" id="faq1">
                <div
                    class="faq-header w-full flex justify-between items-center gap-5 border-5 border-dashed rounded-xl border-gray-500 px-10 py-3 cursor-pointer">
                    <img src="../../assets/img/FAQ.pdf.png" class="h-10" alt="">
                    <h4 class="faq-title">Apa tujuan utama dari Tata Tertib Kampus?</h4>
                    <img src="../../assets/img/Expand_down_light.png" class="h-14 icon" alt="">
                </div>
                <div class="faq-content px-10 py-5 text-gray-700">
                    Tujuan utama dari tata tertib kampus adalah untuk menjaga ketertiban, keamanan, dan kenyamanan di
                    lingkungan kampus bagi seluruh civitas akademika.
                </div>
            </div>

            <div class="faq-item" id="faq2">
                <div
                    class="faq-header w-full flex justify-between items-center gap-5 border-5 border-dashed rounded-xl border-gray-500 px-10 py-3 cursor-pointer">
                    <img src="../../assets/img/FAQ.pdf.png" class="h-10" alt="">
                    <h4 class="faq-title">Apakah tata tertib berlaku di luar kampus?</h4>
                    <img src="../../assets/img/Expand_down_light.png" class="h-14 icon" alt="">
                </div>
                <div class="faq-content px-10 py-5 text-gray-700">
                    Tata tertib berlaku terutama di dalam lingkungan kampus. Namun, nilai-nilai tertentu mungkin tetap
                    diharapkan diterapkan di luar kampus.
                </div>
            </div>

            <div class="faq-item" id="faq3">
                <div
                    class="faq-header w-full flex justify-between items-center gap-5 border-5 border-dashed rounded-xl border-gray-500 px-10 py-3 cursor-pointer">
                    <img src="../../assets/img/FAQ.pdf.png" class="h-10" alt="">
                    <h4 class="faq-title">Bagaimana cara melaporkan pelanggaran tata tertib?</h4>
                    <img src="../../assets/img/Expand_down_light.png" class="h-14 icon" alt="">
                </div>
                <div class="faq-content px-10 py-5 text-gray-700">
                    Anda dapat melaporkan pelanggaran tata tertib melalui pihak berwenang di kampus seperti dosen
                    pembimbing atau bagian administrasi kampus.
                </div>
            </div>

            <div class="faq-item" id="faq4">
                <div
                    class="faq-header w-full flex justify-between items-center gap-5 border-5 border-dashed rounded-xl border-gray-500 px-10 py-3 cursor-pointer">
                    <img src="../../assets/img/FAQ.pdf.png" class="h-10" alt="">
                    <h4 class="faq-title">Apa yang dimaksud dengan pelanggaran tata tertib ringan, sedang, dan berat?
                    </h4>
                    <img src="../../assets/img/Expand_down_light.png" class="h-14 icon" alt="">
                </div>
                <div class="faq-content px-10 py-5 text-gray-700">
                    Pelanggaran ringan meliputi hal-hal kecil seperti keterlambatan masuk kelas. Pelanggaran sedang bisa
                    mencakup plagiarisme ringan, sedangkan pelanggaran berat melibatkan tindakan yang melanggar hukum
                    atau norma kampus.
                </div>
            </div>

            <div class="faq-item" id="faq5">
                <div
                    class="faq-header w-full flex justify-between items-center gap-5 border-5 border-dashed rounded-xl border-gray-500 px-10 py-3 cursor-pointer">
                    <img src="../../assets/img/FAQ.pdf.png" class="h-10" alt="">
                    <h4 class="faq-title">Apa saja hak yang dimiliki mahasiswa di lingkungan kampus?</h4>
                    <img src="../../assets/img/Expand_down_light.png" class="h-14 icon" alt="">
                </div>
                <div class="faq-content px-10 py-5 text-gray-700">
                    Mahasiswa memiliki hak untuk mendapatkan fasilitas belajar, akses ke perpustakaan, bimbingan
                    akademik, serta lingkungan belajar yang aman.
                </div>
            </div>

        </div>
    </section>

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

    <script>
        sessionStorage.setItem("previousPage", window.location.href);
    </script>

    <?php include '../Footer.php' ?>

</body>



</html>