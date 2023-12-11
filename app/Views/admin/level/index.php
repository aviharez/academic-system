<?= $this->extend('main/layout') ?>
<?= $this->section('title') ?>
Data Level
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <div class="card">
    <div class="card-header">
      <button type="button" class="btn btn-primary" onclick="showModal()">
        <i class="fas fa-plus-circle"></i> Tambah Data
      </button>
    </div>
    <div class="card-body">
      <table class="table table-sm table-stripped table-bordered" style="width: 100%;" id="dataLevel">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Level</th>
            <th>Nama Level</th>
            <th>Kriteria Level</th>
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
          <h4 class="modal-title">Tambah Level</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= form_open('admin/level/save', [
            'id' => 'formLevel'
          ]) ?>
            <input type="hidden" name="_method" id="method" value="POST">
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Kode Level</label>
              <div class="col-sm-8">
                <input type="text" maxlength="5" class="form-control" name="kd_level" id="kd_level" placeholder="Masukkan Kode Level" autofocus>
                <div class='invalid-feedback errorKdLevel'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Nama Level</label>
              <div class="col-sm-8">
                <input type="text" maxlength="100" class="form-control" name="nama_level" id="nama_level" placeholder="Masukkan Nama Mata Kuliah">
                <div class='invalid-feedback errorNamaLevel'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Kriteria Level</label>
              <div class="col-sm-8">
                <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;" class="form-control" name="kriteria_level" id="kriteria_level" placeholder="Masukkan Kriteria Minimal Poin">
                <div class='invalid-feedback errorKriteriaLevel'></div>
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
    <!-- /.modal -->

  <script>
    $(document).ready(function () {
      $('#dataLevel').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= site_url('admin/level/getData') ?>',
        order: [],
        columnDefs: [
            { targets: 0, orderable: false},
            { targets: -1, orderable: false }
        ]
      })
    });

    $(function() {
      $('#formLevel').submit(function (e) {
        e.preventDefault();
        let isNewData = $('#method').val() === 'POST';
        console.log('isNewData', isNewData);
        $.ajax({
          type: 'post',
          url: isNewData ? $(this).attr('action') : '<?= site_url('admin/level/update') ?>',
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

              $('.errorKdLevel').html(err.errorKdLevel ?? '');
              if (err.errorKdLevel) {
                $('#kd_level').addClass('is-invalid');
              } else {
                $('#kd_level').removeClass('is-invalid');
              }
              $('.errorNamaLevel').html(err.errorNamaLevel ?? '');
              if (err.errorNamaLevel) {
                $('#nama_level').addClass('is-invalid');
              } else {
                $('#nama_level').removeClass('is-invalid');
              }
              $('.errorKriteriaLevel').html(err.errorKriteriaLevel ?? '');
              if (err.errorKdLevel) {
                $('#kriteria_level').addClass('is-invalid');
              } else {
                $('#kriteria_level').removeClass('is-invalid');
              }
            } else {
              toastr.success(response.success);
              $('.modal').modal('toggle');
              $('#dataLevel').DataTable().ajax.reload();
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
      $("#formLevel").submit();
    }

    function updateData(kd) {
      $.ajax({
        type: "get",
        url: '<?= site_url('admin/level/getSelectedData/')?>' + kd,
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
      $("#kd_level").val(data?.kd_level ?? '');
      $("#nama_level").val(data?.nama_level ?? '');
      $("#kriteria_level").val(data?.kriteria_level ?? '');
      $('#kd_level').prop('readonly', data ? true : false);
      $('.modal-title').html((data ? 'Ubah' : 'Tambah') + ' Level');
      $('#saveButton').html((data ? 'Ubah' : 'Simpan') + ' Data');
      $('.errorKdLevel').html('');
      $('#kd_level').removeClass('is-invalid');
      $('.errorNamaLevel').html('');
      $('#nama_level').removeClass('is-invalid');
      $('.errorKriteriaLevel').html('');
      $('#kriteria_level').removeClass('is-invalid');
      $('.modal').modal('toggle');
    }

    function deleteData(kd) {
      Swal.fire({
        title: "Hapus Data Level",
        text: "Apakah anda akan menghapus level dengan kode: " + kd + "?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "delete",
            url: "<?= site_url('admin/level/delete/') ?>" + kd,
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
                  $('#dataLevel').DataTable().ajax.reload();
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