<div class="panel panel-container">
		<div class="row">
			<!-- Print Messages To user To Know if Actions is done -->
			<div class="col-lg-12 text-centered">
				<?php 
					if(isset($_SESSION['added'])){
		                $message = "Member's Data Added";
	    	            Template::success($message);
                        unset($_SESSION['added']);
					}
					elseif(isset($_SESSION['deleted'])){
						$message = "Member's Data has been deleted!"; 
						Template::Deleted($message);
                        unset($_SESSION['deleted']);
					}
					elseif(isset($_SESSION['StockAdded'])){
		                $message = "Medcine's Data Added";
	    	            Template::success($message);
                        unset($_SESSION['StockAdded']);
					}
					elseif(isset($_SESSION['StockDeleted'])){
						$message = "Medcine's Data has been deleted!"; 
						Template::Deleted($message);
                        unset($_SESSION['StockDeleted']);
					}
				?>
			</div>
		</div>
		<?php
			$WhoLogin = new User();
			$position = $WhoLogin->theUser()->position;
			if($WhoLogin->isAdmin($position)) {
		?>
		<!-- if Admin login -->
		<div class="row">
			<div class="col-xs-6 col-md-3 col-lg-4 no-padding">
				<div class="panel panel-blue panel-widget border-right">
					<div class="row no-padding"><a href="home.php?view=membersView&show=managers"><em class="fa fa-xl fa-users color-teal"></em></a>
						<div class="large"><?php User::NumOfMember('Manager')?>
						</div>
						<div class="text-muted color-teal"><a href="home.php?view=membersView&show=managers"><span>Managers</span></a></div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3 col-lg-4 no-padding">
				<div class="panel panel-blue panel-widget border-right">
					<div class="row no-padding"><a href="home.php?view=membersView&show=pharmacists"><em class="fa fa-xl fa-users color-red"></em></a>
						<div class="large"><?php User::NumOfMember('Pharmacist')?>
						</div>
						<div class="text-muted color-teal"><a href="home.php?view=membersView&show=pharmacists">Pharmacists</a></div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3 col-lg-4 no-padding">
				<div class="panel panel-orange panel-widget border-right">
					<div class="row no-padding"><a href="home.php?view=membersView&show=Cashiers"><em class="fa fa-xl fa-users color-blue"></em></a>
						<div class="large"><?php User::NumOfMember('Cashier')?>
						</div>
						<div class="text-bold color-red"><a href="home.php?view=membersView&show=Cashiers">Cashiers</a></div>
					</div>
				</div>
			</div>
		</div>
		<?php

			} elseif($WhoLogin->isManager($position))
		{?>
		<!-- if Manager Login-->
		<div class="row">
			<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
				<div class="panel panel-blue panel-widget border-right">
					<div class="row no-padding"><em class="fa fa-xl fa-medkit color-red"></em>
						 <div class="large">
						 	<?php Stock::OutOfStock();?>
						</div>
						<div class="Link text-bold"><a href="<?php echo $_SERVER['PHP_SELF'].'?view=stockView&action=out' ?>">Out of Stock</a></div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
				<div class="panel panel-blue panel-widget border-right">
					<div class="row no-padding"><em class="fa fa-xl fa-file color-orange"></em>
						 <div class="large">
						 	<?php Invoice::NumOfInvoice();?>
						</div>
						<div class="Link text-bold"><a href="<?php echo $_SERVER['PHP_SELF'].'?view=reports' ?>">Generate Report</a></div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
				<div class="panel panel-blue panel-widget border-right">
					<div class="row no-padding"><a href="home.php?view=membersView&show=pharmacists"><em class="fa fa-xl fa-users color-red"></em></a>
						<div class="large"><?php User::NumOfMember('Pharmacist')?>
						</div>
						<div class="text-muted color-teal"><a href="home.php?view=membersView&show=pharmacists">Pharmacists</a></div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
				<div class="panel panel-orange panel-widget border-right">
					<div class="row no-padding"><a href="home.php?view=membersView&show=Cashiers"><em class="fa fa-xl fa-users color-blue"></em></a>
						<div class="large"><?php User::NumOfMember('Cashier')?>
						</div>
						<div class="text-bold color-red"><a href="home.php?view=membersView&show=Cashiers">Cashiers</a></div>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-12">
					<div class="alert alert-info color-blue"><center><strong>Stock</strong></center></div>
			</div>
		</div>
		<div class="row">
			
			<div class="col-lg-12">
			<?php 
				require_once('Ajax.php');
			?>
			</div>
		</div>
		<!-- if Pharmacist Login -->
		<?php 
			} elseif($WhoLogin->isPharmacist($position)){ 
		?>
		<div class="row">
			<div class="col-lg-12">
			<?php 
				if (isset($_POST['Rec'])) {
					$pre = new Prescription();
					$pre->number = $_POST['number'];
					$pre->medcine_name = $_POST['medcine_name'];
					$pre->qty = $_POST['qty'];
					$pre->description = $_POST['description'];
					if ($pre->save()) {
						echo "<script>alert('Done')</script>";
	           		 }
				}
			?>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-10">
				<div class="col-sm-offset-4">
					<form method="post"  enctype="multipart/form-data">
					<fieldset> 
						<label class="col-form-label" style="margin-left:20px">Add New Prescription</label>
					    <div class="form-group col-sm-9">
					        <input class="form-control"  name="number" type="number" autofocus="" required="required" id="num" placeholder="Patient Number">
					    </div>
					    <div class="form-group col-sm-9">
					        <input class="form-control" placeholder="Medcine Name"  name="medcine_name" type="text" id="name"  autofocus="" minlength="6"  maxlength="30" required="required">
					    </div>
					    <div class="form-group col-sm-9">
					    	<input type="text" class="form-control" placeholder="Quantity"  name="qty" id="qty" autofocus="" required="required"/>
					    </div>
					    <div class="form-group col-sm-9">
					        <textarea class="form-control" placeholder="Description" name="description" type="text" id="dec" minlength="10" maxlength="300" autofocus="" required="required"></textarea>
					    </div>
					     <div class="form-group col-sm-9">
					        <input class="btn btn-primary form-control" id="add" type="submit" name="Rec" value="Add" />
					     </div>
					</fieldset>
					</form>
				</div>
			</div>
		</div>
<!-- 		<script type="text/javascript">
			//send into server form registration data
			$("#add").click(function() {
			 var Prescription = {
			 	"number": $("#num").val(),
			 	"name": $("#name").val(),
			 	"qty": $("#qty").val() 
			 	"dec": $("#dec").val() 

			 };
			    $.ajax({
			        type: "POST",
			        url: "Ajax.php",
			        data: {"Prescription":JSON.stringify(Prescription)},
			        success: function(response){
			                alert(response);}
				}); //end of ajax object
			return false;
			}); //end of $("#submit").click(function())
			   
		</script> -->
		<div class="row">
			<div class="col-lg-12">
					<div class="alert alert-info color-blue"><center>Stock</center></div>
			</div>
		</div>
		<?php
		require_once('Ajax.php');
	} 
