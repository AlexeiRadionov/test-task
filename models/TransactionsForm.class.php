<?php
	class TransactionsForm extends Transactions {
		public function getUsersList() {
			$sql = "SELECT userName FROM users";
		    $users = $this -> getAssocResult($sql);
		    
		    return $users;
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