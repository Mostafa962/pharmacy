<?php
    //Start Users Controller
    $user  = New User();
    $position = $user->theUser()->position;
    if (!$user->isAdmin($position) AND (!$user->isManager($position)) ){
        header("Location:home.php?view=404");
    }
    //only for Admins and Managers
    $action = isset($_GET['action']) ? $_GET['action'] : null;
    //to add New Member
    if ($action == 'add') {
        if (isset($_POST['save'])) {
            $member = new User();
            $member->position = $_POST['position'];
            $member->Name = $_POST['Name'];
            $member->username = $_POST['username'];
            $member->email =  $_POST['email'];
            // Check if the username exists in the database
            if (User::userExists($member->username)) {
                $message = "username already exists,try with another";
               Template::failed($message);
            }// Check if the email exists in the database
            if (User::emailExists($member->email)) {
                 $message = "Email Address already exists,try with another";
                Template::failed($message);
            }
            //check if two password is identical
            elseif ($_POST['pass'] != $_POST['pass_confirm']) {
                $message = "two Passwords Does'nt Match,try again";
                Template::failed($message);
            }else{ 
                $member->password = md5($_POST['pass']);
                $member->confirmpassord = md5($_POST['pass_confirm']);
                if ($member->save()) {
                    $_SESSION['added']=true ;
                    header("Location:".$_SERVER['PHP_SELF']);
                }
            }
        }
    } 
    //To edit members data
    elseif ($action == 'edit') {
        $item = isset($_GET['item']) ? intval($_GET['item']) : null;
        if ($item) {
            $member = User::read("SELECT * FROM users WHERE id = $item", 
                    PDO::FETCH_CLASS, 'User');
            if ($member !== false) {
                if (isset($_POST['save'])) {
                    $member->position = $_POST['position'];
                    $member->Name = $_POST['Name'];
                    $member->username = $_POST['username'];
                    $member->email =  $_POST['email'];
                    $member->password = $_POST['pass'];
                    $member->confirmpassord =  $_POST['pass_confirm'];
                    if ($member->save()) {
                            $message = "Member's Data Updated";
                            Template::success($message);
                    } 
                }
            }
        }
    }
    //to delete member
    elseif ($action == 'delete') {
        $item = isset($_GET['item']) ? intval($_GET['item']) : null;
        if ($item) {
            $member = User::read("SELECT * FROM users WHERE id = $item", 
                    PDO::FETCH_CLASS, 'User');
            if ($member !== false) {
                if ($member->delete()) {
                  $_SESSION['deleted']= true;
                    header("Location:".$_SERVER['PHP_SELF']);
                } 
            }
        }
    }
    //to show Members Data using labels
    if (isset($_GET['show'])) {
        if ($_GET['show']=='pharmacists') {
           goto pharm;
        }
        elseif ($_GET['show']=='managers') {
           goto man;
        }
        elseif ($_GET['show']=='Cashiers') {
           goto cash;
        }
    }
    //End Users Controller
?>
<div class="panel panel-container">
    <div class="col-sm-offset-2">
		<form method="post" onsubmit = ""  id="members">
        <fieldset> 
            <div class="form-group col-sm-9">
            	<label>Position :<span class="color-red"> *</span></label>
               <select class="form-control" name="position" >
               		<option value="">..Select Position..</option>
                    <?php
                        //Just Admins That Can Add New Admin
                        $position = $_SESSION['user']->position; 
                        $isAdmin = new User();
                          if($isAdmin->isAdmin($position)) 
                            echo '<option value="Admin">Admin</option>';
                    ?>
               		<option value="Manager" <?php if(isset($member)) {
                        $selected = $member->position == 'Manager'?'selected':'';
                        echo $selected;
                    } ?> >Manager</option>
               		<option value="Pharmacist" <?php if(isset($member)) {
                        $selected = $member->position == 'Pharmacist'?'selected':'';
                            echo $selected;
                    } ?>>Pharmacist</option>
               		<option value="Cashier" <?php if(isset($member)) {
                            $selected = $member->position == 'Cashier'?'selected':'';
                            echo $selected;
                    } ?>>Cashier</option>
               </select>
            </div>
            <div id="error1" class="form-group  col-sm-9">
            	<label>Full Name :<span class="color-red"> *</span></label>
                <input minlength="6" maxlength="25" id="name" class="form-control" name="Name" type="text" autofocus=""  value="<?php if(isset($member)) echo $member->Name; ?>">
                <p id='errorMessage'></p>
            </div>
            <div id="error2" class="form-group col-sm-9">
            	<label>User Name :<span class="color-red"> *</span></label>
                <input id="uname" class="form-control" id="username"  name="username" type="text" autofocus=""  value="<?php if(isset($member)) echo $member->username; ?>" minlength="6" maxlength="25">
            </div>
            <div id="error3" class="form-group col-sm-9">
            	<label>E-Mail :<span class="color-red"> *</span></label>
                <input id="mail" class="form-control"  name="email" type="email" autofocus=""  value="<?php if(isset($member)) echo $member->email; ?>">
            </div>
            <div id="error4" class="form-group col-sm-9">
               <label for="password1" class="col-form-label">Password :<span class="color-red"> *</span></label>
                <input type="password" class="form-control" name="pass" id="password"   value="<?php if(isset($member)) echo $member->password; ?>" minlength="6" >
            </div>
            <div id="error5" class="form-group col-sm-9">
                <label for="password2" class="col-form-label">Confirm Password :<span class="color-red"> *</span></label>
                <input type="password"  class="form-control" name="pass_confirm"   value="<?php if(isset($member)) echo $member->confirmpassord; ?>" minlength="6" >
            </div>
             <div class="form-group col-sm-9">
                <input class="btn btn-primary form-control" type="submit" name="save" value="Save"/>
             </div>
        </fieldset>
    </form>
    </div> 
</div>
<?php 
//Pharmacists label 
if ($_GET['show']=='managers') {
    pharm:{
        $sql = "SELECT * FROM users WHERE position ='Pharmacist'";
        $data = User::ShowMembers($sql);
        echo "<div class='color-blue'>Pharmacists Members:</div><br><br>";
        echo($data);
    }
}
//Managers label 
elseif ($_GET['show']=='managers') {
    man:{
        $sql = "SELECT * FROM users WHERE position ='Manager'";
        $data = User::ShowMembers($sql);
        echo "<div class='color-blue'>Managers Members:</div><br><br>";
        echo ($data);
    }
}
//Cashiers label 
elseif ($_GET['show']=='Cashiers') {
    cash: {
        $sql = "SELECT * FROM users WHERE position ='Cashier'";
        $data = User::ShowMembers($sql);
        echo "<div class='color-blue'>Cashiers Members:</div><br><br>";
        echo ($data);
    }
}
?>