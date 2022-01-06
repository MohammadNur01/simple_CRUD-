<?php

//koneksi database

$server = "localhost";
$user = "root";
$pass = "";
$database = "dblatihan";

$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

// jika tombol simpan di klik
if (isset($_POST['bsimpan'])) {
    //Pengujian apakah data akan diedit apa disimpan

    if ($_GET['hal'] == "edit") {
        // data akan diedit
        $edit = mysqli_query(
            $koneksi,
            "UPDATE tmhs SET nim = '$_POST[tnim]', nama = '$_POST[tnama]', alamat = '$_POST[talamat]', prodi = '$_POST[tprodi]' WHERE id_mhs = '$_GET[id]'"
        );

        if ($edit) { //jika diedit sukses
            echo "<script>
        alert('Edit data suskes!');
        document.location= 'index.php';
        </script>";
        } else {
            echo "<script>
        alert('Edit data GAGAL!');
        document.location= 'index.php';
        </script>";
        }
    } else {
        // data akan disimpan
        $simpan = mysqli_query(
            $koneksi,
            "INSERT INTO tmhs(nim, nama, alamat, prodi)
            VALUES ('$_POST[tnim]', '$_POST[tnama]', '$_POST[talamat]', '$_POST[tprodi]')"
        );

        if ($simpan) { //jika simpan sukses
            echo "<script>
        alert('Simpan data suskes!');
        document.location= 'index.php';
        </script>";
        } else {
            echo "<script>
        alert('Simpan data GAGAL!');
        document.location= 'index.php';
        </script>";
        }
    }
}

// Pengujian jika tombol edit atau hapus di klik
if (isset($_GET['hal'])) {
    // pengujian edit data
    if ($_GET['hal'] == "edit") {
        // tampilkan data yg akan diedit
        $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            //jika data ditemukan, maka data akan ditampung dulu ke dalam variabel
            $vnim = $data['nim'];
            $vnama = $data['nama'];
            $valamat = $data['alamat'];
            $vprodi = $data['prodi'];
        }
    } elseif ($_GET['hal'] == "hapus") {
        // Persiapan Hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]'");
        if ($hapus) {
            echo "<script>
    alert('Hapus data Berhasil!');
    document.location= 'index.php';
    </script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>CRUD 2022</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">TODO LIST APPS 2022</h1>
        <h3 class="text-center mb-3">CRUD PHP, MYSQL, BOOTSTRAP 4</h3>
        <!-- Awal Card From -->
        <div class="card mt-3">
            <div class="card-header bg-primary text-white ">
                Form Input Data Mahasiwa
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label>
                            NIM
                            <input type="text" name="tnim" value="<?= @$vnim ?>" class="form-control" placeholder="Masukkan NIM Anda disini" require>
                        </label>
                        <label class="ml-5 md-4">
                            Nama
                            <input type="text" name="tnama" value="<?= @$vnama ?>" class="form-control" placeholder="Masukkan Nama Anda disini" require>
                        </label>
                        <label class="ml-5 md-4">
                            Prodi
                            <select name="tprodi" class="form-control" id="">
                                <option value="<?= @$vprodi ?>"><?= @$vprodi ?></option>
                                <option value="D3-MI">D3-MI</option>
                                <option value="S1-SI">S1-SI</option>
                                <option value="S1-TI">S1-TI</option>
                            </select>
                        </label>
                        <label class="ml-5 col-md-3">
                            Alamat
                            <input type="text" name="talamat" value="<?= @$valamat ?>" class="form-control" placeholder="Masukkan Alamat Anda disini" require>
                        </label>

                    </div>
                    <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
                    <button type="reset" class="btn btn-danger ml-3" name="breset">Kosongkan</button>
                </form>
            </div>
        </div>
        <!-- Penutup Form -->

        <!-- Awal Card Tabel -->
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                Daftar Mahasiswa
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>No. </th>
                        <th>NIM </th>
                        <th>Nama </th>
                        <th>Alamat </th>
                        <th>Program Studi </th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $no = 1;
                    $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs ORDER BY id_mhs DESC");
                    while ($data = mysqli_fetch_array($tampil)) :
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $data['nim']; ?></td>
                            <td><?= $data['nama']; ?></td>
                            <td><?= $data['alamat']; ?></td>
                            <td><?= $data['prodi']; ?></td>
                            <td>
                                <a href="index.php?hal=edit&id=<?= $data['id_mhs'] ?>" class="btn btn-warning">Edit</a>
                                <a href="index.php?hal=hapus&id=<?= $data['id_mhs'] ?>" onclick="return confirm('Aapakah yankin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
            <!-- Penutup Tabel -->
        </div>
    </div>











    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>

</html>