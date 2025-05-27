<?php
session_start();
require_once('config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header('Location: cart.php');
    exit;
}

// Group products by shop
$grouped = [];
foreach ($cart as $item) {
    $shop_id = $item['shop_id'];
    if (!isset($grouped[$shop_id])) $grouped[$shop_id] = [];
    $grouped[$shop_id][] = $item;
}

$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    $required_fields = [
        'firstName', 'lastName', 'email', 'address', 'country', 'province', 'zip',
        'paymentMethod', 'cc-name', 'cc-number', 'cc-expiration', 'cc-cvv', 'delivery_method'
    ];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst(str_replace('-', ' ', $field)) . " is required.";
        }
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email address is required.";
    }

    if (empty($errors)) {
        $payment_method = $_POST['paymentMethod'] ?? 'Card';
        $order_status = 'Pending';
        $delivery_method = $_POST['delivery_method'] ?? 'PostNet';

        // Set delivery cost based on method
        if ($delivery_method === 'Paxi') {
            $delivery_cost = 30;
        } elseif ($delivery_method === 'Aramex') {
            $delivery_cost = 120;
        } else {
            $delivery_cost = 0; // PostNet (Local)
        }

        foreach ($grouped as $shop_id => $items) {
            $total = 0;
            foreach ($items as $item) $total += $item['price'];
            $commission = round($total * 0.15, 2); // 15% commission

            $stmt = $connection->prepare("INSERT INTO orders (user_id, shop_id, total, payment_method, order_status, commission, delivery_method, delivery_cost) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_SESSION['user_id'],
                $shop_id,
                $total,
                $payment_method,
                $order_status,
                $commission,
                $delivery_method,
                $delivery_cost
            ]);
            $order_id = $connection->lastInsertId();

            foreach ($items as $item) {
                // Insert order item
                $stmt = $connection->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$order_id, $item['product_id'], $item['name'], $item['price'], 1]);

                // Decrease stock quantity by 1
                $connection->prepare("UPDATE products SET stock_quantity = stock_quantity - 1 WHERE id = ? AND stock_quantity > 0")->execute([$item['product_id']]);
            }
        }
        $_SESSION['cart'] = [];
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GlamConnect Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        font-family: 'Segoe UI', sans-serif;
        background-color: #fff0f1;
        color: var(--color-body-darker);
        padding: 2rem;
      }
      h4, h5 { color: var(--color-headings); }
      .form-control, .form-select {
        border-radius: var(--border-radius);
        border-color: var(--color-border);
      }
      .btn-primary {
        background-color: var(--color-primary);
        border-color: var(--color-secondary);
        border-radius: var(--border-radius);
        font-weight: 600;
      }
      .btn-primary:hover {
        background-color: var(--color-secondary);
        border-color: var(--color-accent);
      }
      .btn-home {
        background: #fff;
        color: var(--color-secondary);
        border-radius: var(--border-radius);
        font-weight: 600;
        border: 2px solid var(--color-secondary);
        transition: background 0.2s, color 0.2s;
        margin-bottom: 1rem;
      }
      .btn-home:hover {
        background: var(--color-secondary);
        color: #fff;
      }
      .checkout-card {
        border-radius: var(--border-radius);
        border: 1px solid var(--color-border);
        padding: 2rem;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      }
      .form-label { color: var(--color-body-darker); }
      .summary-total {
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--color-accent);
      }
      .success {
        color: green;
        font-size: 1.3rem;
        text-align: center;
        margin: 2rem 0;
      }
      .error-message {
        color: #fff;
        background: var(--color-secondary);
        border-radius: var(--border-radius);
        padding: 1rem;
        margin-bottom: 1rem;
        font-weight: 600;
        text-align: center;
      }
    </style>
