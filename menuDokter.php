<?php
if (!isset($_SESSION)) {
  session_start();
}

// Include the database connection file (koneksi.php)
include_once("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_dokter_modal'])) {
  $id = $_POST['id'];
  $newNamaDokter = $_POST['new_nama_dokter'];
  $newAlamat = $_POST['new_alamat'];
  $newNoHp = $_POST['new_no_hp'];
  $newIdPoli = $_POST['new_id_poli'];

  // Update dokter in the database using prepared statement
  $updateQuery = "UPDATE dokter SET nama=?, alamat=?, no_hp=?, id_poli=? WHERE id=?";
  $stmt = $mysqli->prepare($updateQuery);
  $stmt->bind_param("ssssi", $newNamaDokter, $newAlamat, $newNoHp, $newIdPoli, $id);

  if ($stmt->execute()) {
    // Update successful
    header("Location: menudokterAdmin.php");
    exit();
  } else {
    // Update failed, handle error (you may redirect or display an error message)
    echo "Update failed: " . $stmt->error;
  }

  $stmt->close();
  
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_dokter'])) {
  $newNamaDokter = $_POST['add_nama_dokter'];
  $newAlamat = $_POST['add_alamat'];
  $newNoHp = $_POST['add_no_hp'];
  $newIdPoli = $_POST['add_id_poli'];

  // Insert new dokter into the database using prepared statement
  $insertQuery = "INSERT INTO dokter (nama, alamat, no_hp, id_poli) VALUES (?, ?, ?, ?)";
  $stmt = $mysqli->prepare($insertQuery);
  $stmt->bind_param("sssi", $newNamaDokter, $newAlamat, $newNoHp, $newIdPoli);

  if ($stmt->execute()) {
    // Insertion successful
    header("Location: menudokterAdmin.php");
    exit();
  } else {
    // Insertion failed, handle error (you may redirect or display an error message)
    echo "Insertion failed: " . $stmt->error;
  }

  $stmt->close();
}

// Menangani penghapusan dokter
if (isset($_POST['delete_dokter'])) {
  $id = $_POST['id'];

  // Lanjutkan dengan penghapusan dokter
  $deleteDokterQuery = "DELETE FROM dokter WHERE id=?";
  $stmtDokter = $mysqli->prepare($deleteDokterQuery);
  $stmtDokter->bind_param("i", $id);

  // Jalankan penghapusan dokter
  if ($stmtDokter->execute()) {
      // Penghapusan dokter berhasil
      // Bersihkan output buffer
      ob_clean();

      // Redirect kembali ke halaman utama atau tampilkan pesan keberhasilan
      header("Location: menudokterAdmin.php");
      exit();
  } else {
      // Penghapusan dokter gagal, tangani kesalahan
      echo "Penghapusan dokter gagal: " . $stmtDokter->error;
  }

  // Tutup prepared statement
  $stmtDokter->close();
}

// Fetch data from the 'dokter' table
$dokterQuery = "SELECT * FROM dokter";
$dokterResult = $mysqli->query($dokterQuery);

// Fetch the data as an associative array
$dokterData = $dokterResult->fetch_all(MYSQLI_ASSOC);

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
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addModal">Tambah Dokter</button>

                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama Dokter</th>
                      <th>Alamat</th>
                      <th>No. HP</th>
                      <th>ID Poli</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($dokterData as $dokterRow) {
                      echo "<tr>";
                      echo "<td>" . $nomorUrut++ . "</td>"; // Menampilkan nomor urut
                      echo "<td>" . $dokterRow['nama'] . "</td>";
                      echo "<td>" . $dokterRow['alamat'] . "</td>";
                      echo "<td>" . $dokterRow['no_hp'] . "</td>";
                      echo "<td>" . $dokterRow['id_poli'] . "</td>";
                      echo "<td>
                        <form method='post' action=''>
                            <input type='hidden' name='id' value='" . $dokterRow['id'] . "'>
                            <input type='hidden' name='new_nama_dokter' value='" . $dokterRow['nama'] . "'>
                            <input type='hidden' name='new_alamat' value='" . $dokterRow['alamat'] . "'>
                            <input type='hidden' name='new_no_hp' value='" . $dokterRow['no_hp'] . "'>
                            <input type='hidden' name='new_id_poli' value='" . $dokterRow['id_poli'] . "'>

                            <button type='button' name='update_dokter' class='btn btn-warning btn-sm update-btn' data-toggle='modal' data-target='#updateModal' 
                            data-id='" . $dokterRow['id'] . "' 
                            data-nama_dokter='" . $dokterRow['nama'] . "' 
                            data-alamat='" . $dokterRow['alamat'] . "'
                            data-no_hp='" . $dokterRow['no_hp'] . "'
                            data-id_poli='" . $dokterRow['id_poli'] . "'>Update</button>

                            <form method='post' action=''>
                                <input type='hidden' name='id' value='" . $dokterRow['id'] . "'>
                                <button type='submit' name='delete_dokter' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\");'>Delete</button>
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
          <h5 class="modal-title" id="updateModalLabel">Perbarui Dokter</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="menudokterAdmin.php">
            <!-- Replace with the actual update PHP file -->
            <input type="hidden" name="id" id="update_id">
            <div class="form-group">
              <label for="update_nama_dokter">Nama Dokter</label>
              <input type="text" class="form-control" id="update_nama_dokter" name="new_nama_dokter" required>
            </div>
            <div class="form-group">
              <label for="update_alamat">Alamat</label>
              <input type="text" class="form-control" id="update_alamat" name="new_alamat" required>
            </div>
            <div class="form-group">
              <label for="update_no_hp">No. HP</label>
              <input type="text" class="form-control" id="update_no_hp" name="new_no_hp" required>
            </div>
            <div class="form-group">
              <label for="update_id_poli">ID Poli</label>
              <input type="text" class="form-control" id="update_id_poli" name="new_id_poli" required>
            </div>
            <button type="submit" name="update_dokter_modal" class="btn btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for adding dokter -->
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Tambah Dokter</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="menudokterAdmin.php">
            <!-- Replace with the actual add PHP file -->
            <div class="form-group">
              <label for="add_nama_dokter">Nama Dokter</label>
              <input type="text" class="form-control" id="add_nama_dokter" name="add_nama_dokter" required>
            </div>
            <div class="form-group">
              <label for="add_alamat">Alamat</label>
              <input type="text" class="form-control" id="add_alamat" name="add_alamat" required>
            </div>
            <div class="form-group">
              <label for="add_no_hp">No. HP</label>
              <input type="text" class="form-control" id="add_no_hp" name="add_no_hp" required>
            </div>
            <div class="form-group">
              <label for="add_id_poli">ID Poli</label>
              <input type="text" class="form-control" id="add_id_poli" name="add_id_poli" required>
            </div>
            <button type="submit" name="add_dokter" class="btn btn-primary">Tambah</button>
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
          var nama_dokter = button.getAttribute('data-nama_dokter');
          var alamat = button.getAttribute('data-alamat');
          var no_hp = button.getAttribute('data-no_hp');
          var id_poli = button.getAttribute('data-id_poli');

          document.getElementById('update_id').value = id;
          document.getElementById('update_nama_dokter').value = nama_dokter;
          document.getElementById('update_alamat').value = alamat;
          document.getElementById('update_no_hp').value = no_hp;
          document.getElementById('update_id_poli').value = id_poli;
        });
      });
    });
  </script>
</body>

</html>
