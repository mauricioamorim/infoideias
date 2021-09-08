<?php

/**
 * Escreva um programa que preencha um array com 20 números inteiros sorteados entre 1 e 10. 
 * Depois informe qual número mais se repetiu e quantas vezes ele se repetiu.
 * 
 * Exemplo
 * 
 * Array sorteado = [2,5,8,2,8,5,3,9,6,3,4,6,3,1,2,1,2,3,7,1]
 * O número que mais se repete é o 2. 
 * Ele se repete 4 vezes 
 */
class NumeroDaSorte
{
    public $randMin = 1;
    public $randmax = 10;
    public $quantity = 20;
    public $sortNumbers = [];
    public $mostRepetedNumber;
    public $mostRepetedQuantity;

    function __construct()
    {
        $this->createSortNumbers();
        $this->printResult();
    }

    /**
     * Limpa números antigos e gera nova sequancia de numeros sorteados
     *
     * @return void
     */
    function createSortNumbers()
    {
        $this->sortNumbers = [];
        while(count($this->sortNumbers)<20){
            $this->sortNumbers[] = rand($this->randMin, $this->randmax);
        }

        $this->getStatistic();
    }

    /**
     * Gera as estatisticas de numero que mais repetiu e a quantidade de vezes que repitiu
     *
     * @return void
     */
    function getStatistic()
    {
        $temp = array_count_values($this->sortNumbers);
        arsort($temp);
        $this->mostRepetedNumber = array_keys($temp)[0];
        $this->mostRepetedQuantity = $temp[$this->mostRepetedNumber];
    }

    /**
     * Printa todos os detalhes dos números sorteados
     *
     * @return void
     */
    function printResult()
    {
        echo "Array sorteado = ".json_encode($this->sortNumbers)."<br>";
        echo "O número que mais se repete é o = ".$this->mostRepetedNumber."<br>";
        echo "Ele se repete ".$this->mostRepetedQuantity." vezes"."<br>";
    }
}

new NumeroDaSorte();

?>