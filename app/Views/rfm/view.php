<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-body">
    <a href="#" class="btn btn-info">generate RFM</a>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <table class="table table-hover table-bordered table striped w-100">
      <thead>
        <tr class="text-uppercase text-center">
          <th>no</th>
          <th>nama pelanggan</th>
          <th>recency</th>
          <th>frequency</th>
          <th>monetary</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<script>
  if ($('.table').length > 0) {
    $('.table').DataTable({
      processing: true,
      serverSide: true,
      scrollX: true,
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
          'data': 'r'
        },
        {
          'data': 'f'
        },
        {
          'data': 'm'
        },
      ],
      language: {
        "decimal": ",",
        "emptyTable": "Tidak ada data",
        "info": "Tampil _START_ ke _END_ dari _TOTAL_ entri",
        "infoEmpty": "Menampilkan 0 ke 0 dari 0 entri",
        "infoFiltered": "(filter dari _MAX_ total entri)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Menampilkan _MENU_ entri",
        "loadingRecords": "Loading...",
        "processing": "Sedang Proses...",
        "search": "Cari:",
        "zeroRecords": "Tidak ada record yang sesuai",
        "paginate": {
          "first": "Pertama",
          "last": "Terakhir",
          "next": "Selanjutnya",
          "previous": "Sebelumnya"
        },
        "aria": {
          "sortAscending": ": activate to sort column ascending",
          "sortDescending": ": activate to sort column descending"
        }
      }
    });
  }
</script>
<?= $this->endSection(); ?>