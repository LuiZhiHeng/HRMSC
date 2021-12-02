<div class="container d-flex justify-content-center">
    <form class="row w-50 border border-secondary border-1 rounded-3 p-3 mt-1" method="POST" action="setting.php?changePass=" onsubmit="return confirms('Change Password')">
            <input type="hidden" name="id" value="<?= get_logged_user_id(); ?>" hidden>
            <label for="oldPass">Old Password</label>
            <input type="password" class="form-control mb-2" name="oldPass" id="oldPass" required>
            <label for="newPass">New Password</label>
            <input type="password" class="form-control mb-2" name="newPass" id="newPass" onkeyup="check()" required>
            <label for="confirmPass">Confirm New Password</label>
            <input type="password" class="form-control mb-2" name="confirPass" id="confirmPass" onkeyup="check()" required>
            <span class="m-0 mb-1 text-end" id="message"></span>
            <button type="submit" id="btn" class="btn btn-danger form-control" name="changePass">Change Password</button>
    </form>
</div>
<script>
    var check = function() {
        var oldPass = document.getElementById('oldPass');
        var newPass = document.getElementById('newPass');
        var confirmPass = document.getElementById('confirmPass');
        var ms = document.getElementById('message');
        var btn = document.getElementById('btn');
        if (confirmPass.value == "" && newPass.value == "") {
            ms.innerHTML = '';
        } else if (confirmPass.value == newPass.value) {
            ms.style.color = 'green';
            ms.innerHTML = 'Matched';
            btn.disabled = false;

        } else {
            ms.style.color = 'red';
            ms.innerHTML = '"Password" and "Confirm Password" is not matching!';
            btn.disabled = true;
        }
    }
</script>