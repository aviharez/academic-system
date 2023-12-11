<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="<?= site_url(session()->idgroup == 1 ? 'admin' : (session()->idgroup == 2 ? 'dosen' : 'mahasiswa')).'/main/index' ?>" class="nav-link">
        <i class="nav-icon fas fa-columns"></i>
        <p>
          Dashboard
        </p>
      </a>
    </li>

    <?php if (session()->idgroup == 1) : ?>
      <li class="nav-header">Master Data</li>
      <li class="nav-item">
        <a href="<?= site_url('admin/mahasiswa/index') ?>" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Mahasiswa</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= site_url('admin/dosen/index') ?>" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Dosen</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= site_url('admin/mata-kuliah/index') ?>" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Mata Kuliah</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= site_url('admin/krs/index') ?>" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>KRS</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= site_url('admin/user/index') ?>" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>User</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= site_url('admin/level/index') ?>" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Level</p>
        </a>
      </li>

    <?php endif; ?>
  </ul>
</nav>