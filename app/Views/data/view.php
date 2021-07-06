<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<div class="card">
  <div class="card-body">
    <button class="btn btn-info" id="tesToast">Tes Toast</button>
    <a class="btn btn-primary" href="<?= current_url(); ?>/add"><i class="fas fa-plus-circle"></i> Tambah data</a>
    <button class="btn btn-danger" id="deleteAll"><i class="fas fa-trash" id="deleteAll"></i> Hapus semua</button>
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
          <th>Tipe Paket</th>
          <th>Activity NOSA</th>
          <th>Total Paket</th>
          <th>jumlah terpasang</th>
          <th>layanan</th>
          <th>tgl. daftar</th>
          <th>tgl. aktif</th>
          <th></th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<script>
  $('#tesToast').click(function(e) {
    Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'Your work has been saved',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      toast: true,
    })
  })
  if ($('#table-data').length > 0) {
    $('#table-data').DataTable({
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
          'data': 'alamat'
        },
        {
          'data': 'tipe_paket'
        },
        {
          'data': 'activity_nosa'
        },
        {
          'data': 'jumlah_paket'
        },
        {
          'data': 'jumlah_terpasang'
        },
        {
          'data': 'layanan'
        },
        {
          'data': 'tgl_daftar'
        },
        {
          'data': 'tgl_aktif'
        },
        {
          'data': 'id',
          "searchable": false,
          "sortable": false,
          "render": function(id, type, full, meta) {
            return `<div class="btn-group btn-group-sm" role="group" aria-label="group">
                        <a href="/data/update/${id}" class="btn btn-warning"><i class="far fa-edit"></i></a> <a href="" class="btn btn-danger hapus" data-id="${id}"><i class="fas fa-trash"></i></a>
                      </div>`;
          }
        }
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