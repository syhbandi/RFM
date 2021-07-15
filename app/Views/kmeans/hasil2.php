<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-body">
    <table class="table table-bordered w-100">
      <thead>
        <tr>
          <th>NO</th>
          <th>Nama</th>
          <th>R</th>
          <th>F</th>
          <th>M</th>
          <th>C1</th>
          <th>C2</th>
          <th>Cluster</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($kmeans as $k => $val) : ?>
          <tr>
            <td><?= $k + 1 ?></td>
            <td><?= $val['nama'] ?></td>
            <td><?= $val['r'] ?></td>
            <td><?= $val['f'] ?></td>
            <td><?= $val['m'] ?></td>
            <td><?= $val['c1'] ?></td>
            <td><?= $val['c2'] ?></td>
            <td class="<?= $val['cluster'] == 'Cluster 1' ? 'text-success' : 'text-danger' ?>"><?= $val['cluster'] ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
<script>
  $('table').DataTable();
</script>

<?= $this->endSection(); ?>