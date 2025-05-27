<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="GlamConnect: South Africa's C2C marketplace for fashion , beauty & home decor "
    />
    <meta
      property="og:title"
      content="GlamConnect- Your Local Style Marketplace"
    />
    <meta
      property="og:description"
      content="Discover unique fashion , Make up & home finds from local South Aftican Sellers"
    />

    <title>GlamConnect Connect ,Shop , Sell</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <!-- Google Fonts -->

    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Roboto:wght@400;500;700&display=swap"
      rel="stylesheet"
    />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;800&display=swap" rel="stylesheet">


    <link rel="preconnect" href="https://fonts.googleapis.com" />

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link
      href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  </head>
  <body>
    <?php
    session_start();
    $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    ?>
    <!--navbar section-->
    <nav class="nav collapsible">
      <!--<a aria-label="GlamConnect" class="nav__brand glam-logo">GlamConnect</a>-->
      <a href="index.php" aria-label="GlamConnect" class="nav__brand glam-logo">GlamConnect</a>

      <svg class="icon">
        <use xlink:href="images\sprite.svg#menu"></use>
      </svg>
      <ul class="list nav__list collapsible__content">
        <li class="nav__item"><a href="shop.php">Shops</a></li>
        <li class="nav__item"><a href="profile.php">Profile</a></li>
        <li class="nav__item"><a href="add_shop.php">AddShop</a></li>
         <li class="nav__item"><a href="creatorAdmin.php">creatorAdmin</a></li>
        <li class="nav__item">
          <a href="cart.php">Cart<?php if($cart_count > 0) echo " ($cart_count)"; ?></a>
        </li>
    
      </ul>
    </nav>

    <!--hero section-->
    <section class="block hero block--dark">
      <div class="container grid grid--1x3">
        <header class="block__header hero__content">
          <h1 class="block__heading">Support Local.Shop Unique</h1>
          <p class="hero__tagline">
            find clothes , beauty products and home style by local
            entrepreneurs.
          </p>
          <a href="SignUpPage.php" class="btn btn--accent btn--stretched">Get Started</a>
        </header>
        <img class="hero__image" src="images/hero.png" alt="hero picture" />
        <img class="hero__image" src="images/hero2.png" alt="hero picture" />
      </div>
    </section>
    <section class="block container block-domain">
      <header class="block__header">
        <h2>Low Selling Fees</h2>
        <p>Sell and Buy on GlamConnect</p>
        <p style="color: #e1575a; font-weight: 600;">
          Our 15% commission covers local delivery—no extra delivery costs for your buyers!
        </p>
      </header>
      <div class="input-group">
        <input
          type="text"
          class="input"
          placeholder="Enter shop name here..."
        />
        <button class="btn btn--accent">
          <svg class="icon icon--white">
            <use xlink:href="images/sprite.svg#search"></use>
          </svg>
          Search
        </button>
      </div>
      
<div class="badges-outer">
  <div class="badges-wrapper">
    <div class="mb-3">
      <span class="badge badge--secondary">10% Off for the month</span>
      <span class="badge badge--primary">15% Platform Fee</span>
      <span class="badge badge--secondary">Includes Local Delivery</span>
      <span class="badge badge--primary badge-small">No Listing Fees</span>
    </div>
  </div>
</div>

      <div id="shop-search-results"></div>
      <h2 class="brand--heading">Brands</h2>
      <div class="brand-item__row ">
        <div class="brand-item">
          <a class="brand-item__content" href="index.php">
           <img src="https://lh3.googleusercontent.com/7IHkfk6PFQx5fVyI7aDZKrT8BteYnO6HTjJO7V0te7gB1RzY0uEzBbRwRQSatziT8cIbOemeku1obE9pUcwsSTLQZuAo75_SGfAP=s150" alt="Zara">
          <span class="brand-item__name">Zara</span>
          </a>
      </div>
      <div class="brand-item">
        <a class="brand-item__content" href="index.php">
          <img src="https://lh3.googleusercontent.com/6-BArcpazMKccIyjQ_17o4RD36t39Kbt5YTiaQCgXElyC3lr2tZ9w5_rlbf-MDTAgNwhuZVnDuexIUEKs89kYYIyFqMwBfSIdZbq=s150" alt="Nike">
          <span class="brand-item__name">Nike</span>
        </a>
    </div>
    <div class="brand-item">
      <a class="brand-item__content" href="index.php">
        <img src="https://images.yaga.co.za/_brands/brand-33b6389571c05b747d3db461dbecbf36.jpg?s=150&amp;f=png&amp;c=inside" alt="H&amp;M">
        <span class="brand-item__name">H&M</span>        
      </a>
  </div>
  <div class="brand-item">
    <a class="brand-item__content" href="index.php">
      <img src="https://lh3.googleusercontent.com/HIWctvyrv7RWR-ykZyZTNf8q4r0JHlrYojn8T0-rz571eTL0MxywTbtJgqGBbeHZ7bOCqg6snNRQId59WUGKjBvetgO1Hgh90N5F=s150" alt="Adidas">
      <span class="brand-item__name">Adidas</span>
    </a>
