// Global variables
let products = [];
let cart = [];
let currentUser = null;
let currentPage = 1;
const productsPerPage = 9;

const sampleProducts = [
    {
        id: 1,
        name: "Premium Whey Protein Powder",
        price: 20000,
        category: "supplement", 
        description: "High-quality whey protein isolate with 25g protein per serving. Available in chocolate, vanilla, and strawberry flavors.",
        features: ["25g Protein", "Low Carb", "Fast Absorption", "Third-Party Tested"],
        rating: 4.8,
        reviews: 124,
        image: "images/Whey_protein.jpg"
    },
    {
        id: 2,
        name: "Omega-3 Fish Oil Capsules",
        price: 11450,
        category: "supplement",
        description: "Pure omega-3 fish oil capsules supporting heart health and brain function. 1000mg per capsule.",
        features: ["1000mg EPA/DHA", "Heart Health", "Brain Support", "Molecularly Distilled"],
        rating: 4.6,
        reviews: 89,
        image: "images/Omega.jpg"
    },
    {
        id: 3,
        name: "Pre-Workout Energy Booster",
        price: 7500,
        category: "supplement",
        description: "Clean energy pre-workout formula with natural caffeine, beta-alanine, and citrulline for enhanced performance.",
        features: ["Natural Caffeine", "No Crash", "Enhanced Focus", "30 Servings"],
        rating: 4.7,
        reviews: 156,
        image: "images/Energy.jpg"
    },
    {
        id: 4,
        name: "Multivitamin for Active Adults",
        price: 2700,
        category: "supplement",
        description: "Complete multivitamin specifically formulated for active individuals with enhanced B-vitamins and antioxidants.",
        features: ["25+ Vitamins & Minerals", "Energy Support", "Immune Boost", "60 Tablets"],
        rating: 4.5,
        reviews: 203,
        image: "images/Multivitamin.jpg"
    },
    {
        id: 5,
        name: "Adjustable Dumbbell Set",
        price: 27000,
        category: "equipment",
        description: "Space-saving adjustable dumbbells with quick-change weight system. Each dumbbell adjusts from 5-50 lbs.",
        features: ["5-50 lbs Range", "Quick Adjust", "Space Saving", "Durable Steel"],
        rating: 4.9,
        reviews: 78,
        image: "images/dumbbell.jpg"
    },
    {
        id: 6,
        name: "Power Tower Pull-Up Station",
        price: 3900,
        category: "equipment",
        description: "Multi-functional power tower for pull-ups, dips, push-ups, and knee raises. Heavy-duty steel construction.",
        features: ["4-in-1 Design", "400 lbs Capacity", "Padded Grips", "Easy Assembly"],
        rating: 4.4,
        reviews: 45,
        image: "images/Pull_up.jpg"
    },
    {
        id: 7,
        name: "Folding Treadmill",
        price: 18000,
        category: "equipment",
        description: "Compact folding treadmill with 12 preset programs, heart rate monitoring, and quiet motor operation.",
        features: ["12 Programs", "Foldable Design", "Heart Rate Monitor", "Silent Motor"],
        rating: 4.3,
        reviews: 67,
        image: "images/treadmill.jpg"
    },
    {
        id: 8,
        name: "Olympic Barbell with Plates",
        price: 5100,
        category: "equipment",
        description: "Professional Olympic barbell set including 45lb barbell and 255lbs of rubber-coated weight plates.",
        features: ["Olympic Standard", "Rubber Coated", "300lbs Total", "Chrome Barbell"],
        rating: 4.8,
        reviews: 34,
        image: "images/barbell.jpg"
    },
    {
        id: 9,
        name: "Yoga Mat with Alignment Lines",
        price: 1500,
        category: "wellness",
        description: "Premium non-slip yoga mat with alignment guides. 6mm thick for extra cushioning and joint protection.",
        features: ["6mm Thick", "Non-Slip Surface", "Alignment Lines", "Eco-Friendly Material"],
        rating: 4.6,
        reviews: 189,
        image: "images/yoga_mat.jpg"
    },
    {
        id: 10,
        name: "Foam Roller for Muscle Recovery",
        price: 1200,
        category: "wellness",
        description: "High-density foam roller perfect for myofascial release and post-workout recovery. 13\" x 6\" size.",
        features: ["High Density Foam", "13 inch Length", "Muscle Recovery", "Travel Friendly"],
        rating: 4.7,
        reviews: 142,
        image: "images/foam_roller.jpg"
    }
];

