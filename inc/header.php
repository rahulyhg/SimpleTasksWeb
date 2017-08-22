<?php
/**
 * Author: Kyle Stankovich
 * Date: 8/21/17
 * Time: 1:53 AM
 */
?>

<nav id="mainNav" class="navbar navbar-inverse">
    <div class="container">
        <a style="margin: 0; padding: 0; z-index: 2" class="navbar-brand" href="/">
            <img class="img-responsive" src="../favicon.png" width="100" height="100" alt="SimpleTasks Logo">
        </a>

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><?= $appName; ?></a>
        </div>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right">
                <?php if(isAuthenticated()): ?>
                    <li><a class="nav-link" href="/account.php">My Account</a></li>
                    <?php if(getCurrentUser()['role_id'] == 1): ?>
                        <li><a class="nav-link" href="/admin.php">Admin</a></li>
                    <?php endif; ?>
                    <li><a class="nav-link" href="/procedures/logoutUser.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                <?php else: ?>
                    <li><a class="nav-link" href="/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <li><a class="nav-link" href="/register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>