</div>
<div class="brand-item">
  <a class="brand-item__content" href="index.php">
    <img src="https://images.yaga.co.za/_brands/brand-46371c9dd6c722446ee8867008f56650.jpeg?s=150&amp;f=png&amp;c=inside" alt="Woolworths">
    <span class="brand-item__name">Woolworths</span>
  </a>
</div>
<div class="brand-item">
  <a class="brand-item__content" href="index.php">
    <img src="https://images.yaga.co.za/_brands/brand-010e48a0006e87804f9b580be7412c88.jpg?s=150&amp;f=png&amp;c=inside" alt="Converse">
    <span class="brand-item__name">Converse</span>
  </a>
</div>
<div class="brand-item">
<a class="brand-item__content" href="index.php">
  <img src="https://lh3.googleusercontent.com/BemUSOWdxc2Tx6HMJCB9l73npnzCdN3Hbrah3YoWwwVikO8hPkg5S5PQ_zVBn8EPrWtlsDoSTHVLY8rVHkQC63qUtNEs-cZ5xSRJ=s150" alt="Cotton On">
  <span class="brand-item__name">Cotton On</span></a>
</div>
<div class="brand-item">
  <a class="brand-item__content" href="index.php">
    <img src="https://lh3.googleusercontent.com/uaBbniS4v2Rey1xEFxZLmoqxCSFTvlEnhkcRKfm08rJKq35B5N9OYJO76m0t0BLzIDUWAXwJfzhZBaUfYZAQEsuG3ZKvtvzIDtcVWw=s150" alt="Levi's">
  <span class="brand-item__name">Levi's</span></a>
</div>
<d class="brand-item">
<a class="brand-item__content" href="index.php">
  <img srcset="//coricraft.co.za/cdn/shop/files/logo_125x.webp?v=1744622378, //coricraft.co.za/cdn/shop/files/logo_250x.webp?v=1744622378 2x" src="//coricraft.co.za/cdn/shop/files/logo_125x.webp?v=1744622378" loading="lazy" width="125" height="11" class="header__heading-logo logo__main" alt="Coricraft South Africa">
  <span class="brand-item__name">Coricraft</span></a>
</div>
<div class="brand-item__row ">
<div class="brand-item"><a class="brand-item__content" href="index.php">
  <img src="https://images.yaga.co.za/_brands/brand-36a25b67448101a412ca761267e301ad.png?s=150&amp;f=png&amp;c=inside" alt="Old Khaki">
  <span class="brand-item__name">Old Khaki</span></a>
</div>
<div class="brand-item"><a class="brand-item__content" href="index.php">
  <img src="https://lh3.googleusercontent.com/-Be_5ygDdLcZvoc71ZFsEnHo2voZ0LCeBrW1l2QURlim7g2i8zvqggMGs23NeGGRNHtlcF_htNE7h3GyflNDzLRbNhE_qS9w68dj=s150" alt="Foschini">
  <span class="brand-item__name">Foschini</span></a>
</div>
<div class="brand-item"><a class="brand-item__content" href="index.php">
  <img src="https://lh3.googleusercontent.com/32PlvpZp_9DNSEIweVSSbT-Gu80d-_PKn-dHu-GYJc2IYW5RSJGdZEJRtfSnIplEpDSYDIREhVXY9qmZy9B-No18kQD_d6v2bsU8=s150" alt="Aldo">
  <span class="brand-item__name">Aldo</span></a>
</div>
<div class="brand-item"><a class="brand-item__content" href="index.php">
  <img src="https://images.yaga.co.za/_brands/brand-45a01058ac0343258a7a8fdcd8b077ae.jpeg?s=150&amp;f=png&amp;c=inside" alt="Forever New">
  <span class="brand-item__name">ForeverNew</span></a>
</div>
<div class="brand-item"><a class="brand-item__content" href="index.php">
  <img src="https://images.yaga.co.za/_brands/brand-bd361757635d50e7593ebe44b0903ba2.png?s=150&amp;f=png&amp;c=inside" alt="Mr Price">
  <span class="brand-item__name">Mr Price</span></a>
