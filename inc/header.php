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
                <li><a class="nav-link" href="/register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a class="nav-link" href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
        </div>
    </div>
</nav>