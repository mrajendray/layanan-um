<?php
require_once '../vendor/index.php';

// check user login status
if (!($user = \App\Auth::isLogged()) || $user->role != 'admin') {
    \App\Utils::redirect('login.php');
}

// prepare sql to get assessment
// count rating data and get counted data using left join
$sql  = 'SELECT u.id AS institute_id, u.institute, ';
$sql .= 'COALESCE( na.total_0, 0 ) AS total_0, COALESCE( na.total_1, 0 ) AS total_1, ';
$sql .= 'COALESCE( na.total_2, 0 ) AS total_2, COALESCE( na.total_3, 0 ) AS total_3 ';
$sql .= 'FROM '.\App\Auth::table.' uc ';
$sql .= 'INNER JOIN users u ON uc.id = u.user_id ';
$sql .= 'LEFT JOIN ( ';
$sql .= '    SELECT a.institute_id, ';
$sql .= '    COUNT(CASE WHEN a.rating = 0 THEN 1 ELSE NULL END ) AS total_0, ';
$sql .= '    COUNT(CASE WHEN a.rating = 1 THEN 1 ELSE NULL END ) AS total_1, ';
$sql .= '    COUNT(CASE WHEN a.rating = 2 THEN 1 ELSE NULL END ) AS total_2, ';
$sql .= '    COUNT(CASE WHEN a.rating = 3 THEN 1 ELSE NULL END ) AS total_3 ';
$sql .= '    FROM assessments a ';
$sql .= '    GROUP BY a.institute_id ';
$sql .= ') na ';
$sql .= 'ON na.institute_id = u.id ';
$sql .= 'WHERE uc.role = ?';
// execute sql
$result = R::getAll($sql, array('institute'));

// function to print row in table
function print_tr($i, $assessment) {
    echo '<tr><td class="text-center">';
    echo $i;
    echo '</td><td>';
    echo $assessment['institute'];
    echo '</td><td class="text-center">';
    echo $assessment['total_0'];
    echo '</td><td class="text-center">';
    echo $assessment['total_1'];
    echo '</td><td class="text-center">';
    echo $assessment['total_2'];
    echo '</td><td class="text-center">';
    echo $assessment['total_3'];
    echo '</td></tr>';
}

// shared page
require_once 'page/page.php';
// render header
printHead('assessment', 'Hasil Penilaian Pengguna');
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Hasil Penilaian</h4>
                        <p class="card-category"> Data kepuasan pengguna layanan lembaga UM</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                <th style="width: 50px" class="text-center">No</th>
                                <th>Lembaga</th>
                                <th class="text-center" style="width: 100px">Very Good</th>
                                <th class="text-center" style="width: 100px">Good</th>
                                <th class="text-center" style="width: 100px">Bad</th>
                                <th class="text-center" style="width: 100px">Very Bad</th>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                foreach ($result as $res) {
                                    print_tr(++$i, $res);
                                } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary pull-right" onclick="download()">Unduh Laporan Penilaian</button>
                            </div>
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
    function download() {
        window.location = '/admin/download.php';
    }
</script>
