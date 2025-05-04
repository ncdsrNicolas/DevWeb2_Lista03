<?php
require_once 'classes.php';
session_start();

$nome = $_POST['nome'];
$codigo = $_POST['codigo'];
$categoria = $_POST['categoria'];
$estoque = $_POST['estoque'];
$preco = $_POST['preco'];
$tipo = $_POST['tipo'];

if (!isset($_SESSION['produtos'])) {
    $_SESSION['produtos'] = [];
}

function buscarIndiceProduto($codigo) {
    foreach ($_SESSION['produtos'] as $indice => $produto) {
        if (is_object($produto) && $produto->codigo == $codigo) {
            return $indice;
        }
    }
    return null;
}

echo "<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <title>Cadastro de Produto</title>
    <link rel='icon' type='image/png' href='img/logo_icon.png'>
    <link rel='stylesheet' href='styles/cadastro_resultado_styles.css'>
</head>
<body>
    <div class='container'>";

$indiceProduto = buscarIndiceProduto($codigo);

if ($indiceProduto !== null) {
    $_SESSION['produtos'][$indiceProduto]->nome = $nome;
    $_SESSION['produtos'][$indiceProduto]->categoria = $categoria;
    $_SESSION['produtos'][$indiceProduto]->estoque = $estoque;
    $_SESSION['produtos'][$indiceProduto]->precoUnitario = $preco;
    echo "<div class='success'>Produto atualizado com sucesso!</div>";
} else {
    if ($tipo == 'fisico') {
        $produto = new ProdutoFisico($nome, $codigo, $categoria, $estoque, $preco);
    } else {
        $produto = new ProdutoDigital($nome, $codigo, $categoria, $estoque, $preco);
    }
    $_SESSION['produtos'][] = $produto;
    echo "<div class='success'>Produto cadastrado com sucesso!</div>";
}

echo "<div class='buttons'>
        <a class='button' href='cadastro.html'>Cadastrar outro</a>
        <a class='button' href='gerenciamento.html'>Gerenciar</a>
        <a class='button' href='index.html'>Voltar</a>
      </div>";
echo "</div></body></html>";
?>