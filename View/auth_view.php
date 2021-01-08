<div class="col-md-12">
    <h3>Authorization</h3>
    <form method="post" action="" id="auth_form">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <button type="submit" id="auth_btn" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        $("#auth_btn").click(
            function () {
                sendAjaxForm('message-block','auth_form','/auth/auth');
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
                response.message.forEach(function (item) {
                    $("."+ result_form).append(item);
                });
                if(response.UID){
                    window.location.href = window.location.origin;
                }
            },
            error: function (response) {
                alert("Error");
            }
        });
    }
</script>

