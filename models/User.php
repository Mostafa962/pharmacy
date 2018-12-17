<?php 

class User extends Database  
{
	public $id;
    public $position;
    public $Name;
    public $username;
    public $email;
    public $password;
    public $confirmpassord;
    public $last_login;
    public $tableName = 'users';
    //names of table fields
    public $dbfields = array(
            'position',
            'Name',
            'username',
            'email',
            'password',
            'confirmpassord',
            'last_login');
    //check if username already exist or Not
    public static function userExists ($username) {
        $sql = "SELECT * FROM users WHERE username = '" . $username . "'";
        $foundUser = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
        return $foundUser ? true : false;
    }
    //check if email already exist or Not
    public static function emailExists ($email) {
        $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
        $foundEmail = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
        return $foundEmail ? true : false;
    }
    public static function authenticate ($unameOrEmail,$password, $position) {
        // Check if the username exists and enabled
        $sql = "SELECT * FROM users WHERE (username = '" .$unameOrEmail."'OR email='".$unameOrEmail."')AND password = '" .$password."'AND position='".$position."'";
        $foundUser = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
        if ($foundUser) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['user'] = $foundUser;
            $foundUser->last_login = date('Y-m-d H:i:s');
            if ($foundUser->save()) {
                header('Location: ' . HOST_NAME.'home.php');
            }
        }else{
            $_SESSION['notMatch'] =  true;
            header('Location:'.$_SERVER['PHP_SELF']);
        }
    }
    public static function isLoggedIn () {
        return ($_SESSION['loggedIn'] === true) ? true : false;
    }
    public function logout () {
        session_unset();
        session_destroy();
        header('Location: ' . HOST_NAME);
    }
    public function theUser () {
        return $_SESSION['user'];
    }
    
    public function isAdmin($position) {
        return $position == 'Admin' ? true : false;
    }
    public function isManager($position) {
        return $position == 'Manager' ? true : false;
    }    
    public function isPharmacist($position) {
        return $position == 'Pharmacist' ? true : false;
    }
    public function isCashier($position) {
        return $position == 'Cashier' ? true : false;
    }
    public static function NumOfMember($position){
        global $dbh;
        $sql = "SELECT COUNT(*) as num FROM users WHERE position ='$position'";
        $results = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
        echo($results->num);
    }
    public static function ShowMembers ($sql) {
        $view = $_GET['view'];
        $editUrl = $_SERVER['PHP_SELF'].'?view=' . $view . '&action=edit&item=';
        $deleteUrl = $_SERVER['PHP_SELF'].'?view=' . $view . '&action=delete&item=';
        $deleteWarning = 'onclick="if(!confirm(\'Do you want to delete this item\')) return false;"';
        $allMembers = self::read($sql,PDO::FETCH_CLASS, __CLASS__);
        $table = '<table  class = "table table-responsive table-bordered table-hover table-center"  ><tr>
                    <th width="3%">#</th>
                    <th style="text-align:center;">Name</th>
                    <th style="text-align:center;">Username</th>
                    <th style="text-align:center;">Email</th>
                    <th style="text-align:center;">edit</th>
                    <th style="text-align:center;">delete</th>
                     </tr>';
        if ($allMembers != false) {
            if (is_object($allMembers)) {
                $table .= '<tr>
                            <td>1</td>
                            <td>' .$allMembers->Name .'</td>
                            <td>' .$allMembers->username .'</td>
                            <td>' .$allMembers->email .'</td>
                            <td style="text-align:center;">
                                <a href="'.$editUrl.$allMembers->id .'">
                                   <em class="fa fa-edit"></em>
                                </a> 
                            </td>
                            <td style="text-align:center;">
                                <a href="' .$deleteUrl . $allMembers->id . '" ' . $deleteWarning . '>
                                    <em class="fa fa-trash color-red"></em>
                                </a>
                            </td> 
                           </tr>';
            }else {
                $i = 1;
                foreach ($allMembers as $member) {
                    $table .= '<tr>
                               <td>' . $i ++ . '</td>
                               <td>' .$member->Name .'</td>
                               <td>' .$member->username .'</td>
                               <td>' .$member->email .'</td>
                               <td style="text-align:center;">
                                    <a href="' .$editUrl.$member->id .'">
                                        <em class="fa fa-edit"></em>
                                   </a>
                                </td>
                                <td style="text-align:center;">
                                    <a href="'.$deleteUrl.$member->id.'" '.$deleteWarning . '>
                                        <em class="fa fa-trash color-red"></em>
                                    </a>
                               </td>
                               </tr>';
                }
            }
        } else {
            $table .= '<tr><td colspan="6">No Members found</td></tr>';
        }
        $table .= '</table>';
            return $table;
    }

}
?>
