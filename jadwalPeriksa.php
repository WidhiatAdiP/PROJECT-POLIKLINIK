<?php
if (!isset($_SESSION)) {
  session_start();
}

// Include the database connection file (koneksi.php)
include_once("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_jadwal_periksa_modal'])) {
  $id = $_POST['id'];
  $newHari = $_POST['new_hari'];
  $newJamMulai = $_POST['new_jam_mulai'];
  $newJamSelesai = $_POST['new_jam_selesai'];

  // Update jadwal_periksa in the database using prepared statement
  $updateQuery = "UPDATE jadwal_periksa SET hari=?, jam_mulai=?, jam_selesai=? WHERE id=?";
  $stmt = $mysqli->prepare($updateQuery);
  $stmt->bind_param("sssi", $newHari, $newJamMulai, $newJamSelesai, $id);

  if ($stmt->execute()) {
    // Update successful
    header("Location: jadwalPeriksa.php");
    exit();
  } else {
    // Update failed, handle error (you may redirect or display an error message)
    echo "Update failed: " . $stmt->error;
  }

  $stmt->close();
  
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_jadwal_periksa'])) {
  $newHari = $_POST['add_hari'];
  $newJamMulai = $_POST['add_jam_mulai'];
  $newJamSelesai = $_POST['add_jam_selesai'];

  // Insert new jadwal_periksa into the database using prepared statement
  $insertQuery = "INSERT INTO jadwal_periksa (hari, jam_mulai, jam_selesai) VALUES (?, ?, ?)";
  $stmt = $mysqli->prepare($insertQuery);
  $stmt->bind_param("sss", $newHari, $newJamMulai, $newJamSelesai);

  if ($stmt->execute()) {
    // Insertion successful
    header("Location: jadwalPeriksa.php");
    exit();
  } else {
    // Insertion failed, handle error (you may redirect or display an error message)
    echo "Insertion failed: " . $stmt->error;
  }

  $stmt->close();
}

// Menangani penghapusan jadwal_periksa terkait di dokter
if (isset($_POST['delete_dokter'])) {
  $id = $_POST['id'];

  // Hapus catatan terkait di tabel detail_periksa terlebih dahulu
  $deleteJadwalPeriksaQuery = "DELETE FROM jadwal_periksa WHERE id_dokter=?";
  $stmtJadwalPeriksa = $mysqli->prepare($deleteJadwalPeriksaQuery);
  $stmtJadwalPeriksa->bind_param("i", $id);

  // Jalankan penghapusan detail_periksa
  $stmtJadwalPeriksa->execute();
  $stmtJadwalPeriksa->close();

  // Lanjutkan dengan penghapusan jadwal_periksa
  $deleteJadwalPeriksaQuery = "DELETE FROM jadwal_periksa WHERE id=?";
  $stmtJadwalPeriksa = $mysqli->prepare($deleteJadwalPeriksaQuery);
  $stmtJadwalPeriksa->bind_param("i", $id);

  // Jalankan penghapusan jadwal_periksa
  if ($stmtJadwalPeriksa->execute()) {
      // Penghapusan jadwal_periksa berhasil
      // Bersihkan output buffer
      ob_clean();

      // Redirect kembali ke halaman utama atau tampilkan pesan keberhasilan
      header("Location: jadwalPeriksa.php");
      exit();
  } else {
      // Penghapusan jadwal_periksa gagal, tangani kesalahan
      echo "Penghapusan jadwal periksa gagal: " . $stmtJadwalPeriksa->error;
  }

  // Tutup prepared statement
  $stmtJadwalPeriksa->close();
}





// Fetch data from the 'jadwal_periksa' table
$JadwalPeriksaQuery = "SELECT * FROM jadwal_periksa";
$JadwalPeriksaResult = $mysqli->query($JadwalPeriksaQuery);

