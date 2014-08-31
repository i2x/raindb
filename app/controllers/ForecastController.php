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
        	} else if ($model->select_basin == 9) {
        		$this->actionRainForecastChi($model);
        	} else if ($model->select_basin == 10) {
        
        		$this->actionRainForecastMun($model);
        	} else {
        		$this->render('rainforecast', array('model' => $model));
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


	
	




}








?>