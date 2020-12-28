<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <title>reCaptcha</title>
</head>
<body>
<div class="row">
    <div class="col-4"></div>
    <div class="col-4">
        {if $success_v == true}
            <div class="alert alert-success" role="alert">
                Formulario Enviado con Exito
            </div>
        {/if}
        <form method="POST" id="form1" action="index.php">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" id="name" name="name" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Apellido</label>
                <input type="text" id="last_name" name="last_name" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Telefono</label>
                <input type="number" name="cell" class="form-control">
            </div>
            <div class="mb-3">
                {$recaptcha->render()}
            </div>
            {if $errors != ''}
                <div class="mb-3">
                    <div class="alert alert-danger" role="alert">
                        {foreach from=$errors item=error}
                            <p>{$error}</p>
                        {/foreach}
                    </div>
                </div>
            {/if}
        </form>
    </div>
    <div class="col-4"></div>
</div>

{if $vCaptcha == 2 && $visible == false}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function onSubmit(token) {
            $('#form1').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
            $('#form1').submit();
        }
    </script>
{elseif $vCaptcha == 2}
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
            async defer>
    </script>
    <script type="text/javascript">
        var onloadCallback = function () {
            grecaptcha.render('html_element', {
                'sitekey': '{$secret_client}',
                {if $visible != true}'size': 'invisible'{/if}
            });
        };
    </script>
{else}
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
            $('#form1').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
            $('#form1').submit();
        }
    </script>
{/if}


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>