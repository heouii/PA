<?php session_start(); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Album example · Bootstrap v5.0</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <style>
      .card {
        height: 100%;
      }
      .card-img {
        height: 200px;
        object-fit: cover;
      }
    </style>
  </head>
  <body>
    <header>
      <?php include('include/header.php'); ?>
    </header>

    <main>
      <div class="album py-5 bg-light">
        <div class="container">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 card-height">
            <?php
              try {
                $pdo = new PDO('mysql:host=localhost;port=3306;dbname=projet_annuel', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
              } catch (Exception $e) {
                die($e->getMessage());
              }

              $bdd = $pdo->query('SELECT * FROM produits')->fetchAll(PDO::FETCH_ASSOC);

              foreach ($bdd as $produit) {
            ?>
            <div class="col">
              <div class="card shadow-sm">
                <h3><?php echo $produit['nom'] ?></h3>
                <a href="product.php?id=<?php echo $produit['id']; ?>">
                  <img src="admin/<?php echo $produit['image'] ?>" class="card-img" alt="Image du produit">
                </a>

                <div class="card-body">
                  <form action="panier.php" method="post">
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="btn-group">
                        <button type="submit" name="id" value="<?php echo $produit['id']; ?>" class="btn btn-sm btn-success" onclick="return confirmPurchase()">Ajouter au panier</button>
                      </div>
                      <small class="text" style="font-weight: bold;"><?php echo $produit['prix'] ?>€</small>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5Voici le reste de votre code avec le JavaScript pour la confirmation d'achat (suite du précédent message qui a été coupé) :

```html
.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    function confirmPurchase() {
        <?php
            if(!isset($_SESSION['alert_shown'])){
                echo '$_SESSION["alert_shown"] = true;';
        ?>
            Swal.fire({
                title: 'Confirmer l\'achat',
                text: "Voulez-vous continuer vos achats ou aller directement au panier?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continuer',
                cancelButtonText: 'Aller au panier'
            }).then((result) => {
                if (!result.isConfirmed) {
                    window.location.href = "index.php";
                }
            });
        <?php
            } else {
                echo 'window.location.href = "index.php";';
            }
        ?>
        return false;
    }
</script>

  </body>
</html>
