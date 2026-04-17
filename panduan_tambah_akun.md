# Panduan Menambahkan Akun (User) dalam Sistem

Dokumen ini menjelaskan berbagai metode yang mendasari sistem autentikasi aplikasi untuk menambahkan akun (user) baru ke dalam sistem. Di dalam aplikasi ini, seluruh kredensial login disimpan terpusat di tabel `dt_all_adm`.

## 1. Menambahkan Akun Pegawai (Dosen / Tendik)

Akun untuk Dosen dan Staf/Tendik dapat ditambahkan langsung satu per satu melalui antarmuka aplikasi. Jika admin menambahkan profil pegawai, sistem akan otomatis membuatkan akun login.

1. Silahkan **Login** menggunakan akun dengan peran **Admin Kepegawaian**.
2. Pada menu *sidebar* di sebelah kiri, rentangkan menu **Data Pegawai**.
3. Pilih menu **Data Dosen** atau **Data Tendik** (sesuai kebutuhan).
4. Di pojok kanan atas tabel, klik tombol **[+ Input Data Dosen]** (atau Tendik) untuk memunculkan formulir.
5. Isi data secara lengkap (terutama hal wajib seperti NIP, Password, dan Tipe Akun).  
6. **Submit** form.
   
> [!NOTE] 
> Saat disimpan, *script* `sDtDosen.php` atau `sDtTendik.php` akan langsung memasukkan data relasi ke tabel detail profil dan meregristrasikan `NIP/ID` sebagai nama akun (username) di dalam `dt_all_adm`.

---

## 2. Menambahkan Akun Mahasiswa (S1 & S2)

Dikarenakan jumlah mahasiswa biasanya banyak, sistem menggunakan metode kolektif (Mass Import) via upload file Microsoft Excel (`.xls`).

1. **Login** menggunakan akun **Admin Kepegawaian Utama** (harus username asli bawaan sistem yaitu: `adminkepegawaian1`). Fitur khusus ini disembunyikan untuk staf kepegawaian biasa.
2. Di *sidebar*, buka antarmuka khusus bernama **Impor Data**.
3. Sistem memisahkan antara pendaftaran *Profil Dasar* dan *Akun Akses*:
   - Pertama, akses menu **Impor Data Mahasiswa** untuk memasukkan profil akademik.
   - Kedua, akses menu **Impor User Mahasiswa (S1 atau S2)** untuk membuat akses akun (*Login Credentials*).
4. Sediakan dan Upload file berformat `.xls` yang berisi rincian: `Username`, `Password`, `Level`, `Nama Person`, dan `Status`.
   
> [!TIP]
> File yang di-upload akan di-*parsing* oleh *library* `excel_reader2.php` di dalam `sformImporUserMahasiswaS1.php` dan datanya langsung diloop lalu dibuatkan sebagai entitas pengguna di tabel `dt_all_adm`.

---

## 3. Menambahkan Akun Admin Khusus (Contoh: Admin Surat / Fakultas)

Sama seperti metode impor akun mahasiswa, sistem mendukung pengangkatan role staf baru (misal Admin Tata Persuratan).
- Lewati jalur **Impor Data -> Admin Tata Persuratan** memakai status level khusus (level/role yang bukan milik Mahasiswa atau Dosen).
- Form Excel akan mengelompokkan otorisasi akun baru tsb.

---

## 4. Via Backend Engine (Akses Database Langsung)

Bila Anda adalah arsitek/developer sistem yang memegang akses akses hosting / *Database Engine* (seperti `phpMyAdmin`), membuat akun baru bisa dilakukan instan melalui Eksekusi Kueri *Standard SQL*. 

### Tabel `dt_all_adm`
Struktur kredensial tabel ini adalah:
- **`username`**: (Primary Key/NIP/NIM)
- **`password`**: MD5 Checksum dari *plaintext string*
- **`level`**: ID Angka Numerik Role
- **`nm_person`**: Label Profil/Nama Panjang
- **`status`**: Identifikasi aktif/inaktif ('1' atau '2')

### Query Pembuatan Akun Cepat:
```sql
INSERT INTO dt_all_adm (username, password, level, nm_person, login_terakhir, status) 
VALUES ('123456789', MD5('rahasia123'), '1', 'Dr. Budi Santoso', '', '1');
```

> [!WARNING]
> Bila Anda menambahkan akun hanya secara SQL ke tabel `dt_all_adm` tanpa memasukkan NIP identitasnya ke tabel detailnya (seperti `dt_pegawai` atau `dt_mhssw`), mungkin beberapa relasi fitur dan dashboard sistem tidak selaras (miskin profilisasi data). Jangan lupa selalu *sinkronkan* antara tabel otentikasi primer dan detil profil sekundernya.
