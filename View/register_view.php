
<div class="col-md-12">
    <h3>Registration</h3>
    <form method="post" action="" id="register_form">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">

        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>

        <button type="submit" id="register_btn" class="btn btn-primary">Submit</button>
    </form>
    <div id="register_success_block"></div>
</div>

<script>
    $(document).ready(function () {
        $("#register_btn").click(
            function () {
                sendAjaxForm('message-block','register_form','/register/register');
                return false;
            }
        );
    });

    function sendAjaxForm(result_form, ajax_form, url) {
        $.ajax({
            url: url,
            method: "POST",
            dataType: "html",
            data: $("#"+ ajax_form).serialize(),
            success: function (response) {
                $("."+ result_form).html("");
                response = JSON.parse(response);
                if (response.error){
                    response.error.forEach(function (item) {
                        $("."+ result_form).append(item);
                    });
                }else if(response.message){
                    response.message.forEach(function (item) {
                        $("."+ result_form).append(item);
                    });
                    $("#register_form").hide(200);
                    $("#register_success_block").html("<a href='/auth' role='button' class='btn btn-success'>Authorization</a>");
                }

            },
            error: function (response) {
                alert("Error");
            }
        });
    }
</script>