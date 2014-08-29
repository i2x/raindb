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

  
            
	return View::make('forecast.index')
                ->with('rawdata',$output['rawdata'])
                ->with('spi',$output['spi'])
                ->with('rainyear',$forcast->getlatestyear(Input::get('basin')))
	->with('oldInput', Input::all());
	}


	
	




}








?>