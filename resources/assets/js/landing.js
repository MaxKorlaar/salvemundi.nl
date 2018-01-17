let scrollThreshold = $('.landing').height();
$(window).scroll(function () {
    if ($(this).scrollTop() > scrollThreshold) {
        $("header").removeClass("no-background");
    }
    else {
        $("header").addClass("no-background");
    }
});
if ($(window).scrollTop() > scrollThreshold) {
    $("header").removeClass("no-background");
}