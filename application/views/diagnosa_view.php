<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Diagnosa Penyakit</title>
  <style>
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #f9fcff, #e6f7f4);
      margin: 0;
      padding: 30px;
      color: #2c3e50;
    }

    .main-wrapper {
      max-width: 1100px;
      margin: auto;
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 30px;
    }

    .container {
      background: #ffffff;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.08);
      animation: fadeInUp 0.8s ease;
    }

    h1, h2 {
      color: #2980b9;
      text-align: center;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 10px;
    }

    th {
      background-color: #2980b9;
      color: white;
      padding: 12px;
      border-radius: 10px;
    }

    td {
      background-color: #f7f9fc;
      padding: 12px;
      text-align: center;
      border-radius: 10px;
      border: 1px solid #dde;
    }

    tr:hover td {
      background-color: #ecf6ff;
    }

    .btn {
      padding: 10px 22px;
      margin: 10px 5px;
      font-size: 15px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .btn-diagnosa {
      background-color: #27ae60;
      color: white;
    }

    .btn-diagnosa:hover {
      background-color: #219150;
    }

    .btn-kembali {
      background-color: #e74c3c;
      color: white;
    }

    .btn-kembali:hover {
      background-color: #c0392b;
    }

    .btn-tambah {
      background-color: #f39c12;
      color: white;
    }

    .btn-tambah:hover {
      background-color: #e67e22;
    }

    .hasil-box {
      background: #dfffe2;
      border-left: 6px solid #2ecc71;
      padding: 20px;
      border-radius: 12px;
      margin-top: 20px;
      animation: fadeInUp 1s ease-in-out;
    }

    .hasil-box h2 {
      color: #27ae60;
    }

    .hasil-box strong {
      color: #2c3e50;
    }

    .tambah-form input {
      padding: 10px;
      width: 80%;
      max-width: 300px;
      border-radius: 6px;
      border: 1px solid #ccc;
      background-color: #fbfbfb;
    }

    .actions {
      text-align: center;
      margin-top: 20px;
    }

    .illustration {
      text-align: center;
      margin-top: 40px;
      grid-column: span 2;
    }

    .illustration img {
      max-width: 200px;
      height: auto;
      animation: fadeInUp 1.2s ease-in-out;
    }

    .illustration p {
      color: #555;
      font-size: 14px;
      margin-top: 10px;
    }

    @media (max-width: 800px) {
      .main-wrapper {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

<div class="main-wrapper">

  <!-- Diagnosa -->
  <div class="container">
    <h1>Form Diagnosa Penyakit</h1>
    <form method="post" action="<?= site_url('tbc/diagnosa') ?>">
      <table>
        <tr>
          <th>Pilih</th>
          <th>Gejala</th>
        </tr>
        <?php foreach ($gejala as $g) : ?>
        <tr>
          <td><input type="checkbox" name="gejala_id[]" value="<?= $g->id_gejala ?>"></td>
          <td><?= $g->nama_gejala ?></td>
        </tr>
        <?php endforeach; ?>
      </table>

      <div class="actions">
        <button type="submit" class="btn btn-diagnosa">🔍 Diagnosa</button>
        <a href="<?= site_url('tbc') ?>" class="btn btn-kembali">← Kembali</a>
      </div>
    </form>

    <?php if (isset($hasil)) : ?>
    <div class="hasil-box">
      <h2>Hasil Diagnosa</h2>
      <p>Penyakit paling mungkin: <strong><?= $hasil['penyakit'] ?></strong></p>
      <p>Probabilitas: <strong><?= round($hasil['probabilitas'] * 100, 2) ?>%</strong></p>
    </div>
    <?php endif; ?>
  </div>

  <!-- Tambah Gejala -->
  <div class="container tambah-form">
    <h2>Tambah Gejala Baru</h2>
    <form method="post" action="<?= site_url('tbc/tambah_gejala') ?>">
      <input type="text" name="nama_gejala" placeholder="Masukkan nama gejala..." required><br><br>
      <button type="submit" class="btn btn-tambah">➕ Simpan Gejala</button>
    </form>
  </div>

  <!-- Ilustrasi -->
  <div class="illustration">
    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140051.png" alt="dokter lucu">
    <p>Tetap jaga kesehatanmu, ya! 😊</p>
  </div>

</div>

</body>
</html>
