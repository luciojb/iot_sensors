<?php
define('DB_SERVER', 'localhost');
define('DB_NAME', 'sensor_iot');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');

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

	public function update($sensor) {
		echo "Updating.. id = {$sensor['id']}";
		if ($st = $this->conn->prepare("INSERT INTO sensor_data (humidity, temperature, readed_at, sensor_id) VALUES (?, ?, now(), ?)")) {
			echo "Prepared";
			$st->bind_param('ddi', $sensor['humidity'], $sensor['temperature'], $sensor['id']);
			echo "binded";
			$st->execute();
			echo "executed";
			$st->close();

			$stmt = $this->conn->prepare("SELECT MAX(id) FROM `sensor_data` WHERE sensor_id = ?");
			echo "Prepared";
			$stmt->bind_param('i', $sensor['id']);
			echo "binded";

			$result = '';
			if ($stmt->execute() && $stmt->bind_result($result)) {
				echo "Executed2";
				echo "\n result =  $result";
				$stmt->fetch();
				$stmt->close();
				if (!empty($result)) {
					echo "Result";
					if ($upst = $this->conn->prepare("UPDATE sensor s SET s.last_active=now(), s.latest_data_readed=? WHERE id = ?")) {
						$upst->bind_param('ii', $result, $sensor['id']);
						$upst->execute();
						$upst->close();
						return true;
					} else {
						echo var_export($upst, true);
					}
				}
			} else {
				echo var_export($stmt, true);
			}

		} else {
			echo var_export($st, true);
		}
		return false;
	}

	public function insert($sensor) {
		echo "inserting...";
		if ($st = $this->conn->prepare("INSERT INTO sensor (name, last_active) VALUES (?, now())")) {
			echo "Prepared";
			echo $sensor['id'];
			$st->bind_param('s', $sensor['id']);
			echo "Binded";
			try {
				if ($st->execute()) {
					echo "Executed insert";
					$st->close();
					return true;
				} else {
					echo var_export($st, true);
				}
			} catch (Exception $e) {
				echo $e->getTraceAsString();
			}

		}
		echo "Not worked";
		return false;
	}

	public function saveData($sensorData) {
		echo "Saving data \n";
		$stmt = $this->conn->prepare("SELECT id FROM `sensor` WHERE name = ?");
		$stmt->bind_param('s', $sensorData['id']);

		$result = '';
		if ($stmt->execute() && $stmt->bind_result($result)) {
			$stmt->fetch();
			echo "statement executed \n";
			$stmt->close();
			echo "result = $result";
			if (!empty($result)) {
				echo "Sensor exists. Adding data \n";
				$sensorData['id'] = $result;
				echo $this->update($sensorData);
			} else {
				echo "No sensor. insert \n";
				if ($this->insert($sensorData)) {
					echo "Inserted, updating";
					$this->saveData($sensorData);
				}
			}
		}
	}
}
