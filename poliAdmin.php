<?php
if (!isset($_SESSION)) {
  session_start();
}

// Include the database connection file (koneksi.php)
include_once("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_poli_modal'])) {
  $id = $_POST['id'];
  $newNamaPoli = $_POST['new_nama_poli'];
  $newKeterangan = $_POST['new_keterangan'];

  // Update poli in the database using prepared statement
  $updateQuery = "UPDATE poli SET nama_poli=?, keterangan=? WHERE id=?";
  $stmt = $mysqli->prepare($updateQuery);
  $stmt->bind_param("ssi", $newNamaPoli, $newKeterangan, $id);

  if ($stmt->execute()) {
    // Update successful
    header("Location: daftarpoliAdmin.php");
    exit();
  } else {
    // Update failed, handle error (you may redirect or display an error message)
    echo "Update failed: " . $stmt->error;
  }

  $stmt->close();
  
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_poli'])) {
  $newNamaPoli = $_POST['add_nama_poli'];
  $newKeterangan = $_POST['add_keterangan'];

  // Insert new poli into the database using prepared statement
  $insertQuery = "INSERT INTO poli (nama_poli, keterangan) VALUES (?, ?)";
  $stmt = $mysqli->prepare($insertQuery);
  $stmt->bind_param("ss", $newNamaPoli, $newKeterangan);

  if ($stmt->execute()) {
    // Insertion successful
    header("Location: daftarpoliAdmin.php");
    exit();
  } else {
    // Insertion failed, handle error (you may redirect or display an error message)
    echo "Insertion failed: " . $stmt->error;
  }

  $stmt->close();
}

// Menangani penghapusan poli dan catatan terkait di tabel detail_periksa
if (isset($_POST['delete_poli'])) {
  $id = $_POST['id'];

  // Lanjutkan dengan penghapusan poli
  $deletePoliQuery = "DELETE FROM poli WHERE id=?";
  $stmtPoli = $mysqli->prepare($deletePoliQuery);
  $stmtPoli->bind_param("i", $id);

  // Jalankan penghapusan poli
  if ($stmtPoli->execute()) {
      // Penghapusan poli berhasil
      // Bersihkan output buffer
      ob_clean();

      // Redirect kembali ke halaman utama atau tampilkan pesan keberhasilan
      header("Location: daftarpoliAdmin.php");
      exit();
  } else {
      // Penghapusan poli gagal, tangani kesalahan
      echo "Penghapusan poli gagal: " . $stmtPoli->error;
  }

  // Tutup prepared statement
  $stmtPoli->close();
}

// Fetch data from the 'poli' table
$poliQuery = "SELECT * FROM poli";
$poliResult = $mysqli->query($poliQuery);

// Fetch the data as an associative array
$poliData = $poliResult->fetch_all(MYSQLI_ASSOC);

$nomorUrut = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Add your head section here -->

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

  <!-- Add other necessary CSS links here -->
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addModal">Tambah Poli</button>

                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama Poli</th>
                      <th>Keterangan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($poliData as $poliRow) {
                      echo "<tr>";
                      echo "<td>" . $nomorUrut++ . "</td>"; // Menampilkan nomor urut
                      echo "<td>" . $poliRow['nama_poli'] . "</td>";
                      echo "<td>" . $poliRow['keterangan'] . "</td>";
                      echo "<td>
                        <form method='post' action=''>
                            <input type='hidden' name='id' value='" . $poliRow['id'] . "'>
                            <input type='hidden' name='new_nama_poli' value='" . $poliRow['nama_poli'] . "'>
                            <input type='hidden' name='new_keterangan' value='" . $poliRow['keterangan'] . "'>

                            <button type='button' name='update_poli' class='btn btn-warning btn-sm update-btn' data-toggle='modal' data-target='#updateModal' 
                            data-id='" . $poliRow['id'] . "' 
                            data-nama_poli='" . $poliRow['nama_poli'] . "' 
                            data-keterangan='" . $poliRow['keterangan'] . "'>Update</button>

                            <form method='post' action=''>
                                <input type='hidden' name='id' value='" . $poliRow['id'] . "'>
                                <button type='submit' name='delete_poli' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\");'>Delete</button>
                            </form>
                        </form>
                      </td>";
                      echo "</tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateModalLabel">Perbarui Poli</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="daftarpoliAdmin.php">
            <input type="hidden" name="id" id="update_id">
            <div class="form-group">
              <label for="update_nama_poli">Nama Poli</label>
              <input type="text" class="form-control" id="update_nama_poli" name="new_nama_poli" required>
            </div>
            <div class="form-group">
              <label for="update_keterangan">Keterangan</label>
              <input type="text" class="form-control" id="update_keterangan" name="new_keterangan" required>
            </div>
            <button type="submit" name="update_poli_modal" class="btn btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for adding poli -->
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Tambah Poli</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="daftarpoliAdmin.php">
            <div class="form-group">
              <label for="add_nama_poli">Nama Poli</label>
              <input type="text" class="form-control" id="add_nama_poli" name="add_nama_poli" required>
            </div>
            <div class="form-group">
              <label for="add_keterangan">Keterangan</label>
              <input type="text" class="form-control" id="add_keterangan" name="add_keterangan" required>
            </div>
            <button type="submit" name="add_poli" class="btn btn-primary">Tambah</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>

  <!-- Add other necessary script includes here -->

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Add your JavaScript code here
      var updateButtons = document.querySelectorAll('.update-btn');

      updateButtons.forEach(function(button) {
        button.addEventListener('click', function() {
          var id = button.getAttribute('data-id');
          var nama_poli = button.getAttribute('data-nama_poli');
          var keterangan = button.getAttribute('data-keterangan');

          document.getElementById('update_id').value = id;
          document.getElementById('update_nama_poli').value = nama_poli;
          document.getElementById('update_keterangan').value = keterangan;
        });
      });
    });
  </script>
</body>

</html>
