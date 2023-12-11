<?= $this->extend('main/layout') ?>
<?= $this->section('title') ?>
Data Mata Kuliah
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <div class="card">
    <div class="card-header">
      <button type="button" class="btn btn-primary" onclick="showModal()">
        <i class="fas fa-plus-circle"></i> Tambah Data
      </button>
    </div>
    <div class="card-body">
      <table class="table table-sm table-stripped table-bordered" style="width: 100%;" id="datamatkul">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Mata Kuliah</th>
            <th>Nama Mata Kuliah</th>
            <th>SKS</th>
            <th>Harga</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Mata Kuliah</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= form_open('admin/mata-kuliah/save', [
            'id' => 'formMatkul'
          ]) ?>
            <input type="hidden" name="_method" id="method" value="POST">
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Kode Mata Kuliah</label>
              <div class="col-sm-8">
                <input type="text" maxlength="5" class="form-control" name="kd_mk" id="kd_mk" placeholder="Masukkan Kode Mata Kuliah" autofocus>
                <div class='invalid-feedback errorKdMk'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Nama Mata Kuliah</label>
              <div class="col-sm-8">
                <input type="text" maxlength="100" class="form-control" name="nama_mk" id="nama_mk" placeholder="Masukkan Nama Mata Kuliah">
                <div class='invalid-feedback errorNamaMk'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Jumlah SKS</label>
              <div class="col-sm-8">
                <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==2) return false;" class="form-control" name="sks" id="sks" placeholder="Masukkan Jumlah SKS">
                <div class='invalid-feedback errorSKS'></div>
              </div>
            </div>
          <?= form_close() ?>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="saveButton" value="submit" onclick="submitData()">Simpan Data</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <script>
    $(document).ready(function () {
      $('#datamatkul').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= site_url('admin/mata-kuliah/getData') ?>',
        order: [],
        columnDefs: [
            { targets: 0, orderable: false},
            { targets: -1, orderable: false }
        ]
      })
    });

    $(function() {
      $('#formMatkul').submit(function (e) {
        e.preventDefault();
        let isNewData = $('#method').val() === 'POST';
        $.ajax({
          type: 'post',
          url: isNewData ? $(this).attr('action') : '<?= site_url('admin/mata-kuliah/update') ?>',
          data: $(this).serialize(),
          dataType: "json",
          beforeSend: function() {
            $('#saveButton').html('<i class="fas fa-spin fa-spinner"></i> Tunggu');
            $('#saveButton').prop('disabled', true);
          },
          complete: function() {
            $('#saveButton').html((isNewData ? 'Simpan' : 'Ubah') + ' Data');
            $('#saveButton').prop('disabled', false);
          },
          success: function (response) {
            if (response.error) {
              let err = response.error;

              $('.errorKdMk').html(err.errorKdMk ?? '');
              if (err.errorKdMk) {
                $('#kd_mk').addClass('is-invalid');
              } else {
                $('#kd_mk').removeClass('is-invalid');
              }
              $('.errorNamaMk').html(err.errorNamaMk ?? '');
              if (err.errorNamaMk) {
                $('#nama_mk').addClass('is-invalid');
              } else {
                $('#nama_mk').removeClass('is-invalid');
              }
              $('.errorSKS').html(err.errorSKS ?? '');
              if (err.errorKdMk) {
                $('#sks').addClass('is-invalid');
              } else {
                $('#sks').removeClass('is-invalid');
              }
            } else {
              toastr.success(response.success);
              $('.modal').modal('toggle');
              $('#datamatkul').DataTable().ajax.reload();
            }
          },
          error: function(e) {
            alert(e.responseText);
          }
        });
        return false;
      });
    });

    function submitData() {
      $("#formMatkul").submit();
    }

    function updateData(kd) {
      $.ajax({
        type: "get",
        url: '<?= site_url('admin/mata-kuliah/getSelectedData/')?>' + kd,
        dataType: "json",
        success: function (response) {
          if (response.data) {
            showModal(response.data);
          }
        }
      });
    }

    function showModal(data = null) {
      $("#method").val(data ? 'PUT' : 'POST');
      $("#kd_mk").val(data?.kd_mk ?? '');
      $("#nama_mk").val(data?.nama_mk ?? '');
      $("#sks").val(data?.sks ?? '');
      $('#kd_mk').prop('readonly', data ? true : false);
      $('.modal-title').html((data ? 'Ubah' : 'Tambah') + ' Mata Kuliah');
      $('#saveButton').html((data ? 'Ubah' : 'Simpan') + ' Data');
      $('.errorKdMk').html('');
      $('#kd_mk').removeClass('is-invalid');
      $('.errorNamaMk').html('');
      $('#nama_mk').removeClass('is-invalid');
      $('.errorSKS').html('');
      $('#sks').removeClass('is-invalid');
      $('.modal').modal('toggle');
    }

    function deleteData(kd) {
      Swal.fire({
        title: "Hapus Data Mata Kuliah",
        text: "Apakah anda akan menghapus mata kuliah dengan kode: " + kd + "?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "delete",
            url: "<?= site_url('admin/mata-kuliah/delete/') ?>" + kd,
            dataType: "json",
            success: function (response) {
              if (response.error) {
                Swal.fire({
                  title: "Gagal Menghapus Data",
                  text: response.error,
                  icon: "error"
                });
              }

              if (response.success) {
                Swal.fire({
                  title: "Sukses",
                  text: response.success,
                  icon: "success"
                }).then((value) => {
                  $('#datamatkul').DataTable().ajax.reload();
                })
              }
            },
            error: function (xhr) {
              alert("Error: " + xhr.responseText);
            }
          });
        }
      });
    }
  </script>
<?= $this->endSection() ?>