// Initialize products with sample data
products = [...sampleProducts];

// Initialize from PHP session if available
if (typeof window.currentUserFromPHP !== 'undefined' && window.currentUserFromPHP) {
    currentUser = window.currentUserFromPHP;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', async function() {
    await init();
});

async function init() {
    // Load products from backend or use samples
    await loadProducts();
    
    // Update auth display based on current user
    updateAuthDisplay();
    
    // Update cart count
    updateCartCount();
    
    // Setup all event listeners
    setupEventListeners();
    
    // Setup modal listeners
    setupModalListeners();
    
    // Render products if on product pages
    renderFeaturedProducts();
    renderAllProducts();
}

function setupEventListeners() {
    // Hamburger menu
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('nav-menu');
    
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            hamburger.classList.toggle('active');
        });
    }
    
    // Search
    const searchBtn = document.getElementById('search-btn');
    const searchInput = document.getElementById('search-input');
    
    if (searchBtn) searchBtn.addEventListener('click', performSearch);
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') performSearch();
        });
    }
    
    // Auth buttons
    const loginBtn = document.getElementById('login-btn');
    const signupBtn = document.getElementById('signup-btn');
    const logoutBtn = document.getElementById('logout');
    
    if (loginBtn) loginBtn.addEventListener('click', () => openModal('login-modal'));
    if (signupBtn) signupBtn.addEventListener('click', () => openModal('signup-modal'));
    if (logoutBtn) logoutBtn.addEventListener('click', handleLogout);
    
    // Cart
    const cartBtn = document.getElementById('cart-btn');
    const clearCartBtn = document.getElementById('clear-cart');
    const checkoutBtn = document.getElementById('checkout-btn');
    
    if (cartBtn) cartBtn.addEventListener('click', () => openModal('cart-modal'));
    if (clearCartBtn) clearCartBtn.addEventListener('click', clearCart);
    if (checkoutBtn) checkoutBtn.addEventListener('click', checkout);
    
    // Forms
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');
    
    if (loginForm) loginForm.addEventListener('submit', handleLogin);
    if (signupForm) signupForm.addEventListener('submit', handleSignup);
    
    // Filters
    const categoryFilter = document.getElementById('category-filter');
    const priceFilter = document.getElementById('price-filter');
    const sortFilter = document.getElementById('sort-filter');
    
    if (categoryFilter) categoryFilter.addEventListener('change', applyFilters);
    if (priceFilter) priceFilter.addEventListener('change', applyFilters);
    if (sortFilter) sortFilter.addEventListener('change', applyFilters);
    
    // Load more
    const loadMoreBtn = document.getElementById('load-more');
    if (loadMoreBtn) loadMoreBtn.addEventListener('click', loadMoreProducts);
    
    // Category cards
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            window.location.href = `products.php?category=${encodeURIComponent(category)}`;
        });
    });
    
    // Profile dropdown
    const profileBtn = document.getElementById('profile-btn');
    const profileDropdown = document.getElementById('profile-dropdown');
    
    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
        });
        
        document.addEventListener('click', function(e) {
            if (!profileBtn.contains(e.target)) {
                profileDropdown.classList.remove('show');
            }
        });
    }
    
    // Footer links
    const termsLink = document.getElementById('terms-link');
    const privacyLink = document.getElementById('privacy-link');
    const shippingLink = document.getElementById('shipping-link');
    
    if (termsLink) termsLink.addEventListener('click', (e) => { e.preventDefault(); showInfoModal('Terms & Conditions', getTermsContent()); });
    if (privacyLink) privacyLink.addEventListener('click', (e) => { e.preventDefault(); showInfoModal('Privacy Policy', getPrivacyContent()); });
    if (shippingLink) shippingLink.addEventListener('click', (e) => { e.preventDefault(); showInfoModal('Shipping Information', getShippingContent()); });

    // Profile, Order History, Track Orders
    const viewProfileBtn = document.getElementById('view-profile');
    const orderHistoryBtn = document.getElementById('order-history');
    const trackOrdersBtn = document.getElementById('track-orders');
    
    if (viewProfileBtn) viewProfileBtn.addEventListener('click', (e) => {
        e.preventDefault();
        showProfile();
    });
    
    if (orderHistoryBtn) orderHistoryBtn.addEventListener('click', (e) => {
        e.preventDefault();
        showOrderHistory();
    });
    
    if (trackOrdersBtn) trackOrdersBtn.addEventListener('click', (e) => {
        e.preventDefault();
        showTrackOrders();
    });
}

