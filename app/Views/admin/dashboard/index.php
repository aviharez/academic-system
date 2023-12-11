<?= $this->extend('main/layout') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="alert alert-primary">
    Selamat Datang <?= session()->get('namauser') ?>
</div>
<?= $this->endSection() ?>