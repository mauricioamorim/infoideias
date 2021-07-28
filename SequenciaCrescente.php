<?php


/**
 * Receba como parametro um array de números inteiros e responda TRUE or FALSE 
 * se é possível obter uma sequencia crescente removendo apenas um elemento do array.
 * 
 * Exemplos para teste 
 * 
 * Obs.:- É Importante  realizar todos os testes abaixo para garantir o funcionamento correto.
 *  -  Sequencias com apenas um elemento são consideradas como TRUE
 *
 * [1, 3, 2, 1]  false
 * [1, 3, 2]  true
 * [1, 2, 1, 2]  false
 * [3, 6, 5, 8, 10, 20, 15] false
 * [1, 1, 2, 3, 4, 4] false
 * [1, 4, 10, 4, 2] false
 * [10, 1, 2, 3, 4, 5] true
 * [1, 1, 1, 2, 3] false
 * [0, -2, 5, 6] true
 * [1, 2, 3, 4, 5, 3, 5, 6] false
 * [40, 50, 60, 10, 20, 30] false
 * [1, 1] true
 * [1, 2, 5, 3, 5] true
 * [1, 2, 5, 5, 5] false
 * [10, 1, 2, 3, 4, 5, 6, 1] false
 * [1, 2, 3, 4, 3, 6] true
 * [1, 2, 3, 4, 99, 5, 6] true
 * [123, -17, -5, 1, 2, 3, 12, 43, 45] true
 * [3, 5, 67, 98, 3] true
 * 
 * 
 * @param [integer] $array
 * @return void
 */
function SequenciaCrescente($array)
{
    $countErrors = 0;

    $key_error = verificaSequencia($array);
    if($key_error !== null){
        $countErrors++;
        $temp = $array;
        array_splice($temp, $key_error, 1);
        $error1 = verificaSequencia($temp);
        $temp = $array;
        array_splice($temp, $key_error+1, 1);
        $error2 = verificaSequencia($temp);
        if($error1 !== false && $error2 !== false){
            $countErrors++;
        }
    }

    if($countErrors > 1){
        return false;
    }
    return true;
}

function verificaSequencia($array){
    foreach($array as $key => $atual){
        $nextKey = $key+1;
        if(isset($array[$nextKey]) && $atual >= $array[$nextKey]){
            return $key;
            break;
        }
    }
    return false;
}

?>