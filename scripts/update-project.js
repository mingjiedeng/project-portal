$(document).ready(function() {
    // hide all edit forms at first
    $(".edit-form").hide();
    $(".edit").hide();
    //show edit form after clicking on edit button
    $(".edit").click(function () {
        var block = $(this).attr('id');
        $("#edit_" + block).show(250);
        $("#read_" + block).hide(150);
    });

    //hide edit form and show readable form data again
    //after clicking cancel button
    $(".cancel-update").click(function () {
        $(".edit-form").hide(150);
        $(".read-form").show(250);
    });

    //show edit on hover current block
    $(".read-form").mouseover(function () {
        $('.edit').hide();
        $(this).find(".edit").show();
    });
});