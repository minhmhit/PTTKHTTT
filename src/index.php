<?php
include 'includes/db.php'; // Kết nối cơ sở dữ liệu
include 'includes/header.php'; // Header của trang

// Truy vấn danh sách sản phẩm từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$result = $stmt->get_result();
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
$products_json = json_encode($products); // Chuyển dữ liệu sang JSON để sử dụng trong JavaScript
?>

<div class="container">
    <!-- Carousel banner khuyến mãi -->
    <div class="carousel">
        <button class="prev-btn">❮</button>
        <div class="carousel-wrapper">
            <div class="carousel-item active">
                <img src="public/images/banner1.png" alt="Khuyến mãi 1">
            </div>
            <div class="carousel-item">
                <img src="public/images/banner2.png" alt="Khuyến mãi 2">
            </div>
        </div>
        <button class="next-btn">❯</button>
    </div>

    <!-- Sidebar quảng cáo -->
    <div class="sidebar">
        <img src="public/images/discount.png" alt="Ưu đãi" class="promo-img">
    </div>
</div>

<!-- Tiêu đề danh sách sản phẩm -->
<h2 class="section-title">Menu</h2>

<!-- Bộ lọc sản phẩm -->
<div class="filter-container">
    <label for="filter-type">Lọc theo loại:</label>
    <select id="filter-type" onchange="filterProducts()">
        <option value="all">Tất cả</option>
        <option value="hat">Cà phê hạt</option>
        <option value="bot">Cà phê bột</option>
        <option value="goi">Cà phê gói</option>
    </select>

    <label for="filter-price">Lọc theo giá:</label>
    <select id="filter-price" onchange="filterProducts()">
        <option value="all">Tất cả</option>
        <option value="duoi50">Dưới 50,000đ</option>
        <option value="tren50">Trên 50,000đ</option>
    </select>

    <label for="filter-origin">Lọc theo xuất xứ:</label>
    <select id="filter-origin" onchange="filterProducts()">
        <option value="all">Tất cả</option>
        <option value="Vietnam">Việt Nam</option>
        <option value="Brazil">Brazil</option>
        <option value="Colombia">Colombia</option>
    </select>
</div>

<!-- Khu vực hiển thị sản phẩm -->
<section class="products" id="products-container"></section>

<!-- Phân trang -->
<div class="pagination">
    <button onclick="prevPage()">❮ Trước</button>
    <span id="page-info">Trang 1</span>
    <button onclick="nextPage()">Sau ❯</button>
</div>

<!-- JavaScript điều khiển chức năng -->
<script>
    const products = <?php echo $products_json; ?>;
    let currentPage = 1;
    const productsPerPage = 6;

    // Hàm lọc sản phẩm
    function filterProducts() {
        const type = document.getElementById('filter-type').value;
        const price = document.getElementById('filter-price').value;
        const origin = document.getElementById('filter-origin').value;

        const filtered = products.filter(product => {
            const typeMatch = type === 'all' || product.type === type;
            const priceMatch = price === 'all' ||
                (price === 'duoi50' && parseFloat(product.price) < 50000) ||
                (price === 'tren50' && parseFloat(product.price) >= 50000);
            const originMatch = origin === 'all' || product.origin === origin;
            return typeMatch && priceMatch && originMatch;
        });

        currentPage = 1; // Reset về trang đầu tiên khi lọc
        displayProducts(filtered, currentPage);
    }

    // Hàm hiển thị sản phẩm
    function displayProducts(products, page) {
        const start = (page - 1) * productsPerPage;
        const end = start + productsPerPage;
        const pageProducts = products.slice(start, end);

        const container = document.getElementById('products-container');
        container.innerHTML = '';
        if (pageProducts.length === 0) {
            container.innerHTML = '<p>Không có sản phẩm nào phù hợp.</p>';
        } else {
            pageProducts.forEach(product => {
                const div = document.createElement('div');
                div.className = 'product';
                div.innerHTML = `
                <a href="product.php?id=${product.id}">
                    <img src="public/images/${product.image}" alt="${product.name}">
                    <h2>${product.name}</h2>
                    <p>Giá: ${Number(product.price).toLocaleString('vi-VN')}đ</p>
                </a>
            `;
                container.appendChild(div);
            });
        }

        document.getElementById('page-info').innerText = `Trang ${page}`;
    }

    // Chuyển trang trước
    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            filterProducts();
        }
    }

    // Chuyển trang sau
    function nextPage() {
        const filteredProducts = getFilteredProducts();
        const totalPages = Math.ceil(filteredProducts.length / productsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            filterProducts();
        }
    }

    // Lấy danh sách sản phẩm đã lọc
    function getFilteredProducts() {
        const type = document.getElementById('filter-type').value;
        const price = document.getElementById('filter-price').value;
        const origin = document.getElementById('filter-origin').value;

        return products.filter(product => {
            const typeMatch = type === 'all' || product.type === type;
            const priceMatch = price === 'all' ||
                (price === 'duoi50' && parseFloat(product.price) < 50000) ||
                (price === 'tren50' && parseFloat(product.price) >= 50000);
            const originMatch = origin === 'all' || product.origin === origin;
            return typeMatch && priceMatch && originMatch;
        });
    }

    // Khởi tạo trang
    filterProducts();

    // Điều khiển carousel
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-item');
    const totalSlides = slides.length;

    document.querySelector('.next-btn').addEventListener('click', () => {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % totalSlides;
        slides[currentSlide].classList.add('active');
    });

    document.querySelector('.prev-btn').addEventListener('click', () => {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        slides[currentSlide].classList.add('active');
    });
</script>

<?php include 'includes/footer.php'; // Footer của trang 
?>