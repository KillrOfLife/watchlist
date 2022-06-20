<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$db = getDatabase();

$name = isset($_POST['name']) ? $_POST['name'] : '';
$TMDBID = isset($_POST['TMDBID']) ? $_POST['TMDBID'] : '';
$watchlist = isset($_POST['watchlist']) ? $_POST['watchlist'] : 1;
$watched = isset($_POST['watched']) ? $_POST['watched'] : 0;
$type = isset($_POST['type']) ? $_POST['type'] : '';
$user = isset($_POST['user']) ? $_POST['user'] : '';

if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'add')) {
    $allOk = true;
    $table = '';

    if (trim($name) === '' || trim($TMDBID) === '' || (trim($type) === '')) {
        $formErrors = 'Please use the searchbar';
        $allOk = false;
    }

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

    if ($allOk) {
        $stmt = $db->prepare('INSERT INTO ' . $table . ' (TMDBID, name, in_wl, watched, type) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute(array($TMDBID, $name, $watchlist, $watched, $type));
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Add</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/add.css">
    <link rel="stylesheet" href="css/common.css">
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-left">
                <a class="navbar-brand" href="index.php">Add</a>
            </div>
        </div>
    </nav>


    <div class="container-fluid">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Search
                </div>
                <div class="panel-body">
                    <?php
                    if (!empty($formErrors) && isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'add')) {
                        echo ('<div class="alert alert-danger">
                        <strong>Something went wrong.</strong>
                        <br><br>
                        <ul>');
                        foreach ((array)$formErrors as $error) {
                            echo ('<li>' . $error . '</li>');
                        }
                        echo ('</ul>
                        </div>');
                    }

                    ?>
                    <div class="form-group">
                        <label for="search">name</label>
                        <input class="form-control" type="text" name="search" id="search" placeholder="Search media">
                    </div>
                    <div class="form-group">
                        <label for="typeSelector">Type</label>
                        <select id="typeSelector" name="typeSelector" class="form-control">
                            <option value='serie'>Series</option>
                            <option value='movie'>Movies</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button class="form-control btn btn-default" id="submit">Search</button>
                        </div>
                    </div>
                    <div id="message"></div>
                    <div class="col-sm-offset-4 col-sm-6">
                        <ul id="pagination"></ul>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add
                </div>
                <div class="panel-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="form-group">
                            <label for="user">User</label>
                            <select id="user" name="user" class="form-control">
                                <option value='Maxim'>Maxim</option>
                                <option value='Kiara'>Kiara</option>
                                <option value='Robin'>Robin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">name</label>
                            <input class="form-control" type="text" name="name" id="name" readonly>
                        </div>
                        <div class="form-group">
                            <label for="TMDBID">TMDB ID</label>
                            <input class="form-control" type="text" name="TMDBID" id="TMDBID" readonly>
                        </div>
                        <div class="form-group">
                            <label for="watchlist">In watchlist</label>
                            <input class="form-control" type="number" min="0" max="1" name="watchlist" id="watchlist" value="<?php echo $watchlist ?>">
                        </div>
                        <div class="form-group">
                            <label for="watched">Watched</label>
                            <input class="form-control" type="number" min="0" max="1" name="watched" id="watched" value="<?php echo $watched ?>">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select id="type" name="type" class="form-control" readonly>
                                    <option value='serie'>Series</option>
                                    <option value='movie'>Movies</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="other">Info</label>
                                <p class="other" id="other" style="white-space: pre-line"></p>
                            </div>
                            <input type="hidden" name="moduleAction" value="add" />
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button class="form-control btn btn-success" type="submit">Add</button>
                                </div>
                            </div>
                    </form>
                </div>
                <div class="text-left col-sm-offset-1">
                    <p><a href="index.php">cancel</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="js/search.js"></script>
</body>