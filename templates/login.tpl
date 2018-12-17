<div class="row">
	<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
		<div class="login-panel panel panel-default">
			<div class="panel-heading">Log in</div>
				<?php 
					if(isset($_SESSION['notMatch'])){
						$message = "(Username or Emial) and password doesn't match";
						Template::failed($message);
					}
				?>

			<div class="panel-body">
				<form role="form" method="POST" action="<?PHP echo $_SERVER['PHP_SELF'];?>">
					<fieldset>
						<div class="form-group">
							<input class="form-control" placeholder="Usename Or Email " name="unameORemail" type="text" autofocus="" required="required">
						</div>
						<div class="form-group">
							<input class="form-control" placeholder="Password" name="password" type="password"  required="required">
						</div>
						<div class="form-group">
							<select class="form-control" required="required" name="position">
								<option value="">--Select position--</option>
								<option value="Admin">Admin</option>
								<option value="Manager">Manager</option>
								<option value="Pharmacist">Pharmacist</option>
								<option value="Cashier">Cashier</option>
							</select>
						</div>
						<div class="checkbox">
							<label style="margin-right: 30%;">
								<input name="remember" type="checkbox" value="Remember Me">Remember Me
							</label>
						</div>
						<div class="form-group">
						<input type="submit" name="login" name="submit" class="btn btn-primary form-control" value="Login">
						</div>
					</fieldset>
				</form>
				<a href="" target="_blank">Project Description</a>
			</div>
		</div>
	</div><!-- /.col-->
</div><!-- /.row -->	