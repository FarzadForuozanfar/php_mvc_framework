<?php /** @var $request Core\Request */ ?>
<h1>Login To Your Account</h1>

<form method="post" action="">
    <div class="form-group mb-3">
        <label for="email">Email address</label>
        <input id="email" type="email" name="email" value="<?= htmlspecialchars($request->old('email'), ENT_QUOTES, 'UTF-8', false); ?>"
               class="form-control <?= $request->hasError('email') ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
            <?= htmlspecialchars($request->getFirstError('email'), ENT_QUOTES, 'UTF-8', false); ?>
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" value="<?= htmlspecialchars($request->old('password'), ENT_QUOTES, 'UTF-8', false); ?>"
               class="form-control <?= $request->hasError('password') ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
            <?= htmlspecialchars($request->getFirstError('password'), ENT_QUOTES, 'UTF-8', false); ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
