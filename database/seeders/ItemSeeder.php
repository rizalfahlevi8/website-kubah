<?php

namespace Database\Seeders;

use App\Models\Items;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // Rangka & Struktur Kubah
            [
                'kode' => 'KBH-STR-001',
                'nama' => 'Pipa Galvanis Medium B 2.5 Inch (6m)',
                'satuan' => 'Batang',
                'stock' => 120,
            ],
            [
                'kode' => 'KBH-STR-002',
                'nama' => 'Pipa Galvanis Medium B 2.0 Inch (6m)',
                'satuan' => 'Batang',
                'stock' => 180,
            ],
            [
                'kode' => 'KBH-STR-003',
                'nama' => 'Pipa Galvanis Medium B 1.5 Inch (6m)',
                'satuan' => 'Batang',
                'stock' => 150,
            ],
            [
                'kode' => 'KBH-STR-004',
                'nama' => 'Pipa Galvanis Medium B 1.25 Inch (6m)',
                'satuan' => 'Batang',
                'stock' => 95,
            ],
            [
                'kode' => 'KBH-STR-005',
                'nama' => 'Besi Hollow Galvanis 40x40 Tebal 1.8mm (6m)',
                'satuan' => 'Batang',
                'stock' => 240,
            ],
            [
                'kode' => 'KBH-STR-006',
                'nama' => 'Besi Hollow Galvanis 20x40 Tebal 1.6mm (6m)',
                'satuan' => 'Batang',
                'stock' => 310,
            ],
            [
                'kode' => 'KBH-STR-007',
                'nama' => 'Besi Siku Krakatau Steel 50x50x4mm (6m)',
                'satuan' => 'Batang',
                'stock' => 85,
            ],
            [
                'kode' => 'KBH-STR-008',
                'nama' => 'Besi Siku Krakatau Steel 40x40x3mm (6m)',
                'satuan' => 'Batang',
                'stock' => 110,
            ],
            [
                'kode' => 'KBH-STR-009',
                'nama' => 'Plat Strip Besi 30x3mm (6m)',
                'satuan' => 'Batang',
                'stock' => 140,
            ],

            // Panel Kubah Enamel & Galvalum
            [
                'kode' => 'KBH-PNL-001',
                'nama' => 'Plat Galvalum Anti Karat Tebal 0.40mm',
                'satuan' => 'Lembar',
                'stock' => 450,
            ],
            [
                'kode' => 'KBH-PNL-002',
                'nama' => 'Plat Galvalum Anti Karat Tebal 0.50mm',
                'satuan' => 'Lembar',
                'stock' => 320,
            ],
            [
                'kode' => 'KBH-PNL-003',
                'nama' => 'Plat Baja Low Carbon Steel 1.0mm (Khusus Enamel)',
                'satuan' => 'Lembar',
                'stock' => 260,
            ],
            [
                'kode' => 'KBH-PNL-004',
                'nama' => 'Plat Stainless Steel Titanium Gold 304 Tebal 0.5mm',
                'satuan' => 'Lembar',
                'stock' => 80,
            ],
            [
                'kode' => 'KBH-PNL-005',
                'nama' => 'Panel Kubah Galvalum Hijau Tosca Powder Coating',
                'satuan' => 'Pcs',
                'stock' => 1250,
            ],
            [
                'kode' => 'KBH-PNL-006',
                'nama' => 'Panel Kubah Galvalum Kuning Emas Powder Coating',
                'satuan' => 'Pcs',
                'stock' => 800,
            ],
            [
                'kode' => 'KBH-PNL-007',
                'nama' => 'Panel Kubah Enamel Porselen Biru Safir (Tahan 20 Thn)',
                'satuan' => 'Pcs',
                'stock' => 950,
            ],
            [
                'kode' => 'KBH-PNL-008',
                'nama' => 'Panel Kubah Enamel Porselen Putih Murni',
                'satuan' => 'Pcs',
                'stock' => 600,
            ],

            // Waterproofing, Peredam & Plafon
            [
                'kode' => 'KBH-WTP-001',
                'nama' => 'Kalsiboard / GRC Board 4mm (Kedap Air Plafon Kubah)',
                'satuan' => 'Lembar',
                'stock' => 175,
            ],
            [
                'kode' => 'KBH-WTP-002',
                'nama' => 'Kalsiboard / GRC Board 6mm (Rangka Plafon Kubah)',
                'satuan' => 'Lembar',
                'stock' => 90,
            ],
            [
                'kode' => 'KBH-WTP-003',
                'nama' => 'Membran Bakar Waterproofing Tebal 3mm (10m x 1m)',
                'satuan' => 'Roll',
                'stock' => 45,
            ],
            [
                'kode' => 'KBH-WTP-004',
                'nama' => 'Sealant Silikon Netral Weatherproof Abu-Abu (300ml)',
                'satuan' => 'Tube',
                'stock' => 360,
            ],
            [
                'kode' => 'KBH-WTP-005',
                'nama' => 'Sealant Silikon Netral Weatherproof Hitam (300ml)',
                'satuan' => 'Tube',
                'stock' => 280,
            ],
            [
                'kode' => 'KBH-WTP-006',
                'nama' => 'Aluminium Foil Woven Double Side Peredam Panas (50m)',
                'satuan' => 'Roll',
                'stock' => 35,
            ],

            // Fastener & Bahan Pengelasan
            [
                'kode' => 'KBH-FST-001',
                'nama' => 'Kawat Las Kobe Steel RD-260 Ukuran 2.6mm (5kg)',
                'satuan' => 'Dus',
                'stock' => 65,
            ],
            [
                'kode' => 'KBH-FST-002',
                'nama' => 'Kawat Las Kobe Steel RD-260 Ukuran 3.2mm (5kg)',
                'satuan' => 'Dus',
                'stock' => 40,
            ],
            [
                'kode' => 'KBH-FST-003',
                'nama' => 'Baut Roofing Self Drilling SDS 12-14 x 20mm (Isi 1000)',
                'satuan' => 'Box',
                'stock' => 50,
            ],
            [
                'kode' => 'KBH-FST-004',
                'nama' => 'Dynabolt M12 x 99mm Heavy Duty (Isi 50)',
                'satuan' => 'Box',
                'stock' => 30,
            ],
            [
                'kode' => 'KBH-FST-005',
                'nama' => 'Dynabolt M10 x 77mm (Isi 100)',
                'satuan' => 'Box',
                'stock' => 40,
            ],
            [
                'kode' => 'KBH-FST-006',
                'nama' => 'Mata Gerinda Potong Besi WD 4 Inch (105x1.2mm)',
                'satuan' => 'Pcs',
                'stock' => 200,
            ],

            // Mahkota & Penangkal Petir
            [
                'kode' => 'KBH-MKR-001',
                'nama' => 'Makara Mahkota Kubah Stainless Steel 304 Lafadz Allah (Tinggi 2.5m)',
                'satuan' => 'Unit',
                'stock' => 6,
            ],
            [
                'kode' => 'KBH-MKR-002',
                'nama' => 'Makara Mahkota Kubah Stainless Steel 304 Lafadz Allah (Tinggi 1.8m)',
                'satuan' => 'Unit',
                'stock' => 10,
            ],
            [
                'kode' => 'KBH-MKR-003',
                'nama' => 'Makara Mahkota Kubah Stainless Steel 304 Bulan Bintang (Tinggi 2.0m)',
                'satuan' => 'Unit',
                'stock' => 8,
            ],
            [
                'kode' => 'KBH-MKR-004',
                'nama' => 'Tombak Splitzen Penangkal Petir Tembaga 3/4 Inch + Dudukan',
                'satuan' => 'Set',
                'stock' => 15,
            ],
            [
                'kode' => 'KBH-MKR-005',
                'nama' => 'Kabel Tembaga Bare Copper BC 50mm (Grounding Petir)',
                'satuan' => 'Meter',
                'stock' => 350,
            ],

            // Cat & Finishing
            [
                'kode' => 'KBH-CAT-001',
                'nama' => 'Cat Epoxy Primer Zinc Chromate Anti Karat (Pail 20L)',
                'satuan' => 'Pail',
                'stock' => 18,
            ],
            [
                'kode' => 'KBH-CAT-002',
                'nama' => 'Cat Duco PU Warna Hijau Tosca Kubah (Pail 20L)',
                'satuan' => 'Pail',
                'stock' => 12,
            ],
            [
                'kode' => 'KBH-CAT-003',
                'nama' => 'Cat Duco PU Warna Gold Metalik Spesial (Kaleng 5L)',
                'satuan' => 'Kaleng',
                'stock' => 25,
            ],
            [
                'kode' => 'KBH-CAT-004',
                'nama' => 'Thinner PU Super High Gloss (Jerigen 20L)',
                'satuan' => 'Jerigen',
                'stock' => 22,
            ],
        ];

        foreach ($items as $item) {
            Items::updateOrCreate(
                ['kode' => $item['kode']],
                [
                    'nama' => $item['nama'],
                    'satuan' => $item['satuan'],
                    'stock' => $item['stock'],
                ]
            );
        }
    }
}
