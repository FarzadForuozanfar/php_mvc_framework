<?php /** @var $request Core\Request */ ?>
<h1>Register</h1>

<form method="post" action="">
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label for="firstname">First name</label>
                <input id="firstname" type="text" name="firstname" value="<?= htmlspecialchars($request->old('firstname'), ENT_QUOTES, 'UTF-8', false); ?>"
                       class="form-control <?= $request->hasError('firstname') ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback">
                    <?= htmlspecialchars($request->getFirstError('firstname'), ENT_QUOTES, 'UTF-8', false); ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="lastname">Last name</label>
                <input id="lastname" type="text" name="lastname" value="<?= htmlspecialchars($request->old('lastname'), ENT_QUOTES, 'UTF-8', false); ?>"
                       class="form-control <?= $request->hasError('lastname') ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback">
                    <?= htmlspecialchars($request->getFirstError('lastname'), ENT_QUOTES, 'UTF-8', false); ?>
                </div>
            </div>
        </div>
    </div>
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
    <div class="form-group mb-3">
        <label for="confirm-password">Confirm Password</label>
        <input id="confirm-password" type="password" name="confirmPassword" value="<?= htmlspecialchars($request->old('confirmPassword'), ENT_QUOTES, 'UTF-8', false); ?>"
               class="form-control <?= $request->hasError('confirmPassword') ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
            <?= htmlspecialchars($request->getFirstError('confirmPassword'), ENT_QUOTES, 'UTF-8', false); ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
