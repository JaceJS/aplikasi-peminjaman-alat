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
$pdf->Cell(0, 10, 'DATA PEMINJAMAN', 0, 1, 'C');
$pdf->Ln('10');

// Set Font untuk header tabel
$pdf->SetFont('Arial', 'B', 10);

// Header Tabel
$pdf->SetFillColor(255, 193, 9);
$pdf->Cell(15, 10, 'No', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Tanggal Booking', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Nama Alat', 1, 0, 'C', 1);
$pdf->Cell(35, 10, 'Nama Peminjam', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Tanggal Pinjam', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Kuantitas', 1, 0, 'C', 1); 
$pdf->Cell(50, 10, 'Catatan', 1, 0, 'C', 1);
$pdf->Cell(35, 10, 'Status Pengembalian', 1, 1, 'C', 1);

// Set ulang warna latar belakang ke default
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);

// Isi Tabel
$sql = "SELECT peminjaman.*, barang.nama_brg, anggota.nama 
        FROM peminjaman 
        JOIN barang ON peminjaman.id_brg=barang.id_brg 
        JOIN anggota ON anggota.id_anggota=peminjaman.id_anggota 
        ORDER BY peminjaman.status ASC";
$query = $mysqli->query($sql);
$no = 1;

// Tentukan nama file
$filename = "data_peminjaman.pdf";

// Mengatur header HTTP untuk menentukan nama file
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Type: application/pdf');

while ($lihat = mysqli_fetch_array($query)) {    
    $pdf->Cell(15, 10, $no++, 1);
    $pdf->Cell(40, 10, date('d-M-Y  h:i A', strtotime($lihat['tgl_booking'])), 1);
    $pdf->Cell(30, 10, $lihat['nama_brg'], 1);
    $pdf->Cell(35, 10, $lihat['nama'], 1);
    $pdf->Cell(40, 10, date('d-M-Y h:i A', strtotime($lihat['tgl_pinjam'])), 1);
    $pdf->Cell(30, 10, $lihat['kuantitas'], 1);  
    $pdf->Cell(50, 10, $lihat['catatan'], 1);  

    $backgroundColor = $lihat['status'] == 1 ? [0, 255, 0] : [255, 0, 0];
    $pdf->SetFillColor($backgroundColor[0], $backgroundColor[1], $backgroundColor[2]);
    $pdf->Cell(35, 10, $lihat['status'] == 1 ? 'Sudah Dikembalikan' : 'Belum Dikembalikan', 1, 0, 'C', true);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Ln();
}


// Output PDF ke browser atau simpan ke file
$pdf->Output('D', $filename);

?>
