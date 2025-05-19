<?php

use src\Token;
use src\Validate;

require_once 'core/init.php';

//var_dump(\src\Token::check(\src\Input::get('token')));

if (\src\Input::exists()) {
    if (Token::check(\src\Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, [
            'username' => [
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users',
            ],
            'password' => [
                'required' => true,
                'min' => 2,
            ],
            'password_again' => [
                'required' => true,
                'matches' => 'password',
            ],
            'name' => [
                'required' => true,
                'min' => 2,
                'max' => 50,
            ],
        ]);

        if ($validation->passed()) {
            echo 'Passed';
        } else {
            foreach ($validation->errors() as $error) {
                echo $error . '<br />';
            }
        }
    }
}

?>
<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" id="username" value="<?php echo escape(\src\Input::get('username')); ?>" name="username" placeholder="Username" autocomplete="off"/>
    </div>

    <div class="field">
        <label for="password">Choose a password</label>
        <input type="password" id="password" value="" name="password" placeholder="Password" autocomplete="off"/>
    </div>

    <div class="field">
        <label for="password_again">Enter you password again</label>
        <input type="password" id="password_again" value="" name="password_again" placeholder="Password again"
               autocomplete="off"/>
    </div>

    <div class="field">
        <label for="name">Name</label>
        <input type="text" id="name" value="<?php echo escape(\src\Input::get('name')); ?>" name="name" placeholder="Name" autocomplete="off"/>
    </div>

    <input type="hidden" name="token" value="<?php echo \src\Token::generate(); ?>" />
    <input type="submit" value="Register"/>
</form>
