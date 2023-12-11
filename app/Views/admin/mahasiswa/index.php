<?= $this->extend('main/layout') ?>
<?= $this->section('title') ?>
Data Mahasiswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <div class="card">
    <div class="card-header">
      <button type="button" class="btn btn-primary" onclick="showModal()">
        <i class="fas fa-plus-circle"></i> Tambah Data
      </button>
    </div>
    <div class="card-body">
      <table class="table table-sm table-stripped table-bordered" style="width: 100%;" id="dataMhs">
        <thead>
          <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Program Studi</th>
            <th>Semester</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="modal-add">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="add-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= form_open('admin/mahasiswa/save', [
            'id' => 'formMhs'
          ]) ?>
            <input type="hidden" name="_method" id="method" value="POST">
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">NIM</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="nim" id="nim" placeholder="Masukkan NIM Mahasiswa" autofocus>
                <div class='invalid-feedback errorNIM'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Nama Mahasiswa</label>
              <div class="col-sm-8">
                <input type="text" maxlength="100" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama Mahasiswa">
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
              <label for="" class="col-sm-4 col-form-label">Tanggal Lahir</label>
              <div class="col-sm-8">
                <div class="input-group date" id="dob" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" data-target="#dob" name="tanggal_lahir" id="tanggal_lahir"/>
                  <div class="input-group-append" data-target="#dob" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
                <div class='invalid-feedback errorTL'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Alamat</label>
              <div class="col-sm-8">
                <textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Masukkan alamat"></textarea>
                <div class='invalid-feedback errorAlamat'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Program Studi</label>
              <div class="col-sm-8">
                <input type="text" maxlength="100" class="form-control" name="program_studi" id="program_studi" placeholder="Masukkan Program Studi">
                <div class='invalid-feedback errorProdi'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Semester</label>
              <div class="col-sm-8">
                <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==2) return false;" class="form-control" name="semester" id="semester" placeholder="Masukkan Semester" autofocus>
                <div class='invalid-feedback errorSem'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Email</label>
              <div class="col-sm-8">
                <select class="form-control" name="email" id="email">
                  <option value="">Pilih Data</option>
                </select>
                <div class='invalid-feedback errorEmail'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Level</label>
              <div class="col-sm-8">
                <select class="form-control" name="kd_level" id="kd_level">
                  <option value="">Pilih Data</option>
                </select>
                <div class='invalid-feedback errorLevel'></div>
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

  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Mahasiswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <dl class="row">
            <dt class="col-sm-4">NIM</dt>
            <dd class="col-sm-8" id="text-nim"></dd>
            <dt class="col-sm-4">Nama Mahasiswa</dt>
            <dd class="col-sm-8" id="text-nama"></dd>
            <dt class="col-sm-4">Jenis Kelamin</dt>
            <dd class="col-sm-8" id="text-jk"></dd>
            <dt class="col-sm-4">Tanggal Lahir</dt>
            <dd class="col-sm-8" id="text-tl"></dd>
            <dt class="col-sm-4">Alamat</dt>
            <dd class="col-sm-8" id="text-alamat"></dd>
            <dt class="col-sm-4">Program Studi</dt>
            <dd class="col-sm-8" id="text-prodi"></dd>
            <dt class="col-sm-4">Semester</dt>
            <dd class="col-sm-8" id="text-sem"></dd>
            <dt class="col-sm-4">Email</dt>
            <dd class="col-sm-8" id="text-email"></dd>
            <dt class="col-sm-4">Level</dt>
            <dd class="col-sm-8" id="text-level"></dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      $('#dataMhs').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= site_url('admin/mahasiswa/getData') ?>',
        order: [],
        columnDefs: [
            { targets: 0, orderable: false},
            { targets: -1, orderable: false }
        ]
      });

      $.ajax({
        type: "get",
        url: "<?= site_url('admin/mahasiswa/getAllEmailData') ?>",
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

      $.ajax({
        type: "get",
        url: "<?= site_url('admin/mahasiswa/getAllLevelData') ?>",
        dataType: "json",
        success: function (response) {
          $.each(response.data, function (i, item) {
              $('#kd_level').append($('<option>', { 
                  value: item.kd_level,
                  text : item.nama_level 
              }));
          });
        },
        error: function(e) {
            alert(e.responseText);
        }
      });
    });

    $(function() {
      $('#formMhs').submit(function (e) {
        e.preventDefault();
        let isNewData = $('#method').val() === 'POST';
        $.ajax({
          type: 'post',
          url: isNewData ? $(this).attr('action') : '<?= site_url('admin/mahasiswa/update') ?>',
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

              $('.errorNIM').html(err.errorNIM ?? '');
              if (err.errorNIM) {
                $('#nim').addClass('is-invalid');
              } else {
                $('#nim').removeClass('is-invalid');
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
              $('.errorTL').html(err.errorTL ?? '');
              if (err.errorTL) {
                $('#tanggal_lahir').addClass('is-invalid');
                $('.errorTL').css({"display": "block"})
              } else {
                $('#tanggal_lahir').removeClass('is-invalid');
                $('.errorTL').css({"display": "none"})
              }
              $('.errorAlamat').html(err.errorAlamat ?? '');
              if (err.errorAlamat) {
                $('#alamat').addClass('is-invalid');
              } else {
                $('#alamat').removeClass('is-invalid');
              }
              $('.errorProdi').html(err.errorProdi ?? '');
              if (err.errorProdi) {
                $('#program_studi').addClass('is-invalid');
              } else {
                $('#program_studi').removeClass('is-invalid');
              }
              $('.errorSem').html(err.errorSem ?? '');
              if (err.errorSem) {
                $('#semester').addClass('is-invalid');
              } else {
                $('#semester').removeClass('is-invalid');
              }
              $('.errorEmail').html(err.errorEmail ?? '');
              if (err.errorEmail) {
                $('#email').addClass('is-invalid');
              } else {
                $('#email').removeClass('is-invalid');
              }
              $('.errorLevel').html(err.errorLevel ?? '');
              if (err.errorLevel) {
                $('#kd_level').addClass('is-invalid');
              } else {
                $('#kd_level').removeClass('is-invalid');
              }
            } else {
              toastr.success(response.success);
              $('#modal-add').modal('toggle');
              $('#dataMhs').DataTable().ajax.reload();
            }
          },
          error: function(e) {
            alert(e.responseText);
          }
        });
        return false;
      });

      //Date picker
      $('#dob').datetimepicker({
          format: 'L'
      });
    });

    function submitData() {
      $("#formMhs").submit();
    }

    function showDetail(nim) {
      $.ajax({
        type: "get",
        url: '<?= site_url('admin/mahasiswa/getSelectedData/')?>' + nim,
        dataType: "json",
        success: function (response) {
          if (response.data) {
            let data = response.data;
            $('#text-nim').html(data.nim);
            $('#text-nama').html(data.nama);
            $('#text-jk').html(data.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan');
            $('#text-tl').html(data.tanggal_lahir);
            $('#text-alamat').html(data.alamat);
            $('#text-prodi').html(data.program_studi);
            $('#text-sem').html(data.semester);
            $('#text-level').html(data.nama_level);
            $('#text-email').html(data.email);
            $('#modal-detail').modal('toggle');
          }
        }
      });
    }

    function updateData(nim) {
      $.ajax({
        type: "get",
        url: '<?= site_url('admin/mahasiswa/getSelectedData/')?>' + nim,
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
      $('#nim').prop('readonly', data ? true : false);
      $("#nim").val(data?.nim ?? '');
      $("#nama").val(data?.nama ?? '');
      $("#jenis_kelamin").val(data?.jenis_kelamin ?? '');
      $("#tanggal_lahir").val(data?.tanggal_lahir ?? '');
      $("#alamat").val(data?.alamat ?? '');
      $("#program_studi").val(data?.program_studi ?? '');
      $("#semester").val(data?.semester ?? '');
      $("#email").val(data?.email ?? '');
      $("#kd_level").val(data?.kd_level ?? '');
      $('#add-title').html((data ? 'Ubah' : 'Tambah') + ' Mahasiswa');
      $('#saveButton').html((data ? 'Ubah' : 'Simpan') + ' Data');
      $('.errorNIM').html('');
      $('#nim').removeClass('is-invalid');
      $('.errorNama').html('');
      $('#nama').removeClass('is-invalid');
      $('.errorJK').html('');
      $('#jenis_kelamin').removeClass('is-invalid');
      $('.errorTL').html('');
      $('#tanggal_lahir').removeClass('is-invalid');
      $('.errorTL').css({"display": "none"})
      $('.errorAlamat').html('');
      $('#alamat').removeClass('is-invalid');
      $('.errorProdi').html('');
      $('#program_studi').removeClass('is-invalid');
      $('.errorSem').html('');
      $('#semester').removeClass('is-invalid');
      $('.errorEmail').html('');
      $('#email').removeClass('is-invalid');
      $('.errorLevel').html('');
      $('#kd_level').removeClass('is-invalid');
      $('#modal-add').modal('toggle');
    }

    function deleteData(nim) {
      Swal.fire({
        title: "Hapus Data Mahasiswa",
        text: "Apakah anda akan menghapus mahasiswa dengan nim: " + nim + "?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "delete",
            url: "<?= site_url('admin/mahasiswa/delete/') ?>" + nim,
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
                  $('#dataMhs').DataTable().ajax.reload();
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