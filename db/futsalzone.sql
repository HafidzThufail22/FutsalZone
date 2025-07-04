CREATE DATABASE futsalzone;

USE futsalzone;

CREATE TABLE lapangan (
    id_lapangan INT(11) PRIMARY KEY AUTO_INCREMENT,
    nama_lapangan VARCHAR(100) NOT NULL,
    jenis VARCHAR(50) NOT NULL
);

CREATE TABLE reservasi (
    id_reservasi INT(11) PRIMARY KEY AUTO_INCREMENT,
    id_lapangan INT(11) NOT NULL,
    nama_pemesan VARCHAR(100) NOT NULL,
    tanggal DATE NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    FOREIGN KEY (id_lapangan) REFERENCES lapangan(id_lapangan)
);

CREATE TABLE admin (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL
);