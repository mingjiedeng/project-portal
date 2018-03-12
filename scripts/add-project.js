$(document).ready(function() {
    //show the form after page load
    $(".new-form").hide();
    $(".new-form").show(300);
    $("input,textarea").hide();
    $("#note").hide();

    //fade in content
    $("input,textarea").each(function (index) {
        $(this).delay(30*index).fadeIn(800);
    });

    //change modal fields on click
    $("#add-url").click(function(){
        $("#exampleModalLabel").html("Add Url");
        $("#url").show();
        $("#add-login").hide();
        $("#add-contact").hide();
    });

    $("#add-cred").click(function(){
        $("#exampleModalLabel").html("Add Credentials");
        $("#add-login").show();
        $("#url").hide();
        $("#add-contact").hide();
    });

    $("#add-conct").click(function(){
        $("#exampleModalLabel").html("Add Contact");
        $("#add-contact").show();
        $("#url").hide();
        $("#add-login").hide();
    });

    //add more classes field on button click
    var class_id = 0;
    var input_id = 1;
    $("#remove-class").hide();
    $("#add-class").click(function() {
        $("#remove-class").show(300);
        if(class_id < 4)
        {
            class_id++;
            input_id++;
            $("#class-info").append("<div id='" + class_id + "' class='form-group row'>\n" +
                "                    <div class='col-md-4'>\n" +
                "                    <span id="+"classname_"+ input_id +"-error class='text-danger'></span>\n"+
                "                        <input id="+"classname_"+input_id+" type='text' name='classname[]' placeholder='Class name:'>\n" +
                "                    </div>\n" +
                "                    <div class='col-md-4'>\n" +
                "                    <span id="+"quarter_"+ input_id +"-error class='text-danger'></span>\n"+
                "                        <input id="+"quarter_"+input_id+" type='text' name='quarter[]' placeholder='Quarter:'>\n" +
                "                    </div>\n" +
                "                    <div class='col-md-4'>\n" +
                "                    <span id="+"year_"+ input_id +"-error class='text-danger'></span>\n"+
                "                        <input id="+"year_"+input_id+" type='text' name='year[]' placeholder='Year:'>\n" +
                "                    </div>\n" +
                "                </div>");
            $('#'+class_id).hide();
        }
        $("#"+class_id).show(300);
    });

    //remove class field by clicking remove button
    $("#remove-class").click(function(){
        $('#'+class_id).remove();
        if(class_id > 0) {
            class_id--;
            input_id--;
        }
        if(class_id == 0)
            $("#remove-class").fadeOut("slow");
    });

    //validate all input and text-area fields by making ajax calls
    $("body").on( "focus", "input, textarea", function() {
        $(this).focusout(function(){
            var value = $(this).val(); //get input value
            // var input_name = $(this).attr('name'); //get input name attribute
            var input_name = $(this).attr('id');

            //Make Ajax call
            $.post("model/validation.php",{input:value, name:input_name}, function(result){
                $("#"+input_name+"-error").html(result);
            });
        });
    });

    //validate drop down
    $("#status").change(function(){
       var value = $(this).val();
       var input_name = 'status';

        //Make Ajax call
        $.post("model/validation.php",{input:value, name:input_name}, function(result){
            $("#"+input_name+"-error").html(result);
        });
    });

    $('form').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            type: 'post',
            url: 'model/validation.php',
            data: $('form').serialize(),
            dataType: 'json'
        }).done(function(result) {
            $.each(result, function(index, item){
                $("#test").append(item);
            });
        }).fail(function(data) {
        });
    });
});