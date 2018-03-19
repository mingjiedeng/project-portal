$(document).ready(function() {
    $(".edit-input").hide();

    $(".edit").click(function(){
        var id = $(this).val();

        //show the edit field of current row and hide all the reading info
        //of current row
        if($(this).html() == 'Edit') {
            $("#readName-"+id).hide();
            $("#editName-"+id).show();

            $("#readMail-"+id).hide();
            $("#editMail-"+id).show();

            $("#readPrivilege-"+id).hide();
            $("#editPrivilege-"+id).show();

            $(this).html('Update')
        } else { //switch back to reading mode after clicking update btn
            $(this).html('Edit')
            $("#readName-"+id).show();
            $("#editName-"+id).hide();

            $("#readMail-"+id).show();
            $("#editMail-"+id).hide();

            $("#readPrivilege-"+id).show();
            $("#editPrivilege-"+id).hide();
        }
    });

    $("#addUser").click(function () {
        var userName = $("#addUserName");
        var email = $("#addEmail");
        var privilege = $("#addPrivilege");

        $.post("/addUser",{userName:userName, email:email, privilege:privilege}, function(result){ alert(result)});

        // $.ajax({
        //     type:'post',
        //     url:'addUser',
        //     data:{"userName":userName,
        //           "email":email,
        //           "privilege":privilege
        //     },
        //     cache:false,
        //     success:function(result){
        //         alert(result);
        //     }
        // });
    });
});