<?php
define('DB_SERVER', 'localhost');
define('DB_NAME', 'sensor_db');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

class Connection {
	var $db, $conn, $count = 0, $success = false;


	public function connect() {
		while (!$this->success && $this->count < 5) {
			try {
				if ($this->conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME)) {
					return $this->conn;
				}
			} catch (Exception $e) {
				echo $e->getTraceAsString();
			}
		}
		return $this->success;
	}

	public function insert($sensorData) {
		if ($st = $this->conn->prepare("INSERT INTO sensor ('identifier, humidity, temperatue') VALUES (?, ?, ?)")) {
			$st->bind_param('sdd', $sensorData['identifier'], $sensorData['humidity'], $sensorData['temperature']);
			return $st->execute();
		}
		return false;

	}

	public function update($sensorData) {

		if ($st = $this->conn->prepare("UPDATE sensor s SET s.humidity=?, s.temperature=?, s.readed_at=now() WHERE id = ?")) {
			$st->bind_param('ddi', $sensorData['humidity'], $sensorData['temperature'], $sensorData['identifier']);
			return $st->execute();
		} else {
			echo var_export($st, true);
		}
		return false;


	}

	public function saveData($sensorData) {
		echo "Saving data \n";
		$stmt = $this->conn->prepare("SELECT id FROM `sensor` WHERE identifier = ?");
		$stmt->bind_param('s', $sensorData['identifier']);

		$result = '';
		if ($stmt->execute() && $stmt->bind_result($result)) {
			$stmt->fetch();
			echo "statement executed \n";
			$stmt->close();
			if (!empty($result)) {
				echo "more than one. update \n";
				$sensorData['identifier'] = $result;
				echo $this->update($sensorData);
			} else {
				echo "less than one. insert \n";
				echo $this->insert($sensorData);
			}
		} else {
//			echo var_export($stmt, true);
		}
	}
}

?>
