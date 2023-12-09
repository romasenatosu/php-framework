<?php
    use inserveofgod\forms\Form;
?>

<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow col-sm-3 mx-auto">
        <div class="card-header">
            <h2>Register</h2>
        </div>
        <div class="card-body">
            <?php $form = Form::begin("", "post");
                echo $form->field($user, ['type' => 'text','name' => 'fullname', 'label' => 'Fullname',  'placeholder' => 'John Doe']);
                echo $form->field($user, ['type' => 'text','name' => 'username', 'label' => 'Username',  'placeholder' => 'john_doe']);
                echo $form->field($user, ['type' => 'email','name' => 'email', 'label' => 'Email Address',  'placeholder' => 'example@gmail.com']);
                echo $form->field($user, ['type' => 'password','name' => 'password', 'label' => 'Password',  'placeholder' => '*****']);
                echo $form->field($user, ['type' => 'password','name' => 'password_confirm', 'label' => 'Confirm Password',  'placeholder' => '*****']);
            ?>

                <div class="mb-3">
                    <small><a href="/login">Already have an account? Login.</a></small>
                </div>
                <button type="submit" class="btn btn-primary">Sign up</button>

            <?php
                $form->end();
            ?>
        </div>
    </div>
</div>
