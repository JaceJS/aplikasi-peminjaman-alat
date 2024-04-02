<?php
require('../../fpdf186/fpdf.php');
include "../../config/koneksi.php";

class PDF extends FPDF
{
    function Header()
    {
        // Fungsi Header
    }

    function Footer()
    {
        // Fungsi Footer
    }
}

// Buat objek PDF
$pdf = new PDF();

$pdf->AddPage('L', 'A4');

// Set Font
$pdf->SetFont('Arial', 'B', 18);

// Tambahkan judul
$pdf->Cell(0, 10, 'DATA PENGEMBALIAN', 0, 1, 'C');
$pdf->Ln('10');

// Set Font untuk header tabel
$pdf->SetFont('Arial', 'B', 12);

// Header Tabel
$pdf->SetFillColor(40, 167, 69);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(15, 10, 'No', 1, 0, 'C', 1);
$pdf->Cell(45, 10, 'Nama Alat', 1, 0, 'C', 1);
$pdf->Cell(50, 10, 'Nama Peminjam', 1, 0, 'C', 1);
$pdf->Cell(50, 10, 'Tanggal Pinjam', 1, 0, 'C', 1);
$pdf->Cell(50, 10, 'Tanggal Kembali', 1, 1, 'C', 1);

// Set ulang warna latar belakang ke default
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 12);

// Isi Tabel
$sql = "SELECT pengembalian.*,
        barang.id_brg,
        barang.nama_brg,
        peminjaman.id_peminjaman,
        peminjaman.tgl_pinjam,
        peminjaman.status,
        anggota.id_anggota,
        anggota.nama
        FROM pengembalian 
        JOIN barang ON pengembalian.id_brg=barang.id_brg 
        JOIN anggota ON pengembalian.id_anggota=anggota.id_anggota 
        JOIN peminjaman ON peminjaman.id_peminjaman=pengembalian.id_peminjaman 
        WHERE peminjaman.status=1
        ORDER BY peminjaman.tgl_pinjam DESC";
$query = $mysqli->query($sql);
$no = 1;

// Tentukan nama file
$filename = "data_pengembalian.pdf";

// Mengatur header HTTP untuk menentukan nama file
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Type: application/pdf');


while ($lihat = mysqli_fetch_array($query)) {
    // Tambahkan data ke dalam tabel PDF    
    $pdf->Cell(15, 10, $no++, 1);
    $pdf->Cell(45, 10, $lihat['nama_brg'], 1);
    $pdf->Cell(50, 10, $lihat['nama'], 1);
    $pdf->Cell(50, 10, date('d-M-Y  h:i A', strtotime($lihat['tgl_pinjam'])), 1);
    $pdf->Cell(50, 10, date('d-M-Y  h:i A', strtotime($lihat['tgl_kembali'])), 1);
    $pdf->Ln();
}

// Output PDF ke browser atau simpan ke file
$pdf->Output('D', $filename);