function setupModalListeners() {
    // Close buttons
    document.querySelectorAll('.close').forEach(closeBtn => {
        closeBtn.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                closeModal(modal.id);
            }
        });
    });
    
    // Close on outside click
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this.id);
            }
        });
    });
    
    // Switch between login and signup
    const switchToSignup = document.getElementById('switch-to-signup');
    const switchToLogin = document.getElementById('switch-to-login');
    
    if (switchToSignup) {
        switchToSignup.addEventListener('click', function(e) {
            e.preventDefault();
            closeModal('login-modal');
            openModal('signup-modal');
        });
    }
    
    if (switchToLogin) {
        switchToLogin.addEventListener('click', function(e) {
            e.preventDefault();
            closeModal('signup-modal');
            openModal('login-modal');
        });
    }
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        
        if (modalId === 'cart-modal') {
            renderCart();
        }
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Load products from backend
async function loadProducts() {
    try {
        const response = await fetch('products/get_products.php');
        const data = await response.json();
        
        if (data.success && data.products && data.products.length > 0) {
            products = data.products;
            console.log('✅ Loaded ' + products.length + ' products from database');
        } else {
            // Fallback to sample products
            products = [...sampleProducts];
            console.log('⚠️ Using sample products (database returned no products)');
        }
    } catch (error) {
        console.error('Error loading products:', error);
        console.log('⚠️ Using sample products (error loading from database)');
        products = [...sampleProducts];
    }
}

// Authentication Functions with Backend Integration
async function handleLogin(e) {
    e.preventDefault();
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;
    
    if (!email || !password) {
        showNotification('Please fill in all fields', 'error');
        return;
    }
    
    try {
        const response = await fetch('auth/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification(`Welcome back, ${data.user.name}!`, 'success');
            document.getElementById('login-form').reset();
            closeModal('login-modal');
            
            // Check if user is admin and redirect to admin panel
            if (data.user.role === 'admin') {
                setTimeout(() => window.location.href = 'admin/admin.php', 1000);
            } else {
                // Regular user - reload current page
                setTimeout(() => window.location.reload(), 1000);
            }
        } else {
            showNotification(data.message || 'Login failed', 'error');
        }
    } catch (error) {
        console.error('Login error:', error);
        showNotification('Connection error. Please try again.', 'error');
    }
}

async function handleSignup(e) {
    e.preventDefault();
    const name = document.getElementById('signup-name').value;
    const email = document.getElementById('signup-email').value;
    const password = document.getElementById('signup-password').value;
    const confirmPassword = document.getElementById('signup-confirm').value;
    
    if (!name || !email || !password || !confirmPassword) {
        showNotification('Please fill in all fields', 'error');
        return;
    }
    
    if (password !== confirmPassword) {
        showNotification('Passwords do not match', 'error');
        return;
    }
    
    if (password.length < 6) {
        showNotification('Password must be at least 6 characters', 'error');
        return;
    }
    
    try {
        const response = await fetch('auth/signup.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name, email, password })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification(`Welcome to HEALTHFORGE, ${data.user.name}!`, 'success');
            document.getElementById('signup-form').reset();
            closeModal('signup-modal');
            
            // Check if user is admin and redirect to admin panel
            if (data.user.role === 'admin') {
                setTimeout(() => window.location.href = 'admin/admin.php', 1000);
            } else {
                // Regular user - reload current page
                setTimeout(() => window.location.reload(), 1000);
            }
        } else {
            showNotification(data.message || 'Signup failed', 'error');
        }
    } catch (error) {
        console.error('Signup error:', error);
        showNotification('Connection error. Please try again.', 'error');
    }
}

