	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<?php
					$user = new User();
					$position = $user->theUser()->position; 
					 if($user->isAdmin($position)){
						echo '<img src="images/admin_icon.jpg" class="img-responsive" alt="">';
					}elseif($user->isManager($position)){
						echo '<img src="images/manager.png" class="img-responsive" alt="">';
					}
					elseif($user->isPharmacist($position)){
						echo '<img src="images/pharmacist_icon.jpg" class="img-responsive" alt="">';
					}
					elseif($user->isCashier($position)){
						echo '<img src="images/cashier.jpg" class="img-responsive" alt="">';
					}
					?>
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name">
					<?php
					 echo $user->theUser()->username;
					 ?>
				</div>
				<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		<!-- Form For Live Search -->
		<?php 
			if(!$user->isAdmin($position)){
		?>
			<form method="post">
				<div class="form-group">
					<input type="text" placeholder="Medicine Name" id="searched" class="form-control">
				</div>
			</form>
			<script type="text/javascript">
					$(document).ready(function(){
					$('#searched').keydown(function(){
						var txt = $(this).val();
						if (txt != '') {
							$.ajax({
								url:"Ajax.php",
								method:"get",
								data:{search:txt},
								async: false,
								success:function(data) {
									$('#result').html(data);
									//when user use live search,hide main table  taht contain data with his pagination
									$('#stock_table').hide();
									//$('#result').hide();
								}
							});
						}else{
							$('#result').html('');
							//when user don't use live search,show main table  taht contain data with his pagination
							$('#stock_table').show();
						}
					});
				});
			</script>

		<?php }?>
		<ul class="nav menu">
			<li class="<?php if($_GET['action']!='add' && $_GET['action']!='addStock') echo active ?>">
				<a href="<?php echo $_SERVER['PHP_SELF']?>" title="home page">
					<em class="fa fa-home">&nbsp;</em>Home
				</a>
			</li>
			<!-- if Admin  loged in  -->
			<?php 
				if($user->isAdmin($position)){
			?>
				<!-- When Add New Memeber Selected,Make This is option active -->
			<li class="<?php if($_GET['action']=='add') echo active ?>">
				<a href="<?php echo $_SERVER['PHP_SELF'].'?view=membersView&action=add'?>" title="Add New Member">
					<em class="fa fa-users">&nbsp;</em>Add New Member
				</a>
			</li>
			<?php 
				}
			elseif($user->isManager($position)){
				?>
			<li class="<?php if($_GET['action']=='add') echo active ?>">
				<a href="<?php echo $_SERVER['PHP_SELF'].'?view=membersView&action=add' ?>" title="Add New Member">
					<em class="fa fa-users">&nbsp;</em>Add New Member
				</a>
			</li>
			<li class="<?php if($_GET['action']=='addStock') echo active ?>"><a href="<?php echo $_SERVER['PHP_SELF'].'?view=stockView&action=addStock' ?>"><em class="fa fa-medkit">&nbsp;</em>Add New Medicine</a></li>
			<?php	
				}elseif($user->isPharmacist($position)){
			?>
			<li class="<?php if($_GET['action']=='addStock') echo active ?>"><a href="<?php echo $_SERVER['PHP_SELF'].'?view=stockView&action=addStock' ?>"><em class="fa fa-medkit">&nbsp;</em>Add New Medicine</a></li>		
			<?php
				}
			?>

			<li> <a   data-toggle="modal" data-target="#logout"><i class="fa fa-power-off"></i>Logout</a></li>
		</ul>
	</div><!--/.sidebar-->

  <!-- Modal -->
  <div class="modal fade" id="logout" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">&nbsp; logout</h4>
        </div>
        <div class="modal-body">
          <p>do you want to logout ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal">close</button>
         <a href="views/logout.php" class="btn btn-danger"  title="logout" >Ok</a>
        </div>
      </div>
      
    </div>
  </div>
