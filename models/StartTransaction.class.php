<?php
	class StartTransaction extends Transactions {
		protected $sender;
		protected $recipient;
		protected $sum;

		function __construct($sender, $recipient, $sum) {
			$this -> sender = $sender;
			$this -> recipient = $recipient;
			$this -> sum = $sum;
		}

		public function checkTransaction() {
			$sumSend = $this -> getSum($this -> sender);
			$sumRecipient = $this -> getSum($this -> recipient);
			if (!is_null($sumSend) && !is_null($sumRecipient) && $sumSend >= $this -> sum) {
				if ($this -> transaction($this -> sender, $this -> recipient, $this -> sum)) {

					return true;
				}
			}
		}

		public function getSum($value) {
			$sql = "SELECT sum FROM users WHERE userName = '$value'";
		    $sum = $this -> getAssocResult($sql);
		    
		    return (float)$sum[0]['sum'];
		}

		public function transaction($sender, $recipient, $sum) {
			try {
				$objDataBase = DataBase::getInstance();
				$db = $objDataBase -> getDb();
				
				$db -> beginTransaction();
				$sql = "UPDATE users SET sum = sum - $sum WHERE userName = '$sender'";
				if ($this -> executeQuery($sql)) {
					$sql = "UPDATE users SET sum = sum + $sum WHERE userName = '$recipient'";
					$this -> executeQuery($sql);
				}
			} catch (PDOException $e) {
				$db -> rollBack();
				die('ERROR: ' . $e->getMessage());
			}

			$db -> commit();
			return true;
		}

		public function logFile() {
			$file = 'logFile.txt';
			$text = "======================\n";
			$textLog = 'Пользователь ' . $this -> sender . ' перевёл пользователю ' . $this -> recipient . ' сумму ' . $this -> sum;
			
			$text .= $textLog;
			$text .= "\n". date('Y-m-d H:i:s') ."\n";
			$fOpen = fopen($file,'a');
			fwrite($fOpen, $text);
			fclose($fOpen);
		}

		public function response() {
			$response["result"] = 1;
			$response["sender"] = $this -> sender;
			$response["recipient"] = $this -> recipient;
			$response["sumSend"] = $this -> getSum($this -> sender);
			$response["sumRecipient"] = $this -> getSum($this -> recipient); 

		    return json_encode($response);
		}

		public function template() {
			
		}
	}
?>