async function handleLogout() {
    try {
        const response = await fetch('auth/logout.php', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification('Logged out successfully', 'success');
            setTimeout(() => window.location.href = 'index.php', 1000);
        }
    } catch (error) {
        console.error('Logout error:', error);
        // Force logout anyway
        window.location.href = 'auth/logout.php';
    }
}

function updateAuthDisplay() {
    // This function is called after page load
    // PHP already handles showing/hiding buttons
    // We just need to update cart count if user is logged in
    if (currentUser) {
        loadCart();
    }
}

// Cart Functions
async function addToCart(productId) {
    if (!currentUser) {
        showNotification('Please login to add items to cart', 'error');
        openModal('login-modal');
        return;
    }
    
    try {
        const response = await fetch('cart/add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ product_id: productId })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification('Product added to cart!', 'success');
            if (data.cart_count) {
                document.getElementById('cart-count').textContent = data.cart_count;
            }
            loadCart();
        } else {
            showNotification(data.message || 'Failed to add to cart', 'error');
        }
    } catch (error) {
        console.error('Add to cart error:', error);
        showNotification('Connection error', 'error');
    }
}

async function loadCart() {
    if (!currentUser) return;
    
    try {
        const response = await fetch('cart/get_cart.php');
        const data = await response.json();
        
        if (data.success) {
            cart = data.cart_items.map(item => ({
                ...products.find(p => p.id == item.product_id),
                quantity: item.quantity,
                cart_id: item.id
            }));
            
            updateCartCount();
        }
    } catch (error) {
        console.error('Load cart error:', error);
    }
}

function updateCartCount() {
    const cartCount = document.getElementById('cart-count');
    if (cartCount) {
        const total = cart.reduce((sum, item) => sum + (item.quantity || 0), 0);
        cartCount.textContent = total;
    }
}

function renderCart() {
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    
    if (!cartItems) return;
    
    if (cart.length === 0) {
        cartItems.innerHTML = '<p style="text-align: center; padding: 40px; color: #666;">Your cart is empty</p>';
        cartTotal.textContent = '0.00';
        return;
    }
    
let total = 0;
    cartItems.innerHTML = cart.map(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        
        return `
            <div class="cart-item">
                <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                <div class="cart-item-info">
                    <h4>${item.name}</h4>
                    <p class="cart-item-price">LKR ${item.price.toLocaleString()}</p>
                </div>
                <div class="cart-item-controls">
                    <div class="cart-item-quantity">
                        <button class="quantity-btn" onclick="updateCartQuantity(${item.cart_id}, ${item.quantity - 1})">-</button>
                        <span class="quantity-display">${item.quantity}</span>
                        <button class="quantity-btn" onclick="updateCartQuantity(${item.cart_id}, ${item.quantity + 1})">+</button>
                    </div>
                    <button onclick="removeFromCart(${item.cart_id})" class="remove-btn">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    }).join('');
    
    cartTotal.textContent = total.toLocaleString() + '.00';
}

async function updateCartQuantity(cartId, newQuantity) {
    if (newQuantity < 1) {
        removeFromCart(cartId);
        return;
    }
    
    try {
        const response = await fetch('cart/update_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ cart_item_id: cartId, quantity: newQuantity })
        });
        
        const data = await response.json();
        
        if (data.success) {
            await loadCart();
            renderCart();
        }
    } catch (error) {
        console.error('Update cart error:', error);
    }
}

async function removeFromCart(cartId) {
    try {
        const response = await fetch('cart/remove_from_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ cart_item_id: cartId })
        });
        
        const data = await response.json();
        
        if (data.success) {
            await loadCart();
            renderCart();
            showNotification('Item removed from cart', 'success');
        }
    } catch (error) {
        console.error('Remove from cart error:', error);
    }
}

async function clearCart() {
    if (cart.length === 0) {
        showNotification('Cart is already empty', 'info');
        return;
    }
    
    if (!confirm('Are you sure you want to clear your cart?')) return;
    
    try {
        const response = await fetch('cart/clear_cart.php', {
            method: 'POST'
        });
        
        const data = await response.json();
        
        if (data.success) {
            cart = [];
            updateCartCount();
            renderCart();
            showNotification('Cart cleared', 'success');
        }
    } catch (error) {
        console.error('Clear cart error:', error);
    }
}

async function checkout() {
    if (!currentUser) {
        showNotification('Please login to checkout', 'error');
        openModal('login-modal');
        return;
    }
    
    if (cart.length === 0) {
        showNotification('Your cart is empty', 'error');
        return;
    }
    
    try {
        const response = await fetch('cart/checkout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            cart = [];
            updateCartCount();
            closeModal('cart-modal');
            showNotification(`Order placed successfully! Order #${data.order_number}`, 'success');
            
            setTimeout(() => {
                alert(`Thank you for your order!\n\nOrder Number: ${data.order_number}\nTotal: LKR ${data.total.toFixed(2)}\n\nYou will receive a confirmation email shortly.`);
            }, 1000);
        } else {
            showNotification(data.message || 'Checkout failed', 'error');
        }
    } catch (error) {
        console.error('Checkout error:', error);
        showNotification('Connection error', 'error');
    }
}

