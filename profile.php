<?php

use src\Input;
use src\Redirect;
use src\User;

require_once 'core/init.php';

if (!$username = Input::get("user")) {
    Redirect::to("index.php");
} else {
    $user = new User($username);
    if (!$user->exists()) {
        Redirect::to(404);
    } else {
        $data = $user->data();
    }
?>
    <h3><?php echo escape($data->username); ?></h3>
    <p>Full name: <?php echo escape($data->name); ?></p>
<?php
}
