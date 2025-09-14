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