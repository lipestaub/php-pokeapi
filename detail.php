<?php
    $name = $_GET['name'];

    $arquivoPokemon = file(__DIR__ . "/public/files/$name.txt");

    if (!$arquivoPokemon) {
        $url = 'https://pokeapi.co/api/v2/pokemon/' . $name;

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $result = curl_exec($curl);
        curl_close($curl);

        $pokemon = (array) json_decode($result);
        $stats = $pokemon['stats'];

        $arquivo = __DIR__ . "/public/files/$name.txt";
        $arquivoAberto = fopen($arquivo, 'a');

        foreach ($stats as $stat) {
            $stat = (array) $stat;
            $statName = (array) $stat['stat'];

            fwrite($arquivoAberto, $statName['name'] . " = " . $stat['base_stat'] . "\n");
        }

        fclose($arquivoAberto);
    }

    $stats = file(__DIR__ . "/public/files/$name.txt");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($name); ?></title>

    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body>
    <header>
        <h1><?php echo ucfirst($name); ?> Stats</h1>
    </header>
    <main>
        <ul>
            <?php
                foreach ($stats as $stat) {
                    $statValues = explode(" = ", $stat);
            ?>
                    <li><?php echo $statValues[0] . " = " . $statValues[1];?></li>
            <?php
                }
            ?>
        </ul>
    </main>
</body>
</html>