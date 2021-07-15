<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-body">
    <!-- <button class="btn btn-info" id="btnGenerate"><i class="fas fa-sync-alt"></i> Generate</button> -->
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-kmeans">
      Generate K-Means
    </button>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>NO</th>
          <th>Tanggal</th>
          <th>Periode</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($kmeans_history  as $key => $item) : ?>
          <tr>
            <td><?= $key + 1; ?></td>
            <td><?= $item['tanggal']; ?></td>
            <td><?= $item['periode']; ?></td>
            <td>
              <a href="/kmeans/hasil/<?= $item['id'] ?>" class="btn btn-sm btn-info">Lihat Hasil</a>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="modal-kmeans" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Generate K-Means</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/kmeans/prosesHitung" method="post">
        <div class="modal-body m-3">
          <fieldset>
            <legend class="h4">Periode</legend>
            <div class="form-row mb-3">
              <div class="col">
                <label for="bulan">Bulan</label>
                <select name="bulan" id="bulan" class="form-control">
                </select>
              </div>
              <div class="col">
                <label for="tahun">Tahun</label>
                <select name="tahun" id="tahun" class="form-control">
                </select>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend class="h4">Cluster 1</legend>
            <div class="form-row mb-3">
              <div class="col">
                <label for="c1R">Recency</label>
                <input type="text" id="c1R" name="c1R" class="form-control" placeholder="0">
              </div>
              <div class="col">
                <label for="c1F">Frequency</label>
                <input type="text" id="c1F" name="c1F" class="form-control" placeholder="0">
              </div>
              <div class="col">
                <label for="c1M">Monetary</label>
                <input type="text" id="c1M" name="c1M" class="form-control" placeholder="0">
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend class="h4">Cluster 2</legend>
            <div class="form-row">
              <div class="col">
                <label for="c2R">Recency</label>
                <input type="text" id="c2R" name="c2R" class="form-control" placeholder="0">
              </div>
              <div class="col">
                <label for="c2F">Frequency</label>
                <input type="text" id="c2F" name="c2F" class="form-control" placeholder="0">
              </div>
              <div class="col">
                <label for="c2M">Monetary</label>
                <input type="text" id="c2M" name="c2M" class="form-control" placeholder="0">
              </div>
            </div>
          </fieldset>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="btnProses">Proses</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
  $('table').DataTable();
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

  $('#btnProses').click(function(e) {
    $(this).prop('disabled', true);
    $(this).html(`
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    Sedang proses...
    `)
    $('form').submit()
  })

  $(function() {
    const bulan = {
      1: 'januari - Februari',
      02: 'Februari - Maret',
      03: 'Maret - April',
      04: 'April - Mei',
      05: 'Mei - Juni',
      06: 'Juni - Juli',
      07: 'Juli - Agustus',
      08: 'Agustus - September',
      09: 'September - Oktober',
      10: 'Oktober - November',
      11: 'November - Desember',
      12: 'Desember - Januari',
    }
    const tahun = ['2015', '2016', '2017', '2018', '2019', '2020', '2021']

    let option = '<option value="">Pilih..</option>';
    for (const key in bulan) {
      if (Object.hasOwnProperty.call(bulan, key)) {
        // const element = bulan[key];
        option += `<option value="${key}">${bulan[key]}</option>`
      }
    }
    $('#bulan').html(option)

    let optionTahun = '<option value="">Pilih..</option>'
    // for (const key in tahun) {
    //   if (Object.hasOwnProperty.call(tahun, key)) {
    //     optionTahun += `<option value="${key}">${tahun[key]}</option>`
    //   }
    // }
    for (let i = 0; i < tahun.length; i++) {
      optionTahun += `<option value="${tahun[i]}">${tahun[i]}</option>`
    }
    $('#tahun').html(optionTahun)
  })
</script>
<?= $this->endSection(); ?>