// Product Rendering
function renderFeaturedProducts() {
    const featuredGrid = document.getElementById('featured-grid');
    if (!featuredGrid) return;
    
    const featuredProducts = products.slice(0, 6);
    featuredGrid.innerHTML = featuredProducts.map(product => createProductCard(product)).join('');
    setupProductCardListeners(featuredGrid);
}

function renderAllProducts() {
    const productsGrid = document.getElementById('products-grid');
    if (!productsGrid) return;
    
    const filteredProducts = getFilteredProducts();
    const displayProducts = filteredProducts.slice(0, currentPage * productsPerPage);
    
    productsGrid.innerHTML = displayProducts.map(product => createProductCard(product)).join('');
    setupProductCardListeners(productsGrid);
    
    const loadMoreBtn = document.getElementById('load-more');
    if (loadMoreBtn) {
        loadMoreBtn.style.display = displayProducts.length >= filteredProducts.length ? 'none' : 'block';
    }
}

function createProductCard(product) {
    return `
        <div class="product-card" data-product-id="${product.id}">
            <div class="product-image">
                <img src="${product.image}" alt="${product.name}">
            </div>
            <div class="product-info">
                <h3>${product.name}</h3>
                <p class="product-description">${product.description.substring(0, 100)}...</p>
                <div class="product-footer">
                    <span class="product-price">LKR ${product.price.toLocaleString()}</span>
                    <div class="product-rating">
                        <span class="stars">${'★'.repeat(Math.floor(product.rating))}${'☆'.repeat(5-Math.floor(product.rating))}</span>
                        <span class="reviews">(${product.reviews})</span>
                    </div>
                </div>
            </div>
            <div class="product-actions">
                <button class="btn-add-cart" onclick="event.stopPropagation(); addToCart(${product.id})">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
                <button class="btn-view" onclick="event.stopPropagation(); showProductDetail(${product.id})">
                    <i class="fas fa-eye"></i> View
                </button>
            </div>
        </div>
    `;
}

function setupProductCardListeners(container) {
    container.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('.btn-add-cart')) {
                const productId = this.getAttribute('data-product-id');
                showProductDetail(productId);
            }
        });
    });
}

function showProductDetail(productId) {
    const product = products.find(p => p.id == productId);
    if (!product) return;
    
    const productDetail = document.getElementById('product-detail');
    if (!productDetail) return;
    
    productDetail.innerHTML = `
        <div class="product-detail-content">
            <div class="product-detail-image">
                <img src="${product.image}" alt="${product.name}">
            </div>
            <div class="product-detail-info">
                <h2>${product.name}</h2>
                <div class="product-rating">
                    <span class="stars">${'★'.repeat(Math.floor(product.rating))}${'☆'.repeat(5-Math.floor(product.rating))}</span>
                    <span>${product.rating} (${product.reviews} reviews)</span>
                </div>
                <p class="price">LKR ${product.price.toLocaleString()}</p>
                <p class="description">${product.description}</p>
                <div class="features">
                    <h4>Features:</h4>
                    <ul>
                        ${product.features.map(f => `<li><i class="fas fa-check"></i> ${f}</li>`).join('')}
                    </ul>
                </div>
                <button class="btn-primary btn-large" onclick="addToCart(${product.id}); closeModal('product-modal');">
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
            </div>
        </div>
    `;
    
    openModal('product-modal');
}

