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

  <title><?= $title ?? 'Dashboard' ?></title>
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link href="/assets/css/app.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css" integrity="sha256-IOK+l4ZTv3gsgXRB8x72XhfUPf5SjCzttu6BDdx+2vU=" crossorigin="anonymous">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

  <script src="/assets/js/app.js"></script>
  <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.all.min.js" integrity="sha256-92U7H+uBjYAJfmb+iNPi7DPoj795ZCTY4ZYmplsn/fQ=" crossorigin="anonymous"></script>
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
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script> -->

  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <?= $this->include('layouts/script'); ?>


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
</body>

</html>