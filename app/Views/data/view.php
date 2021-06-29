<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<button class="btn btn-primary" id="export">Export Excel</button>


<script>
  $('#export').click(function() {
    window.location = '/data/exportTemplate';
  })
</script>
<?= $this->endSection(); ?>