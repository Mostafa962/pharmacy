<div id='result'>
</div>
	<?php		
		require_once('env.php');
		$user = new User();
		//Show TableStock For Managers and Pharmacist
		if ($user->theUser()->position != 'Cashier') {
			if (isset($_GET['search'])) {
				$q = $_GET['search'];
				if (strlen($q) > 0) {
					echo (Stock::LiveShowStock("SELECT * FROM stock WHERE stock_name LIKE '%$q%' LIMIT 5"));
				}
			} else{
				echo (Stock::ShowStock('SELECT * FROM stock ORDER BY quantity '));
			}
		//show Table of Stock for Cashiers
		}else{
				if (isset($_GET['search'])) {
				$q = $_GET['search'];
				if (strlen($q) > 0) {
					echo (Stock::LiveDataForCashier("SELECT * FROM stock WHERE stock_name LIKE '%".$q."%' AND status = 'Available' AND quantity > 0   LIMIT 5 "));
				}
			} else{
				echo (Stock::DataForCashier('SELECT * FROM stock  WHERE status = \'Available\' AND quantity > 0 '));
			}
		}
// //insert Prescription information to DB using Ajax
// if(isset($_POST['Prescription'])){
//   $Prescription = json_decode($_POST['Prescription'], true);
//   $number = $Prescription["number"];
//   $medcine = $Prescription["name"];
//   $qty = $Prescription["qty"];
//   $dec = $Prescription["dec"];
// 	$pre = new Prescription();
// 	$pre->save();
// }
	?>
