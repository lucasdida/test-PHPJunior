<?php

namespace App\Http\Controllers\Api;

use App\API\ApiError;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RotasController extends Controller
{

    public function calculamelhorrota($origem, $destino, $autonomia, $litro_combustivel) {

        $obj = new RotasController();
        $pontos = array('A', 'B', 'C', 'D', 'E');

        //Verifica se a rota é valida
        $flag_origem = $obj->verificarotavalida($origem, $pontos);
        $flag_destino = $obj->verificarotavalida($destino, $pontos);

        if ($flag_origem == false) {
            return response()->json(
                ApiError::errorMessage('Rota de origem inválida, favor adicionar uma outra rota de origem', 1010),
            );
        } elseif ($flag_destino == false) {
            return response()->json(
                ApiError::errorMessage('Rota de destino inválida, favor adicionar uma outra rota de destino', 1010),  
            );
        } else {
            
            //Converte os pontos de origem e destino em números
            $origem = $obj->converterota($origem, $pontos);
            $destino = $obj->converterota($destino, $pontos);

            //Adiciona no array os caminhos possíveis
            $rotas = array();
            $rotas[1][2] = 10; //A-B
            $rotas[1][3] = 20; //A-C   
            $rotas[2][1] = 10; //B-A
            $rotas[2][4] = 15; //B-D
            $rotas[2][5] = 50; //B-E
            $rotas[3][1] = 20; //C-A 
            $rotas[3][4] = 30; //C-D
            $rotas[4][2] = 15; //D-B
            $rotas[4][3] = 30; //D-C
            $rotas[4][5] = 30; //D-E 
            $rotas[5][2] = 50; //E-B
            $rotas[5][4] = 30; //E-D

            //Calculo para achar o caminho com valor minimo baseado na logica de Dijkstra
            $distancia = array();
            $Q = array();
            
            foreach (array_keys($rotas) as $val) {
                $Q[$val] = 99999;
            }    
            
            $Q[$origem] = 0;

            while (!empty($Q)) {
                $min = array_search(min($Q), $Q);

                if ($min == $destino) 
                    break;

                foreach ($rotas[$min] as $key=>$val) {
                    if (!empty($Q[$key]) && $Q[$min] + $val < $Q[$key]) {
                        $Q[$key] = $Q[$min] + $val;
                        $distancia[$key] = array($min, $Q[$key]);
                    }
                }
                
                unset($Q[$min]);
            }

            //listagem do caminho
            $caminho = array();
            $pos = $destino;
            
            while ($pos != $origem) {
                $caminho[] = $pos;
                $pos = $distancia[$pos][0];
            }

            $caminho[] = $origem;
            $caminho = array_reverse($caminho);

            $caminho = $obj->convertecaminho($caminho, $pontos);

            $litro_combustivel = str_replace(',','.', $litro_combustivel);

            if (isset($distancia[$destino][1])) 
                $custo = $litro_combustivel * $distancia[$destino][1] / $autonomia;
            else
                $custo = 0;

                
            $melhor_resultado = array (
                'melhor_rota' => $caminho,
                'custo' => $custo = number_format($custo, 2, ',', '.')
            );

            return json_encode($melhor_resultado);
        }

    }

    public function verificarotavalida ($origem_destino, $pontos) {

        foreach ($pontos as $p) {
            if ($origem_destino == $p)
                return true;
        }

        return false;

    }

    public function converterota ($origem_destino, $pontos) {

        for ($i=0; $i < count($pontos); $i++) {
            if ($origem_destino == $pontos[$i]) {
                return $origem_destino = $i + 1;
            }
        }
    
    }

    public function convertecaminho ($caminho, $pontos) {

        for ($i=0; $i <= count($caminho)-1; $i++) {
            switch ($caminho[$i]) {
                case 1:
                    $caminho[$i] = 'A';
                    break;
                case 2:
                    $caminho[$i] = 'B';
                    break;
                case 3:
                    $caminho[$i] = 'C';
                    break;
                case 4:
                    $caminho[$i] = 'D';
                    break;
                case 5:
                    $caminho[$i] = 'E';
                    break;
            }
        }

        return $caminho;
    
    }

}
