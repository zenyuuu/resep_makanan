<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resep;
use App\Models\User;

class ResepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $recipes = [
            [
                'judul' => 'Nasi Goreng Telur Spesial',
                'bahan' => "2 piring nasi putih
2 butir telur
3 siung bawang putih
2 buah cabe merah
Kecap manis 3 sendok
Garam & merica secukupnya
100 gram daging ayam
100 gram udang
Minyak goreng 3 sendok",
                'langkah' => "1. Tumis bawang putih hingga wangi, masukkan daging ayam dan udang
2. Masukkan nasi putih, aduk rata
3. Tambahkan kecap manis, garam, dan merica
4. Buat lubang di tengah, masukkan telur dan scramble hingga matang
5. Aduk rata semua bahan dan siap sajikan
6. Hias dengan bawang goreng dan selada"
            ],
            [
                'judul' => 'Soto Ayam Kuning',
                'bahan' => "1 ekor ayam (potong 8 bagian)
5 siung bawang putih
3 cm kunyit
3 cm jahe
2 batang serai
3 lembar daun salam
2 liter air
Garam secukupnya
200 ml susu cair
1 buah jeruk limau",
                'langkah' => "1. Haluskan bawang putih, kunyit, dan jahe
2. Rebus air dan masukkan potongan ayam hingga setengah matang
3. Masukkan bumbu halus, serai, dan daun salam
4. Masak sampai ayam matang sempurna
5. Tambahkan susu cair dan air jeruk limau
6. Cek rasa dan tambahkan garam sesuai selera"
            ],
            [
                'judul' => 'Rendang Daging',
                'bahan' => "1 kg daging sapi (potong dadu)
400 ml santan
8 siung bawang putih
5 cm jahe
3 cm kunyit
8 buah cabe merah keriting
3 batang serai
5 lembar daun salam
2 liter air
Garam secukupnya",
                'langkah' => "1. Haluskan bawang putih, jahe, kunyit, dan cabe
2. Rebus air dan masukkan daging sapi
3. Masak sampai daging empuk (sekitar 45 menit)
4. Tambahkan bumbu halus dan serai
5. Tuangkan santan dan aduk rata
6. Masak sampai santan mengental dan daging berwarna coklat kemerahan"
            ],
            [
                'judul' => 'Gado-Gado Jakarta',
                'bahan' => "200 gram tahu goreng
100 gram tempe goreng
1 bundle kangkung
100 gram tauge
50 gram kacang panjang
2 buah telur rebus
Bumbu kacang:
- 200 gram kacang tanah goreng
- 3 siung bawang putih
- 2 buah cabe merah
- 1 sdm gula
- Garam secukupnya
- Air secukupnya",
                'langkah' => "1. Rebus semua sayuran sampai empuk tetapi masih renyah
2. Haluskan bumbu kacang (bawang putih, cabe, kacang)
3. Campurkan bumbu dengan air panas sampai konsistensi saus
4. Tata sayuran di piring
5. Tambahkan tahu, tempe, dan telur rebus
6. Siram dengan bumbu kacang dan sajikan"
            ],
            [
                'judul' => 'Martabak Telur',
                'bahan' => "Adonan:
- 500 gram tepung terigu
- 1 sdm gula
- 1/2 sdm garam
- 200 ml air
- 2 sdm minyak

Isi:
- 5 butir telur
- 100 gram daging giling
- 1/2 bundel bawang goreng
- Garam dan merica secukupnya
- 3 siung bawang putih (iris halus)",
                'langkah' => "1. Campur tepung terigu, gula, dan garam
2. Tuangkan air secara perlahan sambil diaduk
3. Uleni sampai kalis dan elastis
4. Diamkan 30 menit
5. Goreng daging giling dengan bawang putih
6. Tipiskan adonan di wajan panas, pecahkan telur di atasnya
7. Masukkan daging dan bawang goreng
8. Lipat martabak dan goreng sampai golden brown"
            ],
            [
                'judul' => 'Perkedel Kentang',
                'bahan' => "1 kg kentang
2 butir telur (ambil 1 untuk campuran, 1 untuk kocekan)
3 siung bawang putih (halus)
100 gram keju (parut)
Garam dan merica secukupnya
Tepung roti secukupnya
Minyak goreng untuk menggoreng",
                'langkah' => "1. Rebus kentang sampai empuk lalu kupas dan hancurkan
2. Campurkan telur, bawang putih, keju, garam, dan merica dengan kentang
3. Bentuk bulatan seukuran jeruk kecil
4. Celupkan ke telur kocok, kemudian gulingkan ke tepung roti
5. Goreng dalam minyak panas sampai berwarna kuning emas
6. Angkat dan tiriskan di atas tisu"
            ],
            [
                'judul' => 'Lumpia Goreng',
                'bahan' => "Kulit lumpia (siap pakai)
200 gram daging giling
100 gram tauge
1 batang bawang prei (iris halus)
3 siung bawang putih (cincang)
2 buah telur
Garam dan merica secukupnya
2 sdm kecap manis
Minyak untuk menggoreng",
                'langkah' => "1. Tumis bawang putih sampai harum
2. Masukkan daging giling, aduk sampai berubah warna
3. Tambahkan tauge dan bawang prei, tumis sebentar
4. Masukkan kecap manis, garam, dan merica
5. Biarkan dingin
6. Ambil kulit lumpia, isi dengan adonan
7. Lipat dan rekatkan ujungnya dengan sedikit air
8. Goreng sampai kuning keemasan"
            ],
            [
                'judul' => 'Bakso Daging',
                'bahan' => "500 gram daging sapi (giling)
2 butir telur
50 gram tepung terigu
100 gram es serut
3 siung bawang putih (halus)
Garam dan merica secukupnya
Kuah:
- 2 liter kaldu sapi
- 2 buah bawang merah
- 3 siung bawang putih
- 2 batang serai
- Garam secukupnya",
                'langkah' => "1. Campurkan daging giling, telur, tepung terigu, es serut, bawang putih, garam, dan merica
2. Uleni sampai adonan sticky
3. Bentuk bulatan dengan sendok makan
4. Rebus dalam air mendidih sampai bakso mengapung dan tetap di permukaan 5 menit
5. Rebus kuah dengan bumbu sampai matang
6. Masukkan bakso ke dalam kuah
7. Sajikan dengan mie kuning atau lontong"
            ],
            [
                'judul' => 'Satay Daging (Sate Ayam)',
                'bahan' => "800 gram daging ayam (potong dadu)
Bumbu kacang:
- 300 gram kacang tanah goreng
- 5 siung bawang putih
- 3 buah cabe merah
- 1 sdm gula merah
- 1 tsp garam
- 100 ml santan
- 2 sdm air asam tamarind
Tusuk sate",
                'langkah' => "1. Rendam tusuk sate dalam air 30 menit
2. Tusukkan daging ayam ke tusuk sate
3. Haluskan semua bumbu kacang
4. Campurkan bumbu dengan santan dan air asam
5. Panaskan arang atau grill
6. Bakar daging sate sampai matang dan gosong di bagian tepinya
7. Olesi dengan bumbu kacang sambil dibakar
8. Sajikan dengan bumbu kacang dan irisan bawang"
            ],
            [
                'judul' => 'Bakso Goreng',
                'bahan' => "400 gram daging sapi giling
100 gram taoge
50 gram bawang prei (iris halus)
2 siung bawang putih (halus)
2 butir telur
50 gram tepung terigu
25 gram tepung kanji
Garam dan merica
Minyak untuk menggoreng",
                'langkah' => "1. Campurkan daging giling, taoge, bawang prei, bawang putih
2. Masukkan telur, tepung terigu, tepung kanji, garam, dan merica
3. Aduk rata sampai tercampur sempurna
4. Bentuk bulatan dengan tangan atau sendok
5. Goreng dalam minyak panas sampai matang dan berwarna coklat
6. Angkat dan tiriskan di atas tisu
7. Sajikan dengan saus cabai atau kecap manis"
            ],
            [
                'judul' => 'Tahu Goreng Istimewa',
                'bahan' => "500 gram tahu putih (potong dadu)
3 siung bawang putih (halus)
Tepung terigu 100 gram
Tepung kanji 50 gram
1 butir telur
Garam dan merica secukupnya
Air 100 ml
Minyak goreng untuk menggoreng",
                'langkah' => "1. Campur tepung terigu, tepung kanji, garam, dan merica
2. Kocok telur bersama air
3. Campurkan tepung dengan air dan telur, tambahkan bawang putih
4. Celupkan tahu ke dalam adonan
5. Goreng dalam minyak panas sampai berwarna kuning emas
6. Angkat dan tiriskan
7. Sajikan dengan saus pedas atau sambal"
            ],
            [
                'judul' => 'Cireng (Aci Goreng)',
                'bahan' => "200 gram aci (tepung kanji)
200 gram air panas
1 butir telur
Garam secukupnya
3 siung bawang putih (halus)
Tepung roti untuk pelapis
Minyak untuk menggoreng
Bumbu pecel:
- Kacang tanah 150 gram
- Cabe 3 buah
- Bawang putih 3 siung",
                'langkah' => "1. Campur aci dengan air panas sambil diaduk
2. Masukkan telur, garam, dan bawang putih
3. Bentuk bulatan memanjang
4. Celupkan ke air dingin, kemudian gulingkan ke tepung roti
5. Goreng dalam minyak panas sampai golden brown
6. Haluskan bumbu pecel
7. Sajikan cireng dengan bumbu pecel"
            ],
            [
                'judul' => 'Perkedel Kentang Pedas',
                'bahan' => "1 kg kentang
3 butir telur
100 gram keju (parut)
4 siung bawang putih (halus)
3 buah cabe merah (halus)
Garam dan merica secukupnya
Tepung roti
Minyak goreng",
                'langkah' => "1. Rebus dan kupas kentang, haluskan
2. Campurkan dengan telur, keju, bawang putih, cabe, garam, dan merica
3. Bentuk bulatan
4. Gulingkan ke tepung roti
5. Goreng dalam minyak panas
6. Tiriskan dan sajikan selagi hangat"
            ]
        ];

        foreach ($recipes as $recipe) {
            Resep::create([
                'judul' => $recipe['judul'],
                'bahan' => $recipe['bahan'],
                'langkah' => $recipe['langkah'],
                'gambar' => null,
                'user_id' => $users->random()->id
            ]);
        }
    }
}
