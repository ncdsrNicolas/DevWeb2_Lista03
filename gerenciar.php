<?php
require_once 'classes.php';
session_start();

function buscarProduto($codigo) {
    foreach ($_SESSION['produtos'] as &$produto) {
        if (is_object($produto) && property_exists($produto, 'codigo') && $produto->codigo == $codigo) {
            return $produto;
        }
    }
    return null;
}

$codigo = $_POST['codigo'];
$acao = $_POST['acao'];
$valor = isset($_POST['valor']) ? $_POST['valor'] : 0;

$valor = str_replace(',', '.', $valor);
$valor = floatval($valor);

echo "<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <title>Resultado da Ação</title>
    <link rel='icon' type='image/png' href='img/logo_icon.png'>
    <link rel='stylesheet' href='styles/gerenciamento_resultado_styles.css'>
</head>
<body>
    <div class='container'>";

if (in_array($acao, ['adicionar', 'reduzir', 'desconto']) && ($valor <= 0 || empty($valor))) {
    echo "<div class='error'>Erro: O campo Quantidade/Percentual deve ter algum valor maior que zero.</div>";
    echo "<a class='button' href='gerenciamento.html'>Voltar</a>";
    exit;
}

$produto = buscarProduto($codigo);

if (!$produto) {
    echo "<div class='error'>Produto não encontrado!</div>";
    echo "<a class='button' href='gerenciamento.html'>Voltar</a>";
    exit;
}

echo "<h2>Ação Executada:</h2>";

echo "<div class='result'>";
switch ($acao) {
    case 'adicionar':
        $produto->adicionarEstoque($valor);
        break;
    case 'reduzir':
        $produto->reduzirEstoque($valor);
        break;
    case 'consultar':
        $produto->consultarEstoque();
        break;
    case 'exibir':
        $produto->exibirProduto();
        break;
    case 'imposto':
        $produto->calcularImposto();
        break;
    case 'desconto':
        $produto->calcularDesconto($valor);
        break;
    default:
        echo "<div class='error'>Ação inválida!</div>";
}
echo "</div>";

echo "<br><a class='button' href='gerenciamento.html'>Voltar</a>";
echo "</div></body></html>";
?>
