<?php
require 'config.php';
session_start();

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Benutzerdaten aus der Datenbank abrufen
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, email, points FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    // Falls der Benutzer nicht gefunden wird, Session zerstören und umleiten
    session_destroy();
    header("Location: login.php");
    exit;
}

// Logout-Funktionalität
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>CoffeeStar - Menu</title>
    <link rel="stylesheet" href="CSS/style-m.css" />
</head>

<body>
    <!-- Popup -->
    <div id="popup" class="popup hidden">
    <div class="popup-content">
        <p id="popup-message">Adding item to cart...</p>
        <div class="quantity-selector">
        <button id="decrease">−</button>
        <span id="quantity">1</span>
        <button id="increase">+</button>
        </div>
        <div class="popup-buttons">
        <button id="confirm-add">Add</button>
        <button id="cancel-add">Cancel</button>
        </div>
    </div>
    </div>
    <!-- Confirmation -->
    <div id="toast" class="toast hidden"></div>

    <div class="container">
        <!-- Navigation Bar -->
        <nav class="navbar">
            <a href="start.html">Start</a>
            <a href="menu.php">Menu</a>
            <a href="cart.html">Cart</a>
            <a href="about.html">About</a>
            <img src="img/logo.jpg" alt="Logo" class="nav-logo">
        </nav>

        <!-- Account & Logo Section -->
        <div class="account-logo-section">
            <div class="logo-box">
                <img src="img/logo.jpg" alt="Main Logo">
            </div>

            <div class="account-box">
                <img src="img/logo-txt.jpg" alt="CoffeeStar" class="account-logo-text">
                
                <div class="account-info">
                    <p><strong>Account Information:</strong></p>
                    <p>Username: <span id="username"><?php echo htmlspecialchars($user['username']); ?></span></p>
                    <p>Points: <span id="points"><?php echo htmlspecialchars($user['points'] ?? 0); ?></span></p>
                    <form method="POST" style="display: inline;">
                        <button type="submit" name="logout" class="SignOut">Sign Out</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Menu Title -->
        <div class="menu-title-box">
            <h1 class="menu-title">Menu</h1>
        </div>

        <!-- Menu Choice Section -->
        <div class="menu-choice">
            <div class="choice-item">
            <button type="button" class="MenuHot" onclick="scrollToSection('hot-coffee')">
                <div class="choice-circle">
                <img src="img/Hot-Coffee/Hot-Coffee.png" alt="Hot Coffee">
                </div>
                <p>Hot Coffee</p>
            </button>
            </div>
            <div class="choice-item">
            <button type="button" class="MenuCold" onclick="scrollToSection('cold-coffee')">
                <div class="choice-circle">
                <img src="img/Cold-Coffee/Cold-Coffee.png" alt="Cold Coffee">
                </div>
                <p>Cold Coffee</p>
            </button>
            </div>
            <div class="choice-item">
            <button type="button" class="MenuBake" onclick="scrollToSection('baked')">
                <div class="choice-circle">
                <img src="img/Baked/baked.png" alt="Baked Goods">
                </div>
                <p>Baked</p>
            </button>
            </div>
        </div>

        <!-- Menu Choice Hot Coffee -->
        <div class="menu-box" id="hot-coffee">
            <h2>Hot Coffee</h2>

            <div class="menu-slider">
                <button class="slide-btn left-btn" data-target="hot-coffee">&#8592;</button>
            <div class="menu-items">

                <div class="menu-item">
                    <img src="img/Hot-Coffee/Americano.jpg" alt="Americano">
                    <p>Americano</p>
                    <p class="price">2,00€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

                <div class="menu-item">
                    <img src="img/Hot-Coffee/Cafe_Latte.jpg" alt="Cafe Latte">
                    <p>Cafe Latte</p>
                    <p class="price">2,50€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

                <div class="menu-item">
                    <img src="img/Hot-Coffee/Cuppuccino.jpg" alt="Cappuccino">
                    <p>Cappuccino</p>
                    <p class="price">2,50€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

                <div class="menu-item">
                    <img src="img/Hot-Coffee/espresso.jpg" alt="Espresso">
                    <p>Espresso</p>
                    <p class="price">1,50€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

                <div class="menu-item">
                    <img src="img/Hot-Coffee/Macchiato.jpg" alt="Macchiato">
                    <p>Macchiato</p>
                    <p class="price">3,00€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

                <div class="menu-item">
                    <img src="img/Hot-Coffee/Mocha.png" alt="Mocha">
                    <p>Mocha</p>
                    <p class="price">2,50€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

            </div>
            <button class="slide-btn right-btn" data-target="hot-coffee">&#8594;</button>
            </div>

            <!-- Info -->
            <div class="Menu-info">
                <p>Our Hot Coffee is always freshly prepared and ready to be enjoyed.</p>
                <p>No matter if inside our Locations or To-Go!</p>
            </div>
        </div>

        <!-- Menu Choice Cold Coffee -->
        <div class="menu-box" id="cold-coffee">
            <h2>Cold Coffee</h2>

            <div class="menu-slider">
            <button class="slide-btn left-btn" data-target="cold-coffee">&#8592;</button>
            <div class="menu-items">

                <div class="menu-item">
                    <img src="img/Cold-Coffee/Cold-Brew.jpg" alt="Cold-Brew">
                    <p>Cold-Brew</p>
                    <p class="price">3,50€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

                <div class="menu-item">
                    <img src="img/Cold-Coffee/Frappuchino.jpg" alt="Frappuchino">
                    <p>Frappuchino</p>
                    <p class="price">4,00€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

                <div class="menu-item">
                    <img src="img/Cold-Coffee/Iced-Americano.jpg" alt="Iced-Americano">
                    <p>Iced-Americano</p>
                    <p class="price">2,50€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

                <div class="menu-item">
                    <img src="img/Cold-Coffee/Iced-Latte.jpeg" alt="Iced-Latte">
                    <p>Iced-Latte</p>
                    <p class="price">2,50€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

                <div class="menu-item">
                    <img src="img/Cold-Coffee/Mazagran.jpg" alt="Mazagran">
                    <p>Mazagran</p>
                    <p class="price">3,50€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

            </div>
            <button class="slide-btn right-btn" data-target="cold-coffee">&#8594;</button>
            </div>

            <!-- Info -->
            <div class="Menu-info">
                <p>Having a hard day?</p>
                <p>Try one of or cold refreshing beverages.</p>
                <p>A true must have on any hot summer day!</p>
            </div>
        </div>

        <!-- Menu Choice Baked -->
        <div class="menu-box" id="baked">
            <h2>Baked</h2>
            <div class="menu-slider">
            <button class="slide-btn left-btn" data-target="baked">&#8592;</button>
            <div class="menu-items">

                <div class="menu-item">
                    <img src="img/Baked/Cheesecake.jpg" alt="Cheesecake">
                    <p>Cheesecake</p>
                    <p class="price">3,00€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

                <div class="menu-item">
                    <img src="img/Baked/Cinnamon-Roll.jpg" alt="Cinnamon-Roll">
                    <p>Cinnamon-Roll</p>
                    <p class="price">2,00€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

                <div class="menu-item">
                    <img src="img/Baked/Croissant.jpg" alt="Croissant">
                    <p>Croissant</p>
                    <p class="price">1,00€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

                <div class="menu-item">
                    <img src="img/Baked/Krapfen.jpg" alt="Krapfen">
                    <p>Krapfen</p>
                    <p class="price">1,50€</p>
                    <button type="button" class="add-Item">Add to Cart</button>
                </div>

            </div>
            <button class="slide-btn right-btn" data-target="baked">&#8594;</button>
            </div>

            <!-- Info -->
            <div class="Menu-info">
                <p>Sweet Tooth?</p>
                <p>You will love this!</p>
                <p>Our freshly home baked goods.</p>
            </div>
        </div>

        <script>
            let currentItem = null;
            let currentQuantity = 1;

            // Add to Cart Buttons
            document.querySelectorAll('.add-Item').forEach(button => {
                button.addEventListener('click', () => {
                const item = button.closest('.menu-item');
                const name = item.querySelector('p').textContent;
                const price = item.querySelector('.price').textContent;
                const img = item.querySelector('img').src;
                const description = "";
                currentItem = { name, img, description, price };
                currentQuantity = 1;
                document.getElementById("quantity").textContent = currentQuantity;
                document.getElementById("popup-message").textContent = `Add "${name}" to cart`;
                document.getElementById("popup").classList.remove("hidden");
                });
            });

            // Quantity controls
            document.getElementById("increase").addEventListener("click", () => {
                currentQuantity++;
                document.getElementById("quantity").textContent = currentQuantity;
            });
            document.getElementById("decrease").addEventListener("click", () => {
                if (currentQuantity > 0) {
                currentQuantity--;
                document.getElementById("quantity").textContent = currentQuantity;
                }
            });

            // Confirm add
            document.getElementById("confirm-add").addEventListener("click", () => {
                if (!currentItem) return;

                let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

                const existingItem = cartItems.find(item => item.name === currentItem.name);
                if (existingItem) {
                if (currentQuantity === 0) {
                    if (confirm(`Remove "${currentItem.name}" from cart?`)) {
                    cartItems = cartItems.filter(item => item.name !== currentItem.name);
                    }
                } else {
                    existingItem.amount += currentQuantity;
                    showToast(`Updated quantity of "${currentItem.name}" in cart`);
                }
                } else if (currentQuantity > 0) {
                    cartItems.push({ ...currentItem, amount: currentQuantity });
                }

                localStorage.setItem('cartItems', JSON.stringify(cartItems));
                document.getElementById("popup").classList.add("hidden");
                showToast(`${currentItem.name} updated in cart.`);
            });

            // Cancel add
            document.getElementById("cancel-add").addEventListener("click", () => {
                document.getElementById("popup").classList.add("hidden");
            });

            // Toast anzeigen
            function showToast(message) {
                const toast = document.getElementById("toast");
                toast.textContent = message;
                toast.classList.remove("hidden");
                setTimeout(() => {
                toast.classList.add("hidden");
                }, 2000);
            }

            // Scroll To Menu Funktion
            function scrollToSection(id) {
                const element = document.getElementById(id);
                if (!element) return;
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                element.classList.add("highlight");
                setTimeout(() => element.classList.remove("highlight"), 1000);
            }

            // Active Choice
            document.querySelectorAll('.choice-item button').forEach(button => {
                button.addEventListener('click', () => {
                document.querySelectorAll('.choice-item button').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                });
            });

            // Menu Slide Buttons
            document.querySelectorAll('.slide-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const direction = button.classList.contains('left-btn') ? -1 : 1;
                    const targetId = button.getAttribute('data-target');
                    const container = document.querySelector(`#${targetId} .menu-items`);
                    const scrollAmount = container.querySelector('.menu-item').offsetWidth + 20;
                    container.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
                });
            });
        </script>

        <!-- Contact Information -->
        <div class="contact-box">
            <p>Contact us at: CoffeStar@bapfit.de | Phone: +123 456 7890</p>
        </div>
    </div>

</body>
</html>