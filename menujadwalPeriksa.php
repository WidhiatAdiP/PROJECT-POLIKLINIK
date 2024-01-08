<?php
if (!isset($_SESSION)) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Add your head section here -->

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function () {
      // Event listener for the "View" button
      $('.view-btn').click(function () {
        var jadwal_periksaId = $(this).data('id');

        // Ajax request to fetch additional details
        $.ajax({
          type: 'POST',
          url: 'get_details.php',
          data: { jadwal_periksa_id: jadwal_periksaId },
          success: function (response) {
            // Display the fetched details in the modal body
            $('#viewModalBody').html(response);

            // Show the modal
            $('#viewModal').modal('show');
          }
        });
      });
    });
  </script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
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
                      include './koneksi.php';

                      $query = "SELECT * FROM jadwal_periksa";
                      $results = $mysqli->query($query);

                      while ($jadwal_periksaRow = $results->fetch_assoc()) {
                    ?>
                      <tr>
                        <td><?= $jadwal_periksaRow['id'] ?></td>
                        <td><?= $jadwal_periksaRow['hari'] ?></td>
                        <td><?= $jadwal_periksaRow['jam_mulai'] ?></td>
                        <td><?= $jadwal_periksaRow['jam_selesai'] ?></td>
                        <td>
                          <button data-toggle="modal" data-target="#detailModal<?= $jadwal_periksaRow['id'] ?>" class="btn btn-primary">
                            Jadwal Periksa
                          </button>
                        </td>
                      </tr>
                    <?php
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

  <!-- Modal for displaying details -->
  <div class="modal fade" id="detailModal<?= $d['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">Jadwal Periksa <?= $d['nama'] ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <?php if ($details->num_rows == 0) : ?>
              <p class="my-2 text-danger">Tidak Ditemukan Jadwal Periksa</p>
          <?php else : ?>
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th scope="col">No</th>
                          <th scope="col">Hari</th>
                          <th scope="col">Jam Mulai</th>
                          <th scope="col">Jam Selesai</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php while ($detail = $details->fetch_assoc()) : ?>
                          <tr>
                              <td><?= $no_detail++; ?></td>
                              <td><?= $detail['id']; ?></td>
                              <td><?= $detail['hari']; ?></td>
                              <td><?= $detail['jam_mulai']; ?></td>
                              <td><?= $detail['jam_selesai']; ?></td>
                          </tr>
                      <?php endwhile ?>
                  </tbody>
              </table>
          <?php endif ?>
          </div>
      </div>
    </div>
  </div>
</body>

</html>
