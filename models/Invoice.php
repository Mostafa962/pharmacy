<?php
class Invoice extends Database
{
	
	public $id;
    public $client;
    public $phone;
    public $stock_name;
    public $price;
    public $qty;
    public $total_price = 0;
    public $tableName = 'invoice';
    //names of table fields
    public $dbfields = array(
            'client',
            'phone',
            'stock_name',
            'price',
            'qty',
            'total_price',
        );
    public function show_invoice(){
       $total_quantity = 0;
        $output = ' <div  class="container container-table " style="width: 60%">
            <table class = \'table table-responsive table-bordered table-hover\' style=\'text-align:center;\'>
            <tr> #INVOICE :1<br></tr>
             <tr>
                <img src="images/logo.png" width="100px"><br>
             </tr>
             <tr>Pharmacy Name<br></tr>
             <tr>455 Foggy Heights,<br /> AZ 85004, US<br></tr>
             <tr>(602) 519-0450<br></tr>
                <tr><a href="mailto:company@example.com">company@example.com<br></a></tr>
                
                <tr>CLIENT :
                    <form method="post" action="'.$_SERVER['PHP_SELF'].'?print=pdf" class="form-group"> <input class="form-control" required="" type="text" name="client"><br></tr>
                <tr>Mobile Number : <input class="form-control" required="" type="number" name="phone"><br></tr>
           
                <tr>DATE :'.  date('Y-m-d').'<br></tr>
              </table>
              <table border="1" id="invoice" class = \'table table-responsive table-bordered table-hover\' style=\'text-align:center;\'>
                <thead>
                  <tr>
                    <th style="text-align:center;">MEDICINE</th>
                    <th style="text-align:center;">PRICE</th>
                    <th style="text-align:center;">QUANTITY</th>
                    <th style="text-align:center;">TOTAL</th>
                    <th style="text-align:center;">Remove</th>
                  </tr>
                </thead>
                <tbody>';
                if(isset($_SESSION["invoice_item"])){
                    foreach ($_SESSION["invoice_item"] as $item){
                        $item_price = $item["qty"]*$item["cost_per_one"];
                        $id = $item['id'];
                       $output.= '<tr>
                        <td style="text-align:center;">'.$item["stock_name"].'</td>
                        <td  style="text-align:center;">'. "$ ".$item["cost_per_one"].'</td>
                        <td style="text-align:center;">'.  $item["qty"] .'</td>
                        <td  style="text-align:center;">'.  "$ ". number_format($item_price,2) .'</td>
                        <td style="text-align:center;"><a href="'.$_SERVER['PHP_SELF'].'?inv=remove&id='.$id.'" class="btnRemoveAction"><i class="fa fa-trash color-red"></i></a></td>
                        </tr>
                     ';
                     $total_quantity += $item["qty"];
                     $this->total_price += ($item["cost_per_one"]*$item["qty"]);
                    }
                }else {
                     $output.= '<tr><td colspan="5">No invoce items found</td></tr>';
                 }
                   $output.= '<tr><td><strong>Total</strong></td><td colspan="4">'.'$'. $this->total_price.'</td></tr>
                </tbody>
                </table> <br><hr>
                        <input style="margin-right: 70%" type="submit" name="invoice" class="btn btn-primary" value="Print">  </form>
                            <a href="'.$_SERVER['PHP_SELF'].'?inv=empty"><button type="button"  class="btn btn-primary" >New Invoice</button></a>
                      </div>';
        echo $output;
    }
    public function invoice_pdf($name,$phone){
        $pdf = new FPDF('p','mm','A4'); 
        $pdf->AddPage();
        //set font to arial
        $pdf->SetFont('Arial','B',12);
        //Cell(width,height,text,border,end line,[align])
        $pdf->Image('images/logo.png',10,10,45,10,'PNG');
        $pdf->Cell(130 ,8,'',0,1);
        $pdf->Cell(130 ,10,'#Invoice 1',0,1);
        $pdf->Cell(130 ,8,'Pharmacy Name',0,1);
        $pdf->Cell(130 ,8,'455 Foggy Heights,',0,1);
        $pdf->Cell(130 ,8,'AZ 85004, US',0,1);
        $pdf->Cell(130 ,8,'(602) 519-0450',0,1);
        $pdf->Cell(130 ,8,'company@example.com',0,1);
        $pdf->Cell(59  ,8,'Date :',0,0);
        $pdf->Cell(130 ,8,date('Y-m-d'),0,1);
        $pdf->Cell(130 ,8,'Bill To ',0,1);
        //set font to arial ,regular 12
        $pdf->Cell(59 ,8,'Client :',0,0);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(130  ,8,$name,0,1);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(59 ,8,'Phone :',0,0);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(130  ,8,$phone,0,1);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(45 ,8,'MEDICINE',1,0);
        $pdf->Cell(45,8,'PRICE',1,0);
        $pdf->Cell(45 ,8,'QUANTITY',1,0);
        $pdf->Cell(45,8,'TOTAL',1,1);
        $pdf->SetFont('Arial','',12);
        if (isset($_SESSION['invoice_item'])) {
            foreach ($_SESSION["invoice_item"] as $item) {
                $item_price = $item["qty"]*$item["cost_per_one"];
                $pdf->Cell(45 ,8,$item["stock_name"],1,0);
                $pdf->Cell(45 ,8,'$'.$item["cost_per_one"],1,0);
                $pdf->Cell(45,8,$item["qty"],1,0);
                $pdf->Cell(45 ,8,number_format($item_price,2),1,1);
            }
        }
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(45,8,'TOTAL',1,0);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(135,8,'$'.$this->total_price,1,1);
        $pdf->Output();
    }
    public static function NumOfInvoice(){
        global $dbh;
        $sql = "SELECT COUNT(*) as num FROM invoice ";
        $results = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
        echo($results->num);
    }


}