function getFilteredProducts() {
    let filtered = [...products];
    
    // Category filter
    const categoryFilter = document.getElementById('category-filter');
    if (categoryFilter && categoryFilter.value) {
        filtered = filtered.filter(p => p.category === categoryFilter.value);
    }
    
    // Price filter
    const priceFilter = document.getElementById('price-filter');
    if (priceFilter && priceFilter.value) {
        const range = priceFilter.value;
        if (range === '20000+') {
            filtered = filtered.filter(p => p.price >= 20000);
        } else {
            const [min, max] = range.split('-').map(Number);
            filtered = filtered.filter(p => p.price >= min && p.price <= max);
        }
    }
    
    // Search
    const searchInput = document.getElementById('search-input');
    if (searchInput && searchInput.value.trim()) {
        const searchTerm = searchInput.value.toLowerCase();
        filtered = filtered.filter(p =>
            p.name.toLowerCase().includes(searchTerm) ||
            p.description.toLowerCase().includes(searchTerm) ||
            p.features.some(f => f.toLowerCase().includes(searchTerm))
        );
    }
    
    // Sort
    const sortFilter = document.getElementById('sort-filter');
    if (sortFilter) {
        switch (sortFilter.value) {
            case 'price-low':
                filtered.sort((a, b) => a.price - b.price);
                break;
            case 'price-high':
                filtered.sort((a, b) => b.price - a.price);
                break;
        }
    }
    
    return filtered;
}

function applyFilters() {
    currentPage = 1;
    renderAllProducts();
}

function performSearch() {
    applyFilters();
}

function loadMoreProducts() {
    currentPage++;
    renderAllProducts();
}

