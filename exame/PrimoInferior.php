<?php

/**
 * Crie uma função que receba como parâmetro um número inteiro e retorne o maior número primo inferior ao número recebido como parâmetro. 
 * Se o argumento for negativo, a função deverá retornar o valor zero.
 *
 * @param integer $num
 * @return integer
 */
function PrimoInferior(int $num): int
{
    for($primo = $num-1; $primo > 1; $primo--){
        $is_primo = true;
        for($count = $primo-1; $count > 1 ; $count--){
            if($primo%$count==0){
                $is_primo = false;
                break;
            }
        }
        if($is_primo){
            return $primo;
        }
    }
    return 0;
}

/* echo PrimoInferior(-1)."<br>";
echo PrimoInferior(7)."<br>";
echo PrimoInferior(17)."<br>";
echo PrimoInferior("593")."<br>"; */

?>