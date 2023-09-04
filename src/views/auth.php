<?php

use function Context\App\Functions\navigateController;
use function Context\App\Functions\navigation;
require_once "../utilities/viewsUtils.php";

ViewsHelpers\secureView();

$authType = isset($_GET['authType']) ? $_GET['authType'] : 'logIn';
$switchAuthTypeMessage = $authType == 'logIn' ? '¿No tienes una cuenta?' : '¿Ya tienes una cuenta?';
$authTypeContrary = $authType == 'logIn' ? 'signUp' : 'logIn';

?>
<link rel="stylesheet" href="../styles/auth.css">

<div class="authFormContainer card">

    <form action="<?php echo navigateController("authentication", [
    "type" => $authType,
]); ?>" method="POST">
        <?php
if ($authType == 'signUp') {
    ?>
            <label for="name">
                <span>Name</span>
                <input type="text" placeholder="Name" id="name" name="<?php echo $userInstance->name ?>">
            </label>
        <?php
}
?>

        <label for="email">
            <span>Email</span>
            <input type="email" placeholder="Email" id="email" name="<?php echo $userInstance->email ?>">
        </label>

        <label for="password">
        <span>Password</span>
        <div>
            <input
            type="password"
            placeholder="Password"
            id="password"
            name="<?php echo $userInstance->password ?>"
            />
            <div id="displayPasswordAfter">
            <button
                class="button"
                id="displayPassword"
                hidden
            ></button>
            </div>
        </div>
        </label>

        <input type="submit" value="Enviar">
    </form>
    <a href='<?php echo navigation("auth", [
    "authType" => $authTypeContrary,
]); ?>'><?php echo $switchAuthTypeMessage; ?></a>
</div>

<script src="../js/public/auth/index.js" type="module"></script>