// Notification Function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add CSS if not exists
    if (!document.getElementById('notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            .notification {
                position: fixed;
                top: 100px;
                right: 20px;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 10000;
                animation: slideIn 0.3s ease-out;
                max-width: 350px;
            }
            .notification-success { background: #4caf50; color: white; }
            .notification-error { background: #f44336; color: white; }
            .notification-info { background: #2196f3; color: white; }
            .notification-content { display: flex; align-items: center; gap: 10px; }
            @keyframes slideIn {
                from { transform: translateX(400px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideIn 0.3s ease-out reverse';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
// Show Profile Modal
function showProfile() {
    if (!currentUser) {
        showNotification('Please login first', 'error');
        return;
    }
    openModal('profile-modal');
}

// Show Order History
async function showOrderHistory() {
    if (!currentUser) {
        showNotification('Please login first', 'error');
        return;
    }
    
    openModal('order-history-modal');
    const content = document.getElementById('order-history-content');
    
    try {
        const response = await fetch('orders/get_user_orders.php');
        const data = await response.json();
        
        if (data.success && data.orders && data.orders.length > 0) {
            content.innerHTML = `
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: ;">
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Order #</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Date</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Total</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.orders.map(order => `
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 12px;">#${order.order_number}</td>
                                <td style="padding: 12px;">${new Date(order.created_at).toLocaleDateString()}</td>
                                <td style="padding: 12px;">LKR ${parseFloat(order.total_amount).toLocaleString()}</td>
                                <td style="padding: 12px;">
                                    <span style="padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 600; 
                                        background: ${order.status === 'completed' ? '#d4edda' : order.status === 'pending' ? '#fff3cd' : '#f8d7da'};
                                        color: ${order.status === 'completed' ? '#155724' : order.status === 'pending' ? '#856404' : '#721c24'};">
                                        ${order.status.toUpperCase()}
                                    </span>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
        } else {
            content.innerHTML = `
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-shopping-bag" style="font-size: 64px; color: #ddd; margin-bottom: 20px;"></i>
                    <h3 style="color: #666; margin-bottom: 10px;">No Orders Yet</h3>
                    <p style="color: #999;">Start shopping to see your orders here!</p>
                    <button onclick="closeModal('order-history-modal'); window.location.href='products.php'" class="btn-primary" style="margin-top: 20px;">
                        Browse Products
                    </button>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading orders:', error);
        content.innerHTML = `
            <div style="text-align: center; padding: 40px; color: #dc3545;">
                <i class="fas fa-exclamation-circle" style="font-size: 48px; margin-bottom: 15px;"></i>
                <p>Unable to load order history. Please try again later.</p>
            </div>
        `;
    }
}

// Show Track Orders
async function showTrackOrders() {
    if (!currentUser) {
        showNotification('Please login first', 'error');
        return;
    }
    
    openModal('track-orders-modal');
    const content = document.getElementById('track-orders-content');
    
    try {
        const response = await fetch('orders/get_user_orders.php');
        const data = await response.json();
        
        if (data.success && data.orders && data.orders.length > 0) {
            const activeOrders = data.orders.filter(o => o.status !== 'completed' && o.status !== 'cancelled');
            
            if (activeOrders.length > 0) {
                content.innerHTML = activeOrders.map(order => `
                    <div style="padding: 20px; border-radius: 10px; margin-bottom: 15px; border-left: 4px solid #c41e3a;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h4 style="margin: 0; color: #2d2d2d;">Order #${order.order_number}</h4>
                            <div><span style="padding: 5px 12px; border-radius: 5px; font-size: 12px; font-weight: 600; 
                                background: ${order.status === 'processing' ? '#d1ecf1' : '#fff3cd'};
                                color: ${order.status === 'processing' ? '#0c5460' : '#856404'};">
                                ${order.status.toUpperCase()}
                            </span></div>
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; font-size: 14px;">
                            <div><strong>Order Date:</strong> ${new Date(order.created_at).toLocaleDateString()}</div>
                            <div><strong>Total:</strong> LKR ${parseFloat(order.total_amount).toLocaleString()}</div>
                        </div>
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #ddd;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-info-circle" style="color: #17a2b8;"></i>
                                <span style="font-size: 13px; color: #666;">
                                    ${order.status === 'pending' ? 'Your order is being processed' : 
                                      order.status === 'processing' ? 'Your order is being prepared for shipping' : 
                                      'Order status: ' + order.status}
                                </span>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                content.innerHTML = `
                    <div style="text-align: center; padding: 40px;">
                        <i class="fas fa-check-circle" style="font-size: 64px; color: #28a745; margin-bottom: 20px;"></i>
                        <h3 style="color: #666; margin-bottom: 10px;">No Active Orders</h3>
                        <p style="color: #999;">All your orders have been completed!</p>
                    </div>
                `;
            }
        } else {
            content.innerHTML = `
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-box-open" style="font-size: 64px; color: #ddd; margin-bottom: 20px;"></i>
                    <h3 style="color: #666; margin-bottom: 10px;">No Orders to Track</h3>
                    <p style="color: #999;">You don't have any orders yet!</p>
                    <button onclick="closeModal('track-orders-modal'); window.location.href='products.php'" class="btn-primary" style="margin-top: 20px;">
                        Start Shopping
                    </button>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading tracking:', error);
        content.innerHTML = `
            <div style="text-align: center; padding: 40px; color: #dc3545;">
                <i class="fas fa-exclamation-circle" style="font-size: 48px; margin-bottom: 15px;"></i>
                <p>Unable to load tracking information. Please try again later.</p>
            </div>
        `;
    }
}
// Info Modal Functions
function showInfoModal(title, content) {
    alert(title + '\n\n' + content);
}

function getTermsContent() {
    return 'Terms and Conditions for HEALTHFORGE...';
}

function getPrivacyContent() {
    return 'Privacy Policy for HEALTHFORGE...';
}

function getShippingContent() {
    return 'Shipping Information for HEALTHFORGE...';
}