<?php
    require_once __DIR__ . '/modules/constants.php';
    require_once __DIR__ . '/modules/variables.php';
    require_once __DIR__ . '/modules/getPokemons.php';

    if (!isset($_GET['page'])) {
        $start = 0;
        $end = LIMIT;

        $currentPage = 1;
        $nextPage = 2;
        $lastPage = 1;
    }
    else {
        $page = (int) $_GET['page'];

        $start = ($page * LIMIT) - LIMIT;
        $end = $page * LIMIT;

        $currentPage = $page;
        $nextPage = $currentPage <= 9 ? $currentPage + 1 : 10;
        $lastPage = $currentPage >= 2 ? $currentPage - 1 : 1;
    }

    $filePath = __DIR__ . '/public/files/pokemons.txt';

    if (!file_exists($filePath) || count(file($filePath)) === 0) {
        $pokemons = getPokemons(150);

        $openedFile = fopen($filePath, 'a');

        foreach ($pokemons as $pokemon) {
            fwrite($openedFile, $pokemon['name'] . "\n");
        }

        fclose($openedFile);
    }

    $pokemons = array_slice(file($filePath), $start, LIMIT);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex</title>

    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body>
    <header>
        <h1>Pokédex (<?php echo ($start + 1) . " - " . $end ?>)</h1>
    </header>
    <main>
        <ol start="<?php echo ($start + 1); ?>">
            <?php
                foreach ($pokemons as $key=>$pokemonName) {
            ?>
                    <li><a href="./detail.php?pokemonName=<?php echo $pokemonName; ?>" target="_blank"><?php echo ucfirst($pokemonName); ?></a></li>
            <?php
                }
            ?>
        </ol>
    </main>
    <footer>
        <a href="./index.php?page=1">Início</a>
        <a href="./index.php?page=<?php echo $lastPage; ?>"><<</a>
        <span><?php echo $currentPage ?></span>
        <a href="./index.php?page=<?php echo $nextPage; ?>">>></a>
        <a href="./index.php?page=10">Fim</a>
    </footer>
</body>
</html>