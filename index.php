<?php
    $limite = 15;

    $inicio = 0;
    $fim = $limite;

    $paginaAtual = 1;
    $paginaSeguinte = 2;
    $paginaAnterior = 1;

    if (isset($_GET['pagina'])) {
        $inicio = ($_GET['pagina'] * $limite) - $limite;
        $fim = $_GET['pagina'] * $limite;

        $paginaAtual = $_GET['pagina'];
        $paginaSeguinte = $paginaAtual <= 9 ? $paginaAtual + 1 : 10;
        $paginaAnterior = $paginaAtual >= 2 ? $paginaAtual - 1 : 1;
    }

    $url = 'https://pokeapi.co/api/v2/pokemon?limit=' . $limite . '&offset=' . $inicio;

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_RETURNTRANSFER => true,
    ]);
    $result = curl_exec($curl);
    curl_close($curl);

    $pokemons = (array) json_decode($result);
    $pokemons = $pokemons['results'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex</title>

    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body>
    <header>
        <h1>Pokédex (<?php echo ($inicio + 1) . " - " . $fim ?>)</h1>
    </header>
    <main>
        <ol start="<?php echo ($inicio + 1); ?>">
            <?php
                foreach ($pokemons as $pokemon) {
                    $pokemon = (array) $pokemon;
            ?>
                    <li><a href="./detail.php?name=<?php echo $pokemon['name']; ?>" target="_blank"><?php echo ucfirst($pokemon['name']); ?></a></li>
            <?php
                }
            ?>
        </ol>
    </main>
    <footer>
        <a href="./index.php?pagina=1">Início</a>
        <a href="./index.php?pagina=<?php echo $paginaAnterior; ?>"><<</a>
        <span><?php echo $paginaAtual ?></span>
        <a href="./index.php?pagina=<?php echo $paginaSeguinte; ?>">>></a>
        <a href="./index.php?pagina=10">Fim</a>
    </footer>
</body>
</html>