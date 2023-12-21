<?php /** @var $request Core\Request */ ?>
<h1>Login To Your Account</h1>

<form method="post" action="">
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
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
