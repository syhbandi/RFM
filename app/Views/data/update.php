<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
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
          <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Pelanggan" value="<?= $dataPelanggan['nama']; ?>" required>
          <div class="invalid-feedback text-capitalize">
            Nama pelanggan wajib diisi
          </div>
        </div>
      </div>
      <!-- alamat -->
      <div class="form-group row">
        <label for="alamat" class="col-md-2 col-sm-12 control-label text-capitalize">alamat</label>
        <div class="col-md-6 col-sm-12">
          <textarea name="alamat" id="alamat" rows="5" class="form-control" placeholder="Alamat Pelanggan" required><?= $dataPelanggan['alamat']; ?></textarea>
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
              <option value="<?= $item['id']; ?>" <?= $item['id'] == $dataPelanggan['paket_id'] ? 'selected' : '' ?>><?= $item['tipe_paket'] ?></option>
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
          <input type="text" class="form-control" name="jumlah_terpasang" id="jumlah_terpasang" placeholder="jumlah terpasang" required value="<?= $dataPelanggan['jumlah_terpasang'] ?>">
          <div class="invalid-feedback text-capitalize">
            jumlah terpasang wajib diisi
          </div>
        </div>
      </div>
      <!-- activity_nosa -->
      <div class="form-group row">
        <label for="activity_nosa" class="col-md-2 col-sm-12 control-label text-capitalize">activity_nosa</label>
        <div class="col-md-6 col-sm-12">
          <textarea name="activity_nosa" id="activity_nosa" rows="5" class="form-control" placeholder="activity nosa"><?= $dataPelanggan['activity_nosa'] ?></textarea>
          <div class="invalid-feedback text-capitalize">
            activity nosa wajib diisi
          </div>
        </div>
      </div>
      <!-- layanan -->
      <div class="form-group row">
        <label for="layanan" class="col-md-2 col-sm-12 control-label text-capitalize">layanan</label>
        <div class="col-md-6 col-sm-12">
          <textarea name="layanan" id="layanan" rows="5" class="form-control" placeholder="Layanan"><?= $dataPelanggan['layanan'] ?></textarea>
          <div class="invalid-feedback text-capitalize">
            layanan wajib diisi
          </div>
        </div>
      </div>
      <!-- tgl_daftar -->
      <div class="form-group row">
        <label for="tgl_daftar" class="col-md-2 col-sm-12 control-label text-capitalize">tgl. daftar</label>
        <div class="col-md-6 col-sm-12">
          <input type="text" class="form-control" name="tgl_daftar" id="tgl_daftar" placeholder="tgl. daftar Pelanggan" required value="<?= $dataPelanggan['tgl_daftar'] ?>">
          <div class="invalid-feedback text-capitalize">
            Tgl Daftar wajib diisi
          </div>
        </div>
      </div>
      <!-- tgl_aktif -->
      <div class="form-group row">
        <label for="tgl_aktif" class="col-md-2 col-sm-12 control-label text-capitalize">tgl. aktif</label>
        <div class="col-md-6 col-sm-12">
          <input type="text" class="form-control" name="tgl_aktif" id="tgl_aktif" placeholder="tgl. aktif Pelanggan" required value="<?= $dataPelanggan['tgl_aktif'] ?>">
          <div class="invalid-feedback text-capitalize">
            Tgl. Aktif wajib diisi
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button class="btn btn-secondary" onclick="history.back()"><i class="fas fa-arrow-left"></i> Kembali</button>
      <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Simpan Data</button>
      <input type="hidden" name="id" value="<?= $dataPelanggan['id'] ?>">
    </div>
  </div>
</form>
<?= $this->endSection(); ?>