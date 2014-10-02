<?php

/**
 * Utilitário para analisar e extrair as informações sobre as linhas
 * de ônibus que passam nos endereços. 
 */

// Carrega o Simple HTML DOM parser
require_once "../vendor/simple_html_dom.php";

/**
 * Funções
 */

// url que exibe as linhas por endereço
define('URL', 'http://sistemas.vitoria.es.gov.br/redeiti/listarLinhas.cfm?cdVia=');

/**
 * Extrai as informações de cada endereço requisitado
 * @param  string $code Código do endereço
 * @return array        Linhas que passam no endereço endereço
 */

function get_lines($code) {
    // define o tempo máximo para processar cada endereço
    set_time_limit(30);
    // faz a requisição do arquivo HTML
    $html = file_get_html(URL . $code);
    // extra os números das linhas
    $lines = array();
    $links = $html->find('.main a[href^=listar]');
    foreach ($links as $line) {
        $code = substr($line->plaintext, 0, 4);
        $lines[] = $code;
    }
    return $lines;
}

/**
 * Imprime as informações extraídas
 * 
 * @param  array $addressList Lista de endereços
 * @param  string $type       Tipo do endereço
 * @return undefined
 */

function parse_lines_from_list($addressList, $type) {
    echo "\"data\" : {";
    foreach ($addressList as $address) {
        $name = $address[0];
        $code = $address[1];
        // pega as informações do endereço
        $lines = get_lines($address[1]);
        // re-ordena as linhas
        sort($lines);
        // transforma de array PHP para JSON
        $lines = json_encode($lines);
        // monta as propriedades de cada linha
        echo "
        \"${code}\" : {
            \"name\" : \"${name}\",
            \"type\" : \"${type}\",
            \"lines\" : ${lines}
        },";
    }
    echo "\n}";
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Linhas por endereço</title>
</head>
<body>
<h1>Linhas por endereço</h1>
<pre>
    <code>
    <?php
    // parse_lines_from_list($AvArray, 'avenue');
    // parse_lines_from_list($RuaArray, 'street');
    // parse_lines_from_list($PcArray, 'square');
    // parse_lines_from_list($OtrArray, 'other');
    ?>
    </code>
</pre>
</body>
</html>
