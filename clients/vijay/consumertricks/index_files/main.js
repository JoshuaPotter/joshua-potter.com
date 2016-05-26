var images = [];
images[0] = "img/banner-img-1.png";
images[1] = "img/banner-img-2.png";
images[2] = "img/banner-img-1.png";
images[3] = "img/banner-img-2.png";
images[4] = "img/banner-img-1.png";
images[5] = "img/banner-img-2.png";
images[6] = "img/banner-img-1.png";
images[7] = "img/banner-img-2.png";
images[8] = "img/banner-img-1.png";

var i = 0;
setInterval(fadeDivs, 5000);

function fadeDivs() {
    i = i < images.length ? i : 0;
    console.log(i)
    $('.psych img').fadeOut(400, function(){
        $(this).attr('src', images[i]).fadeIn(400);
    })
    i++;
}