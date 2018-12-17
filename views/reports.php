<?php
if (isset($_POST['done'])) {
		$start = $_POST['from_date'];
		$end = $_POST['to_date'];
		Stock::reports($start,$end);
}
?>
<form class="form" method="post">
	<div class="row">
		<div class="col-lg-6">
			<label>From  :</label>
			<div class="form-group">
				<input type="date" name="from_date" class="form-control" required="">
			</div>
		</div>
		<div class="col-lg-6">
			<label>to  :</label>
			<div class="form-group">
				<input type="date" name="to_date" class="form-control" required="">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-3">
			<div class="form-group">
				<input type="submit" name="done" value="Create" class="form-control btn btn-success">
			</div>
		</div>
	</div>
</form>