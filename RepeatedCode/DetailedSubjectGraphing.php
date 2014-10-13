<?php
    //depending on which type of signal: triax or marker
    switch ($SigTypeArray[$j]) {
        case 1:
        case 2:
        case 3:
            //Plot triax signal with title depending on where case 1, 2 or 3
            //break up data values using space delimiters
            $dataArrayExplodedUnfixed = explode(" ", $DataArray[$j]);
            //convert string array elements into float
            for($i = 0; $i < sizeof($dataArrayExplodedUnfixed)-1; $i++) {
                $dataArrayExploded[$i] = floatval($dataArrayExplodedUnfixed[$i]);
            }

            //get PHP for graphing
            require_once("TeeChart/sources/libTeeChart.php");

            //Perform graphing with data
            //Set up chart
            $chart1 = new TChart(640,480);
            $chart1->getAspect()->setView3D(false);
            if ($SigTypeArray[$j] == 1) {
                $plotTitle = "Accelerometer signal in medio-lateral axis";
            } else if($SigTypeArray[$j] == 2) {
                $plotTitle = "Accelerometer signal in anterior-posterior axis";
            } else if ($SigTypeArray[$j] == 3) {
                $plotTitle = "Accelerometer signal in vertical axis";
            }
            $chart1->getHeader()->setText($plotTitle);
            $chart1->getLegend()->setVisible(FALSE);
            $varname = new Line($chart1->getChart());
            $varname2 = new Line($chart1->getChart());
            //generate X values to match y value. Signal obtained at 500Hz
            for ($i = 0; $i < sizeof($dataArrayExploded); $i++) {
                $timeArray[$i] = $i * 0.025;
            }
            //process Y values to obtain m/s/s
            for($i = 0; $i < sizeof($dataArrayExploded); $i++) {
                $dataArrayExploded[$i] = ($dataArrayExploded[$i]/4095)*3;
                $dataArrayExploded[$i] = $dataArrayExploded[$i] - 1.5;
            }
        
            //generate X and Y values for markers
            if(isset($markerTimes)) {
                $maxMarker = max($dataArrayExploded);
                $minMarker = min($dataArrayExploded);
                $markerXvalues = [];
                $markerYvalues = [];
                for($i = 0; $i < sizeof($markerTimes); $i++) {
                    array_push($markerXvalues, $markerTimes[$i], $markerTimes[$i], $markerTimes[$i]);
                    array_push($markerYvalues, $minMarker, $maxMarker, $minMarker);
                }
            }
            
            if(isset($markerTimes)) {
                //add markers to graph
                $i = 0;
                foreach($markerXvalues as $y){
                    $varname2->addXY($markerXvalues[$i],$markerYvalues[$i]);
                    $i++;
                }
            } 
        
            //add points to graph
            $i = 0;
            foreach($dataArrayExploded as $y){
                $varname->addXY($timeArray[$i],$dataArrayExploded[$i]);
                $i++;
            }
        
            
            //format graph
            $varname->Setcolor(Color::BLUE()); 
            if(isset($markerTimes)) {
                $varname2->Setcolor(Color::RED());
            }
            $chart1->getAxes()->getBottom()->getTitle()->setText("Time (seconds)"); 
            $chart1->getAxes()->getLeft()->getTitle()->setText("Acceleration G(m/s/s)"); 


            //extract date without slashes (/ not allowed in file names)
            $year = substr($DateArray[$j], -4);
            $month = substr($DateArray[$j], -7, 2);
            $firstSlashPos = strpos($DateArray[$j], "/");
            if($firstSlashPos == 1) {
                $day = substr($DateArray[$j], 0, 1);
            } else if ($firstSlashPos == 2) {
                $day = substr($DateArray[$j], 0, 2); 
            }
            //create graph and PNG image
            $renderName = "subjectID".$subjectID."SigTypeID".$SigTypeArray[$j]."date".$day."-".$month."-".$year.".png";
            $chart1->render($renderName);		
            echo "<img src=".$renderName." class=\"triaxImage\"/>";
            echo "<br>";

            break;
        default:
        
            break;
    }

?>