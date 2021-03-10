<!-- $model is injected from the controller -->

<h1>Create an account</h1>

<?php use app\core\form\Form;
    $form = Form::begin('', 'post')
?>
    <div class="row">
        <div class="col">
            <?php echo $form->field($model, 'firstName'); ?>
        </div>

        <div class="col">
            <?php echo $form->field($model, 'lastName'); ?>
        </div>
    </div>

    <?php echo $form->field($model, 'email'); ?>
    <?php echo $form->field($model, 'password')->passwordField(); ?>
    <?php echo $form->field($model, 'confirmPassword')->passwordField(); ?>

    <button class="btn btn-primary" type="submit">Submit</button>
<?php Form::end() ?>
