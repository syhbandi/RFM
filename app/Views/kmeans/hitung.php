<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-body">
    <button class="btn btn-info" id="btnGenerate"><i class="fas fa-sync-alt"></i> Generate</button>
  </div>
</div>

<div id="hasil"></div>

<script>
  $('#btnGenerate').click(function(e) {
    $(this).prop('disabled', true);
    $(this).html(`
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    Sedang proses...
    `)
    $.ajax({
      url: '<?= current_url() ?>/prosesHitung',
      dataType: 'json',
      success: function(res) {
        if (success) {
          // setTimeout(() => {
          //   $('#hasil').html(res.data)
          // }, 2000);
          console.log(res.data)
        }
      }
    })
  })
</script>

<?= $this->endSection(); ?>