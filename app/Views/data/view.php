<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-body">

    <a class="btn btn-primary" href="<?= current_url(); ?>/add"><i class="fas fa-plus-circle"></i> Tambah data</a>
  </div>
</div>
<div class="card">
  <div class="card-body">
    <table class="table table-hover table-bordered table-striped" id="table-data">
      <thead>
        <tr class="text-center text-uppercase">
          <th>no</th>
          <th>nama</th>
          <th>alamat</th>
          <th>jumlah terpasang</th>
          <th>keterangan</th>
          <th>tgl. daftar</th>
          <th>tgl. aktif</th>
          <th>ID Paket</th>
          <th></th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<script>
  if ($('#table-data').length > 0) {
    $('#table-data').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: '<?= current_url() ?>/loadData',
        type: 'post'
      },
      columns: [{
          "data": null,
          "sortable": false,
          render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          'data': 'nama'
        },
        {
          'data': 'alamat'
        },
        {
          'data': 'jumlah_terpasang'
        },
        {
          'data': 'keterangan'
        },
        {
          'data': 'tgl_daftar'
        },
        {
          'data': 'tgl_aktif'
        },
        {
          'data': 'paket_id'
        },
        {
          'data': 'id',
          "searchable": false,
          "sortable": false,
          "render": function(id, type, full, meta) {
            return `<div class="btn-group btn-group-sm" role="group" aria-label="group">
                        <a href="/admin/member/update/${id}" class="btn btn-warning"><i class="far fa-edit"></i></a> <a href="" class="btn btn-danger hapus" data-id="${id}"><i class="fas fa-trash"></i></a>
                      </div>`;
          }
        }
      ]
    });
  }
</script>
<?= $this->endSection(); ?>