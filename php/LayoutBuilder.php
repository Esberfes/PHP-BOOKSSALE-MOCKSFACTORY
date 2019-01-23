<?php

class LayoutBuilder {

    public static function get_the_nav($current) {

        $active_home = $current == "home" ? "active" : "";
        $active_manager = $current == "manager" ? "active" : "";
        $active_customer = $current == "customer" ? "active" : "";
        ?>
            <nav class="navbar navbar-light bg-light mb-3">
                <a class="navbar-brand" href="index.php">
                    <img src="img/logo.png" height="60" class="d-inline-block align-top" alt="">
                </a>
                <?php if(isset($_SESSION['customer'])): 
                    $customer = $_SESSION['customer'];
                ?>
                    <h4>Welcome <?= $customer->firstname ?></h4>
                <?php endif; ?>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <hr>
                    <ul class="navbar-nav">
                        <li class="nav-item <?= $active_home ?>">
                            <a class="nav-link" href="index.php">Home <span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item <?= $active_customer ?>">
                            <a class="nav-link" href="customer.php">Customer Area</a>
                        </li>
                    </ul>
                </div>
            </nav>

        <?php
    }

    public static function get_the_footer() {
        ?>
        <footer class="mt-3">
            <img src="img/logo.png" height="60" class="d-inline-block align-top" alt="">
        </footer>
        <?php
    }

    public static function get_styles() {
        ?>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link rel="stylesheet" href="css/layout.css">
        <?php
    }

    public static function get_scripts() {
        ?>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <?php
    }
}