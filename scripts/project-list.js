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

    //search the project
    $("#search").keyup(function () {
        $("#list").html(''); //clear the list when key up
        $("#no-result").html(""); //clear the no result found div
        $("#list").hide(); //hide list
        $("#loader").addClass('loader'); //add loaded class when search
        $("#orig-list").hide(); //hide the original list

        //get the search term
        var term = $("#search").val();
        var url = "http://gsingh.greenriverdev.com/328/project-portal/";
        var githubUrl = "//"; var trelloUrl = "//"; var projectUrl = "//";

        //send ajax request with keyword to route
        $.get(url,{keyword:term}, function (result) {
            var results = jQuery.parseJSON(result); //convert result into json

            if(results.length <= 0) { //show no result found msg if item not found
                $("#no-result").html("No Result Found");
            }

            //append the result into the list
            $.each(results, function (index, item){
                githubUrl += item.github; trelloUrl += item.trello; projectUrl += item.url;
                $("#list").append("<div class='list'>\n" +
                    "    <div class='row'>\n" +
                    "        <div class='col'>\n" +
                    "            <p class='h3'>"+item.pTitle+"</p>\n" +
                    "            <hr>\n" +
                    "            <p>\n" +
                    "                "+item.description+"\n" +
                    "            </p>\n" +
                    "\n" +
                    "            <div class='row'>\n" +
                    "                <div class='col-6'>\n" +
                    "                    <a href='"+githubUrl+"' target='_blank'>Github,</a>\n" +
                    "                    <a href='"+trelloUrl+"' target='_blank'>Trello,</a>\n" +
                    "                    <a href='"+projectUrl+"' target='_blank'>Project Url</a>\n" +
                    "                </div>\n" +
                    "\n" +
                    "                <div class='col-6 text-right'>\n" +
                    "                    <a class='btn btn-outline-primary rounded-0' href='project/"+item.pid+"' role='button'>View</a>\n" +
                    "                </div>\n" +
                    "            </div>\n" +
                    "        </div>\n" +
                    "    </div>\n" +
                    "</div>");
                $("#list").fadeIn(300);
                $("#loader").removeClass('loader'); //remove loader class
                githubUrl = "//"; trelloUrl = "//"; projectUrl = "//";
            });
            $("#loader").removeClass('loader'); //remove class here if not go in above loop
        });
    });
});