//<!-- If Cashier login -->
elseif($WhoLogin->isCashier($position)){ 
		?>
		<!-- orders -->
		<div class="row">
			<div class="col-lg-10" style="margin-left: 80px;">
					<div class="alert alert-info color-blue"><center><strong>Orders</strong></center></div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-10" style="margin-left: 80px;">
			<?php
				echo(Prescription::Prescriptions("SELECT * FROM prescription"));
				if (isset($_GET['action'])) {
					if ($_GET['action']=='deletePres') {
						$item = $_GET['item'];
						$pre = Prescription::read("SELECT * FROM prescription WHERE id = '$item'",PDO::FETCH_CLASS, 'Prescription');
			            if ($pre !== false) {
			                if ($pre->delete()) {
			                    header("Location:".$_SERVER['PHP_SELF']);
			                } 
			            }
					}
				}
			 ?>
			</div>
		</div>
		<!-- stock content -->
		<hr>
		<div class="row">
			<div class="col-lg-12">
					<div class="alert alert-info color-blue"><center><strong>Stock</strong></center></div>
			</div>
		</div>
		<?php 
			require_once('Ajax.php');
		?>
		<!--  Invoice  -->
		<hr><hr>
		<div class="row">
			<div class="col-lg-8" style="margin-left: 20%;">
					<div class="alert alert-info color-blue"><center><strong>Invoice</strong></center></div>
			</div>
		</div>

<?php	
//if casher add new stock to invoice
$newInvoice = new Stock();
if(isset($_GET["inv"])) {
		if($_GET['inv']=="add"){
			if ($_POST['qty'] > 0) {
				$itemById =$newInvoice::read("SELECT * FROM stock WHERE id='" . $_GET["id"] . "'",PDO::FETCH_CLASS, 'Stock');
				$itemArray = array("$itemById->id" => [
								  'id'			 =>$itemById->id, 
								  'stock_name'   =>$itemById->stock_name,
								  'qty'   =>$_POST['qty'],
								  'cost_per_one' =>$itemById->cost_per_one, 
								  'company'   	 =>$itemById->company],
							);
				//first item in invoice
				if (empty($_SESSION['invoice_item'])) {
					$_SESSION['invoice_item'] = $itemArray;
				}
				else{
					for ($i=0;$i<count($_SESSION["invoice_item"]); $i++) {
						if("$itemById->id"==$_SESSION['invoice_item'][$i]['id']){
							$_SESSION['invoice_item'][$i]['qty'] += $_POST["qty"];
							break;
						}
						if("$itemById->id"!=$_SESSION['invoice_item'][$i]['id']){
							$_SESSION["invoice_item"] = array_merge($_SESSION["invoice_item"],$itemArray);
							break;
						}
						continue;
					}
				} //end else
			} //end if qty>0
		}//end if action add
		elseif ($_GET['inv']=="remove") {
			$id = $_GET['id'];
			foreach ($_SESSION['invoice_item'] as $key => $value) {
					if("$id" == $value['id']){
						 unset($_SESSION['invoice_item'][$key]);	
						break;	
					}
					if (empty($_SESSION["invoice_item"])) {
						unset($_SESSION["invoice_item"]);
					}
			}
		}
		elseif ($_GET['inv']=="empty") {
			unset($_SESSION["invoice_item"]);
		}
}
//show invoice table
	$invoice = new Invoice();
	$invoice->show_invoice();
?>
		  <br>
	</div>
</div>	<!--/.main-->
<?php
	//print invoice
	if (isset($_GET['print'])) {
		$invoice->client = $_POST['client'];
		$invoice->phone = $_POST['phone'];
		foreach ($_SESSION["invoice_item"] as $item){
			$idSt [] = $item['id'];
		 	$name[]= $item["stock_name"];
		 	$price[]= $item["cost_per_one"];
		 	$qty[]= $item["qty"];
		}
		$stock = new Stock();
		//update quantity of stock
		for ($i=0; $i < count($idSt) ; $i++) { 
			$stock = Stock::read("SELECT * FROM stock WHERE id = ".$idSt[$i], 
                PDO::FETCH_CLASS, 'Stock');
			$stock->quantity -=$qty[$i];
			$stock->sales +=$qty[$i];
			$stock->save();
		}
		$invoice->stock_name = implode('&', $name);
		$invoice->price = implode('&', $price);
		$invoice->qty = implode('&', $qty);
		if ($invoice->save()) {
			$invoice->invoice_pdf($_POST['client'], $_POST['phone']);
			//header("Location:".$_SERVER['PHP_SELF']."?inv=empty");
		}
	} 
}//end if a cashier login
?>
</div><!--/.container-->
