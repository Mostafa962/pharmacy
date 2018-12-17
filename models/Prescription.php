<?php
/**
* 
*/
class Prescription extends Database
{
	
	public $id;
    public $number;
    public $medcine_name;
    public $qty;
    public $description;
    public $tableName = 'prescription';
    //names of table fields
    public $dbfields = array(
            'number',
            'medcine_name',
            'qty',
            'description',);
    public static function Prescriptions ($sql) {
        $deleteUrl = $_SERVER['PHP_SELF'].$view . '?action=deletePres&item=';
        $deleteWarning = 'onclick="if(!confirm(\'Do you want to delete this item\')) return false;"';
        $prescription = self::read($sql,PDO::FETCH_CLASS, __CLASS__);
        $table = '<table  class = "table table-responsive table-bordered table-hover table-center"  ><tr>
                    <th width="3%">#</th>
                    <th style="text-align:center;">Medcine Name</th>
                    <th style="text-align:center;">Quantity</th>
                    <th style="text-align:center;">Description</th>
                    <th style="text-align:center;">delete</th>
                     </tr>';
        if ($prescription != false) {
            if (is_object($prescription)) {
                $table .= '<tr>
                            <td>' .$prescription->number .'</td>
                            <td>' .$prescription->medcine_name .'</td>
                            <td>' .$prescription->qty .'</td>
                            <td>' .$prescription->description .'</td>
                            <td style="text-align:center;">
                                <a href="' .$deleteUrl . $prescription->id . '" ' . $deleteWarning . '>
                                    <em class="fa fa-trash color-red"></em>
                                </a>
                            </td> 
                           </tr>';
            }else {
                foreach ($prescription as $prescrip) {
                    $table .= '<tr>
                               <td>' .$prescrip->number .'</td>
                               <td>' .$prescrip->medcine_name .'</td>
                               <td>' .$prescrip->qty .'</td>
                               <td>' .$prescrip->description .'</td>
                                <td style="text-align:center;">
                                    <a href="'.$deleteUrl.$prescrip->id.'" '.$deleteWarning . '>
                                        <em class="fa fa-trash color-red"></em>
                                    </a>
                               </td>
                               </tr>';
                }
            }
        } else {
            $table .= '<tr><td colspan="6">No patients found</td></tr>';
        }
        $table .= '</table>';
            return $table;
    }

}