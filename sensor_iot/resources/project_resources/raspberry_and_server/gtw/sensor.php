<?php
class Sensor {
  private $umidade;
  private $temperatura;
  private $id;
  private $prox;

  function __construct($umidade, $temperatura, $id) {
    $this->umidade = $umidade;
    $this->temperatura = $temperatura;
    $this->id = $id;
  }

  public function getUmidade() {
    return $this->umidade;
  }

  public function getTemperatura() {
    return $this->temperatura;
  }

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  public function setUmidade($umidade) {
    $this->umidade = $umidade;
    return $this;
  }

  public function setTemperatura($temperatura) {
    $this->temperatura = $temperatura;
    return $this;
  }
  
	public function getProx() {
		return $this->prox;
	}
	
	public function setProx($prox) {
		$this->prox = $prox;
		return $this;
	}
}
