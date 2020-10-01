<?php
include 'Connect/db_connect.php';
if($mysqli->connect_errno){
    echo 'Connection error';
    exit;
}


include 'View/login.php';
?>
<script>
    $(document).ready(function () {
        $("#register_btn").click(
            function () {
                sendAjaxForm('message-block','register_form','Controller/registration.php');
                return false;
            }
        );
    });
    
    function sendAjaxForm(result_form, ajax_form, url) {
        $.ajax({
            url: url,
            method: "POST",
            dataType: "html",
            data: $("#"+ajax_form).serialize(),
            success: function (response) {
                alert(response);
            },
            error: function (response) {
                alert("Error");
            }
        });
    }
</script>
