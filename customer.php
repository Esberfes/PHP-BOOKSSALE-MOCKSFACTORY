<?php
if (!isset($_SESSION)) session_start();
require_once('php/LayoutBuilder.php');
require_once('php/Login.php'); 
require_once('php/CustomerArea.php'); 
Login::process_request(); 
$customer_data = CustomerArea::get_customer_sale_data();
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <?php LayoutBuilder::get_styles(); ?>
    <title>Customer</title>
  </head>
  <body>
    <?php LayoutBuilder::get_the_nav('customer'); ?>
    
    <main class="container">
        <?php if(!isset($_SESSION['customer'])): ?>
        <form class="card" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
        <?php else: ?>
        <form class="card" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="card-body text-center">
                <button name="logout" type="submit" class="btn btn-primary">Logout</button>
            </div>
        </form>
       
        <table class="table mt-5">
            <thead>
                <tr>
                <th scope="col">Title</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
                <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($customer_data as $data): ?>
                <tr>
                    <td><?= $data->title ?></td>
                    <td><?= $data->amount ?> Ud.</td>
                    <td><?= $data->date ?></td>
                    <td><?= $data->price * $data->amount ?> €</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
       
        <?php endif; ?>
    </main>   
        
 
    <?php LayoutBuilder::get_the_footer(); ?>
    <?php LayoutBuilder::get_scripts(); ?>
  </body>
</html>