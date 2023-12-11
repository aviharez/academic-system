<?= $this->extend('main/layout') ?>
<?= $this->section('title') ?>
Data KRS
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <div class="card">
    <div class="card-header">
      <button type="button" class="btn btn-primary" onclick="showModal()">
        <i class="fas fa-plus-circle"></i> Tambah Data
      </button>
    </div>
    <div class="card-body">
      <table class="table table-sm table-stripped table-bordered" style="width: 100%;" id="dataKrs">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode KRS</th>
            <th>Mata Kuliah</th>
            <th>Dosen</th>
            <th>Jumlah SKS</th>
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
          <?= form_open('admin/krs/save', [
            'id' => 'formKrs'
          ]) ?>
            <input type="hidden" name="_method" id="method" value="POST">
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Kode KRS</label>
              <div class="col-sm-8">
                <input type="text" maxlength="7" class="form-control" name="kd_krs" id="kd_krs" placeholder="Masukkan Kode KRS" autofocus>
                <div class='invalid-feedback errorKdKrs'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Mata Kuliah</label>
              <div class="col-sm-8">
                <select class="form-control" name="kd_mk" id="kd_mk">
                  <option value="">Pilih Data</option>
                </select>
                <div class='invalid-feedback errorKdMk'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Dosen</label>
              <div class="col-sm-8">
                <select class="form-control" name="nip" id="nip">
                  <option value="">Pilih Data</option>
                </select>
                <div class='invalid-feedback errorNIP'></div>
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
              <label for="" class="col-sm-4 col-form-label">Tahun Ajaran</label>
              <div class="col-sm-8">
                <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==4) return false;" class="form-control" name="thn_ajaran" id="thn_ajaran" placeholder="Masukkan Tahun Ajaran">
                <div class='invalid-feedback errorThn'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Hari</label>
              <div class="col-sm-8">
                <input type="text" maxlength="7" class="form-control" name="hari" id="hari" placeholder="Masukkan Hari">
                <div class='invalid-feedback errorHari'></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Jam</label>
              <div class="col-sm-8">
                <div class="input-group date" id="time" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" data-target="#time" name="jam" id="jam"/>
                  <div class="input-group-append" data-target="#jam" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-clock"></i></div>
                  </div>
                </div>
                <div class='invalid-feedback errorJam'></div>
              </div>
            </div>
          <?= form_close() ?>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="saveButton" value="submit" onclick="submitData()">Simpan Data</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail KRS</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <dl class="row">
            <dt class="col-sm-4">Kode KRS</dt>
            <dd class="col-sm-8" id="text-kd_krs"></dd>
            <dt class="col-sm-4">Mata Kuliah</dt>
            <dd class="col-sm-8" id="text-kd_mk"></dd>
            <dt class="col-sm-4">Dosen</dt>
            <dd class="col-sm-8" id="text-dosen"></dd>
            <dt class="col-sm-4">Semester</dt>
            <dd class="col-sm-8" id="text-sem"></dd>
            <dt class="col-sm-4">Tahun Ajaran</dt>
            <dd class="col-sm-8" id="text-thn"></dd>
            <dt class="col-sm-4">Jumlah SKS</dt>
            <dd class="col-sm-8" id="text-sks"></dd>
            <dt class="col-sm-4">Hari</dt>
            <dd class="col-sm-8" id="text-hari"></dd>
            <dt class="col-sm-4">Jam</dt>
            <dd class="col-sm-8" id="text-jam"></dd>
            <dt class="col-sm-4">Harga</dt>
            <dd class="col-sm-8" id="text-harga"></dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      $('#dataKrs').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= site_url('admin/krs/getData') ?>',
        order: [],
        columns: [
            {data: 'no'},
            {data: 'kd_krs'},
            {data: 'nama_mk'},
            {data: 'nama'},
            {data: 'sks'},
            {data: 'action'}
        ],
        columnDefs: [
            { targets: 0, orderable: false},
            { targets: -1, orderable: false }
        ]
      });

      $.ajax({
        type: "get",
        url: "<?= site_url('admin/krs/getAllMatkulData') ?>",
        dataType: "json",
        success: function (response) {
          $.each(response.data, function (i, item) {
              $('#kd_mk').append($('<option>', { 
                  value: item.kd_mk,
                  text : item.nama_mk 
              }));
          });
        },
        error: function(e) {
            alert(e.responseText);
        }
      });

      $.ajax({
        type: "get",
        url: "<?= site_url('admin/krs/getAllDosenData') ?>",
        dataType: "json",
        success: function (response) {
          $.each(response.data, function (i, item) {
              $('#nip').append($('<option>', { 
                  value: item.nip,
                  text : item.nama 
              }));
          });
        },
        error: function(e) {
            alert(e.responseText);
        }
      });
    });

    $(function() {
      $('#formKrs').submit(function (e) {
        e.preventDefault();
        let isNewData = $('#method').val() === 'POST';
        $.ajax({
          type: 'post',
          url: isNewData ? $(this).attr('action') : '<?= site_url('admin/krs/update') ?>',
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

              $('.errorKdKrs').html(err.errorKdKrs ?? '');
              if (err.errorKdKrs) {
                $('#kd_krs').addClass('is-invalid');
              } else {
                $('#kd_krs').removeClass('is-invalid');
              }
              $('.errorKdMk').html(err.errorKdMk ?? '');
              if (err.errorKdMk) {
                $('#kd_mk').addClass('is-invalid');
              } else {
                $('#kd_mk').removeClass('is-invalid');
              }
              $('.errorNIP').html(err.errorNIP ?? '');
              if (err.errorNIP) {
                $('#nip').addClass('is-invalid');
              } else {
                $('#nip').removeClass('is-invalid');
              }
              $('.errorJam').html(err.errorJam ?? '');
              if (err.errorJam) {
                $('#jam').addClass('is-invalid');
                $('.errorJam').css({"display": "block"})
              } else {
                $('#jam').removeClass('is-invalid');
                $('.errorJam').css({"display": "none"})
              }
              $('.errorThn').html(err.errorThn ?? '');
              if (err.errorThn) {
                $('#thn_ajaran').addClass('is-invalid');
              } else {
                $('#thn_ajaran').removeClass('is-invalid');
              }
              $('.errorSem').html(err.errorSem ?? '');
              if (err.errorSem) {
                $('#semester').addClass('is-invalid');
              } else {
                $('#semester').removeClass('is-invalid');
              }
              $('.errorHari').html(err.errorHari ?? '');
              if (err.errorHari) {
                $('#hari').addClass('is-invalid');
              } else {
                $('#hari').removeClass('is-invalid');
              }
            } else {
              toastr.success(response.success);
              $('#modal-add').modal('toggle');
              $('#dataKrs').DataTable().ajax.reload();
            }
          },
          error: function(e) {
            alert(e.responseText);
          }
        });
        return false;
      });

      //Date picker
      $('#time').datetimepicker({
          format: 'LT'
      });
    });

    function submitData() {
      $("#formKrs").submit();
    }

    function showDetail(kd_krs) {
      $.ajax({
        type: "get",
        url: '<?= site_url('admin/krs/getSelectedData/')?>' + kd_krs,
        dataType: "json",
        success: function (response) {
          if (response.data) {
            let data = response.data;
            $('#text-kd_krs').html(data.kd_krs);
            $('#text-kd_mk').html(data.nama_mk);
            $('#text-dosen').html(data.nama_dosen);
            $('#text-thn').html(data.thn_ajaran);
            $('#text-sks').html(data.sks);
            $('#text-hari').html(data.hari);
            $('#text-sem').html(data.semester);
            $('#text-harga').html(data.harga);
            $('#text-jam').html(data.jam);
            $('#modal-detail').modal('toggle');
          }
        }
      });
    }

    function updateData(kd_krs) {
      $.ajax({
        type: "get",
        url: '<?= site_url('admin/krs/getSelectedData/')?>' + kd_krs,
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
      $('#kd_krs').prop('readonly', data ? true : false);
      $("#kd_krs").val(data?.kd_krs ?? '');
      $("#kd_mk").val(data?.kd_mk ?? '');
      $("#nip").val(data?.nip ?? '');
      $("#jam").val(data?.jam ?? '');
      $("#alamat").val(data?.alamat ?? '');
      $("#thn_ajaran").val(data?.thn_ajaran ?? '');
      $("#semester").val(data?.semester ?? '');
      $("#hari").val(data?.hari ?? '');
      $("#kd_level").val(data?.kd_level ?? '');
      $('#add-title').html((data ? 'Ubah' : 'Tambah') + ' KRS');
      $('#saveButton').html((data ? 'Ubah' : 'Simpan') + ' Data');
      $('.errorKdKrs').html('');
      $('#kd_krs').removeClass('is-invalid');
      $('.errorKdMk').html('');
      $('#kd_mk').removeClass('is-invalid');
      $('.errorNIP').html('');
      $('#nip').removeClass('is-invalid');
      $('.errorJam').html('');
      $('#jam').removeClass('is-invalid');
      $('.errorJam').css({"display": "none"})
      $('.errorAlamat').html('');
      $('#alamat').removeClass('is-invalid');
      $('.errorThn').html('');
      $('#thn_ajaran').removeClass('is-invalid');
      $('.errorSem').html('');
      $('#semester').removeClass('is-invalid');
      $('.errorHari').html('');
      $('#hari').removeClass('is-invalid');
      $('.errorLevel').html('');
      $('#kd_level').removeClass('is-invalid');
      $('#modal-add').modal('toggle');
    }

    function deleteData(kd_krs) {
      Swal.fire({
        title: "Hapus Data krs",
        text: "Apakah anda akan menghapus krs dengan kd_krs: " + kd_krs + "?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "delete",
            url: "<?= site_url('admin/krs/delete/') ?>" + kd_krs,
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
                  $('#dataKrs').DataTable().ajax.reload();
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