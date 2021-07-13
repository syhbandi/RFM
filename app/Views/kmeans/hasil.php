<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<?php foreach ($data as $key => $item) : ?>
  <h4>Centroid <?= $key ?></h4>
  <div class="card">
    <div class="card-body">
      <table class="table table-bordered">
        <tr>
          <th>Centroid</th>
          <th>Recency</th>
          <th>Frequency</th>
          <th>Monetary</th>
        </tr>
        <?php foreach ($centroid[$key] as $pret => $preret) : ?>
          <tr>
            <td><?= $pret ?></td>
            <td><?= $preret[0] ?></td>
            <td><?= $preret[1] ?></td>
            <td><?= $preret[2] ?></td>
          </tr>
        <?php endforeach ?>
      </table>
    </div>
  </div>

  <h4><?= $key ?></h4>
  <div class="card">
    <div class="card-body">
      <table class="table table-bordered w-100" id="table-<?= $key; ?>">
        <thead>
          <tr>
            <th>NO</th>
            <th>R</th>
            <th>F</th>
            <th>M</th>
            <th>C1</th>
            <th>C2</th>
            <th>Cluster</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($item as $k => $val) : ?>
            <tr>
              <td><?= $k + 1 ?></td>
              <td><?= $val['r'] ?></td>
              <td><?= $val['f'] ?></td>
              <td><?= $val['m'] ?></td>
              <td><?= $val['C1'] ?? '' ?></td>
              <td><?= $val['C2'] ?? '' ?></td>
              <td><?= $val['Cluster'] ?? '' ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
  <script>
    $('#table-<?= $key ?>').DataTable();
  </script>
<?php endforeach ?>

<?= $this->endSection(); ?>