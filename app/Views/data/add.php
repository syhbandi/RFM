<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-6 col-sm-12">
        <form action="/data/uploadData" method="POST" enctype="multipart/form-data" id="form-batch">
          <div class="form-group row mb-0">
            <label for="fileExcel" class="col-md-4 col-sm-12">Import dari Excel</label>
            <div class="col-md-8 col-sm-12">
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="fileExcel" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">Pilih File</label>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-6 col-sm-12">
        <button class="btn btn-secondary" id="export"><i class="fas fa-download"></i> Unduh Format</button>
        <button type="submit" class="btn btn-info float-right" id="btnUp"><i class="fas fa-upload"></i> Unggah</button>
      </div>
    </div>

  </div>
</div>
<form action="/data/save" class="needs-validation" id="form-add" method="POST" novalidate>
  <div class="card">
    <div class="card-header">
      <button class="btn btn-secondary" onclick="history.back()"><i class="fas fa-arrow-left"></i> Kembali</button>
    </div>
    <div class="card-body">
      <?= csrf_field() ?>
      <!-- nama -->
      <div class="form-group row">
        <label for="nama" class="col-md-2 col-sm-12 control-label text-capitalize">Nama</label>
        <div class="col-md-6 col-sm-12">
          <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Pelanggan" required>
          <div class="invalid-feedback text-capitalize">
            Nama pelanggan wajib diisi
          </div>
        </div>
      </div>
      <!-- alamat -->
      <div class="form-group row">
        <label for="alamat" class="col-md-2 col-sm-12 control-label text-capitalize">alamat</label>
        <div class="col-md-6 col-sm-12">
          <textarea name="alamat" id="alamat" rows="5" class="form-control" placeholder="Alamat Pelanggan" required></textarea>
          <div class="invalid-feedback text-capitalize">
            alamat wajib diisi
          </div>
        </div>
      </div>
      <!-- tipe transaksi -->
      <div class="form-group row">
        <label for="paket" class="col-md-2 col-sm-12 control-label  text-capitalize">tipe transaksi</label>
        <div class="col-md-6 col-sm-12">
          <select name="paket" id="paket" class="form-control" required>
            <?php foreach ($dataPaket as $item) : ?>
              <option value="<?= $item['id']; ?>"><?= $item['tipe_paket'] ?></option>
            <?php endforeach ?>
          </select>
          <div class="invalid-feedback text-capitalize">
            paket wajib diisi
          </div>
        </div>
      </div>
      <!-- jumlah terpasang -->
      <div class="form-group row">
        <label for="jumlah_terpasang" class="col-md-2 col-sm-12 control-label text-capitalize">jumlah terpasang</label>
        <div class="col-md-6 col-sm-12">
          <input type="text" class="form-control" name="jumlah_terpasang" id="jumlah_terpasang" placeholder="jumlah terpasang" required>
          <div class="invalid-feedback text-capitalize">
            jumlah terpasang wajib diisi
          </div>
        </div>
      </div>
      <!-- activity_nosa -->
      <div class="form-group row">
        <label for="activity_nosa" class="col-md-2 col-sm-12 control-label text-capitalize">activity_nosa</label>
        <div class="col-md-6 col-sm-12">
          <textarea name="activity_nosa" id="activity_nosa" rows="5" class="form-control" placeholder="activity nosa"></textarea>
          <div class="invalid-feedback text-capitalize">
            activity nosa wajib diisi
          </div>
        </div>
      </div>
      <!-- layanan -->
      <div class="form-group row">
        <label for="layanan" class="col-md-2 col-sm-12 control-label text-capitalize">layanan</label>
        <div class="col-md-6 col-sm-12">
          <textarea name="layanan" id="layanan" rows="5" class="form-control" placeholder="Layanan"></textarea>
          <div class="invalid-feedback text-capitalize">
            layanan wajib diisi
          </div>
        </div>
      </div>
      <!-- tgl_daftar -->
      <div class="form-group row">
        <label for="tgl_daftar" class="col-md-2 col-sm-12 control-label text-capitalize">tgl. daftar</label>
        <div class="col-md-6 col-sm-12">
          <input type="text" class="form-control" name="tgl_daftar" id="tgl_daftar" placeholder="tgl. daftar Pelanggan" required>
          <div class="invalid-feedback text-capitalize">
            Tgl Daftar wajib diisi
          </div>
        </div>
      </div>
      <!-- tgl_aktif -->
      <div class="form-group row">
        <label for="tgl_aktif" class="col-md-2 col-sm-12 control-label text-capitalize">tgl. aktif</label>
        <div class="col-md-6 col-sm-12">
          <input type="text" class="form-control" name="tgl_aktif" id="tgl_aktif" placeholder="tgl. aktif Pelanggan" required>
          <div class="invalid-feedback text-capitalize">
            Tgl. Aktif wajib diisi
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button class="btn btn-secondary" onclick="history.back()"><i class="fas fa-arrow-left"></i> Kembali</button>
      <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Simpan Data</button>
    </div>
  </div>
</form>
<script>
  $('#export').click(function() {
    window.location = '/data/exportTemplate';
  })

  $('#btnUp').click(function(e) {
    let formData = new FormData($('#form-batch')[0]);
    $.ajax({
      url: $('#form-batch').attr('action'),
      type: 'post',
      dataType: 'json',
      contentType: false,
      processData: false,
      data: formData,
      success: function(res) {
        console.log(res);
        if (res.success) {
          window.location = res.redirect
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: res.msg,
          })
        }
      }
    });
  })
</script>
<?= $this->endSection(); ?>