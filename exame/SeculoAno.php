<?php

/**
 * Desenvolva uma função que receba como parametro o ano e retorne o século ao qual este ano faz parte. 
 * O primeiro século começa no ano 1 e termina no ano 100, 
 * o segundo século começa no ano 101 e termina no 200. 
 *
 * @param integer $ano
 * @return integer
 */
function SeculoAno($ano): int
{
    if(is_numeric($ano)){
        return ceil($ano/100);
    }
    return 0;
}

/* echo SeculoAno("1701")."<br>";
echo SeculoAno(1990)."<br>";
echo SeculoAno("1")."<br>";
echo SeculoAno("2000")."<br>";
echo SeculoAno("801")."<br>";
echo SeculoAno("1905")."<br>";
echo SeculoAno("1700")."<br>";
echo SeculoAno("q700")."<br>";
echo SeculoAno(700)."<br>";
echo SeculoAno(-700)."<br>"; */

?>