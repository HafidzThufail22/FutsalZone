# FutsalZone - Sistem Reservasi Lapangan Futsal

FutsalZone adalah aplikasi web untuk reservasi lapangan futsal secara online, dengan fitur pemisahan tampilan user dan admin, sistem login & registrasi admin, serta pengelolaan data reservasi dan lapangan.

## Fitur Utama

- **User**

  - Melihat daftar lapangan futsal yang tersedia
  - Melakukan reservasi lapangan secara online
  - Formulir reservasi dengan validasi

- **Admin**
  - Login & registrasi admin (dengan password hash)
  - Dashboard statistik (total lapangan, total reservasi)
  - Kelola data lapangan (tambah, lihat)
  - Melihat dan mengelola riwayat reservasi (edit, hapus, filter/cari)
  - Reset password admin
  - Keamanan dasar (session, validasi input, prepared statement)

## Struktur Folder

```
project-akhir/
│
├── index.php
├── reservasi.php
├── README.md
│
├── asset/
│   └── Lapangan.jpg
│
├── css/
│   └── styles.css
│
├── db/
│   └── futsalzone.sql
│
├── futsalzone-admin/
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── register.php
│   ├── riwayat.php
│   ├── tambah_lapangan.php
│   ├── setup_admin.php
│   └── reset_password.php
│
├── includes/
│   ├── cek_login.php
│   ├── fungsi.php
│   ├── koneksi_db.php
│   └── konfigurasi.php
```

## Struktur Database

### Tabel `admin`

| Kolom        | Tipe Data    | Keterangan                  |
| ------------ | ------------ | --------------------------- |
| id_admin     | INT (PK, AI) | Primary Key, auto increment |
| username     | VARCHAR(50)  | Username admin, unik        |
| password     | VARCHAR(255) | Password hash               |
| nama_lengkap | VARCHAR(100) | Nama lengkap admin          |
| created_at   | DATETIME     | Tanggal pembuatan akun      |

### Tabel `lapangan`

| Kolom         | Tipe Data    | Keterangan                  |
| ------------- | ------------ | --------------------------- |
| id_lapangan   | INT (PK, AI) | Primary Key, auto increment |
| nama_lapangan | VARCHAR(100) | Nama lapangan               |
| jenis         | VARCHAR(50)  | Jenis lapangan              |

### Tabel `reservasi`

| Kolom        | Tipe Data    | Keterangan                  |
| ------------ | ------------ | --------------------------- |
| id_reservasi | INT (PK, AI) | Primary Key, auto increment |
| id_lapangan  | INT          | Foreign Key ke lapangan     |
| nama_pemesan | VARCHAR(100) | Nama pemesan                |
| tanggal      | DATE         | Tanggal reservasi           |
| jam_mulai    | TIME         | Jam mulai                   |
| jam_selesai  | TIME         | Jam selesai                 |
| status       | VARCHAR(20)  | Status reservasi            |

## Cara Instalasi

1. Clone/copy project ke folder web server (misal: `htdocs` di XAMPP).
2. Import file database `db/futsalzone.sql` ke MySQL.
3. Atur koneksi database di `includes/koneksi_db.php` sesuai konfigurasi lokal.
4. Jalankan aplikasi melalui browser:
   - User: `http://localhost/project-akhir/`
   - Admin: `http://localhost/project-akhir/futsalzone-admin/login.php`

## Teknologi

- PHP 7+
- MySQL/MariaDB
- Tailwind CSS
- HTML5, CSS3, JavaScript

## Kontribusi

Silakan fork dan pull request jika ingin berkontribusi atau mengembangkan fitur lebih lanjut.
