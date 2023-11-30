<h1>Register</h1>

<form method="post" action="">
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label for="firstname">First name</label>
                <input id="firstname" type="text" name="firstname" value="<?= $model->firstname; ?>"
                       class="form-control <?= $model->hasError('firstname') ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback">
                    <?= $model->getFirstError('firstname'); ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="lastname">Last name</label>
                <input id="lastname" type="text" name="lastname" value="<?= $model->lastname; ?>"
                       class="form-control <?= $model->hasError('lastname') ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback">
                    <?= $model->getFirstError('lastname'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="email">Email address</label>
        <input id="email" type="email" name="email" value="<?= $model->email; ?>"
               class="form-control <?= $model->hasError('email') ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
            <?= $model->getFirstError('email'); ?>
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" value="<?= $model->password; ?>"
               class="form-control <?= $model->hasError('password') ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
            <?= $model->getFirstError('password'); ?>
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="confirm-password">Confirm Password</label>
        <input id="confirm-password" type="password" name="confirmPassword" value="<?= $model->confirmPassword; ?>"
               class="form-control <?= $model->hasError('confirmPassword') ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
            <?= $model->getFirstError('confirmPassword'); ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
