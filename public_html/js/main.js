let scrollThreshold = $('.landing').height();
$(window).scroll(function () {
    if ($(this).scrollTop() > scrollThreshold) {
        $("header").removeClass("no-bg");
    }
    else {
        $("header").addClass("no-bg");
    }
});