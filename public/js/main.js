let scrollThreshold = $('.landing').height();
$(window).scroll(function () {
    if ($(this).scrollTop() > scrollThreshold) {
        $("nav").removeClass("no-bg");
    }
    else {
        $("nav").addClass("no-bg");
    }
});