// Fetch the data as an associative array
$JadwalPeriksaData = $JadwalPeriksaResult->fetch_all(MYSQLI_ASSOC);

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
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addModal">Tambah Jadwal Periksa</button>

                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Hari</th>
                      <th>Jam Mulai</th>
                      <th>Jam Selesai</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($JadwalPeriksaData as $JadwalPeriksaRow) {
                      echo "<tr>";
                      echo "<td>" . $nomorUrut++ . "</td>"; // Menampilkan nomor urut
                      echo "<td>" . $JadwalPeriksaRow['hari'] . "</td>";
                      echo "<td>" . $JadwalPeriksaRow['jam_mulai'] . "</td>";
                      echo "<td>" . $JadwalPeriksaRow['jam_selesai'] . "</td>";
                      echo "<td>
                        <form method='post' action=''>
                                                    <input type='hidden' name='id' value='" . $JadwalPeriksaRow['id'] . "'>
                                                    <input type='hidden' name='new_hari' value='" . $JadwalPeriksaRow['hari'] . "'>
                                                    <input type='hidden' name='new_jam_mulai' value='" . $JadwalPeriksaRow['jam_mulai'] . "'>
                                                    <input type='hidden' name='new_jam_selesai' value='" . $JadwalPeriksaRow['jam_selesai'] . "'>

                                                    <button type='button' name='update_jadwal_periksa' class='btn btn-warning btn-sm update-btn' data-toggle='modal' data-target='#updateModal' 
                                                    data-id='" . $JadwalPeriksaRow['id'] . "' 
                                                    data-hari='" . $JadwalPeriksaRow['hari'] . "' 
                                                    data-jam_mulai='" . $JadwalPeriksaRow['jam_mulai'] . "' 
                                                    data-jam_selesai='" . $JadwalPeriksaRow['jam_selesai'] . "'>Update</button>
                                                    
                                                    <form method='post' action=''>
                                                        <input type='hidden' name='id' value='" . $JadwalPeriksaRow['id'] . "'>
                                                        <button type='submit' name='delete_jadwal_periksa' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\");'>Delete</button>
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
          <h5 class="modal-title" id="updateModalLabel">Perbarui Jadwal Periksa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="jadwalPeriksa.php">
            <!-- Replace with the actual update PHP file -->
            <input type="hidden" name="id" id="update_id">
            <div class="form-group">
              <label for="update_hari">Hari</label>
              <input type="enum" class="form-control" id="update_hari" name="new_hari" required>
            </div>
            <div class="form-group">
              <label for="update_jam_mulai">Jam Mulai</label>
              <input type="time" class="form-control" id="update_jam_mulai" name="new_jam_mulai" required>
            </div>
            <div class="form-group">
              <label for="update_harga">Jam Selesai</label>
              <input type="time" class="form-control" id="update_jam_selesai" name="new_jam_selesai" required>
            </div>
            <button type="submit" name="update_jadwal_periksa_modal" class="btn btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- Modal for adding jadwal_periksa -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Tambah Jadwal Periksa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="jadwalPeriksa.php">
          <!-- Replace with the actual add PHP file -->
          <div class="form-group">
            <label for="add_hari">Hari</label>
            <input type="enum" class="form-control" id="add_hari" name="add_hari" required>
          </div>
          <div class="form-group">
            <label for="add_jam_mulai">Jam Mulai</label>
            <input type="time" class="form-control" id="add_jam_mulai" name="add_jam_mulai" required>
          </div>
          <div class="form-group">
            <label for="add_jam_selesai">Jam Selesai</label>
            <input type="time" class="form-control" id="add_jam_selesai" name="add_jam_selesai" required>
          </div>
          <button type="submit" name="add_jadwal_periksa" class="btn btn-primary">Tambah</button>
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
          var hari = button.getAttribute('data-hari');
          var jam_mulai = button.getAttribute('data-jam_mulai');
          var jam_selesai = button.getAttribute('data-jam_selesai');

          document.getElementById('update_id').value = id;
          document.getElementById('update_hari').value = hari;
          document.getElementById('update_jam_mulai').value = jam_mulai;
          document.getElementById('update_jam_selesai').value = jam_selesai;
        });
      });
    });
  </script>
</body>

</html>