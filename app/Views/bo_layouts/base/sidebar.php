<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">AdminKit</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Tools & Components
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-buttons.html">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item active">
                <a class="sidebar-link" href="<?= site_url('panel/agenda') ?>">
                    <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Agenda</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= site_url('panel/news') ?>">
                    <i class="align-middle" data-feather="grid"></i> <span class="align-middle">News</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= site_url('panel/faq') ?>">
                    <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">FAQ</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= site_url('panel/ks') ?>">
                    <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Kerjasama</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= site_url('panel/staff') ?>">
                    <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Staff</span>
                </a>
            </li>

            <li class="sidebar-header">
                Plugins & Addons
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#multi" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-right-down align-middle">
                        <polyline points="10 15 15 20 20 15"></polyline>
                        <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                    </svg> <span class="align-middle">Multi Level</span>
                </a>
                <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar" style="">
                    <li class="sidebar-item">
                        <a data-bs-target="#multi-2" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">Two Levels</a>
                        <ul id="multi-2" class="sidebar-dropdown list-unstyled collapse">
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="#">Item 1</a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="#">Item 2</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#multi-3" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">Three Levels</a>
                        <ul id="multi-3" class="sidebar-dropdown list-unstyled collapse">
                            <li class="sidebar-item">
                                <a data-bs-target="#multi-3-1" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">Item 1</a>
                                <ul id="multi-3-1" class="sidebar-dropdown list-unstyled collapse">
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="#">Item 1</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="#">Item 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="#">Item 2</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</nav>