<?php  if (!isset($_SESSION)) session_start(); ?>
<?php require_once('php/LayoutBuilder.php'); ?>
<?php require_once('php/Book.php'); ?>
<?php require_once('php/Buy.php'); ?>

<?php Buy::process_request(); ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <?php LayoutBuilder::get_styles(); ?>
    <title>Hello, world!</title>
  </head>
  <body>
    <?php LayoutBuilder::get_the_nav('home'); ?>
    
    <main class="container">
      <div class="row">
      <?php foreach(Book::get_all() as $book): ?>
      <div class="col-12 col-lg-4">
      <div class="card mb-3">
        <img src="<?= $book->image?>" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title"><?= $book->title ?></h5>
          <p class="card-text"><?= $book->sinopsis ?></p>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><b>ISBN: </b><?= $book->isbn ?></li>
          <li class="list-group-item"><b>Price: </b><?= $book->price ?>€</li>
          <li class="list-group-item"><b>Stock: </b><?= $book->stock ?></li>
        </ul>
        <div class="card-body">
          <?php if(isset($_SESSION['customer'])): ?>
          <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="row">
              <div class="col"><input type="number" value="1" min="1" max="<?= $book->stock ?>" name="amount" class="form-control"></div>
              <div class="col"><button class="btn btn-primary w-100">Buy</button></div>
            </div>
            <input type="hidden" name="id" value="<?= $book->id ?>">
          </form>
          <?php else: ?>
          <a class="btn btn-primary" href="customer.php">Login to buy</a>
          <?php endif; ?>
        </div>
      </div>
      </div>
      <?php endforeach ?>
      </div>
    </main>   
        
 
    <?php LayoutBuilder::get_the_footer(); ?>
    <?php LayoutBuilder::get_scripts(); ?>

  </body>
</html>