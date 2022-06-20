<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$db = getDatabase();

$formErrors = array();
$user = isset($_POST['user']) ? $_POST['user'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$table = '';
$watched = '';
$watchlist = '';
/**
 * Handle action 'add' (user pressed add button)
 * ----------------------------------------------------------------
 */
// if ((isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'user')) || ( isset($_POST['user']) && isset($_POST['type']))){
//     if (isset($_POST['user']) && $user == 'Maxim'){
//         $stmt = $db->prepare('SELECT * FROM watchlist1 WHERE type=:type ORDER BY id'); #where watchlist ==true # type == movie or serie or both
//     }elseif (isset($_POST['user']) && $user == 'Kiara'){
//         $stmt = $db->prepare('SELECT * FROM watchlist1 WHERE type=:type ORDER BY id');
//     }elseif (isset($_POST['user']) && $user == 'Robin'){
//         $stmt = $db->prepare('SELECT * FROM watchlist1 WHERE type=:type ORDER BY id');
//     }
//     $stmt->execute(['type'=> $type]);
//     $watchlist = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     header('');
// }


if ((isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'watchlist'))) {
    switch ($user) {
        case 'Maxim':
            $table = 'watchlist1';
            break;
        case 'Kiara':
            $table = 'watchlist2';
            break;
        case 'Robin':
            $table = 'watchlist3';
            break;
    }

    if ($type == 'both') {
        $stmt = $db->prepare('SELECT * FROM ' . $table . ' WHERE in_wl=1 ORDER BY id');
        $stmt->execute();
    } else {
        $stmt = $db->prepare('SELECT * FROM ' . $table . ' WHERE (type=:type AND in_wl=1) ORDER BY id'); #where watchlist ==true # type == movie or serie or both
        $stmt->execute(['type' => $type]);
    }


    $watchlist = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('');
}

if ((isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'watched'))) {
    switch ($user) {
        case 'Maxim':
            $table = 'watchlist1';
            break;
        case 'Kiara':
            $table = 'watchlist2';
            break;
        case 'Robin':
            $table = 'watchlist3';
            break;
    }

    if ($type == 'both') {
        $stmt = $db->prepare('SELECT * FROM ' . $table . ' WHERE watched=1 ORDER BY id');
        $stmt->execute();
    } else {
        $stmt = $db->prepare('SELECT * FROM ' . $table . ' WHERE (type=:type AND watched=1) ORDER BY id'); #where watchlist ==true # type == movie or serie or both
        $stmt->execute(['type' => $type]);
    }


    $watched = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('');
}





/**
 * No action to handle: show our page itself
 * ----------------------------------------------------------------
 */

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Watchlist</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-left">
                <a class="navbar-brand" href="index.php">Watchlist</a>
            </div>
        </div>
    </nav>


    <div class="container-fluid">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="form-group">
                            <label for="userPicker">Watchlist for user</label>
                            <select id="userPicker" name="user" class="form-control">
                                <option value='Maxim'>Maxim</option>
                                <option value='Kiara'>Kiara</option>
                                <option value='Robin'>Robin</option>
                            </select>
                            <label for="typeSelector">Type</label>
                            <select id="typeSelector" name="type" class="form-control">
                                <option value="both">Series & Movies</option>
                                <option value='serie'>Series</option>
                                <option value='movie'>Movies</option>

                            </select>
                        </div>
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" name="moduleAction" value="watchlist" class="btn btn-default form-control">Select</button>
                        </div>
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" name="moduleAction" value="watched" class="btn btn-default form-control">Select</button>
                        </div>
                    </form>

                    <br><br>
                    <div class="col-sm-offset-3 col-sm-6">
                        <a class="btn btn-success form-control" href="add.php" role="button">Add</a>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo isset($_POST['moduleAction']) ? $_POST['moduleAction'] : 'watchlist' ?>
                </div>

                <div class="panel-body table-responsive">
                    <table class="table table-striped">

                        <thead>
                            <tr>
                                <th class="col-sm-1"></th>

                                <th class="col-sm-2">TMDB</th>
                                <th class="col-sm-4">Name</th>
                                <th class="col-sm-3">Watched</th>

                                <th class="col-sm-3">Type</th>
                                <th class="col-sm-1">&nbsp;</th>
                                <th class="col-sm-1">&nbsp;</th>
                            </tr>

                        </thead>
                        <tbody>

                            <?php
                            if (isset($_POST['moduleAction'])) {
                                $list = ($_POST['moduleAction'] == 'watched') ? $watched : $watchlist;
                                var_dump($list);
                                if (!empty($list)) {
                                    foreach ($list as $item) {
                                        $iId = $item['id'];
                                        $iTMDBID = $item['TMDBID'];
                                        $iName = $item['name'];
                                        $iWatched = $item['watched'];
                                        $iType = $item['type'];

                                        echo ("<tr>
                                                <td>
                                                    <div><input type='checkbox' class='checkbox' id='{$iId}'/></div>
                                                </td>
                                                <td class='table-text'>
                                                    <div>{$iTMDBID}</div>
                                                </td>
                                                <td class='table-text'>
                                                    <div>{$iName}</div>
                                                </td>
                                                <td class='table-text'>
                                                    <div>{$iWatched}</div>
                                                </td>
                                                <td class='table-text'>
                                                    <div>{$iType}</div>
                                                </td>
                                                <td>
                                                    <a class='btn btn-default' href='edit.php?id={$iId}' role='button'>
                                                        <i class='fa fa-btn fa-pencil'></i>Edit
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class='btn btn-danger' href='delete.php?id={$iId}' role='button'>
                                                        <i class='fa fa-btn fa-trash'></i>Delete
                                                    </a>
                                                </td>
                                                </tr>");
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>


    <script>
        window.addEventListener('load', function() {

            // usability enhancement: focus the input field
            document.getElementById('userPicker').focus();
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>