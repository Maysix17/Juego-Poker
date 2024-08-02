<?php
//definir la función repartir cartas
function repartirCartas() {
    $palos = ["♥", "♣", "♦", "♠"];
    $valores = ["2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K", "A"];
    
    $mazo = [];

    foreach ($palos as $palo) {
        foreach ($valores as $valor) {
            $mazo[] = "$valor de $palo";
        }
    }

    shuffle($mazo);
    return array_slice($mazo, 0, 5);
}

//definir la mostrar Cartas
function mostrarCartas($cartas) {
    foreach ($cartas as $carta) {
        echo $carta . "\n";
    }
}
// definir la función evaluar mano
function evaluarMano($cartas) { 
    $valores = [];
    $palos = [];
    foreach ($cartas as $carta) {
        list($valor, $palo) = explode(" de ", $carta);
        $valores[] = trim($valor);
        $palos[] = trim($palo);
    }
    
    $numerosContados = array_count_values($valores);
    $palosContados = array_count_values($palos);

    if (esEscaleraReal($valores, $palosContados)) {
        echo "Escalera Real\n";
    } elseif (esEscaleraColor($valores, $palosContados)) {
        echo "Escalera de Color\n";
    } elseif (max($numerosContados) == 4) {
        echo "Póker\n";
    } elseif (max($numerosContados) == 3 && in_array(2, $numerosContados)) {
        echo "Full House\n";
    } elseif (max($palosContados) == 5) {
        echo "Color\n";
    } elseif (esEscalera($valores)) {
        echo "Escalera\n";
    } elseif (max($numerosContados) == 3) {
        echo "Trío\n";
    } elseif (count(array_keys($numerosContados, 2)) == 2) {
        echo "Dos Pares\n";
    } elseif (max($numerosContados) == 2) {
        echo "Par\n";
    } else {
        echo "Carta Alta: " . max(array_map('valorNumerico', $valores)) . "\n";
    }
}

function esEscaleraReal($valores, $palosContados) {
    $escaleraReal = ["10", "J", "Q", "K", "A"];
    return esEscalera($valores) && !array_diff($escaleraReal, $valores) && max($palosContados) == 5;
}

function esEscaleraColor($valores, $palosContados) {
    return esEscalera($valores) && max($palosContados) == 5;
}

function esEscalera($valores) {
    $valoresOrdenados = array_map('valorNumerico', $valores);
    sort($valoresOrdenados);
    for ($i = 0; $i < count($valoresOrdenados) - 1; $i++) {
        if ($valoresOrdenados[$i] + 1 != $valoresOrdenados[$i + 1]) {
            return false;
        }
    }
    return true;
}

function valorNumerico($valor) {
    $mapa = ["2" => 2, "3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7, "8" => 8, "9" => 9, "10" => 10, "J" => 11, "Q" => 12, "K" => 13, "A" => 14];
    return $mapa[$valor];
}

$cartas = repartirCartas();
mostrarCartas($cartas);
echo "\nEvaluación de la mano:\n";
evaluarMano($cartas);

?>
