<?php
require_once '../vendor/index.php';

// check user login status
if (!($user = \App\Auth::isLogged()) || $user->role != 'admin') {
    \App\Utils::redirect('');
}

// --prepare request data--
// check given user request
$notify = false;
if (!\App\Utils::check_request($_REQUEST, array('new_institute', 'new_username', 'new_password'), 'POST')) {
    // get user request into php variable
    $request = \Kiss\Utils::array_clean($_REQUEST, array(
        'new_institute' => 'string',
        'new_username' => 'string',
        'new_password' => 'string',
    ));

    if ($request['new_institute'] == '' || $request['new_username'] == '' || $request['new_password'] == '') {
        // for failed notification
        $notify['error'] = true;
        $notify['ermsg'] = 'Mohon isi data dengan lengkap!';
        $notify['type'] = 'Pendaftaran';
    } else {

        // --make new user--
        // register user into auth system
        if ($register = \App\Auth::register($request['new_username'], $request['new_password'], 'institute')) {
            // register new user into database
            $newUser = R::dispense('users');
            $newUser->user_id = $register->id;
            $newUser->institute = $request['new_institute'];
            $newUser->created_at = date("Y-m-d H:i:s");
            $newUser->updated_at = $newUser->created_at;
            R::store($newUser);

            // for succeed notification
            $notify['error'] = false;
            $notify['type'] = 'Pendaftaran';
        } else {
            // for failed notification
            $notify['error'] = true;
            $notify['ermsg'] = 'Username telah digunakan!';
            $notify['type'] = 'Pendaftaran';
        }

    }
}

// prepare sql to get users data
$sql  = 'SELECT u.institute, uc.username ';
$sql .= 'FROM users u INNER JOIN '.\App\Auth::table.' uc ON u.user_id = uc.id ';;
$sql .= 'WHERE uc.role = ?';
// execute sql
$result = R::getAll($sql, array('institute'));

/** action button
 *echo '<td class="td-actions text-right">';
echo '<button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">';
echo '<i class="material-icons">edit</i>';
echo '</button>';
echo '<button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">';
echo '<i class="material-icons">close</i>';
echo '</button>';
echo '</td>';
 */

// shared page
require_once 'page/page.php';
// render header
printHead('institute', "Lembaga");
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Lembaga Baru</h4>
                        <p class="card-category">Pendaftaran lembaga baru kedalam EVAN</p>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" id="new_user">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Lembaga</label>
                                        <input type="text" class="form-control" name="new_institute" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Username</label>
                                        <input type="text" class="form-control" name="new_username" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Password</label>
                                        <input type="password" class="form-control" id="new_password1" name="new_password" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Masukan ulang password</label>
                                        <input type="password" class="form-control" id="new_password2" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Tambah Lembaga</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Daftar Lembaga</h4>
                        <p class="card-category"> Daftar lembaga terdaftar dalam EVAN</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                <th style="width: 50px" class="text-center">No</th>
                                <th style="width: 550px">Lembaga</th>
                                <th>Username</th>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                foreach ($result as $res) {
                                    echo '<tr>';
                                    echo '<td class="text-center">'.++$i.'</td>';
                                    echo '<td>'.$res["institute"].'</td>';
                                    echo '<td>'.$res["username"].'</td>';
                                    echo '</tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
//render footer
printFoot();
?>
<script>
    $(document).ready(function() {
        var newPassword1 = $('#new_password1');
        var newPassword2 = $('#new_password2');
        newPassword2.blur(function(e) {
            if (newPassword2.val() !== '')
                checkPassword();
        });
        $('#new_user').submit(function (e) {
            if (!checkPassword()) e.preventDefault();
        });
        function checkPassword() {
            if (newPassword1.val() !== newPassword2.val()) {
                newPassword2.val('');
                newPassword2.focus();
                showNotification(2, "Password tidak sama");
                return false;
            }
            return true;
        }
        <?php
        if ($notify && $notify['error'] == false)
            echo 'showNotification(3, "Pendaftaran berhasil!<br>Lembaga '.$request['new_institute'].' berhasil didaftarkan");';
        else if ($notify && $notify['error'] == true)
            echo 'showNotification(2, "'.$notify['type'].' gagal!<br>'.$notify['ermsg'].'");';
        ?>
        function showNotification (type, message) {
            types = ['', 'info', 'danger','success', 'warning', 'rose', 'primary'];
            $.notify({
                icon: "notifications",
                message: message

            }, {
                type: types[type],
                timer: 3000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                }
            });
        }
    })
</script>
