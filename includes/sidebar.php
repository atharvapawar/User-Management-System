<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" aria-label="Main navigation">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <!-- Core Section -->
                <div class="sb-sidenav-menu-heading">Core</div>

                <!-- Dashboard Link -->
                <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'welcome.php') {
                                        echo 'active';
                                    } ?>" href="welcome.php" aria-label="Dashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <!-- Profile Link -->
                <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'profile.php') {
                                        echo 'active';
                                    } ?>" href="profile.php" aria-label="Profile">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Profile
                </a>

                <!-- Change Password Link -->
                <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'change-password.php') {
                                        echo 'active';
                                    } ?>" href="change-password.php" aria-label="Change Password">
                    <div class="sb-nav-link-icon"><i class="fas fa-key"></i></div>
                    Change Password
                </a>

                <!-- Logout Link -->
                <a class="nav-link" href="logout.php" aria-label="Sign Out">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                    Sign Out
                </a>
            </div>
        </div>
    </nav>
</div>