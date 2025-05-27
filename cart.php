<?php
// cart.php

session_start();
$cart = $_SESSION['cart'] ?? [];
$total = 0;



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Your Cart - GlamConnect</title>
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
    body {
      font-family: 'Inter', 'Roboto', sans-serif;
      background: linear-gradient(to right, #fff6f7, #ffeaea);
      margin: 0;
      padding: 0;
    }
    .cart-container {
      max-width: 900px;
      margin: 3rem auto;
      background: #fff;
      border-radius: var(--border-radius);
      box-shadow: 0 4px 24px rgba(229, 87, 90, 0.08);
      padding: 2rem;
    }
    .cart-title {
      color: var(--color-headings);
      text-align: center;
      font-size: 2.5rem;
      margin-bottom: 2rem;
      font-weight: 700;
    }
    .cart-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 2rem;
    }
    .cart-table th, .cart-table td {
      padding: 1rem;
      text-align: left;
      border-bottom: 1px solid var(--color-border);
    }
    .cart-table th {
      color: var(--color-accent);
      font-size: 1.1rem;
      font-weight: 600;
    }
    .cart-table img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 16px;
      border: 1px solid var(--color-border);
    }
    .cart-total {
      text-align: right;
      font-size: 1.3rem;
      color: var(--color-secondary);
      font-weight: 700;
      margin-bottom: 2rem;
    }
    .cart-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .btn {
      background: var(--color-secondary);
      color: #fff;
      border: none;
      border-radius: 20px;
      padding: 0.7rem 2.5rem;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s;
      text-decoration: none;
      display: inline-block;
    }
    .btn:hover {
      background: var(--color-accent);
    }
    .empty-cart {
      text-align: center;
      color: var(--color-body-darker);
      font-size: 1.2rem;
      margin: 3rem 0;
    }
    .remove-btn {
      background: transparent;
      color: var(--color-secondary);
      border: none;
      font-size: 1.2rem;
      cursor: pointer;
      font-weight: bold;
    }
    @media (max-width: 600px) {
      .cart-table th, .cart-table td { padding: 0.5rem; }
      .cart-table img { width: 50px; height: 50px; }
      .cart-container { padding: 1rem; }
    }
  </style>
</head>
<body>
  <div class="cart-container">
    <h1 class="cart-title">Your Cart</h1>
    <?php if (empty($cart)): ?>
      <div class="empty-cart">Your cart is empty. <a href="shop.php" class="btn">Shop Now</a></div>
    <?php else: ?>
      <table class="cart-table">
        <thead>
          <tr>
            <th>Product</th>
            <th>Name</th>
            <th>Price</th>
            <th>Remove</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($cart as $index => $item): 
          $total += $item['price'];
        ?>
          <tr>
            <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
            <td><?php echo htmlspecialchars($item['name']); ?></td>
            <td>R<?php echo number_format($item['price'], 2); ?></td>
            <td>
              <form method="post" action="cart.php" style="display:inline;">
                <input type="hidden" name="remove" value="<?php echo $index; ?>">
                <button type="submit" class="remove-btn" title="Remove">&times;</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <div class="cart-total">Total: R<?php echo number_format($total, 2); ?></div>
      <div class="cart-actions">
        <a href="shop.php" class="btn">&larr; Continue Shopping</a>
        <a href="checkout.php" class="btn">Checkout</a>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
<?php
// Remove item from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $removeIndex = (int)$_POST['remove'];
    if (isset($_SESSION['cart'][$removeIndex])) {
        array_splice($_SESSION['cart'], $removeIndex, 1);
    }
    header('Location: cart.php');
    exit;
}
?>