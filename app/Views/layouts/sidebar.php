<nav id="sidebar" class="sidebar">
  <div class="sidebar-content js-simplebar">
    <a class="sidebar-brand" href="/">
      <span class="align-middle">MYAPP</span>
    </a>

    <ul class="sidebar-nav">
      <li class="sidebar-header">
        Menu
      </li>

      <li class="sidebar-item <?= service('uri')->getSegment(1) == 'home' || service('uri')->getSegment(1) == '' ? 'active' : '';  ?>">
        <a class="sidebar-link" href="/">
          <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
        </a>
      </li>

      <li class="sidebar-item <?= isset($title) && $title == 'Data' ? 'active' : '' ?>">
        <a class="sidebar-link" href="/data">
          <ion-icon name="server-outline" class="align-middle mr-3"></ion-icon> <span class="align-middle">Data</span>
        </a>
      </li>

      <li class="sidebar-item <?= isset($title) && $title == 'RFM' ? 'active' : '' ?>">
        <a class="sidebar-link" href="/rfm">
          <!-- <i class="align-middle" data-feather="user"></i>  -->
          <i class="fas fa-calculator align-middle mr-3"></i>
          <span class="align-middle">RFM</span>
        </a>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link" href="pages-settings.html">
          <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Settings</span>
        </a>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link" href="pages-invoice.html">
          <i class="align-middle" data-feather="credit-card"></i> <span class="align-middle">Invoice</span>
        </a>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link" href="pages-blank.html">
          <i class="align-middle" data-feather="book"></i> <span class="align-middle">Blank</span>
        </a>
      </li>

      <!-- <li class="sidebar-header">
        Tools & Components
      </li>
      <li class="sidebar-item">
        <a href="#ui" data-toggle="collapse" class="sidebar-link collapsed">
          <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">UI Elements</span>
        </a>
        <ul id="ui" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
          <li class="sidebar-item"><a class="sidebar-link" href="ui-alerts.html">Alerts</a></li>
          <li class="sidebar-item"><a class="sidebar-link" href="ui-buttons.html">Buttons</a></li>
          <li class="sidebar-item"><a class="sidebar-link" href="ui-cards.html">Cards</a></li>
          <li class="sidebar-item"><a class="sidebar-link" href="ui-general.html">General</a></li>
          <li class="sidebar-item"><a class="sidebar-link" href="ui-grid.html">Grid</a></li>
          <li class="sidebar-item"><a class="sidebar-link" href="ui-modals.html">Modals</a></li>
          <li class="sidebar-item"><a class="sidebar-link" href="ui-typography.html">Typography</a></li>
        </ul>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link" href="icons-feather.html">
          <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Icons</span>
        </a>
      </li>

      <li class="sidebar-item">
        <a href="#forms" data-toggle="collapse" class="sidebar-link collapsed">
          <i class="align-middle" data-feather="check-circle"></i> <span class="align-middle">Forms</span>
        </a>
        <ul id="forms" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
          <li class="sidebar-item"><a class="sidebar-link" href="forms-layouts.html">Form Layouts</a></li>
          <li class="sidebar-item"><a class="sidebar-link" href="forms-basic-inputs.html">Basic Inputs</a></li>
        </ul>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link" href="tables-bootstrap.html">
          <i class="align-middle" data-feather="list"></i> <span class="align-middle">Tables</span>
        </a>
      </li> -->
      <!--

      <li class="sidebar-header">
        Plugins & Addons
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link" href="charts-chartjs.html">
          <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Charts</span>
        </a>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link" href="maps-google.html">
          <i class="align-middle" data-feather="map"></i> <span class="align-middle">Maps</span>
        </a>
      </li> -->
    </ul>

    <!-- <div class="sidebar-cta">
      <div class="sidebar-cta-content">
        <strong class="d-inline-block mb-2">Upgrade to Pro</strong>
        <div class="mb-3 text-sm">
          Are you looking for more components?
        </div>
        <a href="https://kit.io/pricing" target="_blank" class="btn btn-outline-primary btn-block">Upgrade</a>
      </div>
    </div> -->
  </div>
</nav>