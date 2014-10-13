<?php
    function plotDataTrendGraph($Xvalues, $Yvalues) {
        //get PHP for graphing
        require_once("TeeChart/sources/libTeeChart.php");

        //Perform graphing with data
        //Set up chart
        $chart1 = new TChart(640,480);
        $chart1->getAspect()->setView3D(false);
        $chart1->getHeader()->setText("Data Trend Graph");
        $chart1->getLegend()->setVisible(FALSE);
        $varname = new Line($chart1->getChart());

        //add points to graph
		$i = 0;
        foreach($Xvalues as $y){
            $varname->addXY($Xvalues[$i],$Yvalues[$i]);
            $i++;
        }
        
        //format graph
		$varname->Setcolor(Color::BLUE()); 
		$chart1->getAxes()->getBottom()->getTitle()->setText("Age (years)"); 
		$chart1->getAxes()->getLeft()->getTitle()->setText("True Falls Risk"); 
		//create graph and PNG image
		$chart1->render("dataTrendGraph.png");   
    }

?>