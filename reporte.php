
<?php

	include 'plantilla.php';
    require 'conexion.php';

    /* Consultamos la tabla */
    $resultado = $conexion->prepare("SELECT * FROM comisiones");
    $resultado->execute();

    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    /* Declaracion de Basico Y Movilidad */
    $basico = 850.00;
    $basicodec = number_format($basico, 2, '.', ' ');
    $movilidad = 400.00;
    $movilidaddec = number_format($movilidad, 2, '.', ' ');
    /* Declaracion de Comisiones y convertido a decimales */
    $comvent = 0.50;
    $comventdec = number_format($comvent, 2, '.', ' ');
    $commoro = 0.30;
    $commorodec = number_format($commoro, 2, '.', ' ');
    $comcobe = 0.20;
    $comcobedec = number_format($comcobe, 2, '.', ' ');
    /* Declaracion de Parametros y convertido a decimales */
    $parvent = 85.00;
    $parventdec = number_format($parvent, 2, '.', ' ');
    $parmoro = 5.00;
    $parmorodec = number_format($parmoro, 2, '.', ' ');
    $parcobe = 85.00;
    $parcobedec = number_format($parcobe, 2, '.', ' ');

    /*  Calculando Alcanzados */
    $vta=$data[2]["n_neta"]*100/$data[2]["cuota"];
    $vtadec=number_format((float)$vta, 2, '.', ' ');

    $mor=$data[2]["morosidad"];
    $mordec=number_format((float)$mor, 2, '.', ' ');

    $cob=$data[2]["cobertura"]*100/$data[2]["t_clientes"];
    $cobdec=number_format((float)$cob, 2, '.', ' ');
    /* convertir numero en decimal
    $coberentero = ;*/
    $totalcobertura = number_format((float)$data[2]["t_clientes"], 2, '.', ' ' );
    $conbertura = number_format((float)$data[2]["cobertura"], 2, '.', ' ' );
    $cob= $conbertura*100/$totalcobertura;
    $cobdec=number_format((float)$cob, 2, '.', ' ');
    /* Calculando Total */
    if($vtadec >= $parvent){
        $totalcomvent = $data[2]["n_neta"]*$comvent/100;
        $totalcomventdec = number_format($totalcomvent, 2, '.', ' ');
    }
    else{
        $totalcomventdec = 0;
    }
    if($mordec <= $parmoro)
    {
        $totalcommoro = $data[2]["n_neta"]*$commoro/100;
        $totalcommorodec = number_format($totalcommoro, 2, '.', ' ');
    }
    else
    {
        $totalcommorodec = 0;
    }
    if($cobdec >= $parcobe)
    {
        $totalcomcobe = $data[2]["n_neta"]*$comcobe/100;
        $totalcomcobedec = number_format($totalcomcobe, 2, '.', ' ');
    }
    else
    {
        $totalcomcobedec = 0;
    }   

    $sueldo = $basicodec + $movilidaddec + $totalcomventdec + $totalcommorodec + $totalcomcobedec;

    $var = 30;

    $pdf = new PDF('P','mm','A4');
    $title = 'Comisiones M&M';
    $pdf->SetTitle($title);
    $pdf->SetAuthor('Frank Ynga Yanarico');
    $pdf->SetMargins(30, 25 , 30);

    /* Imprime funcion(indicamos el orden)  ChapterTitle y ChapterBody */
    $pdf->PrintChapter($data[2]["zona"], $data[2]["vendedor"],'prueba2.txt');
    $pdf->PrintChapter($data[3]["zona"], $data[3]["vendedor"],'prueba2.txt');
    $pdf->PrintChapter($data[4]["zona"], $data[4]["vendedor"],'prueba1.txt');
    $pdf->PrintChapter($data[5]["zona"], $data[5]["vendedor"],'prueba2.txt');
    
    
    $pdf->SetTextColor(0,0,0); //color texto de la barra NEGRO
    $pdf->SetXY(30,140);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(50,10,"TOTAL DE SUELDO",'L,T,B',0,'C',0);
    $pdf->Cell(100,10,$sueldo,'R,T,B',0,'R',0);
    
    $pdf->SetFont('Arial','',8);
    //Tabla Sueldo Basico
    $cabe = array('','TOTALES');
    $info = array($basicodec, $movilidaddec);
    $TituInf = array("BASICO","MOVILIDAD");
    $infovac = [];
    for ($index = 0; $index < 2; $index++) {
        array_push($infovac, array($TituInf[$index], $info[$index]));
    }
    $pdf->SueldoBasico($cabe, $infovac, 30, 65);
    //Tabla Comisiones, Parametros, Alcanzados
    
    $cabe = array('% COMISIONES', 'PARAMETROS', '% ALCANZADO');
    $ComiArray = array($comventdec,$commorodec,$comcobedec);
    $ParaArray = array($parventdec,$parmorodec,$parcobedec);
    $AlcaArray = array($vtadec,$mordec,$cobdec);
    $infovac = [];
    for ($index = 0; $index < 3; $index++) {
        array_push($infovac, array($ComiArray[$index],$ParaArray[$index],$ParaArray[$index]));
    }
    $pdf->ComiParaAlca($cabe, $infovac, 100, 86);
    //Com. Venta, Com. Morosidad, Com. Cobertura
    $cabe = array('', '');
    $TituSub = array("COM. VENTA", "COM. MOROSIDAD", "COM. COBERTURA");
    $Infosub = array("1219.53","15","18");
    $infovac = [];
    for ($index = 0; $index < 3; $index++) {
        array_push($infovac, array($TituSub[$index],$Infosub[$index]));
    }
    $pdf->VentMoroCobe($cabe, $infovac, 30, 86);
    //Observacion y Datos
    $cabe = array('OBSERVACION', '');
    $TituObse = array("CUOTA VENTA","VENTA REALIZADA","TOTAL POR COBRAR","TOTAL MOROSIDAD","TOTAL COBRANZA","TOTAL CLIENTES","CLIENTES COBERTURADOS");
    $InfoObse = array("1","2","3","4","5","6","7");
    $infovac = [];
    for ($index = 0; $index < 7; $index++) {
        array_push($infovac, array($TituObse[$index],$InfoObse[$index]));
    }
    $pdf->ObseDato($cabe, $infovac, 30, 155);
    //Calculando VENTA, MOROSIDAD Y COBERTURA
    $cabe = array('', '');
    $TituCal = array("% VTA","% MOR","% COB");
    $InfoCal = array("1","2","3");
    $infovac = [];
    for ($index = 0; $index < 3; $index++) {
        array_push($infovac, array($TituCal[$index],$InfoCal[$index]));
    }
    $pdf->CalcAlca($cabe, $infovac, 120, 165);
    $pdf->Ln(8);
	$pdf->AliasNbPages();
    $pdf->Output();
?>
