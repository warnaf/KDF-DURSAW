  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="/home">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Menu Master</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a class="{{ Request::is('kelas*') ? 'active' : '' }}" href="/kelas">
              <i class="bi bi-circle"></i><span>Menu Kelas</span>
            </a>
          </li>
          <li>
            <a class="{{ Request::is('department*') ? 'active' : '' }}" href="/department">
              <i class="bi bi-circle"></i><span>Menu Department</span>
            </a>
          </li>
          <li>
            <a class="{{ Request::is('guru*') ? 'active' : '' }}" href="/guru">
              <i class="bi bi-circle"></i><span>Menu Guru</span>
            </a>
          </li>
          <li>
            <a class="{{ Request::is('matpel*') ? 'active' : '' }}" href="/matpel">
              <i class="bi bi-circle"></i><span>Menu Mata Pelajaran</span>
            </a>
          </li>
          <li>
            <a class="{{ Request::is('detailMatpel*') ? 'active' : '' }}" href="/detailMatpel">
              <i class="bi bi-circle"></i><span>Menu Detail Pelajaran</span>
            </a>
          </li>
          <li>
            <a class="{{ Request::is('mengajar*') ? 'active' : '' }}" href="/mengajar">
              <i class="bi bi-circle"></i><span>Menu Mengajar</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Generate</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="tables-general.html">
              <i class="bi bi-circle"></i><span>General Tables</span>
            </a>
          </li>
          <li>
            <a href="tables-data.html">
              <i class="bi bi-circle"></i><span>Data Tables</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-contact.html">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-register.html">
          <i class="bi bi-card-list"></i>
          <span>Register</span>
        </a>
      </li><!-- End Register Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  