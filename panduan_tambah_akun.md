Ran command: `Get-ChildItem -Path "C:\Users\losts\Desktop\web fakultas psikologi\apps-psikologi\psychoApps" -Filter "*surat*.php" | Select-Object Name`
Viewed agendaSuratMasukAdm.php:1-232
Viewed agendaSuratKeluarAdm.php:1-217
Viewed suratMahasiswaAdm.php:1-214
Viewed permohonanSuratUser.php:1-254

Berdasarkan _source code legacy_, modul **Tata Persuratan** terbagi menjadi dua ranah utama: **Agenda Surat Administrasi (Masuk & Keluar)** untuk tata usaha fakultas, dan **Pelayanan Surat Mahasiswa** untuk memproses permohonan surat akademik mahasiswa secara otomatis.

Berikut adalah panduan lengkap fungsionalitas, struktur file, dan tabel database yang menggerakkan modul ini:

---

### Bagian 1: Agenda Surat Administrasi (Tata Usaha)

Modul ini digunakan oleh staf persuratan untuk mengarsipkan lalu lintas surat resmi.

#### A. Fitur & Alur (Workflow)

1. **Surat Masuk**: Admin menerima surat fisik/digital dari luar, lalu mencatat _Nomor Berkas_, _Pengirim_, _Perihal_, dan mengelompokkannya ke dalam map _Ordner_. Admin juga mencatat siapa _Eksekutor_ (yang menindaklanjuti) dan dapat mencetak **Lembar Disposisi**.
2. **Surat Keluar**: Pencatatan surat resmi yang dikeluarkan oleh fakultas. Fitur andalannya adalah kemampuan untuk mencetak **Kop Amplop** secara otomatis berdasarkan alamat tujuan yang diinput.

#### B. File Referensi (_Legacy_)

- **Surat Masuk**:
  - `agendaSuratMasukAdm.php` (Dasbor utama daftar surat masuk)
  - `inputAgendaSuratMasukAdm.php` & `sinputAgendaSuratMasukAdm.php` (Form & Aksi penambahan surat masuk)
  - `cetakDisposisiAdm.php` (Mencetak form disposisi untuk pimpinan)
- **Surat Keluar**:
  - `agendaSuratKeluarAdm.php` (Dasbor utama surat keluar)
  - `inputAgendaSuratKeluarAdm.php` & `sinputAgendaSuratKeluarAdm.php` (Form & Aksi penambahan surat keluar)
  - `cetakKopAmplopAdm.php` (Mencetak label amplop surat keluar)

#### C. Tabel Database Terkait

- **`surat_masuk`**:
  - Kolom utama: `id`, `no_berkas`, `tgl_terima`, `pengirim`, `perihal`, `ordner`, `jml_berkas`, `berkas` (link PDF), `executor` (merujuk ke tabel admin).
- **`surat_keluar`**:
  - Kolom utama: `id`, `no_berkas`, `tgl_surat`, `tujuan`, `perihal`, `ordner`, `jml_berkas`, `berkas`.
- **`ordner`**: Tabel master untuk mengelompokkan kategori arsip surat fisik (misal: "Ordner A: SK Rektor"). Kolom: `id`, `kode_ordner`, `nm_ordner`.

---

### Bagian 2: Pelayanan Surat Mahasiswa (Otomatisasi Dokumen Akademik)

Modul ini melayani permohonan pembuatan surat pengantar secara mandiri oleh mahasiswa (S1).

#### A. Fitur & Alur (Workflow)

1. **Pengajuan (_Frontend User_)**: Mahasiswa _login_ dan mengakses portal "Permohonan Surat". Mereka memilih jenis surat (misal: _Izin Penelitian Skripsi_, _Magang_, dll) lalu mengisi form. Data akan langsung masuk ke database masing-masing kategori surat.
2. **Katalog & Cetak (_Backend Admin_)**: Admin Tata Persuratan membuka "Katalog Percetakan Surat" yang berisi _template_ _layout_ surat siap cetak. Admin dapat merekap data ajuan, memvalidasinya, lalu mengeklik tombol **Cetak**. Sistem akan memanggil kerangka surat (berisi kop, redaksi baku, dan nama dekan) lalu menyisipkan data variabel mahasiswa (Nama, NIM, Tujuan, Judul Skripsi/Kegiatan) di dalamnya lalu diekspor menjadi dokumen siap potong/PDF.

#### B. File Referensi (_Legacy_)

**Panel Mahasiswa (Pengajuan):**

- `permohonanSuratUser.php` (Dasbor mahasiswa, berisi rekap total pengajuan surat yang pernah mereka buat)
- Kumpulan Form: `formSiowiUser.php` (Observasi Individu), `formSimagkUser.php` (Magang Kelompok), `formSipsUser.php` (Skripsi), dll.

**Panel Admin (Percetakan & Rekap):**

- `suratMahasiswaAdm.php` (Katalog master preview template surat)
- `rekapSuratMahasiswaAdm.php` (Dasbor daftar mahasiswa yang telah mengajukan surat)
- Kumpulan _Generator_ Cetak (Mode PDF / Print HTML):
  - `cetakSiowiAdm.php` / `cetakSiowkAdm.php` (Cetak Izin Observasi & Wawancara - Individu/Kelompok)
  - `cetakSimagIndividuAdm.php` / `cetakSimagKelompokAdm.php` (Cetak Magang Mandiri)
  - `cetakSitpAdm.php` (Cetak Izin Tempat PKL)
  - `cetakSiprakisAdm.php` / `cetakSiprakimAdm.php` (Cetak Praktikum dengan Testee Siswa / Mahasiswa)
  - `cetakPrasipsAdm.php` (Cetak Observasi Pra-Skripsi)
  - `cetakSipsAdm.php` (Cetak Penelitian Skripsi Utama)
  - `cetakSkkbAdm.php` (Cetak Surat Keterangan Kelakuan Baik)

#### C. Tabel Database Terkait

Sistem ini menggunakan banyak tabel pecahan, karena atribut/kolom formulir setiap jenis surat berbeda-beda (misal surat penelitian butuh "Judul Skripsi", sementara magang tidak).

- **`siow_individu` & `siow_kelompok`**: Permohonan Observasi & Wawancara. _(Kolom: nim, nama_matkul, dosen_pengampu, instansi_tujuan, dll)_
- **`magang`**: Permohonan Magang Mandiri. Memiliki kolom `jenis_magang` (`1` untuk individu, `2` untuk kelompok).
- **`sitp`**: Surat Izin Tempat Praktik Kerja Lapangan (PKL).
- **`siprak_mahasiswa` & `siprak_siswa`**: Permohonan praktikum. Pembeda tabel berdasarkan subjek (testee) yang diobservasi.
- **`prasips`**: Izin pencarian data awal / Pra-Skripsi.
- **`sips`**: Izin Penelitian Skripsi Resmi. _(Kolom: nim, judul_skripsi, pembimbing, instansi_penelitian)_
- **`skkb`**: Permohonan Keterangan Kelakuan Baik.
