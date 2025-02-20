<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary d-print-none">

    <a class="pb-1 mt-1 brand-link" href="clients.php">
        <p class="h6"><i class="nav-icon fas fa-arrow-left ml-3 mr-2"></i>
            <span class="brand-text ">Back | <strong>Client Overview</strong>
        </p>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav>

            <ul class="nav nav-pills nav-sidebar flex-column mt-2" data-widget="treeview" data-accordion="false">

                <?php  if (lookupUserPermission("module_support") >= 1) { ?>
                    <li class="nav-item">
                        <a href="contacts.php" class="nav-link <?php if (basename($_SERVER["PHP_SELF"]) == "contacts.php" || basename($_SERVER["PHP_SELF"]) == "contact_details.php") { echo "active"; } ?>">
                            <i class="nav-icon fas fa-address-book"></i>
                            <p><strong>ALL</strong> Contacts</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="assets.php" class="nav-link <?php if (basename($_SERVER["PHP_SELF"]) == "assets.php") { echo "active"; } ?>">
                            <i class="nav-icon fas fa-desktop"></i>
                            <p><strong>ALL</strong> Assets</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="domains.php" class="nav-link <?php if (basename($_SERVER["PHP_SELF"]) == "domains.php") { echo "active"; } ?>">
                            <i class="nav-icon fas fa-globe"></i>
                            <p><strong>ALL</strong> Domains</p>
                        </a>
                    </li>
                <?php } ?>

            </ul>

        </nav>
        <!-- /.sidebar-menu -->

        <div class="sidebar-custom mb-3">

        </div>

    </div>
    <!-- /.sidebar -->
</aside>
