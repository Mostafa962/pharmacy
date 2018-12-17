<?php 
	//Start Stock Controller
	$user  = New User();
	$position = $user->theUser()->position;
	if (!$user->isPharmacist($position) AND !$user->isManager($position)) {
	    header("Location:home.php?view=404");
	}
	$action = isset($_GET['action']) ? $_GET['action'] : null;
	//to add New Stock
	if ($action == 'addStock') {
		if (isset($_POST['save'])) {
		    $newStock = new Stock();
		    $newStock->stock_name = $_POST['name'];
		    $newStock->type = $_POST['type'];
		    $newStock->company = $_POST['Company'];
		    $newStock->quantity =  $_POST['quantity'];
	        $newStock->cost_per_one = $_POST['cost'];
	        $newStock->status = $_POST['statues'];
	            if ($newStock->save()) {
	                $_SESSION['StockAdded']=true ;
	                header("Location:".$_SERVER['PHP_SELF']);
	            }
		}
	}
	//To edit Stock data
	elseif ($action == 'edit') {
		$item = isset($_GET['item']) ? intval($_GET['item']) : null;
		if ($item) {
		    $StockData = Stock::read("SELECT * FROM stock WHERE id = $item", 
		            PDO::FETCH_CLASS, 'Stock');
		    if ($StockData !== false) {
		        if (isset($_POST['save'])) {
				    $StockData->stock_name = $_POST['name'];
				    $StockData->type = $_POST['type'];
				    $StockData->company = $_POST['Company'];
				    $StockData->quantity =  $_POST['quantity'];
			        $StockData->cost_per_one = $_POST['cost'];
			        $StockData->status = $_POST['statues'];
		            if ($StockData->save()) {
		                    $message = "Medcine's Data Updated";
		                    Template::success($message);
		            } 
		        }
		    }
		}
	}
	//to delete Stock
	elseif ($action == 'delete') {
		$item = isset($_GET['item']) ? intval($_GET['item']) : null;
		if ($item) {
		    $stock = Stock::read("SELECT * FROM stock WHERE id = $item", 
		            PDO::FETCH_CLASS, 'Stock');
		    if ($stock !== false) {
		        if ($stock->delete()) {
		          $_SESSION['StockDeleted']= true;
		            header("Location:".$_SERVER['PHP_SELF']);
		        } 
		    }
		}
	}
	elseif ($action=='out') {
		echo Stock::ShowStock("SELECT * FROM stock Where quantity = 0 ");
	}
	//End Stock Controller
if ($action!='out') {
	?>
<div class="panel panel-container">
    <div class="col-sm-offset-2">
		<form method="post"  action="" id="stock">
		<fieldset> 
		    <div class="form-group col-sm-9">
		    	<label for="name" class="col-form-label">Medcine Name : <span class="color-red">*</span></label>
		        <input class="form-control " value="<?php if(isset($StockData)) echo $StockData->stock_name; ?>"  name="name" type="text" autofocus=""  minlength="6" maxlength="30">
		    </div>
		    <div class="form-group col-sm-9">
		    	<label for="type" class="col-form-label">Medcine Type : <span class="color-red">*</span></label>
		        <input class="form-control" value="<?php if(isset($StockData)) echo $StockData->type; ?>"  name="type" type="text" autofocus=""  minlength="6" maxlength="30">
		    </div>
		    <div class="form-group col-sm-9">
		    	<label for="Company" class="col-form-label">Company : <span class="color-red">*</span></label>
		    	<input type="text" class="form-control" value="<?php if(isset($StockData)) echo $StockData->company; ?>"  name="Company" autofocus="" / minlength="6" maxlength="30">

		    </div>
		    <div class="form-group col-sm-9">
		    	<label for="quantity"  class="col-form-label">Medine Quantity : <span class="color-red">*</span></label>
		        <input class="form-control" value="<?php if(isset($StockData)) echo $StockData->quantity; ?>" name="quantity" type="number" autofocus=""  >
		    </div>
		    <div class="form-group col-sm-9">
		    	<label for="Cost" class="col-form-label">Cost Per One :  <span class="color-red">*</span></label>
		        <input class="form-control" value="<?php if(isset($StockData)) echo $StockData->cost_per_one; ?>" name="cost" type="number" step="any" autofocus=""  >
		    </div>


		    <div class="form-group col-sm-9">
		    	<label for="Statues" class="col-form-label">Statues :  <span class="color-red">*</span></label>
		        <select name="statues"  class="form-control" >
		        	<option value="Available" <?php if(isset($StockData)) {
		                    $selected = $StockData->status == 'Available'?'selected':'';
		                    echo $selected;
		                } ?>>Available</option>
		        	<option value="Not Available" <?php if(isset($StockData)) {
		                    $selected = $StockData->status == 'Not Available'?'selected':'';
		                    echo $selected;
		                } ?>>Not Available</option>
		        </select>
		     </div>  
		     <div class="form-group col-sm-9">
		        <input class="btn btn-primary form-control" type="submit" name="save" value="Save Medcine Data"/>
		     </div>
		</fieldset>
		</form>
	</div>
</div>
<?php }
?>