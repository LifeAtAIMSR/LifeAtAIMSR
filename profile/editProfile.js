$(document).ready(function () {
    $("#edit-name-btn").click(function () {
        var firstName = $("#edit-first-name-field").val();
        var lastName = $("#edit-last-name-field").val();

        $.post("editProfileName.php", {
            firstName: firstName,
            lastName: lastName
        }, function (data) {
            if (data == "success") {
                $("#profile-name").html(firstName + " " + lastName)
            }
        });
    });

    $("#change-password-btn").click(function() {
        var password = $("#original-password-field").val();
        var new_password = $("#new-password-field").val();
        
        $.post("checkOldPassword.php", {
            password: password
        }, function (data) {
            if (data == "Match") {
                
                $.post("updatePassword.php", {
                    new_password: new_password
                }, function (data) {
                    if (data == "success") {
                        alert(data);
                    } else {
                        alert(data);
                    }
                })

            } else {
                alert(data);
            }
        })
    })

});