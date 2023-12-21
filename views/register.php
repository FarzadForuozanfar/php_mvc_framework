<?php /** @var $request Core\Request */ ?>
<h1>Register</h1>

<form method="post" action="">
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label for="firstname">First name</label>
                <input id="firstname" type="text" name="firstname" value="<?= $request->old('firstname'); ?>"
                       class="form-control <?= $request->hasError('firstname') ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback">
                    <?= $request->getFirstError('firstname'); ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="lastname">Last name</label>
                <input id="lastname" type="text" name="lastname" value="<?= $request->old('lastname'); ?>"
                       class="form-control <?= $request->hasError('lastname') ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback">
                    <?= $request->getFirstError('lastname'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="email">Email address</label>
        <input id="email" type="email" name="email" value="<?= $request->old('email'); ?>"
               class="form-control <?= $request->hasError('email') ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
            <?= $request->getFirstError('email'); ?>
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" value="<?= $request->old('password'); ?>"
               class="form-control <?= $request->hasError('password') ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
            <?= $request->getFirstError('password'); ?>
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="confirm-password">Confirm Password</label>
        <input id="confirm-password" type="password" name="confirmPassword" value="<?= $request->old('confirmPassword'); ?>"
               class="form-control <?= $request->hasError('confirmPassword') ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
            <?= $request->getFirstError('confirmPassword'); ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
