import './bootstrap';

import Alpine from 'alpinejs';

import '../css/products.css';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    const imageInput = document.getElementById("imageInput");
    const fileName = document.getElementById("fileName");
    const previewContainer = document.getElementById("previewContainer");
    const previewImage = document.getElementById("previewImage");

    if (imageInput) {
        imageInput.addEventListener("change", (event) => {
            const file = event.target.files[0];
            if (file) {
                // ファイル名を表示
                fileName.textContent = file.name;

                // プレビューを表示
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
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".product-name-text").forEach(el => {
        const parentWidth = el.parentElement.offsetWidth;
        let fontSize = 20; // 初期サイズ(px)
        el.style.fontSize = fontSize + "px";

        // 親幅を超えるならフォントサイズを縮小
        while (el.scrollWidth > parentWidth && fontSize > 10) {
            fontSize--;
            el.style.fontSize = fontSize + "px";
        }
    });
});

// 全角数字を半角に変換する関数
function toHalfWidth(str) {
    return str.replace(/[０-９]/g, function(s) {
        return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const priceInput = document.querySelector("input[name='price']");
    const stockInput = document.querySelector("input[name='stock']");

    [priceInput, stockInput].forEach(input => {
        if (input) {
            // フォーカス外れたときに変換
            input.addEventListener("blur", function() {
                this.value = toHalfWidth(this.value);
            });
        }
    });
});
