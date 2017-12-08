$(window).scroll(function () {
    if ($(this).scrollTop() > 750) {
        $("nav").removeClass("navNoBG");
    }
    else {
        $("nav").addClass("navNoBG")
    }
});