$(document).ready(function() {
    //show fields after page load
    $("#login-box").hide();
    $("#login-box").fadeIn(600);

    //validate email while user typing
    $("#email, #password").keyup(function(){
        //get email or password
        var login = $(this).val();
        var id = $(this).attr("id");

        //send login info
        sendData(login, id, "false");
    });

    //validate sign in form on submit button
    $("#sign-in").click(function(){
        $("#failed").html('');

        //get email
        var login = $("#email").val();
        var id = $("#email").attr("id");

        //send email and password
        for(i = 0; i < 2; i++) {
            sendData(login, id, "true");

            //get password after sending email
            login = $("#password").val();
            id = $("#password").attr("id");
        }
    });

    //this method validate login info while user typing
    function sendData(login, id, submit)
    {
        //send login to the file
        $.post("model/login-validation.php",{login:login, input_id:id, submit:submit}, function(result){
            console.log(result);
            if(result == "false") {
                $("#"+id).css("border", "1px solid red");
            } else if(result == "true"){
                $("#"+id).css("border", "1px solid green");
            } else if(result.includes("failed")){
                $("#failed").html("Incorrect email or password!");
            } else {
                window.location.href = "http://gsingh.greenriverdev.com/328/project-portal/signIn";
            }
        });
    }
});