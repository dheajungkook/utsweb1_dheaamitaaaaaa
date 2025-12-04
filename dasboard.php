<?php
session_start();

// Jika belum login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}



// Tambah barang ke keranjang
if (isset($_POST['tambah'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    $total = $harga * $jumlah;

    $_SESSION['keranjang'][] = [
        'kode' => $kode,
        'nama' => $nama,
        'harga' => $harga,
        'jumlah' => $jumlah,
        'total' => $total
    ];
}

// Kosongkan keranjang
if (isset($_POST['clear'])) {
    unset($_SESSION['keranjang']);
}

// Hitung total
$totalBelanja = 0;
if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $b) {
        $totalBelanja += $b['total'];
    }
}

$diskon = $totalBelanja * 0.5;
$totalBayar = $totalBelanja - $diskon;

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Penjualan</title>
<style>
/* Tema Pink Peach Dashboard */
:root {
    --peach: #b1dce2ff;
    --peach-soft: #b7e3eeff;
    --peach-dark: #a0cde2ff;
}

body{
    font-family: Arial, sans-serif;
    background: var(--peach-soft);
    margin:0;
    padding:0;
}

/* Navbar */
.navbar{
    display:flex;
    justify-content:space-between;
    padding:20px;
    background:white;
    box-shadow:0 2px 4px rgba(0,0,0,0.1);
    border-bottom:3px solid var(--peach);
}

.navbar strong{
    color: var(--peach-dark);
}

/* Container */
.container{
    width:80%;
    margin:30px auto;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 4px 10px rgba(201, 145, 168, 0.1);
}

/* Input & Dropdown */
input, select {
    padding:12px;
    width:100%;
    margin-top:5px;
    border-radius:10px;
    border:2px solid var(--peach);
    background:#fff7f6;
}

input:focus, select:focus{
    outline:none;
    border-color: var(--peach-dark);
    background:white;
}

/* Tombol */
button{
    padding:12px 20px;
    border:none;
    border-radius:10px;
    background: var(--peach);
    color:white;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background: var(--peach-dark);
}

/* Tombol merah */
button[style*="background:#dc3545"]{
    background:#ff6f6f !important;
}
button[style*="background:#dc3545"]:hover{
    background:#ff4040 !important;
}

/* Tombol abu */
button[style*="background:#6c757d"]{
    background:#c4c4c4 !important;
}

/* Table */
table{
    width:100%;
    margin-top:20px;
    border-collapse:collapse;
    background:#fff7f6;
    border-radius:10px;
    overflow:hidden;
}

table th{
    background: var(--peach);
    color:white;
    padding:12px;
}

table td{
    border-bottom:1px solid #c0d2e7ff;
    padding:10px;
}

.total-row{
    font-weight:bold;
    background:#ffe5e1;
}

</style>
</head>

<body>

<div class="navbar">
    <div><strong>--POLGAN MART--</strong><br><small>Sistem Penjualan Sederhana</small></div>
    <div>
        Selamat datang, <strong><?= $_SESSION['username'] ?></strong>  
        <form method="post" action="logout.php" style="display:inline;">
            <button style="background:#dc3545; color:white;">Logout</button>
        </form>
    </div>
</div>

<div class="container">
  <h3>Input Barang</h3>

<form method="post">

<style>
.select-box {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #8caaebff;
    font-size: 16px;
    color: #666;
}
</style>

<label>Kode Barang (klik kotak untuk memilih)</label>
<select id="kode" name="kode" class="select-box" onchange="updateBarang()">
    <option value="" disabled selected>Pilih Kode & Nama Barang</option>
    <option value="001" data-nama="Baju" data-harga="50000">001 - Baju</option>
    <option value="002" data-nama="Celana" data-harga="75000">002 - Celana</option>
    <option value="003" data-nama="Jilbab" data-harga="30000">003 - Jilbab</option>
</select>

<label>Nama Barang</label>
<input type="text" id="nama_barang" name="nama" readonly class="input-style">

<label>Harga</label>
<input type="number" id="harga" name="harga" readonly class="input-style">

<label>Jumlah</label>
<input type="number" name="jumlah" required class="input-style">

<br><br>
<button type="submit" name="tambah">Tambahkan</button>
<button type="reset" style="background:#6c757d;">Batal</button>
</form>

<script>
function updateBarang() {
    const select = document.getElementById("kode");
    const selected = select.options[select.selectedIndex];

    if (selected.value === "") return;

    document.getElementById("nama_barang").value = selected.dataset.nama;
    document.getElementById("harga").value = selected.dataset.harga;
}
</script>


    

    <h3 style="text-align:center; margin-top:40px;">Daftar Pembelian</h3>

    <table>
        <tr>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
        </tr>

        <?php if (!empty($_SESSION['keranjang'])): ?>
            <?php foreach ($_SESSION['keranjang'] as $b): ?>
            <tr>
                <td><?= $b['kode'] ?></td>
                <td><?= $b['nama'] ?></td>
                <td>Rp <?= number_format($b['harga'],0,',','.') ?></td>
                <td><?= $b['jumlah'] ?></td>
                <td>Rp <?= number_format($b['total'],0,',','.') ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>

        <tr class="total-row">
            <td colspan="4">Total Belanja</td>
            <td>Rp <?= number_format($totalBelanja,0,',','.') ?></td>
        </tr>

        <tr class="total-row">
            <td colspan="4">Diskon (5%)</td>
            <td>Rp <?= number_format($diskon,0,',','.') ?></td>
        </tr>

        <tr class="total-row">
            <td colspan="4">Total Bayar</td>
            <td>Rp <?= number_format($totalBayar,0,',','.') ?></td>
        </tr>
    </table>

    <form method="post">
        <button name="clear" style="background:#dc3545; margin-top:20px;">Kosongkan Keranjang</button>
    </form>
</div>

</body>
</html>