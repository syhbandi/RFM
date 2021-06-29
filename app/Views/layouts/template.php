<?php service('uri')->setSilent(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Responsive Web UI Kit &amp; Dashboard Template based on Bootstrap">
  <meta name="author" content="AdminKit">
  <meta name="keywords" content="adminkit, bootstrap, web ui kit, dashboard template, admin template">

  <!-- <link rel="shortcut icon" href="assets/img/icons/icon-48x48.png" /> -->

  <title><?= isset($title) ? $title : 'Dashboard' ?></title>
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link href="/assets/css/app.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css" integrity="sha256-IOK+l4ZTv3gsgXRB8x72XhfUPf5SjCzttu6BDdx+2vU=" crossorigin="anonymous">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
</head>

<body>
  <div class="wrapper">
    <!-- sidebar -->
    <?= $this->include('layouts/sidebar') ?>
    <div class="main">
      <!-- navbar -->
      <?= $this->include('layouts/navbar') ?>

      <!-- content -->
      <main class="content">
        <div class="container-fluid p-0">
          <!-- breadcrumb -->
          <?= $this->include('layouts/breadcrumb'); ?>
          <!-- render section here -->
          <?= $this->renderSection('content'); ?>
        </div>
      </main>


      <?= $this->include('layouts/footer'); ?>


    </div>

  </div>





  <!-- <script src="/assets/js/vendor.js"></script> -->
  <script src="/assets/js/app.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script> -->
  <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.all.min.js" integrity="sha256-92U7H+uBjYAJfmb+iNPi7DPoj795ZCTY4ZYmplsn/fQ=" crossorigin="anonymous"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


  <!-- cek flash data dari session -->
  <?php if (session()->getFlashdata('sukses') != null) : ?>
    <!-- TRUE -->
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Sukses',
        text: "<?= session()->getFlashdata('sukses') ?>",
        showConfirmButton: false,
        timer: '2000'
      });
    </script>
  <?php endif ?>

  <!-- server side datatable practice -->
  <script>
    if ($('#tabel-ssp').length > 0) {
      $('#tabel-ssp').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '<?= current_url() ?>/dataAjax2',
          data: {},

        },
        columns: [{
            "data": null,
            "sortable": false,
            render: function(data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }
          },
          {
            'data': 'name'
          },
          {
            'data': 'email'
          },
          {
            'data': 'mobile'
          },
          {
            'data': 'designation'
          },
          {
            'data': 'gender'
          },
          {
            'data': 'status'
          },
          {
            'data': 'id',
            "searchable": false,
            "sortable": false,
            "render": function(id, type, full, meta) {
              return `<div class="btn-group btn-group-sm" role="group" aria-label="group">
                        <a href="/member/update/${id}" class="btn btn-warning"><i class="far fa-edit"></i></a> <a href="" class="btn btn-danger hapus" data-id="${id}"><i class="fas fa-trash"></i></a>
                      </div>`;
            }
          }
        ]
      });
    }
  </script>


  <!-- create update and delete function -->
  <script>
    // simpan data
    const forms = $('form');
    const validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
          form.classList.add('was-validated');
        } else {
          event.preventDefault();
          let fd = new FormData(form);
          // console.log($(form).serialize());
          $.ajax({
            url: $(form).attr('action'),
            type: 'post',
            dataType: 'json',
            contentType: false,
            processData: false,
            data: fd,
            success: function(res) {
              $(`input[name=csrf_test_name]`).val(res.tokenCSRF);
              console.log(res.msg);
              if (!res.success && !res.validator) {
                for (const prop in res.msg) {
                  if (Object.hasOwnProperty.call(res.msg, prop)) {
                    $(`input[name=${prop}]`).addClass('is-invalid').siblings('.invalid-feedback').html(res.msg[prop]);
                  }
                }
              } else if (!res.success) {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: res.msg,
                })
              } else {
                window.location = res.redirect;
              }
            }
          });
        }


      }, false);
    });

    function deleteRow(e) {
      e.preventDefault();

      Swal.fire({
        title: 'Hapus data ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?= current_url() ?>/delete",
            data: {
              "id": $(this).data('id'),
            },
            dataType: 'json',
            success: function(res) {
              location.reload();
            }
          });
        }
      })
    }


    // fungsi hapus
    $('#tabel-ssp tbody').on('click', '.hapus', deleteRow);
    $('.deleteButton').on('click', deleteRow);
  </script>



  <script>
    $(function() {
      $('#tabel').DataTable({
        responsive: {
          details: true
        }
      });




      var ctx = document.getElementById('chartjs-dashboard-line').getContext("2d");
      var gradient = ctx.createLinearGradient(0, 0, 0, 225);
      gradient.addColorStop(0, 'rgba(215, 227, 244, 1)');
      gradient.addColorStop(1, 'rgba(215, 227, 244, 0)');
      // Line chart
      new Chart(document.getElementById("chartjs-dashboard-line"), {
        type: 'line',
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "Sales ($)",
            fill: true,
            backgroundColor: gradient,
            borderColor: window.theme.primary,
            data: [
              2115,
              1562,
              1584,
              1892,
              1587,
              1923,
              2566,
              2448,
              2805,
              3438,
              2917,
              3327
            ]
          }]
        },
        options: {
          maintainAspectRatio: false,
          legend: {
            display: false
          },
          tooltips: {
            intersect: false
          },
          hover: {
            intersect: true
          },
          plugins: {
            filler: {
              propagate: false
            }
          },
          scales: {
            xAxes: [{
              reverse: true,
              gridLines: {
                color: "rgba(0,0,0,0.0)"
              }
            }],
            yAxes: [{
              ticks: {
                stepSize: 1000
              },
              display: true,
              borderDash: [3, 3],
              gridLines: {
                color: "rgba(0,0,0,0.0)"
              }
            }]
          }
        }
      });
    });
  </script>
  <script>
    $(function() {
      // Pie chart
      new Chart(document.getElementById("chartjs-dashboard-pie"), {
        type: 'pie',
        data: {
          labels: ["Chrome", "Firefox", "IE"],
          datasets: [{
            data: [4306, 3801, 1689],
            backgroundColor: [
              window.theme.primary,
              window.theme.warning,
              window.theme.danger
            ],
            borderWidth: 5
          }]
        },
        options: {
          responsive: !window.MSInputMethodContext,
          maintainAspectRatio: false,
          legend: {
            display: false
          },
          cutoutPercentage: 75
        }
      });
    });
  </script>
  <script>
    $(function() {
      // Bar chart
      new Chart(document.getElementById("chartjs-dashboard-bar"), {
        type: 'bar',
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "This year",
            backgroundColor: window.theme.primary,
            borderColor: window.theme.primary,
            hoverBackgroundColor: window.theme.primary,
            hoverBorderColor: window.theme.primary,
            data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
            barPercentage: .75,
            categoryPercentage: .5
          }]
        },
        options: {
          maintainAspectRatio: false,
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              gridLines: {
                display: false
              },
              stacked: false,
              ticks: {
                stepSize: 20
              }
            }],
            xAxes: [{
              stacked: false,
              gridLines: {
                color: "transparent"
              }
            }]
          }
        }
      });
    });
  </script>
  <script>
    $(function() {
      $("#world_map").vectorMap({
        map: "world_mill",
        normalizeFunction: "polynomial",
        hoverOpacity: .7,
        hoverColor: false,
        regionStyle: {
          initial: {
            fill: "#e3eaef"
          }
        },
        markerStyle: {
          initial: {
            "r": 9,
            "fill": window.theme.primary,
            "fill-opacity": .95,
            "stroke": "#fff",
            "stroke-width": 7,
            "stroke-opacity": .4
          },
          hover: {
            "stroke": "#fff",
            "fill-opacity": 1,
            "stroke-width": 1.5
          }
        },
        backgroundColor: "transparent",
        zoomOnScroll: false,
        markers: [{
            latLng: [31.230391, 121.473701],
            name: "Shanghai"
          },
          {
            latLng: [28.704060, 77.102493],
            name: "Delhi"
          },
          {
            latLng: [6.524379, 3.379206],
            name: "Lagos"
          },
          {
            latLng: [35.689487, 139.691711],
            name: "Tokyo"
          },
          {
            latLng: [23.129110, 113.264381],
            name: "Guangzhou"
          },
          {
            latLng: [40.7127837, -74.0059413],
            name: "New York"
          },
          {
            latLng: [34.052235, -118.243683],
            name: "Los Angeles"
          },
          {
            latLng: [41.878113, -87.629799],
            name: "Chicago"
          },
          {
            latLng: [51.507351, -0.127758],
            name: "London"
          },
          {
            latLng: [40.416775, -3.703790],
            name: "Madrid"
          }
        ]
      });
      setTimeout(function() {
        $(window).trigger('resize');
      }, 250)
    });
  </script>
  <script>
    $(function() {
      $('#datetimepicker-dashboard').datetimepicker({
        inline: true,
        sideBySide: false,
        format: 'L'
      });
    });
  </script>

</body>

</html>