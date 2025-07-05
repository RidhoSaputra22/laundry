<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaundryTrack - Pelacakan Laundry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div class="w-full h-screen">
        <div class="flex h-full flex-col md:flex-row overflow-hidden card-shadow">
            <!-- Sidebar Biru -->
            <div class="bg-blue-800 text-white p-8 md:w-1/4 flex flex-col">
                <div class="mb-8">
                    <img src="assets/img/logo.svg"
                        alt="Logo LaundryTrack - gambar mesin cuci modern berwarna putih dengan latar biru"
                        class="mb-4 h-12">
                    <h1 class="text-2xl font-bold">LaundryTrack</h1>
                    <p class="text-blue-200">Pantau laundry Anda dengan mudah</p>
                </div>


            </div>

            <!-- Main Content -->
            <div class="bg-white p-8 md:w-full">
                <form id="loginForm" class=" md:flex md:flex-col md:items-center md:justify-center h-full">
                    <div class="space-y-5 md:w-1/2 border border-gray-300 rounded-lg p-8 shadow-md">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Masuk ke Akun Anda </h2>
                        <input type="text" name="login" hidden>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor
                                Telepon</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: 081234567890" required>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" id="password" name="password"
                                class="w-full px-4 py-2  rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Masukkan password Anda" required>
                        </div>

                        <button type="submit"
                            class=" w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                            <span id="loginText">Masuk</span>
                            <svg id="loginSpinner" class="animate-spin -mr-1 ml-3 h-5 w-5 text-white hidden"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </form>

                <div class="mt-2 hidden space-y-4" id="userDashboard">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Status Laundry</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">2 Pesanan
                            Aktif</span>
                    </div>

                    <div class="space-y-4 overflow-y-scroll" id="laundryItems">
                        <!-- Items will be loaded here -->
                    </div>


                </div>
            </div>
        </div>
        <script>
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                const phone = $('#phone').val();
                const password = $('#password').val();

                // Show loading state
                $('#loginText').text('Memeriksa...');
                $('#loginSpinner').removeClass('hidden');

                // Kirim data ke backend pakai AJAX
                $.ajax({
                    url: 'laundry_track.php',
                    method: 'POST',
                    data: {
                        phone: phone,
                        password: password
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Sembunyikan form login
                            $('#loginForm').addClass('hidden md:hidden');

                            const laundryData = response.data; // ambil data dari respons

                            // Render semua transaksi
                            renderSemuaTransaksi(laundryData.transaksi);

                            $('#userDashboard').removeClass('hidden');
                        } else {
                            $('#loginText').text('Masuk');
                            $('#loginSpinner').addClass('hidden');
                            alert(response.message || 'Login gagal.');
                        }
                    },
                    error: function() {
                        $('#loginText').text('Masuk');
                        $('#loginSpinner').addClass('hidden');
                        alert('Terjadi kesalahan saat menghubungi server.');
                    }
                });
            });

            function renderSemuaTransaksi(dataList) {
                const container = $('#userDashboard');
                container.empty();

                dataList.forEach(data => {
                    const statusProgress = getProgress(data.status);
                    const tglOrder = formatTanggal(data.tgl);
                    const batasWaktu = formatTanggal(data.batas_waktu);
                    const tglBayar = data.tgl_pembayaran ? formatTanggal(data.tgl_pembayaran) : '-';
                    const statusBayarClass = data.status_bayar === 'dibayar' ? 'bg-green-100 text-green-700' :
                        'bg-red-100 text-red-700';

                    const statusLaundryClass = data.status === 'selesai' ?
                        'bg-green-100 text-green-800' :
                        'bg-blue-100 text-blue-800';

                    const item = `
            <div class="bg-white p-5 rounded-lg shadow border border-gray-200">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <h4 class="font-semibold text-gray-800">Kode Invoice: ${data.kode_invoice}</h4>
                        <p class="text-sm text-gray-500">Tanggal Order: ${tglOrder}</p>
                        <p class="text-sm text-gray-500">Batas Waktu: ${batasWaktu}</p>
                        <p class="text-sm text-gray-500">Tanggal Bayar: ${tglBayar}</p>
                    </div>
                    <div class="text-right space-y-1">
                        <span class="px-2 py-1 text-xs rounded-full font-semibold ${statusLaundryClass}">
                            ${capitalize(data.status)}
                        </span><br/>
                        <span class="px-2 py-1 text-xs rounded-full font-medium ${statusBayarClass}">
                            ${capitalize(data.status_bayar)}
                        </span>
                    </div>
                </div>

                <div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: ${statusProgress}%"></div>
                    </div>
                    <div class="text-xs text-gray-500 flex justify-between">
                        <span>Proses</span>
                        <span>${statusProgress}%</span>
                    </div>
                </div>
            </div>
        `;

                    container.append(item);
                });
            }

            // Helper
            function getProgress(status) {
                switch (status) {
                    case 'baru':
                        return 20;
                    case 'proses':
                        return 50;
                    case 'selesai':
                        return 100;
                    default:
                        return 0;
                }
            }

            function formatTanggal(tanggal) {
                const date = new Date(tanggal);
                const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                return `${date.getDate()} ${bulan[date.getMonth()]} ${date.getFullYear()}`;
            }

            function capitalize(str) {
                return str.charAt(0).toUpperCase() + str.slice(1);
            }
        </script>
</body>

</html>