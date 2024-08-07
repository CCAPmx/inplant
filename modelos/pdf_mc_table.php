<?php
date_default_timezone_set('America/Mexico_City');
require('../vistas/fpdf/fpdf.php');
//create new class extending fpdf class
class PDF_MC_Table extends FPDF {



  
var $widths;
var $aligns;
var $lineHeight;

function Header()
{
    $hoy = date("d/m/Y");
    // $this->Image('../vistas/recursos/img/avatars/lersan.png',10,5,120,16);
    $this->SetFont('Arial','',7);
    $this->Cell( 0, 11,'Fecha '. $hoy."  " . utf8_decode('Página ').$this->PageNo().' de {nb}', 0, 0, 'R' );
    // $this->Ln(1); 
    // $this->Cell(0,18,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
    //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
   
    // Arial bold 15
    //$this->SetFont('Arial','B',15);
    // Move to the right
   // $this->Cell(80);
    // Title
    //$this->Cell(30,10,'Title',1,0,'C');
    // Line break
    $this->Ln(10);
}



// $this->SetY(-10);

// $this->SetFont('Arial','I',8);
// $Num= intval($this->PageNo())+1;
// $Pag=intval('{nb}');
// if($Pag<Num){
//     $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
// }else{
//     // $this->Cell(0,10,$Pag,0,0,'C');
// }

//    }


//Set the array of column widths
function SetWidths($w){
    $this->widths=$w;
}

//Set the array of column alignments
function SetAligns($a){
    $this->aligns=$a;
}

//Set line height
function SetLineHeight($h){
    $this->lineHeight=$h;
}

//Calculate the height of the row
function Row($data,$color)
{
    // number of line
    $nb=0;

    // loop each data to find out greatest line number in a row.
    for($i=0;$i<count($data);$i++){
        // NbLines will calculate how many lines needed to display text wrapped in specified width.
        // then max function will compare the result with current $nb. Returning the greatest one. And reassign the $nb.
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    }
    
    //multiply number of line with line height. This will be the height of current row
    $h=$this->lineHeight * $nb;

    //Issue a page break first if needed
    $this->CheckPageBreak($h);

    //Draw the cells of current row
    for($i=0;$i<count($data);$i++)
    {
        // width of the current col
        $w=$this->widths[$i];
        // alignment of the current col. if unset, make it left.
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        
        //Print the text
        if ($color==0){
            $this->MultiCell($w,3,$data[$i],0,$a);
        }else{
            $this->SetTextColor(26,26,26);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(153,153,153); 
            $this->MultiCell($w,3,$data[$i],0,$a,True);
        }
        
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //calculate the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
?>
