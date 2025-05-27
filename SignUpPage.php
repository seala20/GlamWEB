<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up - GlamConnect</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="canonical"
      href="https://getbootstrap.com/docs/5.3/examples/dropdowns/"
    />
    <script src="/docs/5.3/assets/js/color-modes.js"></script>
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
        background: #f3b2b6;
        font-family: "Segoe UI", sans-serif;
      }

      .signup-container {
        max-width: 500px;
        margin: 50px auto;
        padding: 30px;
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--color-border);
        transition: border-color 0.15s, box-shadow 0.15s;
      }

      .brand-title {
        font-size: 2rem;
        font-weight: bold;
        color: var(--color-accent);
        text-align: center;
        margin-bottom: 10px;
      }

      .brand-tagline {
        text-align: center;
        color: var(--color-body);
        margin-bottom: 20px;
      }

      label {
        color: var(--color-body-darker);
      }

      .form-control,
      .form-select {
        border-radius: var(--border-radius);
        border: 1px solid var(--color-border);
      }

      .btn-glam {
        background-color: var(--color-accent);
        color: #fff;
        border-radius: var(--border-radius);
        border: none;
      }

      .btn-glam:hover {
        background-color: var(--color-accent);
      }

      a {
        color: var(--color-secondary);
      }

      a:hover {
        color: var(--color-accent);
      }
      input[type="email"]:focus,
      input[type="password"]:focus,
      input[type="text"]:focus {
        border-color: #e1575a;
        outline: 0;
        box-shadow: 0 0 0 4px #ff7f85;
      }
      .dropdown .dropdown-toggle {
        border: 1px solid var(--color-border);
        border-radius: var(--border-radius);
        width: 100%;
        text-align: left;
        color: var(--color-body-darker);
        background-color: #fff;
        transition: border-color 0.15s, box-shadow 0.15s;
      }
      .dropdown .dropdown-toggle:focus {
        border-color: var(--color-secondary); /* #e1575a */
        outline: 0;
        box-shadow: 0 0 0 4px var(--color-primary); /* #ff7f85 */
      }
      .dropdown-item:hover {
        background-color: var(--color-primary);
        color: white;
        border-radius: var(--border-radius);
      }
    </style>
  </head>
  <body>
    <div class="signup-container">
      <div class="brand-title">GlamConnect</div>
      <div class="brand-tagline">
        Join the glam community — Buy & Sell with Style!
      </div>

      <form action="signup.php" method="POST">
        <div class="mb-3">
          <label for="name" class="form-label">Full Name</label>
          <input
            type="text"
            class="form-control"
            id="name"
            name="name"
            required
          />
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            required
          />
        </div>
        <div class="mb-3">
          <label for="roleDropdown" class="form-label">Profile Type</label>
          <div class="dropdown">
            <button
              class="btn btn-light dropdown-toggle form-select"
              type="button"
              id="roleDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Select Role
            </button>
            <ul class="dropdown-menu" aria-labelledby="roleDropdown">
              <li>
                <a class="dropdown-item" href="#" onclick="setRole('Buyer')"
                  >Buyer</a
                >
              </li>
              <li>
                <a class="dropdown-item" href="#" onclick="setRole('Seller')"
                  >Seller</a
                >
              </li>
            </ul>
          </div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <input
              type="password"
              class="form-control"
              id="password"
              name="password"
              required
            />
            <span class="input-group-text" id="toggle-password">
              <i class="bi bi-eye-slash" id="eye-icon"></i>
              <!-- Eye icon for hiding -->
            </span>
          </div>
        </div>

        <div class="mb-3">
          <label for="confirm_password" class="form-label"
            >Confirm Password</label
          >
          <div class="input-group">
            <input
              type="password"
              class="form-control"
              id="confirm_password"
              name="confirm_password"
              required
            />
            <span class="input-group-text" id="toggle-confirm-password">
              <i class="bi bi-eye-slash" id="eye-icon-confirm"></i>
              <!-- Eye icon for hiding -->
            </span>
          </div>
        </div>

        <!-- Include Bootstrap Icons -->
        <link
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
          rel="stylesheet"
        />

        <script>
          // Toggle password visibility
          document
            .getElementById("toggle-password")
            .addEventListener("click", function () {
              let passwordField = document.getElementById("password");
              let eyeIcon = document.getElementById("eye-icon");

              if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("bi-eye-slash");
                eyeIcon.classList.add("bi-eye");
              } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("bi-eye");
                eyeIcon.classList.add("bi-eye-slash");
              }
            });

          // Toggle confirm password visibility
          document
            .getElementById("toggle-confirm-password")
            .addEventListener("click", function () {
              let confirmPasswordField =
                document.getElementById("confirm_password");
              let eyeIconConfirm = document.getElementById("eye-icon-confirm");

              if (confirmPasswordField.type === "password") {
                confirmPasswordField.type = "text";
                eyeIconConfirm.classList.remove("bi-eye-slash");
                eyeIconConfirm.classList.add("bi-eye");
              } else {
                confirmPasswordField.type = "password";
                eyeIconConfirm.classList.remove("bi-eye");
                eyeIconConfirm.classList.add("bi-eye-slash");
              }
            });
        </script>
        <input type="hidden" name="role" id="roleInput" required />

        <button type="submit" class="btn btn-glam w-100">Sign Up</button>

        <div class="mt-3 text-center">
          Already have an account? <a href="Login.php">Login here</a>
        </div>
        <div class="mt-3 text-center">
          <a href="index.php">Back to Home</a>
        </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function setRole(role) {
  document.getElementById("roleDropdown").textContent = role;
  document
    .querySelector(".dropdown-toggle")
    .classList.remove("btn-light");
  document
    .querySelector(".dropdown-toggle")
    .classList.add("btn-secondary");

  // 👇 NEW: Set hidden input value for form submission
  document.getElementById("roleInput").value = role;
}

    </script>
  </body>
</html>
