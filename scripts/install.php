<?php
// Get the PDO DSN string
$root = realpath(__DIR__.'/..');
$database = $root . '/data/users.sqlite';
$dsn = 'sqlite:' . $database;
$error = '';

$databaseLib = $root . '/data/library.sqlite';
$dsnLib = 'sqlite:' . $databaseLib;

//prevents overwriting of current database
if (is_readable($database) && filesize($database) > 0 && is_readable($databaseLib) && filesize($databaseLib) > 0)
{
    $error = 'Delete the existing databases before installing';
}

//creates empty file for the databases
if (!$error)
{
    $createdOk = @touch($database);
	$createdLib = @touch($databaseLib);
    if (!$createdOk)
    {
        $error = sprintf(
            'Could not create the user database, please allow the server to create new files in \'%s\'',
            dirname($database)
        );
    }
	if (!$createdLib)
    {
        $error = sprintf(
            'Could not create the library database, please allow the server to create new files in \'%s\'',
            dirname($databaseLib)
        );
    }
}

if (!$error)
{
    $sql = file_get_contents($root . '/data/users.sql');
	$sqlLib = file_get_contents($root . '/data/library.sql');

    if ($sql === false)
    {
        $error = 'Cannot find user SQL file';
    }
	if ($sqlLib === false)
    {
        $error = 'Cannot find user library SQL file';
    }
}

if (!$error)
{
    $pdo = new PDO($dsn);
    $result = $pdo->exec($sql);
    if (!$result === false)
    {
        $error = 'Could not run SQL: ' . print_r($pdo->errorInfo(), true);
    }
}
if (!$error)
{
    $pdo = new PDO($dsnLib);
    $result = $pdo->exec($sqlLib);
    if ($result === false)
    {
        $error = 'Could not run SQL: ' . print_r($pdo->errorInfo(), true);
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Blog installer</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <style type="text/css">
            .box {
                border: 1px dotted silver;
                border-radius: 5px;
                padding: 4px;
            }
            .error {
                background-color: #ff6666;
            }
            .success {
                background-color: #88ff88;
            }
        </style>
    </head>
    <body>
        <?php if ($error): ?>
            <div class="error box">
                <?php echo $error ?>
            </div>
        <?php else: ?>
            <div class="success box">
                The databases were created OK.
            </div>
			<a href="register.php">Click to register</a>
        <?php endif ?>
    </body>
</html>