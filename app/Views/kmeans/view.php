<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-body">
    <button class="btn btn-info" id="btnGenerate"><i class="fas fa-sync-alt"></i> Generate</button>
  </div>
</div>


<script>
  $('#btnGenerate').click(function(e) {
    $(this).prop('disabled', true);
    $(this).html(`
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    Sedang proses...
    `)
    setTimeout(() => {
      location.href = '/kmeans/prosesHitung'
    }, 2000);
  })
</script>
<?= $this->endSection(); ?>