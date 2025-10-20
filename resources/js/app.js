import './bootstrap';
import Alpine from 'alpinejs';
import '../css/products.css';
import './products.js';

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

    // --- プロダクト名・メーカー名のフォント調整 ---
    const adjustTextSize = (selector) => {
        document.querySelectorAll(selector).forEach(el => {
            const parentWidth = el.parentElement.clientWidth; // offsetWidthより安定
            let fontSize = 20;
            el.style.fontSize = fontSize + "px";
    
            while (el.scrollWidth > parentWidth && fontSize > 10) {
                fontSize--;
                el.style.fontSize = fontSize + "px";
            }
        });
    };
    
    // 商品名とメーカー名の両方に適用
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

});

$(document).on('click', '#searchBtn', function() {
    let keyword = $('#keyword').val();

    $.ajax({
        url: '/products/search', // Controller の検索用ルート
        type: 'GET',
        data: {
            keyword: $('#keyword').val(),
            category: $('#category').val(),
            price_min: $('#price_min').val(),
            price_max: $('#price_max').val(),
            stock_min: $('#stock_min').val(),
            stock_max: $('#stock_max').val()
        },
                success: function(data) {
            console.log(data); // 確認用
            $('#productTable tbody').html(data.html);
            $('#pagination').html(data.pagination);
        },
        error: function() {
            console.log('検索に失敗しました');
        }
    });

    // --- 削除フォーム ---
    $(document).on('submit', '.deleteProductForm', function(e) {
        e.preventDefault(); // 通常のフォーム送信を止める
    
        if (!confirm('本当に削除しますか？')) return;
    
        const form = $(this);
        const url = form.attr('action');
        const token = form.find('input[name="_token"]').val();
    
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: token,
            },
            success: function(response) {
                // 削除した行を非表示
                form.closest('tr').fadeOut();
            },
            error: function(xhr) {
                alert('削除に失敗しました');
            }
        });
    });    
});