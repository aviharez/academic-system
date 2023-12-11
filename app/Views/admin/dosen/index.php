<?= $this->extend('main/layout') ?>
<?= $this->section('title') ?>
Data Dosen
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
            <th>NIP</th>
            <th>Nama Dosen</th>
            <th>Jenis Kelamin</th>
            <th>Email</th>
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
          <?= form_open('admin/dosen/save', [
            'id' => 'formDosen'
          ]) ?>
            <input type="hidden" name="_method" id="method" value="POST">
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">NIP</label>
              <div class="col-sm-8">
                <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==11) return false;" class="form-control" name="nip" id="nip" placeholder="Masukkan NIP Dosen" autofocus>
                <div class='invalid-feedback errorNIP'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Nama Dosen</label>
              <div class="col-sm-8">
                <input type="text" maxlength="100" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama Dosen">
                <div class='invalid-feedback errorNama'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Jenis Kelamin</label>
              <div class="col-sm-8">
                <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                  <option value="">Pilih Data</option>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
                <div class='invalid-feedback errorJK'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Email</label>
              <div class="col-sm-8">
                <select class="form-control" name="email" id="email">
                  <option value="">Pilih Data</option>
                </select>
                <!-- <input type="email" maxlength="50" class="form-control" name="email" id="email" placeholder="Masukkan Email"> -->
                <div class='invalid-feedback errorEmail'></div>
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
      $('#datamatkul').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= site_url('admin/dosen/getData') ?>',
        order: [],
        columnDefs: [
            { targets: 0, orderable: false},
            { targets: -1, orderable: false }
        ]
      });

      $.ajax({
        type: "get",
        url: "<?= site_url('admin/dosen/getAllEmailData') ?>",
        dataType: "json",
        success: function (response) {
          $.each(response.data, function (i, item) {
              $('#email').append($('<option>', { 
                  value: item.email,
                  text : item.email 
              }));
          });
        },
        error: function(e) {
            alert(e.responseText);
        }
      });
    });

    $(function() {
      $('#formDosen').submit(function (e) {
        e.preventDefault();
        let isNewData = $('#method').val() === 'POST';
        $.ajax({
          type: 'post',
          url: isNewData ? $(this).attr('action') : '<?= site_url('admin/dosen/update') ?>',
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

              $('.errorNIP').html(err.errorNIP ?? '');
              if (err.errorNIP) {
                $('#nip').addClass('is-invalid');
              } else {
                $('#nip').removeClass('is-invalid');
              }
              $('.errorNama').html(err.errorNama ?? '');
              if (err.errorNama) {
                $('#nama').addClass('is-invalid');
              } else {
                $('#nama').removeClass('is-invalid');
              }
              $('.errorJK').html(err.errorJK ?? '');
              if (err.errorJK) {
                $('#jenis_kelamin').addClass('is-invalid');
              } else {
                $('#jenis_kelamin').removeClass('is-invalid');
              }
              $('.errorEmail').html(err.errorEmail ?? '');
              if (err.errorEmail) {
                $('#email').addClass('is-invalid');
              } else {
                $('#email').removeClass('is-invalid');
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
      $("#formDosen").submit();
    }

    function updateData(kd) {
      $.ajax({
        type: "get",
        url: '<?= site_url('admin/dosen/getSelectedData/')?>' + kd,
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
      $("#nip").val(data?.nip ?? '');
      $("#nama").val(data?.nama ?? '');
      $("#jenis_kelamin").val(data?.jenis_kelamin ?? '');
      $("#email").val(data?.email ?? '');
      $('.modal-title').html((data ? 'Ubah' : 'Tambah') + ' Dosen');
      $('#saveButton').html((data ? 'Ubah' : 'Simpan') + ' Data');
      $('.errorNIP').html('');
      $('#nip').removeClass('is-invalid');
      $('.errorNama').html('');
      $('#nama').removeClass('is-invalid');
      $('.errorJK').html('');
      $('#jenis_kelamin').removeClass('is-invalid');
      $('.errorEmail').html('');
      $('#email').removeClass('is-invalid');
      $('.modal').modal('toggle');
    }

    function deleteData(kd) {
      Swal.fire({
        title: "Hapus Data Dosen",
        text: "Apakah anda akan menghapus dosen dengan nip: " + kd + "?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "delete",
            url: "<?= site_url('admin/dosen/delete/') ?>" + kd,
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