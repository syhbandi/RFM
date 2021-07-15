<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<div class="alert alert-success">
  <div class="alert-message">
    Selamat Datang, <strong><?= session('nama') ?></strong>
  </div>
</div>

<div class="row">
  <?php foreach ($periode as $key => $item) : ?>
    <div class="col-sm-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-4">Periode </h5>
          <h1 class="display-5 mt-1 mb-3"><?= $item['periode'] ?></h1>
          <a href="/kmeans/hasil/<?= $item['id'] ?>" class="">Lihat hasil</a>
        </div>
      </div>
    </div>
  <?php endforeach ?>

</div>


<?= $this->endSection(); ?>