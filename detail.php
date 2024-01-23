<?php
    require_once __DIR__ . '/modules/variables.php';
    require_once __DIR__ . '/modules/getPokemon.php';

    $pokemonName = $_GET['pokemonName'];

    $filePath = __DIR__ . "/public/files/$pokemonName.txt";

    if (!file_exists($filePath)) {
        $pokemon = getPokemon($pokemonName);

        $stats = $pokemon['stats'];

        $openedFile = fopen($filePath, 'a');

        foreach ($stats as $stat) {
            fwrite($openedFile, $stat['stat']['name'] . " = " . $stat['base_stat'] . "\n");
        }

        fclose($openedFile);
    }

    $stats = file($filePath);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($pokemonName); ?></title>

    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body>
    <header>
        <h1><?php echo ucfirst($pokemonName); ?> Stats</h1>
    </header>
    <main>
        <ul>
            <?php
                foreach ($stats as $stat) {
                    $statValues = explode(" = ", $stat);
            ?>
                    <li><?php echo $statValues[0] . " = " . $statValues[1]; ?></li>
            <?php
                }
            ?>
        </ul>
    </main>
</body>
</html>