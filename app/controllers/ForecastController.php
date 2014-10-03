<?php

class ForecastController extends BaseController 
{


	/**
	 * Returns all the blog graph.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		return View::make('forecast.index');
	}
	
	
	public function postIndex()
	{
            
        	if (Input::get('basin') == 7) {
        		$forcast = new ForecastPing();
                        $output = $forcast->forecast(Input::all());
        	} else if (Input::get('basin') == 9) {
        		$forcast = new ForecastChi();
                        $output = $forcast->forecast(Input::all());
        	} else if (Input::get('basin') == 10) {
        		$forcast = new ForecastMun();
                        $output = $forcast->forecast(Input::all());
        	} else if (Input::get('basin') == 8) {
        		$forcast = new ForecastNan();
                        $output = $forcast->forecast(Input::all());
        	} else {
        		$forcast = new ForecastTapi();
                        $output = $forcast->forecast(Input::all());
        	}

  $nseason = array(
    			'1'=>'JFM',
    			'2'=>'FMA',
    			'3'=>'MAM',
    			'4'=>'AMJ',
    			'5'=>'MJJ',
    			'6'=>'JJA',
    			'7'=>'JAS',
    			'8'=>'ASO',
    			'9'=>'SON',
    			'10'=>'OND',
    			'11'=>'NDJ',
    			'12'=>'DJF'
    	);                

 $iseason = array_flip($nseason);
 
 if(Input::get('basemonth') >= $iseason[Input::get('season')]){
     $targetyear = Input::get('baseyear')+1;
 }else {
     $targetyear = Input::get('baseyear');
 }
 
 if(isset($output['rawdata'])){
            
	return View::make('forecast.index')
                ->with('rawdata',$output['rawdata'])
                ->with('spi',$output['spi'])
                ->with('rainyear',$forcast->getlatestyear(Input::get('basin')))
                ->with('targetyear',$targetyear)
                ->with('boxplotdata',$output['boxplotdata'])
                ->with('p33',$output['p33'])
                ->with('p20',$output['p20'])
                ->with('dataISP',$output['dataISP'])
	->with('oldInput', Input::all());
 }
 else{
     return View::make('forecast.index')->with('errormessage',$output['errormessage']);
 }
	}


	
	




}








?>