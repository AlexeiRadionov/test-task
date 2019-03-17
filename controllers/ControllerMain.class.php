<?php
	class ControllerMain {
		private $page_name;
		private $action;

		public function getPage_name() {
			return $this -> page_name;
		}

		public function getAction() {
			return $this -> action;
		}

		public function setter($page_name, $action) {
			$this -> page_name = $page_name;
			$this -> action = $action;
		}

		function __construct($page_name, $action) {
			$this -> setter($page_name, $action);
		}

		public function prepareVariables() {
			switch ($this -> page_name) {
		        case 'index':
		            $objTransactionsForm = new TransactionsForm();
					$objTransactionsForm -> template();
		            break;
		        case 'startTransaction':
		        	if (isset($_POST['sender']) && isset($_POST['recipient']) && isset($_POST['sum'])) {
		        		$sender = $_POST['sender'];
		        		$recipient = $_POST['recipient'];
		        		$sum = abs((float)$_POST['sum']);
		        		$sum = round($sum, 2);
		        		
		        		$objStartTransaction = new StartTransaction($sender, $recipient, $sum);
		            	if ($objStartTransaction -> checkTransaction()) {
		            		$objStartTransaction -> logFile();
		            		echo $objStartTransaction -> response();
		            	}
		        	}
		            break;
		    }
		}
	}
?>