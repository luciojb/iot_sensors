<?php
require 'sensor.php';

class ListaCircular {
	private $inicio = null, $fim = null, $aux = null, $anterior = null;

// 	public function inserirInicio($umidade, $temperatura, $id){
// 		$sensor = new Sensor($umidade, $temperatura, $id);
// 		if (inicio == null){
// 			//Vazia, inicio e fim recebem o elemento
// 			$this->inicio = $sensor;
// 			$this->fim = $sensor;
// 			$this->fim->prox = $inicio;
// 		} else {
// 			//A lista contém elementos, e o novo elemento será inserido no inicio da lista
// 			$sensor->prox = $this->inicio;
// 			$this->inicio = $sensor;
// 			$fim->prox = $this->inicio;
// 		}
// 	}

	/**
	 * 
	 * @param string $id = the identifier
	 * @param double $umidade = the humidity read
	 * @param double $temperatura = the temperature read
	 */
	public function inserirFim($id, $umidade, $temperatura){
		$sensor = new Sensor($umidade, $temperatura, $id);
		if (empty($this->inicio)){
			//Vazia, inicio e fim recebem o elemento
			$this->inicio = $sensor;
			$this->fim = $sensor;
			$this->fim->setProx($this->inicio);
		} else {
			//A lista contém elementos, e o novo elemento será inserido no fim da lista

			$this->fim->setProx($sensor);
			$this->fim = $sensor;
			$this->fim->setProx($this->inicio);
		}
	}

// 	public void removerNodo(int cod){
// 		int ocorrencias = 0;
// 		if(inicio == null){
// 			System.out.println("Lista Vazia");
// 		} else {
// 			aux = inicio;
// 			anterior = null;
// 			do {
// 				if (aux.cod == cod){
// 					ocorrencias++;
// 					if (inicio == fim){
// 						inicio = null;
// 					}
// 					if(aux == inicio){
// 						inicio = aux.prox;
// 						fim.prox = inicio;
// 						aux = inicio;
// 					} else if(aux == fim){
// 						fim = anterior;
// 						fim.prox = inicio;
// 						aux = inicio;
// 					} else {
// 						anterior.prox = aux.prox;
// 						aux = aux.prox;
// 					}
// 				} else {
// 					anterior = aux;
// 					aux = aux.prox;
// 				}
// 			}while (aux != inicio);
// 		}
// 		if (ocorrencias == 0){
// 			System.out.println("Produto não encontrado.");
// 		} else {
// 			System.out.println("Removidos "+ocorrencias+" produtos de codigo "+cod+".");
// 		}
// 	}

	public function contarNodos(){
		$ocorrencias = 0;
		if(!empty($this->inicio)){
			$this->aux = $this->inicio;
			$ocorrencias++;
			while(!empty($this->aux->getProx()) && $this->aux->getProx() !== $this->inicio){
				$this->aux = $this->aux->getProx();
				$ocorrencias++;
			};
		}
		return $ocorrencias;
	}
	
	public function calculaMédia() {
		$id = '';
		$temp = 0;
		$umidade = 0;
		
		$ocorrencias = 0;
		if(!empty($this->inicio)){
			$this->aux = $this->inicio;
			
			$id = $this->aux->getId();
			
			$temp += $this->aux->getTemperatura();
			$umidade += $this->aux->getUmidade();
			
			$ocorrencias++;
			while(!empty($this->aux->getProx()) && $this->aux->getProx() !== $this->inicio){
				$this->aux = $this->aux->getProx();
				
				$temp += $this->aux->getTemperatura();
				$umidade += $this->aux->getUmidade();
				
				$ocorrencias++;
			};
		}
		
		return "id:$id;temperature:".$temp/$ocorrencias.";humidity:".$umidade/$ocorrencias;
	}

}
