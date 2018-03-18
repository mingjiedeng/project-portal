$(document).ready(function(){
    //hide search bar
    $("#search").hide();
    $(".list").hide();
    //fade in content
    $(".list").each(function (index) {
        $(this).delay(120*index).fadeIn(500);
    });
    $(window).resize(function() {
        console.log($(window).width());
    });
    //add red border to the bottom of search bar
    $("#search").focus(function(){
        $("#search-icon").addClass("red-border");
    });
    //remove class when user click in blank space
    $("body").click(function(){
        $("#search").removeClass("red-border");
        $("#search-icon").removeClass("red-border");
    });
    //show search bar
    $("#search-icon").click(function(){
        $("#search").show(400);
    });
    //add and remove class from btn
    $(".list").mouseover(function(){
        $(this).find(".btn").removeClass("btn-outline-primary");
        $(this).find(".btn").addClass("btn-primary");
    });
    $(".list").mouseout(function(){
        $(this).find(".btn").removeClass("btn-primary");
        $(this).find(".btn").addClass("btn-outline-primary");
    });
});