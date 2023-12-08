<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow col-sm-3 mx-auto">
        <div class="card-header">
            <h2>Register</h2>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="mb-3">
                    <label for="fullname" class="form-label">Fullname</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="John Doe">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com">
                    <small class="form-text">We'll never share your email with anyone else.</small>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="******">
                </div>
                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password-confirm" name="password-confirm" placeholder="******">
                </div>
                <div class="mb-3">
                    <small><a href="/login">Already have an account? Login.</a></small>
                </div>
                <button type="submit" class="btn btn-primary">Sign up</button>
            </form>
        </div>
    </div>
</div>
