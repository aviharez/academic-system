<?= $this->extend('main/layout') ?>
<?= $this->section('title') ?>
Data User
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <div class="card">
    <div class="card-header">
      <button type="button" class="btn btn-primary" onclick="showModal()">
        <i class="fas fa-plus-circle"></i> Tambah Data
      </button>
    </div>
    <div class="card-body">
      <table class="table table-sm table-stripped table-bordered" style="width: 100%;" id="dataUser">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama User</th>
            <th>Email</th>
            <th>Grup Akses</th>
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
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= form_open('admin/user/save', [
            'id' => 'formUser'
          ]) ?>
            <input type="hidden" name="_method" id="method" value="POST">
            <input type="hidden" name="id_user" id="id_user" value="">
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Nama User</label>
              <div class="col-sm-8">
                <input type="text" maxlength="100" class="form-control" name="nama_user" id="nama_user" placeholder="Masukkan Nama User" autofocus>
                <div class='invalid-feedback errorNama'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Email</label>
              <div class="col-sm-8">
                <input type="email" maxlength="50" class="form-control" name="email" id="email" placeholder="Masukkan Email">
                <div class='invalid-feedback errorEmail'></div>
              </div>
            </div>
            <div class="form-group row" id="passRow">
              <label for="" class="col-sm-4 col-form-label">Password</label>
              <div class="col-sm-8">
                <input type="password" maxlength="100" class="form-control" name="pass_user" id="pass_user" placeholder="Masukkan Password">
                <div class='invalid-feedback errorPass'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Grup</label>
              <div class="col-sm-8">
                <select class="form-control" name="id_group" id="id_group">
                  <option value="">Pilih Data</option>
                  <option value="1">Administrator</option>
                  <option value="2">Dosen</option>
                  <option value="3">Mahasiswa</option>
                </select>
                <div class='invalid-feedback errorGroup'></div>
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
      $('#dataUser').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= site_url('admin/user/getData') ?>',
        order: [],
        columnDefs: [
            { targets: 0, orderable: false},
            { targets: -1, orderable: false }
        ]
      });
    });

    $(function() {
      $('#formUser').submit(function (e) {
        e.preventDefault();
        let isNewData = $('#method').val() === 'POST';
        console.log('isNewData', isNewData);
        $.ajax({
          type: 'post',
          url: isNewData ? $(this).attr('action') : '<?= site_url('admin/user/update') ?>',
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

              $('.errorNama').html(err.errorNama ?? '');
              if (err.errorNama) {
                $('#nama_user').addClass('is-invalid');
              } else {
                $('#nama_user').removeClass('is-invalid');
              }
              $('.errorGroup').html(err.errorGroup ?? '');
              if (err.errorGroup) {
                $('#id_group').addClass('is-invalid');
              } else {
                $('#id_group').removeClass('is-invalid');
              }
              $('.errorEmail').html(err.errorEmail ?? '');
              if (err.errorEmail) {
                $('#email').addClass('is-invalid');
              } else {
                $('#email').removeClass('is-invalid');
              }
              $('.errorPass').html(err.errorPass ?? '');
              if (err.errorPass) {
                $('#pass_user').addClass('is-invalid');
              } else {
                $('#pass_user').removeClass('is-invalid');
              }
            } else {
              toastr.success(response.success);
              $('.modal').modal('toggle');
              $('#dataUser').DataTable().ajax.reload();
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
      $("#formUser").submit();
    }

    function updateData(kd) {
      $.ajax({
        type: "get",
        url: '<?= site_url('admin/user/getSelectedData/')?>' + kd,
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
      $("#id_user").val(data?.id_user ?? '');
      $("#nama_user").val(data?.nama_user ?? '');
      $("#email").val(data?.email ?? '');
      $("#pass_user").val('');
      $("#id_group").val(data?.id_group ?? '');
      if (data) {
        $('#passRow').hide();
      } else {
        $('#passRow').show();
      }
      $('.modal-title').html((data ? 'Ubah' : 'Tambah') + ' User');
      $('#saveButton').html((data ? 'Ubah' : 'Simpan') + ' Data');
      $('.errorNama').html('');
      $('#nama_user').removeClass('is-invalid');
      $('.errorEmail').html('');
      $('#email').removeClass('is-invalid');
      $('.errorPass').html('');
      $('#pass_user').removeClass('is-invalid');
      $('.errorGroup').html('');
      $('#id_group').removeClass('is-invalid');
      $('.modal').modal('toggle');
    }

    function deleteData(kd) {
      Swal.fire({
        title: "Hapus Data User",
        text: "Apakah anda akan menghapus user tersebut?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "delete",
            url: "<?= site_url('admin/user/delete/') ?>" + kd,
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
                  $('#dataUser').DataTable().ajax.reload();
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