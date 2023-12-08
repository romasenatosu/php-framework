<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow col-sm-3 mx-auto">
        <div class="card-header">
            <h2>Login</h2>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com">
                    <small class="form-text">We'll never share your email with anyone else.</small>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="******">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me">
                    <label class="form-check-label" name="remember_me" for="remember_me">Remember me</label>
                </div>
                <div class="mb-3">
                    <small><a href="/register">Don't you have an account? Register.</a></small>
                </div>
                <button type="submit" class="btn btn-primary">Sign in</button>
            </form>
        </div>
    </div>
</div>
