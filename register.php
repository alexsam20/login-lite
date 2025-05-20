<?php

use src\Hash;
use src\Input;
use src\Redirect;
use src\Session;
use src\Token;
use src\User;
use src\Validate;

require_once 'core/init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
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
            $user = new User();
            $salt = Hash::salt(32);
            try {
                $user->create([
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'name' => Input::get('name'),
                    'group' => 1
                ]);
                Session::flash('home', 'You have been registered and can now log in!');
                Redirect::to('index.php');
            } catch (\Exception $e) {
                die($e->getMessage());
            }
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
        <input type="text" id="username" value="<?php echo escape(Input::get('username')); ?>" name="username" placeholder="Username" autocomplete="off"/>
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
        <input type="text" id="name" value="<?php echo escape(Input::get('name')); ?>" name="name" placeholder="Name" autocomplete="off"/>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
    <input type="submit" value="Register"/>
</form>
