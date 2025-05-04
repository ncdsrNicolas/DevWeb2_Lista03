<?php
interface Funcoes {
    public function adicionarEstoque($quantidade);
    public function reduzirEstoque($quantidade);
    public function consultarEstoque();
    public function exibirProduto();
    public function calcularImposto();
}

trait Desconto {
    public function calcularDesconto($percentual) {
        $valorDesconto = floatval(str_replace(',', '.', $this->precoUnitario)) * ($percentual / 100);
        $precoComDesconto = floatval(str_replace(',', '.', $this->precoUnitario)) - $valorDesconto;
        echo "Preço com desconto de {$percentual}%: R$ " . number_format($precoComDesconto, 2) . "<br>";
    }
}

abstract class Produto implements Funcoes {
    public $nome;
    public $codigo;
    public $categoria;
    public $estoque;
    public $precoUnitario;

    public function __construct($nome, $codigo, $categoria, $estoque, $precoUnitario) {
        $this->nome = $nome;
        $this->codigo = $codigo;
        $this->categoria = $categoria;
        $this->estoque = $estoque;
        $this->precoUnitario = str_replace(',', '.', $precoUnitario); // Corrige a vírgula para ponto
    }

    public function adicionarEstoque($quantidade) {
        $this->estoque += $quantidade;
        echo "Adicionado {$quantidade} unidades ao estoque.<br>";
    }

    public function reduzirEstoque($quantidade) {
        if ($quantidade > $this->estoque) {
            echo "Erro: estoque insuficiente.<br>";
        } else {
            $this->estoque -= $quantidade;
            echo "Reduzido {$quantidade} unidades do estoque.<br>";
        }
    }

    public function consultarEstoque() {
        echo "Estoque atual: {$this->estoque} unidades.<br>";
    }

    public function exibirProduto() {
        $precoCorrigido = floatval($this->precoUnitario);
        echo "Produto: {$this->nome}<br>";
        echo "Código: {$this->codigo}<br>";
        echo "Categoria: {$this->categoria}<br>";
        echo "Estoque: {$this->estoque}<br>";
        echo "Preço Unitário: R$ " . number_format($precoCorrigido, 2) . "<br>";
    }

    abstract public function calcularImposto();
}

class ProdutoFisico extends Produto {
    use Desconto;

    public function calcularImposto() {
        $precoCorrigido = floatval($this->precoUnitario);
        $imposto = $precoCorrigido * 0.10;
        echo "Imposto (10%): R$ " . number_format($imposto, 2) . "<br>";
    }
}

class ProdutoDigital extends Produto {
    use Desconto;

    public function calcularImposto() {
        $precoCorrigido = floatval($this->precoUnitario);
        $imposto = $precoCorrigido * 0.05;
        echo "Imposto (5%): R$ " . number_format($imposto, 2) . "<br>";
    }
}
?>