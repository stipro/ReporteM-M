<?php
	
	require 'fpdf/fpdf.php';
	
	class PDF extends FPDF
	{
		/* Cabezera de Hoja */
		function Header()
		{
			$this->SetFont('Arial','B',10);
			$this->Cell(120,10, 'M&M PRODUCTOS MEDICOS Y FARMACEUTICOS E.I.R.L.',0,0,'I');
			$this->Ln(5);
			$this->Cell(50,10,"AV PARRA 365 PJE BISHOP #5",0,0,'L',0);
			$this->Ln(5);
			$this->Cell(50,10,"RUC : 20370715107",0,0,'L',0);
			$this->Ln(8);           
		}
		/* TItulo de la Hoja */
		function ChapterTitle($num, $label)
		{
			// Arial 12
			$this->SetFont('Arial','',8);
			// Color de fondo
			$this->SetFillColor(200,220,255);
			// Título
			$this->Ln(2);
			$this->Cell(50,10,"COMISIONES DE VENTAS ",0,0,'L',0);
			// Salto de línea
			$this->Ln(8);
			$this->Cell(25,10,"NOMBRE",0,0,'L',0);
			$this->Cell(100,10, $label,0,0,'C',0);
			$this->Cell(25,10,"Zona $num",0,1,'R',0);
			$this->Ln(4);
			
		}
		//Sueldo Principal
		function SueldoBasico($cabe, $infovac, $x = 0, $y = 0)
		{
			//Posicion
			$this->SetXY($x , $y);
			//Desplegamos cabezera de la tabla guardado en un array
			foreach($cabe as $colu)
			{
				//Imprimos celda por celdam con los siguientes parametros
				$this->Cell(75 ,7,$colu,1,0,'R',0);
			}			
			//Hacmoes un salto de linea	
			$this->Ln();
			$i = 7;
			//Posicionamos cuerpo tabla
			$this->SetXY($x , $y + $i);

			foreach($infovac as $row)
			{
				foreach($row as $col)
				{
					if ($col<1)
					{
						$this->Cell(75 ,7,$col,1,0,'L',0);
					}
					if($col>0)
					{
						$this->Cell(75 ,7,$col,1,0,'R',0);
					}
				}
				
				$i= $i + 7 ;  // incremento el valor de la columna
				$this->SetXY($x , $y + $i);		
			}
		}
		
		function ComiParaAlca($cabe, $infovac, $x = 0, $y = 0)
		{
			$this->SetFillColor(232,232,232);
			$this->SetFont('Arial','',5);
			//Posicion
			$this->SetXY($x , $y);
			//Desplegamos cabezera de la tabla guardado en un array
			foreach($cabe as $colu)
			{
				//Imprimos celda por celdam con los siguientes parametros
				$this->Cell(22 ,9,$colu,1,0,'C',1);
			}			
			//Hacmoes un salto de linea	
			$this->Ln();
			$i = 9;
			$this->SetFont('Arial','',8);
			//Posicionamos cuerpo tabla
			$this->SetXY($x , $y + $i);
			foreach($infovac as $row)
			{
				foreach($row as $col)
				{

					$this->Cell(22 ,9,$col,1,0,'C',0);
					
				}
				$i= $i + 9 ;  // incremento el valor de la columna
				$this->SetXY($x , $y + $i);		
			}
		}
		//Com. Venta, Com. Morosidad, Com. Cobertura
		function VentMoroCobe($cabe, $infovac, $x = 0, $y = 0)
		{
			//Posicion
			$this->SetXY($x , $y);
			//Desplegamos cabezera de la tabla guardado en un array
			foreach($cabe as $colu)
			{
				//Imprimos celda por celdam con los siguientes parametros
				$this->Cell(75 ,9,$colu,1,0,'R',0);
			}
			//Hacmoes un salto de linea	
			$this->Ln();
			$i = 9;
			$this->SetFont('Arial','',8);
			//Posicionamos cuerpo tabla
			$this->SetXY($x , $y + $i);
			$prim = 0;
			$segu = 0;
			for($segu = 0; $segu < 3; $segu++)
			{				
				for($prim = 0; $prim < 1; $prim++)
				{
					$this->Cell(75,9,$infovac[$segu][$prim] ,1,0,'L',0);
				}
				$this->Cell(75,9,$infovac[$segu][$prim] ,1,1,'R',0);
			}
		}

		function ObseDato($cabe, $infovac, $x = 0, $y = 0)
		{
			//Posicion
			$this->SetXY($x , $y);
			foreach($cabe as $colu)
			{
				//Imprimos celda por celdam con los siguientes parametros
				$this->Cell(30 ,9,$colu,1,0,'L',1);
			}
			//Hacmoes un salto de linea	
			$this->Ln();
			$i = 15;
			$this->SetFont('Arial','',8);
			//Posicionamos cuerpo tabla
			$this->SetXY(40 , $y + $i);
			$prim = 0;
			$segu = 0;
			for($segu = 0; $segu < 7; $segu++)
			{				
				for($prim = 0; $prim < 1; $prim++)
				{
					$this->Cell(42,9,$infovac[$segu][$prim] ,1,0,'L',0);
				}
				$x=40;
				
				$this->Cell(25,9,$infovac[$segu][$prim] ,1,1,'R',0);
				$i= $i + 9 ;  // incremento el valor de la columna
				
				$this->SetXY($x , $y + $i);
			}
		}
		// Calculo de Alcanzado
		function CalcAlca($cabe, $infovac, $x = 0, $y = 0)
		{
			$this->SetXY($x , $y);
			foreach($cabe as $colu)
			{
				//Imprimos celda por celdam con los siguientes parametros
				$this->Cell(30 ,9,$colu,1,0,'L',1);
			}
			//Hacmoes un salto de linea	
			$this->Ln();
			$i = 15;
			$this->SetXY(120 , $y + $i);
			$prim = 0;
			$segu = 0;
			for($segu = 0; $segu < 3; $segu++)
			{				
				for($prim = 0; $prim < 1; $prim++)
				{
					$this->Cell(30,9,$infovac[$segu][$prim] ,1,0,'L',0);
					
				}
				$x=120;

				$this->Cell(25,9,$infovac[$segu][$prim] ,1,1,'R',0);
				$i= $i + 9 ;  // incremento el valor de la columna
				
				$this->SetXY($x , $y + $i);
			}
		}

		/* Pie de Hoja */
		function Footer()
		{
			/* Separacion desde la parte Inferior */
			$this->SetY(-15);
			/* Damos tipo de letre, estilo, tamaño*/ 
			$this->SetFont('Arial','I', 8);
			$this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C' );
		}
		function PrintChapter($num, $title/*$file*/)
		{
			$this->AddPage();
			$this->ChapterTitle($num,$title);
			//$this->ChapterBody($file);
		}
	}
  ?>
