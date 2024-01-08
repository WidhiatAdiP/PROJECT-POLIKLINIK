<?php
// Start or resume the session
if (!isset($_SESSION)) {
    session_start();
}

// Include the database connection file
include_once("koneksi.php");

/// Query to fetch data from dokter and jadwal_periksa tables
$jadwal_periksaQuery = "SELECT dokter.id, dokter.nama, jadwal_periksa.id AS id_jadwal_periksa, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai
                FROM jadwal_periksa 
                INNER JOIN dokter ON dokter.id = jadwal_periksa.id_dokter";


// Prepare and execute the query
$stmt = $mysqli->prepare($jadwal_periksaQuery);

if ($stmt === false) {
    die("Error in preparing statement");
}

$stmt->execute();

// Get the result and fetch data
$jadwal_periksaResult = $stmt->get_result();
$jadwal_periksaData = $jadwal_periksaResult->fetch_all(MYSQLI_ASSOC);

$stmt->close();

//// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $id_dokter = $_POST['poli_id_dokter'];
    $jadwal_periksa = $_POST['periksa_jadwal'];

    // Update the daftar_poli table
    $updateQuery = "UPDATE jadwal_periksa SET jadwal_periksa = ? WHERE id_dokter = ?";
    $updateStmt = $mysqli->prepare($updateQuery);

    if ($updateStmt === false) {
        die("Error in preparing update statement: " . $mysqli->error);
    }

    // Tipe data "s" untuk string, "i" untuk integer
    $updateStmt->bind_param("si", $jadwal_periksa, $id_dokter);

    if ($updateStmt->execute() === false) {
        die("Error in executing update statement: " . $updateStmt->error);
    } else {
        // Logging: Tulis ke file log atau outputkan ke console
        file_put_contents('update_log.txt', "Update successful for id_dokter: $id_dokter\n", FILE_APPEND);
    }

    $updateStmt->close();

    // Query to fetch all data from the periksa table
    $allPoliQuery = "SELECT * FROM poli";

    // Prepare and execute the query
    $allPoliStmt = $mysqli->prepare($allPoliQuery);

    if ($allPoliStmt === false) {
        die("Error in preparing statement");
    }

    $allPoliStmt->execute();

    // Get the result and fetch data
    $allPoliResult = $allPoliStmt->get_result();
    $allPoliData = $allPoliResult->fetch_all(MYSQLI_ASSOC);

    $allPeriksaStmt->close();
}
?>



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Jadwal Periksa Dokter</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

    <style>
        .aksi-btn {
            margin-right: 5px;
        }

        table {
            width: 100%;
        }
    </style>
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
                                            <th>Nama Dokter</th>
                                            <th>Jadwal Periksa</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jadwal_periksaData as $jadwal_periksaRow) {
                                            echo "<tr>";
                                            echo "<td>" . $jadwal_periksaRow['id'] . "</td>";
                                            echo "<td>" . $jadwal_periksaRow['nama'] . "</td>";
                                            echo "<td>" . $jadwal_periksaRow['hari'] . "</td>";
                                            echo "<td>" . $jadwal_periksaRow['jam_mulai'] . "</td>";
                                            echo "<td>" . $jadwal_periksaRow['jam_selesai'] . "</td>";
                                            echo "<td>";

                                            // Check if the 'status_periksa' key exists in the $jadwal_periksaRow array
                                            if (array_key_exists('jadwal_periksa', $jadwal_periksaRow)) {
                                                // Check the status and display the appropriate button
                                                if ($jadwal_periksaRow['status_periksa'] == 1) {
                                                    // Status is 1, hide "Periksa" button and show "Edit" button
                                                    echo "<button class='btn btn-primary edit-btn' data-toggle='modal' data-target='#editModal' data-id='" . $jadwal_periksaRow['id'] . "' data-jadwal_periksa='" .$jadwal_periksaRow['id_jadwal_periksa'] . "'>Edit</button>";
                                                } 
                                            } else {
                                                // Handle the case where 'status_periksa' key is not present in the array
                                                echo "Status not available";
                                            }

                                            echo "</td>";
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

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>

    <!-- Jadwal Periksa Modal -->
    <div class="modal fade" id="jadwal_periksaModal" tabindex="-1" role="dialog" aria-labelledby="periksaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="periksaModalLabel">Form Jadwal Periksa Dokter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="create_dokter.php">
                        <input type="hidden" name="id_dokter" id="dokter_id_dokter">
                        <input type="hidden" name="id_jadwal_periksa" id="id_jadwal_periksa">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_nama">Nama Dokter</label>
                                    <input type="text" class="form-control" id="nama" name="nama" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hari_jadwal_periksa">Hari</label>
                                    <input type="enum" class="form-control" id="hari" name="hari" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam_mulai_jadwal_periksa">Jam Mulai</label>
                                    <input type="time-local" class="form-control" id="jam_mulai" name="jam_mulai" required>
                                </div>
                            </div>
                        </div>
                            </select>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" name="submit_periksa">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- ... (existing code) ... -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Form Update Jadwal Periksa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form method="POST" action="update_jadwal_periksa.php">
                        <input type="hidden" name="id_dokter" id="edit_id_dokter">
                        <input type="hidden" name="id_jadwal_periksa" id="edit_jadwal_periksa">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_nama">Nama</label>
                                    <input type="text" class="form-control" id="edit_nama" name="nama" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_hari">Hari</label>
                                    <input type="enum" class="form-control" id="hari" name="hari" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_jam_mulai">Jam Mulai</label>
                                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_jam_selesai">Jam Selesai</label>
                                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                                </div>
                            </div>
                        </div>
                            </select>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" name="submit_update">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk menangani data pada modal -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tangkap klik pada tombol "Periksa"
            $('.btn-success').click(function() {
                // Ambil nilai ID dokter dari atribut data-id tombol
                var id_dokter = $(this).data('id');

                // Set nilai ID dokter ke elemen input periksa_id_dokter pada modal
                $('#jadwal_periksa_id_dokter').val(id_dokter);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Tangkap klik pada tombol "Edit"
            $('.edit-btn').click(function() {
                var id_dokter = $(this).data('id');
                var selectedDokter = <?php echo json_encode($dokterData); ?>;
                var dokter = selectedDokter.find(dokter => dokter.id === id_dokter);
                
                $('#edit_id_dokter').val(id_dokter);
                $('#edit_id_jadwal_periksa').val(dokter.id_jadwal_periksa);
                $('#edit_nama').val(dokter.nama);
            });

            $('.periksa-btn').click(function () {
                var id_dokter = $(this).data('id');
                var selectedDokter = <?php echo json_encode($dokterData); ?>;
                var dokter = selectedDokter.find(dokter => dokter.id === id_dokter);

                $('#jadwal_periksa_id_dokter').val(id_dokter);
                $('#id_jadwal_periksa').val(dokter.id_jadwal_periksa);
                $('#nama').val(dokter.nama);
            });
        });
    </script>

</body>

</html>