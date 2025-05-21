<?php

use src\Hash;
use src\Input;
use src\Redirect;
use src\Session;
use src\Token;
use src\User;
use src\Validate;

include 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, [
            'password_current' => [
                'required' => true,
                'min' => 6,
            ],
            'password_new' => [
                'required' => true,
                'min' => 6,
            ],
            'password_new_again' => [
                'required' => true,
                'min' => 6,
                'matches' => 'password_new',
            ],
        ]);

        if ($validation->passed()) {
            if (Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
                echo 'Your current password does not matches with the password you provided. Please try again.';
            } else {
                $salt = Hash::salt(32);
                $user->update([
                    'password' => Hash::make(Input::get('password_new'), $salt),
                    'salt' => $salt,
                ]);
            }
            Session::flash('home', 'You password changed successfully!.');
            Redirect::to('index.php');
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
        <label for="password_current">Current password</label>
        <input type="password" id="password_current" value="" name="password_current"/>
    </div>

    <div class="field">
        <label for="password_new">New password</label>
        <input type="password" id="password_new" value="" name="password_new"/>
    </div>

    <div class="field">
        <label for="password_new_again">New password again</label>
        <input type="password" id="password_new_again" name="password_new_again"/>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
    <input type="submit" value="Change"/>
</form>
