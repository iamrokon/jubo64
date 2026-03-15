<!doctype html>
<html lang="en">

<head>
  <title>Earning Information | e-Learning & Earning Ltd.</title>
  <?php include "header-link.php" ?>
</head>

<body data-topbar="colored">
  <div id="layout-wrapper">
    <?php include "header.php" ?>
    <?php include "sidebar.php" ?>
    <div class="main-content">
      <section id="about-us" class="about-us mt-5">
        <div class="row content">
          <div class="col-lg-12 mt-3" data-aos="fade-left">
            <div class="shadow rounded p-2">
              <?php include('report-by-category-old.php'); ?>
            </div>
          </div>

    <div class="col-lg-12 mt-1" data-aos="fade-left">
      <div class="shadow p-3 rounded">
        <div class="page-content-wrapper">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <table id="datatable" class="table table-bordered table-hover align-middle">
                    <thead>
                      <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Marketplace</th>
                        <th>Earning BD</th>
                        <th>Earning Dollar</th>
                        <th>Photo</th>
                        <th><center> Action </center></th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Data will be loaded via Ajax -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
            </div>
    </div>
  </div>
  </section>
  <?php include "footer.php" ?>
  </div>
  </div>
  <?php include "script.php" ?>

  <script>
    $(document).ready(function() {
      // Use "destroy: true" to prevent the "Cannot reinitialise DataTable" warning.
      var table = $('#datatable').DataTable({
        "destroy": true, 
        "processing": true,
        "serverSide": true,
        "pageLength": 25,
        "lengthMenu": [
          [25, 50, 100, 500],
          [25, 50, 100, 500]
        ],
        "ajax": {
          "url": "district-wise-report-data.php",
          "type": "GET",
          "data": function(d) {
            d.DistId = $('#DistId').val();
            d.Batch = $('#Batch').val();
            d.Group = $('#Group').val();
          }
        },
        "columnDefs": [
          { "orderable": false, "targets": [0, 2, 3, 4, 5, 6] } 
        ],
        "language": {
          "processing": "<div class='spinner-border text-primary' role='status'><span class='visually-hidden'>Loading...</span></div>",
          "search": "🔍 Search Name:",
          "paginate": {
            "next": "→",
            "previous": "←"
          }
        }
      });

      // Handle the filter form
      $('#getOrderReportForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        table.ajax.reload();
      });

      // Live reload on dropdown change
      $('#DistId, #Batch, #Group').off('change').on('change', function() {
        table.ajax.reload();
      });
    });
  </script>
</body>

</html>