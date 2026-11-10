<?php

namespace Database\Seeders;

use App\Models\Items;
use App\Models\stock_movements;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StockMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ItemSeeder sudah dijalankan terlebih dahulu
        $itemMap = Items::all()->keyBy('nama');

        if ($itemMap->isEmpty()) {
            $this->call(ItemSeeder::class);
            $itemMap = Items::all()->keyBy('nama');
        }

        $now = Carbon::now();

        $movements = [
            // 1. Pipa Galvanis 2.5 Inch
            [
                'item_nama' => 'Pipa Galvanis Medium B 2.5 Inch (6m)',
                'jenis' => 'masuk',
                'jumlah' => 150,
                'keterangan' => 'Pengadaan stok pipa rangka utama dari PT Spindo Tbk (PO-KBH-2026-001)',
                'tanggal' => $now->copy()->subDays(25)->toDateString(),
            ],
            [
                'item_nama' => 'Pipa Galvanis Medium B 2.5 Inch (6m)',
                'jenis' => 'keluar',
                'jumlah' => 30,
                'keterangan' => 'Rangka utama proyek Kubah Masjid Al-Ikhlas (D: 8m) Surabaya',
                'tanggal' => $now->copy()->subDays(18)->toDateString(),
            ],

            // 2. Pipa Galvanis 2.0 Inch
            [
                'item_nama' => 'Pipa Galvanis Medium B 2.0 Inch (6m)',
                'jenis' => 'masuk',
                'jumlah' => 220,
                'keterangan' => 'Penerimaan suplai pipa lengkung kubah dari distributor besi',
                'tanggal' => $now->copy()->subDays(24)->toDateString(),
            ],
            [
                'item_nama' => 'Pipa Galvanis Medium B 2.0 Inch (6m)',
                'jenis' => 'keluar',
                'jumlah' => 40,
                'keterangan' => 'Pabrikasi struktur lengkung kubah Masjid Baiturrahman (D: 10m) Semarang',
                'tanggal' => $now->copy()->subDays(15)->toDateString(),
            ],

            // 3. Pipa Galvanis 1.5 Inch
            [
                'item_nama' => 'Pipa Galvanis Medium B 1.5 Inch (6m)',
                'jenis' => 'masuk',
                'jumlah' => 180,
                'keterangan' => 'Penerimaan stok pipa pembagi rangka kubah',
                'tanggal' => $now->copy()->subDays(22)->toDateString(),
            ],
            [
                'item_nama' => 'Pipa Galvanis Medium B 1.5 Inch (6m)',
                'jenis' => 'keluar',
                'jumlah' => 30,
                'keterangan' => 'Material bracing kubah Masjid Jami\' Nurul Huda Malang',
                'tanggal' => $now->copy()->subDays(12)->toDateString(),
            ],

            // 4. Besi Hollow Galvanis 40x40
            [
                'item_nama' => 'Besi Hollow Galvanis 40x40 Tebal 1.8mm (6m)',
                'jenis' => 'masuk',
                'jumlah' => 300,
                'keterangan' => 'Penerimaan material hollow dudukan panel kubah',
                'tanggal' => $now->copy()->subDays(20)->toDateString(),
            ],
            [
                'item_nama' => 'Besi Hollow Galvanis 40x40 Tebal 1.8mm (6m)',
                'jenis' => 'keluar',
                'jumlah' => 60,
                'keterangan' => 'Fabrikasi rangka dudukan panel proyek Masjid Agung Al-Falah Solo',
                'tanggal' => $now->copy()->subDays(10)->toDateString(),
            ],

            // 5. Besi Hollow Galvanis 20x40
            [
                'item_nama' => 'Besi Hollow Galvanis 20x40 Tebal 1.6mm (6m)',
                'jenis' => 'masuk',
                'jumlah' => 380,
                'keterangan' => 'Penerimaan hollow untuk rangka plafon kedap air',
                'tanggal' => $now->copy()->subDays(20)->toDateString(),
            ],
            [
                'item_nama' => 'Besi Hollow Galvanis 20x40 Tebal 1.6mm (6m)',
                'jenis' => 'keluar',
                'jumlah' => 70,
                'keterangan' => 'Rangka kalsiboard plafon kubah Masjid Al-Muttaqin Yogyakarta',
                'tanggal' => $now->copy()->subDays(8)->toDateString(),
            ],

            // 6. Besi Siku 50x50x4mm
            [
                'item_nama' => 'Besi Siku Krakatau Steel 50x50x4mm (6m)',
                'jenis' => 'masuk',
                'jumlah' => 100,
                'keterangan' => 'Pengadaan besi siku ring balok tumpuan kubah',
                'tanggal' => $now->copy()->subDays(23)->toDateString(),
            ],
            [
                'item_nama' => 'Besi Siku Krakatau Steel 50x50x4mm (6m)',
                'jenis' => 'keluar',
                'jumlah' => 15,
                'keterangan' => 'Ring balok pondasi kubah Masjid At-Taqwa Bandung',
                'tanggal' => $now->copy()->subDays(7)->toDateString(),
            ],

            // 7. Plat Galvalum 0.40mm
            [
                'item_nama' => 'Plat Galvalum Anti Karat Tebal 0.40mm',
                'jenis' => 'masuk',
                'jumlah' => 500,
                'keterangan' => 'Pengiriman plat galvalum roll/sheet dari PT Krakatau Steel',
                'tanggal' => $now->copy()->subDays(21)->toDateString(),
            ],
            [
                'item_nama' => 'Plat Galvalum Anti Karat Tebal 0.40mm',
                'jenis' => 'keluar',
                'jumlah' => 50,
                'keterangan' => 'Bahan pres panel kubah motif belah ketupat proyek Surabaya',
                'tanggal' => $now->copy()->subDays(14)->toDateString(),
            ],

            // 8. Plat Baja Low Carbon 1.0mm (Enamel)
            [
                'item_nama' => 'Plat Baja Low Carbon Steel 1.0mm (Khusus Enamel)',
                'jenis' => 'masuk',
                'jumlah' => 300,
                'keterangan' => 'Penerimaan plat baja low carbon untuk proses oven enamel 800°C',
                'tanggal' => $now->copy()->subDays(25)->toDateString(),
            ],
            [
                'item_nama' => 'Plat Baja Low Carbon Steel 1.0mm (Khusus Enamel)',
                'jenis' => 'keluar',
                'jumlah' => 40,
                'keterangan' => 'Pengiriman plat ke divisi pressing & oven enamel Masjid Al-Baiturrahman',
                'tanggal' => $now->copy()->subDays(16)->toDateString(),
            ],

            // 9. Plat Stainless Titanium Gold
            [
                'item_nama' => 'Plat Stainless Steel Titanium Gold 304 Tebal 0.5mm',
                'jenis' => 'masuk',
                'jumlah' => 100,
                'keterangan' => 'Import plat gold mirror 304 untuk ornamen kubah masjid premium',
                'tanggal' => $now->copy()->subDays(28)->toDateString(),
            ],
            [
                'item_nama' => 'Plat Stainless Steel Titanium Gold 304 Tebal 0.5mm',
                'jenis' => 'keluar',
                'jumlah' => 20,
                'keterangan' => 'Pembuatan ornamen leher kubah & lisplang Masjid Raya Sumatera',
                'tanggal' => $now->copy()->subDays(9)->toDateString(),
            ],

            // 10. Panel Kubah Galvalum Hijau Tosca
            [
                'item_nama' => 'Panel Kubah Galvalum Hijau Tosca Powder Coating',
                'jenis' => 'masuk',
                'jumlah' => 1500,
                'keterangan' => 'Hasil produksi batch A divisi oven powder coating',
                'tanggal' => $now->copy()->subDays(15)->toDateString(),
            ],
            [
                'item_nama' => 'Panel Kubah Galvalum Hijau Tosca Powder Coating',
                'jenis' => 'keluar',
                'jumlah' => 250,
                'keterangan' => 'Pemasangan panel lapis luar Masjid Nurul Iman Bekasi',
                'tanggal' => $now->copy()->subDays(5)->toDateString(),
            ],

            // 11. Panel Kubah Enamel Porselen Biru Safir
            [
                'item_nama' => 'Panel Kubah Enamel Porselen Biru Safir (Tahan 20 Thn)',
                'jenis' => 'masuk',
                'jumlah' => 1200,
                'keterangan' => 'Penerimaan panel selesai oven porcelain enamel dari pabrik',
                'tanggal' => $now->copy()->subDays(19)->toDateString(),
            ],
            [
                'item_nama' => 'Panel Kubah Enamel Porselen Biru Safir (Tahan 20 Thn)',
                'jenis' => 'keluar',
                'jumlah' => 250,
                'keterangan' => 'Pengiriman ke lokasi proyek Masjid Raya Al-Baiturrahman',
                'tanggal' => $now->copy()->subDays(6)->toDateString(),
            ],

            // 12. Kalsiboard 4mm (Waterproofing Plafon)
            [
                'item_nama' => 'Kalsiboard / GRC Board 4mm (Kedap Air Plafon Kubah)',
                'jenis' => 'masuk',
                'jumlah' => 200,
                'keterangan' => 'Pengadaan papan kalsiboard kedap air dari distributor resmi',
                'tanggal' => $now->copy()->subDays(22)->toDateString(),
            ],
            [
                'item_nama' => 'Kalsiboard / GRC Board 4mm (Kedap Air Plafon Kubah)',
                'jenis' => 'keluar',
                'jumlah' => 25,
                'keterangan' => 'Pemasangan lapisan kedap air kubah Masjid Al-Ikhlas Surabaya',
                'tanggal' => $now->copy()->subDays(11)->toDateString(),
            ],

            // 13. Membran Bakar Waterproofing
            [
                'item_nama' => 'Membran Bakar Waterproofing Tebal 3mm (10m x 1m)',
                'jenis' => 'masuk',
                'jumlah' => 50,
                'keterangan' => 'Penerimaan roll membran bakar pelindung bocor kubah',
                'tanggal' => $now->copy()->subDays(25)->toDateString(),
            ],
            [
                'item_nama' => 'Membran Bakar Waterproofing Tebal 3mm (10m x 1m)',
                'jenis' => 'keluar',
                'jumlah' => 5,
                'keterangan' => 'Aplikasi waterproofing membran bakar Masjid Agung Semarang',
                'tanggal' => $now->copy()->subDays(13)->toDateString(),
            ],

            // 14. Sealant Silikon Netral
            [
                'item_nama' => 'Sealant Silikon Netral Weatherproof Abu-Abu (300ml)',
                'jenis' => 'masuk',
                'jumlah' => 400,
                'keterangan' => 'Restock sealant silicone tahan cuaca dan UV untuk nat panel kubah',
                'tanggal' => $now->copy()->subDays(16)->toDateString(),
            ],
            [
                'item_nama' => 'Sealant Silikon Netral Weatherproof Abu-Abu (300ml)',
                'jenis' => 'keluar',
                'jumlah' => 40,
                'keterangan' => 'Pengisian sela nat panel kubah proyek Masjid Al-Muttaqin',
                'tanggal' => $now->copy()->subDays(4)->toDateString(),
            ],

            // 15. Kawat Las RD-260 2.6mm
            [
                'item_nama' => 'Kawat Las Kobe Steel RD-260 Ukuran 2.6mm (5kg)',
                'jenis' => 'masuk',
                'jumlah' => 80,
                'keterangan' => 'Pengadaan konsumabel las bengkel fabrikasi rangka',
                'tanggal' => $now->copy()->subDays(27)->toDateString(),
            ],
            [
                'item_nama' => 'Kawat Las Kobe Steel RD-260 Ukuran 2.6mm (5kg)',
                'jenis' => 'keluar',
                'jumlah' => 15,
                'keterangan' => 'Pemakaian perakitan kuda-kuda rangka kubah workshop',
                'tanggal' => $now->copy()->subDays(17)->toDateString(),
            ],

            // 16. Baut Roofing SDS
            [
                'item_nama' => 'Baut Roofing Self Drilling SDS 12-14 x 20mm (Isi 1000)',
                'jenis' => 'masuk',
                'jumlah' => 60,
                'keterangan' => 'Restock baut drilling anti karat dengan ring karet EPDM',
                'tanggal' => $now->copy()->subDays(20)->toDateString(),
            ],
            [
                'item_nama' => 'Baut Roofing Self Drilling SDS 12-14 x 20mm (Isi 1000)',
                'jenis' => 'keluar',
                'jumlah' => 10,
                'keterangan' => 'Pemasangan panel galvalum proyek Masjid Jami\' Nurul Huda',
                'tanggal' => $now->copy()->subDays(7)->toDateString(),
            ],

            // 17. Dynabolt M12 x 99mm
            [
                'item_nama' => 'Dynabolt M12 x 99mm Heavy Duty (Isi 50)',
                'jenis' => 'masuk',
                'jumlah' => 35,
                'keterangan' => 'Penerimaan dynabolt penjangkar angkur baseplate kubah',
                'tanggal' => $now->copy()->subDays(22)->toDateString(),
            ],
            [
                'item_nama' => 'Dynabolt M12 x 99mm Heavy Duty (Isi 50)',
                'jenis' => 'keluar',
                'jumlah' => 5,
                'keterangan' => 'Pemasangan angkur ring balok kubah Masjid Raya Al-Baiturrahman',
                'tanggal' => $now->copy()->subDays(15)->toDateString(),
            ],

            // 18. Makara Stainless Lafadz Allah 2.5m
            [
                'item_nama' => 'Makara Mahkota Kubah Stainless Steel 304 Lafadz Allah (Tinggi 2.5m)',
                'jenis' => 'masuk',
                'jumlah' => 7,
                'keterangan' => 'Penerimaan mahkota makara stainless steel dari pengrajin workshop',
                'tanggal' => $now->copy()->subDays(30)->toDateString(),
            ],
            [
                'item_nama' => 'Makara Mahkota Kubah Stainless Steel 304 Lafadz Allah (Tinggi 2.5m)',
                'jenis' => 'keluar',
                'jumlah' => 1,
                'keterangan' => 'Pemasangan mahkota makara puncak kubah Masjid Raya Al-Baiturrahman',
                'tanggal' => $now->copy()->subDays(2)->toDateString(),
            ],

            // 19. Makara Bulan Bintang 2.0m
            [
                'item_nama' => 'Makara Mahkota Kubah Stainless Steel 304 Bulan Bintang (Tinggi 2.0m)',
                'jenis' => 'masuk',
                'jumlah' => 10,
                'keterangan' => 'Penerimaan makara stainless steel ornamen bulan bintang',
                'tanggal' => $now->copy()->subDays(26)->toDateString(),
            ],
            [
                'item_nama' => 'Makara Mahkota Kubah Stainless Steel 304 Bulan Bintang (Tinggi 2.0m)',
                'jenis' => 'keluar',
                'jumlah' => 2,
                'keterangan' => 'Pemasangan mahkota kubah proyek Masjid Al-Ikhlas & At-Taqwa',
                'tanggal' => $now->copy()->subDays(3)->toDateString(),
            ],

            // 20. Penangkal Petir Splitzen Tembaga
            [
                'item_nama' => 'Tombak Splitzen Penangkal Petir Tembaga 3/4 Inch + Dudukan',
                'jenis' => 'masuk',
                'jumlah' => 18,
                'keterangan' => 'Pengadaan tombak splitzen tembaga murni untuk puncak kubah',
                'tanggal' => $now->copy()->subDays(20)->toDateString(),
            ],
            [
                'item_nama' => 'Tombak Splitzen Penangkal Petir Tembaga 3/4 Inch + Dudukan',
                'jenis' => 'keluar',
                'jumlah' => 3,
                'keterangan' => 'Instalasi sistem penangkal petir di puncak makara 3 masjid',
                'tanggal' => $now->copy()->subDays(4)->toDateString(),
            ],

            // 21. Cat Epoxy Primer Zinc Chromate
            [
                'item_nama' => 'Cat Epoxy Primer Zinc Chromate Anti Karat (Pail 20L)',
                'jenis' => 'masuk',
                'jumlah' => 22,
                'keterangan' => 'Pengadaan cat dasar anti karat untuk seluruh pipa rangka kubah',
                'tanggal' => $now->copy()->subDays(24)->toDateString(),
            ],
            [
                'item_nama' => 'Cat Epoxy Primer Zinc Chromate Anti Karat (Pail 20L)',
                'jenis' => 'keluar',
                'jumlah' => 4,
                'keterangan' => 'Pelapisan anti karat rangka pipa kubah Masjid Baiturrahman',
                'tanggal' => $now->copy()->subDays(12)->toDateString(),
            ],

            // 22. Cat Duco PU Hijau Tosca
            [
                'item_nama' => 'Cat Duco PU Warna Hijau Tosca Kubah (Pail 20L)',
                'jenis' => 'masuk',
                'jumlah' => 15,
                'keterangan' => 'Pengadaan cat polyurethane khusus outdoor tahan cuaca & pudar',
                'tanggal' => $now->copy()->subDays(21)->toDateString(),
            ],
            [
                'item_nama' => 'Cat Duco PU Warna Hijau Tosca Kubah (Pail 20L)',
                'jenis' => 'keluar',
                'jumlah' => 3,
                'keterangan' => 'Finishing pengecatan panel kubah proyek Masjid Nurul Huda',
                'tanggal' => $now->copy()->subDays(6)->toDateString(),
            ],
        ];

        foreach ($movements as $mov) {
            $item = $itemMap->get($mov['item_nama']);

            if (! $item) {
                continue;
            }

            stock_movements::create([
                'item_id' => $item->id,
                'jenis' => $mov['jenis'],
                'jumlah' => $mov['jumlah'],
                'keterangan' => $mov['keterangan'],
                'tanggal' => $mov['tanggal'],
            ]);
        }
    }
}

