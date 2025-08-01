<aside id="sidebar" class="js-sidebar" style="background-color: #3a001e;">
    <!-- Content For Sidebar -->
    <div class="h-200">
        <div class="sidebar-logo mt-3">
            <img src="img/logotipo/logotipo-mini.png" class="w-25">
        </div>
        <ul class="sidebar-nav">

            <div class="sidebar-header text-secondary mb-2">
                Herramientas de <?php if ($_SESSION['rol'] == 1) {
                                    echo 'Administrador';
                                } else if ($_SESSION['rol'] == 2) {
                                    echo 'Operador';
                                } else {
                                    echo 'Asesor';
                                }
                                ?>
            </div>
            

            <li <?php echo ($view === 'inicio') ? 'class="sidebar-active-link"' : ''; ?>>
                <a href="dashboard.php?view=inicio" class="sidebar-link">
                    <i class="fa-solid fa-house pe-2"></i>
                    Inicio
                </a>
            </li>

            <?php if ($_SESSION['rol'] === '1' || $_SESSION['rol'] === '3') { ?>
                <li <?php echo ($view === 'gestionar') ? 'class="sidebar-active-link"' : ''; ?>>
                    <a href="dashboard.php?view=gestionar" class="sidebar-link">
                        <i class="fa-solid fa-file-lines pe-2"></i>
                        Gestionar
                    </a>
                </li>
                <li <?php echo ($view === 'consultas') ? 'class="sidebar-active-link"' : ''; ?>>
                    <a href="dashboard.php?view=consultas" class="sidebar-link">
                        <i class="fa-solid fa-list-check pe-2"></i>
                        Consultas
                    </a>
                </li>

                <li class="sidebar-item-ventas">
                    <a href="#" class="sidebar-link collapsed" data-bs-target="#posts_ventas" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-cash-register pe-2"></i> Ventas
                    </a>
                    <ul id="posts_ventas" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar-item-ventas">
                        <li <?php echo ($view === 'proceso_ventas') ? 'class="sidebar-active-link"' : ''; ?>>
                            <a href="dashboard.php?view=proceso_ventas" class="sidebar-link">En proceso</a>
                        </li>
                        <?php if ($_SESSION['rol'] !== '3') { ?>
                            <li <?php echo ($view === 'gestion_ventas') ? 'class="sidebar-active-link"' : ''; ?>>
                            <a href="dashboard.php?view=gestion_ventas" class="sidebar-link">En gestión</a>
                        </li>
                        <?php }  ?>
                        
                        <li>
                            <a href="#" class="sidebar-link collapsed" data-bs-target="#submenu_desembolsado" data-bs-toggle="collapse" aria-expanded="false">
                                Desembolsado
                            </a>
                            <ul id="submenu_desembolsado" class="sidebar-dropdown list-unstyled collapse">
                                <li <?php echo ($view === 'ventas') ? 'class="sidebar-active-link"' : ''; ?>>
                                    <a href="dashboard.php?view=ventas" class="sidebar-link ps-4">Total de Desembolsados</a>
                                </li>
                                <li <?php echo ($view === 'misventas') ? 'class="sidebar-active-link"' : ''; ?>>
                                    <a href="dashboard.php?view=misventas" class="sidebar-link ps-4">Mis Desembolsados</a>
                                </li>
                            </ul>
                        </li>
                        <li <?php echo ($view === 'archivado_ventas') ? 'class="sidebar-active-link"' : ''; ?>>
                            <a href="dashboard.php?view=archivado_ventas" class="sidebar-link">Archivados</a>
                        </li>
                    </ul>
                </li>

                <li <?php echo ($view === 'cartera') ? 'class="sidebar-active-link"' : ''; ?>>
                    <a href="dashboard.php?view=cartera" class="sidebar-link">
                        <i class="fa-solid fa-wallet pe-2"></i>
                        Cartera
                    </a>
                </li>

            <?php } ?>

            <?php if ($_SESSION['rol'] === '2') { ?>
                <li <?php echo ($view === 'gestionar') ? 'class="sidebar-active-link"' : ''; ?>>
                    <a href="dashboard.php?view=gestionar" class="sidebar-link">
                        <i class="fa-solid fa-database pe-2"></i>
                        Base
                    </a>
                </li>
            <?php }  ?>

            <?php if ($_SESSION['rol'] === '1') { ?>
                <li <?php echo ($view === 'usuarios') ? 'class="sidebar-active-link"' : ''; ?>>
                    <a href="dashboard.php?view=usuarios" class="sidebar-link">
                        <i class="fa-solid fa-users pe-2"></i>
                        Usuarios
                    </a>
                </li>
            <?php }  ?>

            <?php if ($_SESSION['rol'] === '2' || $_SESSION['rol'] === '1') { ?>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-target="#posts" data-bs-toggle="collapse" aria-expanded="false"><i class="fa-solid fa-bullseye pe-2"></i>
                        Metas
                    </a>
                    <ul id="posts" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <?php if ($_SESSION['rol'] === '1') { ?>
                            <li <?php echo ($view === 'metas') ? 'class="sidebar-active-link"' : ''; ?>>
                                <a href="dashboard.php?view=metas" class="sidebar-link">Individual</a>
                            </li>
                        <?php }  ?>
                        <?php if ($_SESSION['rol'] === '2') { ?>
                            <li <?php echo ($view === 'metasfv') ? 'class="sidebar-active-link"' : ''; ?>>
                                <a href="dashboard.php?view=metasfv" class="sidebar-link">Fuerza de Ventas</a>
                            </li>
                        <?php }  ?>
                    </ul>
                </li>
            <?php }  ?>




        </ul>
    </div>
</aside>