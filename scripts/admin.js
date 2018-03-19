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
            var userName = $("#editName-"+id).val();
            var email = $("#editMail-"+id).val();
            var privilege = $("#editPrivilege-"+id).val();
            var user_id = $("#editUser").val();

            $.post("./updateUser",
                {userName:userName, email:email, privilege:privilege, user_id:user_id},
                function(result){
                    var uname = $result['userName'];
                    var email = $result['email'];
                    var priv = $result['privilege'] == "1" ? "Administrator" : "General User";
                    $("#readName-"+id).html(uname);
                    $("#readMail-"+id).html(email);
                    $("#readPrivilege-"+id).html(priv);
                    $("#editName-"+id).val(uname);
                    $("#editMail-"+id).val(email);
                    $("#editPrivilege-"+id).val($result['privilege']);
            });

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
        var userName = $("#addUserName").val();
        var email = $("#addEmail").val();
        var privilege = $("#addPrivilege").val();

        $.post("./addUser",{userName:userName, email:email, privilege:privilege}, function(user){
            var pri = (user['privilege'] == "1") ? "Administrator" : " General User";
            var newUser = "<tr>\n" +
                "                <th><span id=\"readName-" + user['user_id'] + "\">user['userName']</span>\n" +
                "                    <input id=\"editName-" + user['user_id'] + "\" class=\"form-control form-control-sm edit-input\" type=\"text\" value=\"user['userName']\">\n" +
                "                </th>\n" +
                "                <td><span id=\"readMail-" + user['user_id'] + "\">user['email']</span>\n" +
                "                    <input id=\"editMail-" + user['user_id'] + "\" class=\"form-control form-control-sm edit-input\" type=\"text\" value=\"user['email']\">\n" +
                "                </th>\n" +
                "                <td><span id=\"readPrivilege-" + user['user_id'] + "\">\n" + pri + "</span>\n\n" +
                "                    <select id=\"editPrivilege-" +  user['user_id'] + "\" class=\"form-control form-control-sm edit-input\">\n" +
                "                        <option value=\"2\">General User</option>\n" +
                "                        <option value=\"1\">Administrator</option>\n" +
                "                    </select>\n" +
                "                </td>\n" +
                "                <td><button id=\"editUser\" type=\"button\" class=\"btn text-success edit\" value=\"" + user['user_id'] + "\">Edit</button> </td>\n" +
                "            </tr>";
            $("#usersTable tr:last-child").after(newUser);
            $(".edit-input").hide();
        });
    });
});