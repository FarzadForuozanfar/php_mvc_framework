<h1>Register</h1>

<form method="post" action="">
    <div class="row mb-3">
        <div class="col">
            <div class="form-group">
                <label for="firstname">First name</label>
                <input id="firstname" type="text" class="form-control" name="firstname">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="lastname">Last name</label>
                <input id="lastname" type="text" class="form-control" name="lastname">
            </div>
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="email">Email address</label>
        <input id="email" type="email" class="form-control" name="email">
    </div>
    <div class="form-group mb-3">
        <label for="password">Password</label>
        <input id="password" type="password" class="form-control" name="password">
    </div>
    <div class="form-group mb-3">
        <label for="confirm-password">Confirm Password</label>
        <input id="confirm-password" type="password" class="form-control" name="confirmPassword">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>