</div>
<div class="brand-item"><a class="brand-item__content" href="index.php">
  <img src="https://lh3.googleusercontent.com/9_kpmZYnPWfvjxloxuDJuBXqXFz-fybdA7TdJ5hUIvIZMqt_ws4fvuU6wydnsYMbQVuZ2ISaL4cUYvpQbEUCzBbBPp6OHMmFvZQIaQ=s150" alt="Birkenstock">
  <span class="brand-item__name">Birkenstock</span></a>
</div>
<div class="brand-item"><a class="brand-item__content" href="index.php">
  <img src="https://images.yaga.co.za/_brands/brand-46daa3ac677c678b6c2b57522f0fa30c.png?s=150&amp;f=png&amp;c=inside" alt="Trenery">
  <span class="brand-item__name">Trenery</span></a>
</div>
<div class="brand-item"><a class="brand-item__content" href="index.php">
  <img src="https://images.yaga.co.za/_brands/brand-28ca2ecf01d5ebaac1e350f31797768b.png?s=150&amp;f=png&amp;c=inside" alt="Country Road">
  <span class="brand-item__name">Country Road</span></a>
</div>
</div>
<!--categories section-->
<section class="categories-section">
  <h2>Categories</h2>
  <div class="categories-grid">
    <div class="block-image">
      <div class="image-container dark">
        <img src="images/catewomen.jpg" alt="women" class="src-image" />
        <div class="text-over">WOMEN</div>
      </div>
    </div>
    <div class="block-image">
      <div class="image-container dark">
        <img src="images/catemen.jpg" alt="men" class="src-image" />
        <div class="text-over">MEN</div>
      </div>
    </div>
    <div class="block-image">
      <div class="image-container dark">
        <img src="images/catebeauty.jpg" alt="BEAUTY" class="src-image" />
        <div class="text-over">BEAUTY</div>
      </div>
    </div>
    <div class="block-image">
      <div class="image-container dark">
        <img src="images/catehome.jpg" alt="Home" class="src-image" />
        <div class="text-over">HOME</div>
      </div>
    </div>
  </div>
</section>
<!--secure payment section-->
<section class="hp_payments_shipping">
  <div class="hp_payments_shipping-grid">
    <!-- Safe Selling -->
    <div class="hp_payments_shipping-item">
      <div class="hp_payments_shipping-paymentsguarantee">
        <svg class="icon">
          <use xlink:href="images/sprite2.svg#Group (1)"></use>
        </svg>
        <p class="hp_payments_shipping-subtext">
          Safe selling & buying<br>
         <a href="learn-more.php" class="link-arrow">Learn More</a>

        </p>
      </div>
    </div>

    <div class="hp_payments_shipping-divider"></div>

    <!-- Secure Payments -->
    <div class="hp_payments_shipping-item hp_payments_shipping-item--payments">
      <p class="hp_payments_shipping-subtext">Secure payments by</p>
      <div class="payments_shipping-logos">
        <svg class="icon">
          <use xlink:href="images/sprite2.svg#formkit_visa (1)"></use>
        </svg>
        <svg class="icon">
          <use xlink:href="images/sprite2.svg#logos_mastercard (1)"></use>
        </svg>
        <svg class="icon">
          <use xlink:href="images/sprite2.svg#hugeicons_paypal (1)"></use>
        </svg>
      </div>
    </div>

    <div class="hp_payments_shipping-divider"></div>

    <!-- Fast Delivery -->
    <div class="hp_payments_shipping-item hp_payments_shipping-item--shipping">
      <p class="hp_payments_shipping-subtext">Fast and convenient delivery by</p>
      <div class="payments_shipping-delivery">
        <svg class="icon">
          <use xlink:href="images/sprite2.svg#iconoir_delivery-truck (1)"></use>
        </svg>
        <ul class="delivery-services">
          <li>Paxi</li>
          <li>PostNet</li>
          <li>Aramex</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!--testimonial section -->
