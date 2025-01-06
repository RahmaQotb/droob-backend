if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
/****************************/
setInterval(function() { location.reload(); }, (7200 * 1000));
/****************************/
var postContent = CKEDITOR.replace('postContent');
CKFinder.setupCKEditor(postContent);

/*******Slick*********/
$('.post-wrapper').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    nextArrow: $('.next'),
    prevArrow: $('.prev'),
    responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ]
});
/******************************************************* */

var x = document.getElementsByClassName("sd");
x[0].setAttribute("class", "active");
var y = document.getElementsByClassName("carousel-item");
y[0].setAttribute("class", "carousel-item active");
/******************************************************* */