</head>
<body>
<main class="container">
  <a href="index.php" class="btn btn-home">&larr; Home</a>
  <div class="row g-5">
    <!-- Billing Form -->
    <div class="col-md-7 col-lg-8">
      <div class="checkout-card">
        <?php if ($success): ?>
          <div class="success">Your order has been placed! We’ll be in touch soon regarding shipping details and order tracking.</div>
          <a href="shop.php" class="btn btn-primary w-100">Continue Shopping</a>
        <?php else: ?>
        <?php if (!empty($errors)): ?>
          <div class="error-message">
            <?php foreach ($errors as $error) echo htmlspecialchars($error) . "<br>"; ?>
          </div>
        <?php endif; ?>
        <h4 class="mb-3">Billing Information</h4>
        <form class="needs-validation" method="post" novalidate>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">First name</label>
              <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="col-sm-6">
              <label for="lastName" class="form-label">Last name</label>
              <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>
            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="col-md-5">
              <label for="country" class="form-label">Country</label>
              <select class="form-select" id="country" name="country" required>
                <option value="">Choose...</option>
                <option>South Africa</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="province" class="form-label">Province</label>
              <select class="form-select" id="province" name="province" required>
                <option value="">Choose...</option>
                <option>Gauteng</option>
                <option>Western Cape</option>
                <option>KwaZulu-Natal</option>
                <option>Eastern Cape</option>
                <option>Mpumalanga</option>
                <option>Limpopo</option>
                <option>Northern Cape</option>
                <option>Free State</option>
                <option>North West</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="zip" class="form-label">Postal code</label>
              <input type="text" class="form-control" id="zip" name="zip" required>
            </div>
          </div>
          <hr class="my-4">
          <h5 class="mb-3">Payment</h5>
          <div class="my-3">
            <div class="form-check">
              <input id="credit" name="paymentMethod" type="radio" value="Credit Card" class="form-check-input" checked required>
              <label class="form-check-label" for="credit">Credit card</label>
            </div>
            <div class="form-check">
              <input id="debit" name="paymentMethod" type="radio" value="Debit Card" class="form-check-input" required>
              <label class="form-check-label" for="debit">Debit card</label>
            </div>
            <div class="form-check">
              <input id="paypal" name="paymentMethod" type="radio" value="PayPal" class="form-check-input" required>
              <label class="form-check-label" for="paypal">PayPal</label>
            </div>
          </div>
          <div class="row gy-3">
            <div class="col-md-6">
              <label for="cc-name" class="form-label">Name on card</label>
              <input type="text" class="form-control" id="cc-name" name="cc-name" required>
            </div>
            <div class="col-md-6">
              <label for="cc-number" class="form-label">Card number</label>
              <input type="text" class="form-control" id="cc-number" name="cc-number" required>
            </div>
            <div class="col-md-3">
              <label for="cc-expiration" class="form-label">Expiration</label>
              <input type="text" class="form-control" id="cc-expiration" name="cc-expiration" required>
            </div>
            <div class="col-md-3">
              <label for="cc-cvv" class="form-label">CVV</label>
              <input type="text" class="form-control" id="cc-cvv" name="cc-cvv" required>
            </div>
          </div>
          <hr class="my-4">
          <!-- Delivery Method -->
          <h5 class="mb-3">Delivery Method</h5>
          <div class="mb-3">
            <select class="form-select" name="delivery_method" required>
              <option value="PostNet" selected>PostNet (Local) - R0</option>
              <option value="Paxi">Paxi (Provincial) - R30</option>
              <option value="Aramex">Aramex (International) - R120</option>
            </select>
          </div>
          <button class="btn btn-primary btn-lg w-100" type="submit">Place Order</button>
        </form>
        <?php endif; ?>
      </div>
    </div>
    <!-- Order Summary -->
    <div class="col-md-5 col-lg-4 order-md-last">
      <div class="checkout-card">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span>Your cart</span>
          <span class="badge bg-secondary rounded-pill"><?= count($cart) ?></span>
        </h4>
        <?php foreach ($grouped as $shop_id => $items): 
          $shop = $connection->prepare("SELECT name FROM shops WHERE id=?");
          $shop->execute([$shop_id]);
          $shop_name = $shop->fetchColumn();
          $shop_total = 0;
        ?>
        <ul class="list-group mb-3">
          <li class="list-group-item active" style="background: var(--color-primary); border-color: var(--color-primary);">
            <strong><?= htmlspecialchars($shop_name) ?></strong>
          </li>
          <?php foreach ($items as $item): $shop_total += $item['price']; ?>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0"><?= htmlspecialchars($item['name']) ?></h6>
            </div>
            <span class="text-muted">R<?= number_format($item['price'], 2) ?></span>
          </li>
          <?php endforeach; ?>
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (ZAR)</span>
            <strong class="summary-total">R<?= number_format($shop_total, 2) ?></strong>
          </li>
        </ul>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>