<?= $this->extend('main/layout') ?>
<?= $this->section('title') ?>
Form Edit Mata Kuliah
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <div class="card">
    <div class="card-header">
      <button type="button" class="btn btn-info" onclick="window.location='/admin/mata-kuliah/index'">
        <i class="fas fa-arrow-left"></i> Kembali
      </button>
    </div>
    <div class="card-body">
      <?= (session()->getFlashdata('msg')) ? session()->getFlashdata('msg') : '' ?>
      <?= form_open('admin/mata-kuliah/update') ?>
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group row">
          <label for="" class="col-sm-2 col-form-label">Kode Mata Kuliah</label>
          <div class="col-sm-6">
            <input readonly type="text" maxlength="5" class="form-control" name="kd_mk" value="<?= $kd_mk ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="" class="col-sm-2 col-form-label">Nama Mata Kuliah</label>
          <div class="col-sm-6">
            <input type="text" maxlength="100" class="form-control
            <?= (session()->getFlashdata('errorNamaMk')) ? 'is-invalid' : '' ?>
            " name="nama_mk" placeholder="Masukkan Nama Mata Kuliah" value="<?= $nama_mk ?>">
            <?= (session()->getFlashdata('errorNamaMk')) ? "<div class='invalid-feedback'>" . session()->getFlashData('errorNamaMk') . "</div>" : ''; ?>
          </div>
        </div>
        <div class="form-group row">
          <label for="" class="col-sm-2 col-form-label">Jumlah SKS</label>
          <div class="col-sm-6">
            <input type="number" pattern="\d*" maxlength="2" class="form-control
            <?= (session()->getFlashdata('errorSKS')) ? 'is-invalid' : '' ?>
            " name="sks" placeholder="Masukkan Jumlah SKS" value="<?= $sks ?>">
            <?= (session()->getFlashdata('errorSKS')) ? "<div class='invalid-feedback'>" . session()->getFlashData('errorSKS') . "</div>" : ''; ?>
          </div>
        </div>
        <div class="form-group row">
          <label for="" class="col-sm-2 col-form-label"></label>
          <div class="col-sm-6">
            <button type="submit" class="btn btn-success">
              <i class="fas fa-edit"></i> Update
            </button>
          </div>
        </div>
      <?= form_close() ?>
    </div>
  </div>
<?= $this->endSection() ?>