<section class="block testimonial-section">
  <header class="block__header">
    <h2 class="section-title " >What Our Customers Are Saying</h2>
    <p class="section-subtitle"> At GlamConnect, we empower small business owners, creators, and everyday dreamers to launch and grow their brands. With zero selling fees and a supportive community of buyers, GlamConnect is the platform where passion meets profit.</p>
  </header>
  <div class="container">
    <div class="card testimonial">
      <div class="grid grid--1x2">
        <div class="testimonial__image">
          <img src="images/testimonial2.jpg" alt="Smiling GlamConnect Seller" />
          <span class="icon-container icon-container--accent">
            <svg class="icon icon--white icon--small">
              <use xlink:href="images/sprite.svg#quotes"></use>
            </svg>
          </span>
        </div>
        <blockquote class="quote">
          <p class="quote__text">
            “Thanks to GlamConnect, I’ve grown my brand by paying low commission fees per order.
             I reached thousands of customers and turned my side hustle into a real business.”
          </p>
          <p class="quote__text">
            “If you're thinking about joining—do it. Whether you're selling handmade clothes, makeup, or home designs, GlamConnect gives you a voice, a platform, and a family of shoppers who care about local talent. It's more than just a marketplace—it's a movement.”
          </p>
          <footer>
            <div class="media">
              <div class="media__image">
                <svg class="icon icon--primary quote__line">
                  <use xlink:href="images/sprite.svg#line"></use>
                </svg>
              </div>
              <div class="media__body">
                <h3 class="media__title quote__author">Lerato Mokoena</h3>
                <p class="quote__organization">Owner of LeraGlow Beauty</p>
              </div>
            </div>
          </footer>
        </blockquote>
      </div>
    </div>
  </div>
</section>

<footer class="block block--dark footer">
  <div class="container grid footer__sections">

    <!-- Shop Section -->
    <section class="collapsible collapsible--expanded footer__section">
      <header class="collapsible__header">
        <h2 class="collapsible__heading footer__heading">Shop</h2>
        <svg class="icon icon--white collapsible__chevron">
          <use xlink:href="images/sprite.svg#chevron"></use>
        </svg>
      </header>
      <div class="collapsible__content">
        <ul class="list">
          <li><a href="shop.php">Clothing</a></li>
          <li><a href="shop.php">Makeup</a></li>
          <li><a href="shop.php">Home Decor</a></li>
        </ul>
      </div>
    </section>

    <!-- About Section -->
    <section class="collapsible footer__section">
      <header class="collapsible__header">
        <h2 class="collapsible__heading footer__heading">About GlamConnect</h2>
        <svg class="icon icon--white collapsible__chevron">
          <use xlink:href="images/sprite.svg#chevron"></use>
        </svg>
      </header>
      <div class="collapsible__content">
        <ul class="list">
          <li><a href="#">Our Story</a></li>
          <li><a href="#">Our Mission</a></li>
          <li><a href="#">For Sellers</a></li>
        </ul>
      </div>
    </section>

    <!-- Support Section -->
    <section class="collapsible footer__section">
      <header class="collapsible__header">
        <h2 class="collapsible__heading footer__heading">Support</h2>
        <svg class="icon icon--white collapsible__chevron">
          <use xlink:href="images/sprite.svg#chevron"></use>
        </svg>
      </header>
      <div class="collapsible__content">
        <ul class="list">
          <li><a href="./ContactUs.html">Contact Us</a></li>
          <li><a href="./Faqs.html">FAQs</a></li>
          <li><a href="./shipping-returns.html">Shipping & Returns</a></li>
        </ul>
      </div>
    </section>

    <!-- Community Section -->
    <section class="collapsible footer__section">
      <header class="collapsible__header">
        <h2 class="collapsible__heading footer__heading">Community</h2>
        <svg class="icon icon--white collapsible__chevron">
          <use xlink:href="images/sprite.svg#chevron"></use>
        </svg>
      </header>
      <div class="collapsible__content">
        <ul class="list">
          <li><a href="#">Become a Seller</a></li>
          <li><a href="#">Follow on Instagram</a></li>
          <li><a href="#">Join Our Newsletter</a></li>
        </ul>
      </div>
    </section>

    <!-- Brand Section -->
    <section class="footer__brand">
      <img src="images/glamlogo.svg" alt="GlamConnect Logo" />
      <p class="footer__copyright">
        &copy; 2025 GlamConnect. Built with love in South Africa.
      </p>
    </section>

  </div>
</footer>

    <script src="js/main.js"></script>
    <script>
document.querySelector('.input-group .input').addEventListener('input', function() {
    const query = this.value;
    if (query.length < 1) {
        document.getElementById('shop-search-results').innerHTML = '';
        return;
    }
    fetch('searchShops.php?q=' + encodeURIComponent(query))
        .then(res => res.json())
        .then(data => {
            let html = '';
            if (data.length > 0) {
                html = '<ul class="search-results">';
                data.forEach(shop => {
                    html += `<li><a href="shop.php?shop=${encodeURIComponent(shop)}">${shop}</a></li>`;
                });
                html += '</ul>';
            } else {
                html = '<p>No shops found.</p>';
            }
            document.getElementById('shop-search-results').innerHTML = html;
        });
});
</script>
  </body>
</html>
