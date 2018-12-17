<?php
class Stock extends Database
{
	public $id;
    public $stock_name;
    public $type;
    public $company;
    public $quantity;
    public $cost_per_one;
    public $status;
    public $sales;
    public $added_or_updated_date;
    public $tableName = 'stock';
    //names of table fields
    public $dbfields = array(
            'stock_name',
            'type',
            'company',
            'quantity',
            'cost_per_one',
            'status',
            'sales',
        );
    public static function ShowStock ($sql) {
        global $dbh;
        $view = $_GET['view'];
        $editUrl = 'home.php'.'?view=stockView&action=edit&item=';
        $deleteUrl = 'home.php?view=stockView&action=delete&item=';
        $deleteWarning = 'onclick="if(!confirm(\'Do you want to delete this item\')) return false;"';
        $allStock = self::read($sql,PDO::FETCH_CLASS, __CLASS__);
        $table = '<div id="stock_table"><table class = "search-table table table-responsive table-bordered table-hover table-center"><thead>
                <tr style="background:#dee1e6">
                    <th width="3%">#</th>
                    <th style="text-align:center;">Name</th>
                    <th style="text-align:center;">Type</th>
                    <th style="text-align:center;">Company</th>
                    <th style="text-align:center;">Quantity</th>
                    <th style="text-align:center;">Cost^One</th>
                    <th style="text-align:center;">status</th>
                    <th style="text-align:center;">Added/Updated</th>
                    <th style="text-align:center;">edit</th>
                    <th style="text-align:center;">delete</th>
                </tr></thead>';
        if ($allStock != false) {
            if (is_object($allStock)) {
                $table .= '<tbody><tr>
                            <td>1</td>
                            <td>' .$allStock->stock_name .'</td>
                            <td>' .$allStock->type .'</td>
                            <td>' .$allStock->company .'</td>
                            <td>' .$allStock->quantity .'</td>
                            <td>' .$allStock->cost_per_one .'</td>
                            <td>' .$allStock->status .'</td>
                            <td>' .$allStock->added_or_updated_date .'</td>
                            <td style="text-align:center;">
                                <a href="'.$editUrl.$allStock->id .'">
                                   <em class="fa fa-edit"></em>
                                </a> 
                            </td>
                            <td style="text-align:center;">
                                <a href="' .$deleteUrl . $allStock->id . '" ' . $deleteWarning . '>
                                    <em class="fa fa-trash color-red"></em>
                                </a>
                            </td> 
                           </tr></tbody></table>';
                             $table .= '</table>';
            }else {
                $i = 1;
                $option = array("limit" => 10, "theme" => "blue", "adjacents" => 3, "action" =>'',"condition" => "1","query" => $sql);
                $pg = new MP($dbh,'stock',$option);
                foreach ($pg->getData() as $medcine) {
                    $table .= '<tbody><tr>
                                <td>' . $i++ . '</td>
                                <td><div>' .$medcine['stock_name'].'</div></td>
                           		<td>' .$medcine['type'] .'</td>
                           		<td>' .$medcine['company'] .'</td>
                         		<td>' .$medcine['quantity'] .'</td>
                          		<td>' .$medcine['cost_per_one'] .'</td>
                          		<td>' .$medcine['status'].'</td>
                         		<td>' .$medcine['added_or_updated_date'] .'</td>
                                <td style="text-align:center;">
                                    <a href="' .$editUrl.$medcine['id'].'">
                                        <em class="fa fa-edit"></em>
                                   </a>
                                </td>
                                <td style="text-align:center;">
                                    <a href="'.$deleteUrl.$medcine['id'].'" '.$deleteWarning . '>
                                        <em class="fa fa-trash color-red"></em>
                                    </a>
                               </td>
                               </tr></tbody>';
                }
                  $table .= '</table>';
            $table.='<center>'.$pg->pagination().'</center></div>';
            }
       
        } else {
            $table .= '<tbody><tr><td colspan="6">No Stock found</td></tr></tbody></table>';
        }
        
            return $table;
    }
    public static function LiveShowStock ($sql) {
        global $dbh;
        $view = $_GET['view'];
        $editUrl = 'home.php'.'?view=stockView&action=edit&item=';
        $deleteUrl = 'home.php'.'?view=stockView&action=delete&item=';
        $deleteWarning = 'onclick="if(!confirm(\'Do you want to delete this item\')) return false;"';
        $allStock = self::read($sql,PDO::FETCH_CLASS, __CLASS__);
        $table = '<table  class = "search-table table table-responsive table-bordered table-hover table-center"><thead>
                <tr style="background:#dee1e6">
                    <th width="3%">#</th>
                    <th style="text-align:center;">Name</th>
                    <th style="text-align:center;">Type</th>
                    <th style="text-align:center;">Company</th>
                    <th style="text-align:center;">Quantity</th>
                    <th style="text-align:center;">Cost^One</th>
                    <th style="text-align:center;">status</th>
                    <th style="text-align:center;">Added/Updated</th>
                    <th style="text-align:center;">edit</th>
                    <th style="text-align:center;">delete</th>
                </tr></thead>';
        if ($allStock != false) {
            if (is_object($allStock)) {
                $table .= '<tbody><tr>
                            <td>1</td>
                            <td>' .$allStock->stock_name .'</td>
                            <td>' .$allStock->type .'</td>
                            <td>' .$allStock->company .'</td>
                            <td>' .$allStock->quantity .'</td>
                            <td>' .$allStock->cost_per_one .'</td>
                            <td>' .$allStock->status .'</td>
                            <td>' .$allStock->added_or_updated_date .'</td>
                            <td style="text-align:center;">
                                <a href="'.$editUrl.$allStock->id .'">
                                   <em class="fa fa-edit"></em>
                                </a> 
                            </td>
                            <td style="text-align:center;">
                                <a href="' .$deleteUrl . $allStock->id . '" ' . $deleteWarning . '>
                                    <em class="fa fa-trash color-red"></em>
                                </a>
                            </td> 
                           </tr></tbody></table>';
            }else {
                $i = 1;
                foreach ($allStock as $stock) {
                    $table .= '<tr>
                               <td>' . $i ++ . '</td>
                            <td>' .$stock->stock_name .'</td>
                            <td>' .$stock->type .'</td>
                            <td>' .$stock->company .'</td>
                            <td>' .$stock->quantity .'</td>
                            <td>' .$stock->cost_per_one .'</td>
                            <td>' .$stock->status .'</td>
                            <td>' .$stock->added_or_updated_date .'</td>
                               <td style="text-align:center;">
                                    <a href="' .$editUrl.$stock->id .'">
                                        <em class="fa fa-edit"></em>
                                   </a>
                                </td>
                                <td style="text-align:center;">
                                    <a href="'.$deleteUrl.$stock->id.'" '.$deleteWarning . '>
                                        <em class="fa fa-trash color-red"></em>
                                    </a>
                               </td>
                               </tr>';
                }
            }
          $table .= '</table>';
        } else {
            $table .= '<tbody><tr><td colspan="6">No Stock found</td></tr></tbody></table>';
        }
            return $table;
    }
    public static function DataForCashier ($sql) {
        global $dbh;
        $allStock = self::read($sql,PDO::FETCH_CLASS, __CLASS__);
        $table = '<div id="stock_table"><table class = "table table-responsive table-bordered table-hover table-center">
                <tr style="background:#dee1e6">
                    <th width="3%">#</th>
                    <th style="text-align:center;">Name</th>
                    <th style="text-align:center;">Type</th>
                    <th style="text-align:center;">Cost^One</th>
                     <th style="text-align:center;">Qty</th>
                    <th style="text-align:center;">Add</th>
                </tr>';
        if ($allStock != false) {
            if (is_object($allStock)) {
                $table .= '<tr style="width:10px;">
                            <td>1</td>
                            <td>' .$allStock->stock_name .'</td>
                            <td>' .$allStock->type .'</td>
                            <td>' .$allStock->cost_per_one .'</td>
                         <td style="width:50px;">
                            <form method="post" action="'. $_SERVER['PHP_SELF'].'?inv=add&id=' .$allStock->id.'">
                            <input style="width:50px;" type="number" name="qty" value="1">
                        </td>
                        <td style="width:50px;">
                            <input type="submit" class="btn btn-info" value="+" class="btnAddAction" /></form>
                        </td>
                           </tr>';
            }else {
                $i = 1;
                $option = array("limit" => 10, "theme" => "blue", "adjacents" => 3, "action" =>'',"condition" => "1","query" =>" SELECT * FROM stock WHERE status = 'Available' AND quantity > 0");
                $pg = new MP($dbh,'stock',$option);
                foreach ($pg->getData() as $medcine) {
                    $table .= '<tr>
                        <td>' . $i++ . '</td>
                        <td style="text-align:center">' .$medcine['stock_name'].'</td>
                        <td style="text-align:center">' .$medcine['type'] .'</td>
                        <td style="width:50px;text-align:center">' .$medcine['cost_per_one'] .'</td>
                        <td style="width:50px;">
                            <form method="post" action="'. $_SERVER['PHP_SELF'].'?inv=add&id=' .$medcine['id'].'">
                            <input style="width:50px;" type="number" name="qty" value="1">
                        </td>
                        <td style="width:50px;">
                            <input type="submit" class="btn btn-info" value="+" class="btnAddAction" /></form>
                        </td>
                            </tr>';
                }
            } $table.='<center>'.$pg->pagination().'</center></div>';
        } else {
            $table .= '<tr><td colspan="6">No Stock found</td></tr>';
        }
        $table .= '</table>';
           
            return $table;
    }
    public static function LiveDataForCashier ($sql) {
        global $dbh;
        $allStock = self::read($sql,PDO::FETCH_CLASS, __CLASS__);
        $table = '<table  class = "table table-responsive table-bordered table-hover table-center">
                <tr style="background:#dee1e6">
                    <th width="3%">#</th>
                    <th style="text-align:center;">Name</th>
                    <th style="text-align:center;">Type</th>
                    <th style="text-align:center;">Cost^One</th>
                    <th style="text-align:center;">Qty</th>
                    <th style="text-align:center;">Add</th>
                </tr>';
        if ($allStock != false) {
            if (is_object($allStock)) {
                $table .= '<tr style="width:10px;">
                            <td>1</td>
                            <td>' .$allStock->stock_name .'</td>
                            <td>' .$allStock->type .'</td>
                            <td>' .$allStock->cost_per_one .'</td>
                        <td style="width:50px;">
                            <form method="post" id="my_form" action="home.php?inv=add&id=' .$allStock->id.'">
                            <input style="width:50px;" type="number" name="qty" value="1">
                        </td>
                        <td style="width:50px;">
                            <input type="submit" form="my_form" class="btn btn-info" value="+" class="btnAddAction" /></form>
                        </td>
                           </tr>';
            }else {
                $i = 1;
                foreach ($allStock as $stock) {
                    $table .= '<tr>
                        <td>' . $i++ . '</td>
                        <td style="text-align:center">' .$stock->stock_name.'</td>
                        <td style="text-align:center">' .$stock->type .'</td>
                        <td style="width:50px;text-align:center">' .$stock->cost_per_one .'</td>
                        <td style="width:50px;">
                            <form method="post" id="my_form" action="home.php?inv=add&id=' .$stock->id.'">
                            <input style="width:50px;" type="number" name="qty" value="1">
                        </td>
                        <td style="width:50px;">
                            <input type="submit" form="my_form" class="btn btn-info" value="+" class="btnAddAction" /></form>
                        </td>
                    </tr>';
                }
            }
        } else {
            $table .= '<tr><td colspan="6">No Stock found</td></tr>';
        }
        $table .= '</table>';
            return $table;
    }
    public static function OutOfStock(){
        global $dbh;
        $sql = "SELECT COUNT(*) as num FROM stock Where quantity = 0 ";
        $results = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
        echo($results->num);
    }
    public static function reports($start,$end){
        $results = self::read("SELECT * FROM stock Where sales > 0 AND CAST(added_or_updated_date as DATE) BETWEEN '$start' AND '$end'", PDO::FETCH_CLASS, __CLASS__);

        $pdf = new FPDF('p','mm','A4'); 
        $pdf->AddPage();
        //set font to arial
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(20 ,8,'RANK',1,0);
        $pdf->Cell(50,8,'MEDICINE',1,0);
        $pdf->Cell(50 ,8,'SALES',1,0);
        $pdf->Cell(50 ,8,'PRICE',1,0);
        $pdf->Cell(50,8,'REMAIN',1,1);
        $i=1;
        $total = 0;
        $pdf->SetFont('Arial','',12);
         if (is_object($results)) {
            $totPerUnit = $results->cost_per_one*$results->sales;
            $pdf->Cell(20 ,8,$i++,1,0);
            $pdf->Cell(50,8,$results->stock_name,1,0);
            $pdf->Cell(50 ,8,$results->sales,1,0);
            $pdf->Cell(50 ,8,'$'.$totPerUnit,1,0);
            $pdf->Cell(50 ,8,$results->quantity,1,1);
            $total +=$totPerUnit;
         }
        else{
        foreach ($results as $inv) {
            $totPerUnit = $inv->cost_per_one*$inv->sales;
            $pdf->Cell(20 ,8,$i++,1,0);
            $pdf->Cell(50,8,$inv->stock_name,1,0);
            $pdf->Cell(50 ,8,$inv->sales,1,0);
            $pdf->Cell(50 ,8,'$'.$totPerUnit,1,0);
            $pdf->Cell(50 ,8,$inv->quantity,1,1);
            $total +=$totPerUnit;
         }
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(20,8,'TOTAL',1,0);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(200 ,8,'$'.$total,1,1);
        }  $pdf->Output();
    }
}
