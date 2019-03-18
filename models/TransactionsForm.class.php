<?php
	class TransactionsForm extends Transactions {
		public function getUsersList() {
			$sql = "SELECT userName FROM users";
		    $users = $this -> getAssocResult($sql);
		    
		    return $users;
		}

		public function getBalance($user) {
			$sql = "SELECT sum FROM users WHERE userName = '$user'";
		    $balance = $this -> getAssocResult($sql);
		    if (!empty($balance)) {
		    	$response["result"] = 1;
				$response["balance"] = $balance[0]['sum'];
		    }
		    
		    return json_encode($response);
		}

		public function template() {
			include '../Twig/Autoloader.php';
			Twig_Autoloader::register();

			try {
			  $loader = new Twig_Loader_Filesystem('../templates');
			  
			  $twig = new Twig_Environment($loader);
			  
			  $template = $twig->loadTemplate('transactionsForm.tmpl');

			  echo $template->render(array(
			  	'users' => $this -> getUsersList()
			  ));
			  
			} catch (Exception $e) {
			  die ('ERROR: ' . $e->getMessage());
			}	
		}
	}
?>