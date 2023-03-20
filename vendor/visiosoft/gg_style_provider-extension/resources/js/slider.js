<!-- Initialize Swiper -->
let paginationImages = $('.swiper-paginate-images').map((i, obj) => $(obj).attr('data-img_src'));

var swiper = new Swiper(".mySwiper", {
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        renderBullet: function (index, className) {
            return `<div class="${className}"><img class="swiper-border" src="${paginationImages[index]}" ></div>`;
        },
    },
});
