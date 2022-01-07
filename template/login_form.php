<div class="row">
    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
            <div class="card-body p-4 p-sm-5 border border-secondary border-1 rounded-3">
                <h3 class="card-title text-center mb-4">HRMSC</h3>
                <form action="login.php" method="POST">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                        <label for="email">Email address</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                        <label for="password">Password</label>
                    </div>
                    <div class="d-grid mb-1 text-end">
                        <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#fileModal">Forgot Password?</a>
                    </div>
                    <div class="d-grid mb-1">
                        <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Log in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="title" class="modal-title">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalForm" action="login.php" method="POST" onsubmit="return confirms('reset password')">
                        <label for="email">Email Address:</label>
                        <input type="email" id="email" class="form-control mb-2" name="email">
                        <input type="submit" class="btn btn-danger form-control" name="reset" value="Done">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>