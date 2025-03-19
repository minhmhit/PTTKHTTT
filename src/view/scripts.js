document.addEventListener("DOMContentLoaded", function () {
    const items = document.querySelectorAll(".carousel-item");
    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");
    let currentIndex = 0;
    let autoSlide; // Biến để lưu interval

    function updateCarousel() {
        items.forEach((item, index) => {
            item.style.display = index === currentIndex ? "block" : "none";
        });
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % items.length;
        updateCarousel();
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + items.length) % items.length;
        updateCarousel();
    }

    function startAutoSlide() {
        autoSlide = setInterval(nextSlide, 3000); // Chuyển slide mỗi 3 giây
    }

    function resetAutoSlide() {
        clearInterval(autoSlide); // Dừng slide tự động khi bấm nút
        startAutoSlide(); // Bắt đầu lại sau khi bấm
    }

    // Bắt sự kiện nút nhấn
    prevBtn.addEventListener("click", function () {
        prevSlide();
        resetAutoSlide();
    });

    nextBtn.addEventListener("click", function () {
        nextSlide();
        resetAutoSlide();
    });

    updateCarousel();
    startAutoSlide(); // Khởi động auto slide khi load trang
});
let currentPage = 1;
const productsPerPage = 6; // Hiển thị 4 sản phẩm trên mỗi trang
const products = document.querySelectorAll(".product");
const totalPages = Math.ceil(products.length / productsPerPage);

function showPage(page) {
    products.forEach((product, index) => {
        product.style.display =
            index >= (page - 1) * productsPerPage && index < page * productsPerPage
                ? "block"
                : "none";
    });
    document.getElementById("page-info").innerText = `Trang ${page}`;
}

function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
    }
}

function nextPage() {
    if (currentPage < totalPages) {
        currentPage++;
        showPage(currentPage);
    }
}
// Hiển thị trang đầu tiên khi tải trang
showPage(currentPage);
function filterProducts() {
    var selectedCategory = document.getElementById("filter").value;
    var products = document.querySelectorAll(".product");

    products.forEach(function(product) {
        // Lấy loại sản phẩm từ class của từng sản phẩm
        var productType = product.getAttribute("data-category");

        if (selectedCategory === "all" || productType === selectedCategory) {
            product.style.display = "block";
        } else {
            product.style.display = "none";
        }
    });
}
document.addEventListener("DOMContentLoaded", function () {
    const typeFilter = document.getElementById("filter-type");
    const priceFilter = document.getElementById("filter-price");
    const originFilter = document.getElementById("filter-origin");
    const products = document.querySelectorAll(".product");

    function filterProducts() {
        const selectedType = typeFilter.value;
        const selectedPrice = priceFilter.value;
        const selectedOrigin = originFilter.value;

        products.forEach(product => {
            const productType = product.getAttribute("data-type");
            const productPrice = parseInt(product.getAttribute("data-price"));
            const productOrigin = product.getAttribute("data-origin");
            
            let typeMatch = (selectedType === "all" || productType === selectedType);
            let priceMatch = (selectedPrice === "all" || 
                (selectedPrice === "50000" && productPrice <= 50000) || 
                (selectedPrice === "55000" && productPrice > 50000));
            let originMatch = (selectedOrigin === "all" || productOrigin === selectedOrigin);
            
            if (typeMatch && priceMatch && originMatch) {
                product.style.display = "block";
            } else {
                product.style.display = "none";
            }
        });
    }

    typeFilter.addEventListener("change", filterProducts);
    priceFilter.addEventListener("change", filterProducts);
    originFilter.addEventListener("change", filterProducts);
});
