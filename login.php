<?php

use src\Input;
use src\Token;
use src\User;
use src\Validate;

require_once 'core/init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, [
            'username' => ['required' => true,],
            'password' => ['required' => true],
        ]);
        if ($validation->passed()) {
            $user = new User();
            $login = $user->login(Input::get('username'), Input::get('password'));
            if ($login) {
                \src\Redirect::to('index.php');
            } else {
                echo '<p style="color: brown;">Sorry, logging in failed</p>';
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error, '<br />';
            }
        }
    }
}
?>
<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" id="username" value="" name="username" placeholder="Username" autocomplete="off"/>
    </div>

    <div class="field">
        <label for="password">Choose a password</label>
        <input type="password" id="password" value="" name="password" placeholder="Password" autocomplete="off"/>
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
    <input type="submit" id="submit" value="Log in"/>
</form>
