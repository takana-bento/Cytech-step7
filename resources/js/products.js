import './bootstrap';
import Alpine from 'alpinejs';
import '../css/products.css';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener("DOMContentLoaded", () => {

    // --- 画像プレビュー ---
    const imageInput = document.getElementById("imageInput");
    const fileName = document.getElementById("fileName");
    const previewContainer = document.getElementById("previewContainer");
    const previewImage = document.getElementById("previewImage");

    if (imageInput) {
        imageInput.addEventListener("change", (event) => {
            const file = event.target.files[0];
            if (file) {
                fileName.textContent = file.name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove("hidden");
                };
                reader.readAsDataURL(file);
            } else {
                fileName.textContent = "";
                previewContainer.classList.add("hidden");
                previewImage.src = "";
            }
        });
    }

    // --- 商品名・メーカー名の文字サイズ調整 ---
    const adjustTextSize = (selector) => {
        document.querySelectorAll(selector).forEach(el => {
            const parentWidth = el.parentElement.clientWidth;
            let fontSize = 20;
            el.style.fontSize = fontSize + "px";

            while (el.scrollWidth > parentWidth && fontSize > 10) {
                fontSize--;
                el.style.fontSize = fontSize + "px";
            }
        });
    };
    adjustTextSize(".product-name-text");
    adjustTextSize(".company-name-text");

    // --- 全角数字を半角に変換 ---
    const toHalfWidth = (str) => str.replace(/[０-９]/g, s => String.fromCharCode(s.charCodeAt(0) - 0xFEE0));

    const priceInput = document.querySelector("input[name='price']");
    const stockInput = document.querySelector("input[name='stock']");
    [priceInput, stockInput].forEach(input => {
        if (input) {
            input.addEventListener("blur", function() {
                this.value = toHalfWidth(this.value);
            });
        }
    });

    // --- Ajax検索 ---
    const fetchProducts = (url, data = {}) => {
        $.ajax({
            url: url,
            type: 'GET',
            data: data,
            success: function(res) {
                $('#productTable tbody').html(res.html);
                $('#pagination').html(res.pagination);
                adjustTextSize(".product-name-text");
                adjustTextSize(".company-name-text");
            },
            error: function() {
                console.log('検索に失敗しました');
            }
        });
    };

    // 検索ボタン
    $(document).on('click', '#searchBtn', function() {
        const keyword = $('#keyword').val();
        const company_id = $('select[name="company_id"]').val();
        const price_min = $('#price_min').val();
        const price_max = $('#price_max').val();
        const stock_min = $('#stock_min').val();
        const stock_max = $('#stock_max').val();

        fetchProducts(productSearchUrl, { keyword, company_id, price_min, price_max, stock_min, stock_max });
    });
    
    // ページネーションリンクのAjax対応
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url) {
            const keyword = $('#keyword').val();
            const company_id = $('select[name="company_id"]').val();
            const price_min = $('#price_min').val();
            const price_max = $('#price_max').val();
            const stock_min = $('#stock_min').val();
            const stock_max = $('#stock_max').val();

            fetchProducts(url, { keyword, company_id, price_min, price_max, stock_min, stock_max });
        }
    });

    // ソート機能
    let sortColumn = 'id';
    let sortDirection = 'desc';

    $('.sortable').removeClass('bg-gray-200');
    $(`.sortable[data-column="${sortColumn}"]`).addClass('bg-gray-200');

    $(document).on('click', '.sortable', function() {
        const column = $(this).data('column');
        sortDirection = (sortColumn === column && sortDirection === 'asc') ? 'desc' : 'asc';
        sortColumn = column;

        const keyword = $('#keyword').val();
        const company_id = $('select[name="company_id"]').val();
        const price_min = $('#price_min').val();
        const price_max = $('#price_max').val();
        const stock_min = $('#stock_min').val();
        const stock_max = $('#stock_max').val();

        fetchProducts(productSearchUrl, { 
            keyword, company_id, price_min, price_max, stock_min, stock_max,
            sort_column: sortColumn, sort_direction: sortDirection
        });
    });

        // --- Ajax削除 ---
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();

        if (!confirm('本当に削除しますか？')) return;

        const url = $(this).attr('href'); // 例: /products/{id}
        
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                // 削除後、リストを再取得
                const keyword = $('#keyword').val();
                const company_id = $('select[name="company_id"]').val();
                const price_min = $('#price_min').val();
                const price_max = $('#price_max').val();
                const stock_min = $('#stock_min').val();
                const stock_max = $('#stock_max').val();

                fetchProducts(productSearchUrl, { keyword, company_id, price_min, price_max, stock_min, stock_max });
            },
            error: function() {
                alert('削除に失敗しました');
            }
        });
    });
});