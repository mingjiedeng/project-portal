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

    $("#add-cred").click(function(){
        $("#login-error").html('');
        $("#add-btn").show();
        $("#exampleModalLabel").html("Add Credentials");
        $("#add-login").show();
        // $("#url").hide();
        $("#add-contact").hide();
    });

    $("#add-conct").click(function(){
        $("#login-error").html('');
        $("#add-btn").show();
        $("#exampleModalLabel").html("Add Contact");
        $("#add-contact").show();
        // $("#url").hide();
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
                "                        <input id="+"classname_"+input_id+" type='text' name='className[]' placeholder='Class name:'>\n" +
                "                    </div>\n" +
                "                    <div class='col-md-4'>\n" +
                "                    <span id="+"quarter_"+ input_id +"-error class='text-danger'></span>\n"+
                "                        <input id="+"quarter_"+input_id+" type='text' name='quarter[]' placeholder='Quarter: example spring 2017'>\n" +
                "                    </div>\n" +
                "                    <div class='col-md-4'>\n" +
                "                    <span id="+"instructor_"+ input_id +"-error class='text-danger'></span>\n"+
                "                        <input id="+"instructor_"+input_id+" type='text' name='instructor[]' placeholder='Instructor:'>\n" +
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

    //send form data after user hit submit button
    $('form').on('submit', function (e) {
        e.preventDefault(); //prevent page reload

        //set submit flag
        var set = 'submit';
        var data = $('form').serializeArray(); //serialize form data
        data.push({name:'submit', value:set}); //set submit

        $.post("./addProject", data, function (result) {
            if(result.includes(":")) {
                var results = jQuery.parseJSON(result); //covert result into json
                $.each(results, function (index, item) { //loop over and get the values
                    var input_name = item.split(":");
                    $("#" + input_name[0] + "-error").html(input_name[1]); //show errors
                });
            }
        });
    });

    //add login credentials
    $('#add-btn').click(function () {
        var set = 'submit';
        var btn = 'addCred';
        //change btn name base on which field is visible
        if($("#add-login").is(":hidden"))
            btn = "addContact";

        //serialize form data
        var data = $('#login-form').serializeArray();
        data.push({name:btn, value:set}); //push submit flag

        //send data using post method
        $.post("model/validate-hiddenfields.php", data, function (result) {
            // show error is not success
            if(!result.includes("-")) {
                $("#login-error").html(result);
            } else { //other wise hide the fields and show success message
                var part = result.split("-");
                $("#login-error").removeClass('text-danger');
                $("#login-error").addClass('text-success');

                if(part[1].substring(0, 4) == 'User') {
                    $("#username").hide(); $("#password").hide(); $("#add-btn").hide();
                    $("#login-error").html("Login credentials has been added");

                    $("#added-cred").html(part[1]);
                    $("#added-cred, #rm-cred").addClass("add-rm-cred"); $("#rm-cred").addClass("rm-cred");

                    $("#rm-cred").html("x");
                    $("#add-cred").hide(150);
                } else {
                    $("#login-error").html("Contact has been added");
                }
            }
        });
    });

    //remove login credentials
    $("#rm-cred").click(function(){
        var login = 'login';
        $("#username").val(''); $("#password").val('');

        //serialize form data
        var data = $('#login-form').serializeArray();
        data.push({name:'remove', value:'login'}); //push submit flag

        $.post("model/validate-hiddenfields.php", data, function (result) {
            $("#username").show(); $("#password").show(); $("#add-btn").show();
            $("#login-error").addClass('text-danger');

            $("#added-cred").html("");
            $("#added-cred, #rm-cred").removeClass("add-rm-cred"); $("#rm-cred").removeClass("rm-cred");

            $("#rm-cred").html("");
            $("#add-cred").show(150);
        });
    });
});