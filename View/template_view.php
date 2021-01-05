<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/css/bootstrap-grid.min.css">
    <link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/css/bootstrap-reboot.css">
    <link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/css/bootstrap-utilities.css">
    <link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/css/custom.css">
    <script src="https://kit.fontawesome.com/fbeb08ead3.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="../js/alerts.js"></script>
    <script src="../js/ajax.js"></script>
</head>
<body>

<div class="app">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
                <?php if ($UID): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/dashboard">Dashboard</a>
                </li>
                <?php endif; ?>


            </ul>
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Login
                </a>
                <div class="dropdown-menu dropdown-menu_right" aria-labelledby="navbarDropdown">
                    <?php if (!$UID): ?>
                    <a class="dropdown-item" href="/register">Registration</a>
                    <a class="dropdown-item" href="/auth">Authorization</a>
                    <?php else: ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/main/out">Logout</a>
                </div>
                <?php endif;?>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="message-block col-sm-12"></div>

<?php include 'View/'.$content_view; ?>

        </div>
    </div>
</div>

<div id="PromiseConfirm" class="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-check-circle text-success"></i> <span>Подтвердите действие</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
