<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GlamConnect Shops</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />
    <style>
:root {
  --color-primary: #ff7f85;
  --color-secondary: #e1575a;
  --color-accent: #ed6a6a;
  --color-headings: #e48286;
  --color-body: #918ca4;
  --color-body-darker: #5c5577;
  --color-border: #ccc;
  --border-radius: 30px;
}
.shop--name {
  color: var(--color-headings);
  font-size: 2rem;
  margin-bottom: 1rem;
    text-align: center; /* Center the shop names */
  font-weight: 700;
}

/* Optional improvement: Add consistent spacing above and below each shop section */
.shop-section {
  margin-top: 3rem;
  margin-bottom: 3rem;
}

.fw-bold {
  font-weight: 700;
  color: var(--color-accent);
}
.lead{
  font-size: 1.25rem;
  color: var(--color-body);
}
/* Make images responsive and styled */
.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: var(--border-radius);
  border: #e48286;
}

.card{
   border-radius: 30px;
   border: solid 1px #e48286;
}

/* Button styling */
.add-to-cart-btn {
  display: block;
  margin: 1rem auto 0 auto; /* top margin for spacing, auto for horizontal center */
  background-color: var(--color-primary);
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  transition: background-color 0.3s ease;
}

.add-to-cart-btn:hover {
  background-color: var(--color-secondary);
}

.add-to-cart-btn.clicked {
  background-color: var(--color-accent);
}

/* Responsive card text layout */
.card-text-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Responsive images */
.image-container {
  height: 300px;
  overflow: hidden;
  border:rgb(252, 207, 209);
 background-color:rgb(252, 211, 212);
  border-radius: var(--border-radius);
}

/* Optional: Make cards stack nicely on smaller screens */
@media (max-width: 768px) {
  .image-container {
    height: 250px;
  }
}

.extra-text {
  color:rgb(244, 95, 95);
  font-size: 1rem;
  margin-left: 1rem;
  font-weight: 500;
}

.custom-btn {
  background-color: var(--color-accent);
  color: white;
  border-radius: 30px;
  padding: 10px 20px;
  font-weight: 600;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.custom-btn:hover {
  background-color: var(--color-secondary);
  transform: translateY(-2px);
  color: white;
} 

.sold-badge {
  background: #e1575a;
  color: #fff;
  font-weight: bold;
  padding: 0.4em 1em;
  border-radius: 20px;
  font-size: 1rem;
  letter-spacing: 1px;
  z-index: 2;
  box-shadow: 0 2px 8px #e1575a33;
}
  </style>
  </head>
  <body>
  <div class="container my-4">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-3">
    <!-- Back to Home Button -->
    <div class="mb-3 mb-md-0 order-1 order-md-1">
      <a href="index.php" class="btn custom-btn">
        &larr; Back to Home
      </a>
    </div>
    <!-- Heading and Subtitle Centered -->
    <div class="text-center flex-grow-1 mb-3 mb-md-0 order-3 order-md-2">
      <h1 class="fw-bold mb-2">Explore GlamConnect Shops</h1>
      <p class="lead mb-0">
        Your one-stop marketplace for beauty, fashion, and décor
      </p>
    </div>
    <!-- Go to Cart Button -->
    <div class="mb-3 mb-md-0 order-2 order-md-3">
      <a href="cart.php" class="btn custom-btn">
        Go to Cart &rarr;
      </a>
    </div>
  </div>
</div>

    <!-- Shop Sections -->
    <div class="container mb-5">
      <?php
require_once('config.php');
$shops = $connection->query("SELECT * FROM shops WHERE active=1")->fetchAll(PDO::FETCH_ASSOC);
?>
<?php foreach ($shops as $shop): ?>
  <section class="shop-section">
    <h2 class="shop--name"><?= htmlspecialchars($shop['name']) ?></h2>
    <p class="lead"><?= htmlspecialchars($shop['description']) ?></p>
    <div class="row g-4">
      <?php
      $products = $connection->prepare("SELECT * FROM products WHERE shop_id=?");
      $products->execute([$shop['id']]);
      foreach ($products as $product):
      ?>
      <div class="col-md-4">
        <div class="card block-image position-relative">
          <?php if ($product['stock_quantity'] == 0): ?>
            <span class="sold-badge position-absolute top-0 end-0 m-2">SOLD</span>
          <?php endif; ?>
          <div class="image-container position-relative" style="height: 300px">
            <img src="<?= htmlspecialchars($product['image']) ?>" class="lazy-image lazy-image-loaded" alt="<?= htmlspecialchars($product['name']) ?>" />
          </div>
          <div class="card-body">
            <div class="card-text-container">
              <p class="card-text fw-bold">R<?= htmlspecialchars($product['price']) ?></p>
              <span class="extra-text"><?= htmlspecialchars($product['name']) ?></span>
              <span class="extra-text">
                <?= ($product['stock_quantity'] > 0) ? $product['stock_quantity'] . ' in stock' : 'Out of Stock' ?>
              </span>
            </div>
            <?php if ($product['stock_quantity'] > 0): ?>
              <form method="post" action="add_to_cart.php" style="text-align:center;">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="shop_id" value="<?= $product['shop_id'] ?>">
                <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                <input type="hidden" name="price" value="<?= htmlspecialchars($product['price']) ?>">
                <input type="hidden" name="image" value="<?= htmlspecialchars($product['image']) ?>">
                <button type="submit" class="add-to-cart-btn">Add to Cart</button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>
<?php endforeach; ?>
    </div>
<script>
  document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function () {
      this.classList.toggle('clicked');
    });
  });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
<?php
// $connection->prepare("UPDATE products SET in_stock = 0 WHERE id = ?")->execute([$item['product_id']]);
?>
