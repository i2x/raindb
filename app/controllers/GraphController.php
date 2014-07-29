<?php

class GraphController extends BaseController 
{

	
	



	/**
	 * Returns all the blog graph.
	 *
	 * @return View
	 */
	public function getIndex()
	{
	
	    
		return View::make('graph.graph');
	}


	
	public function ampher(){
		

		/*$ampher = Ampher::where('province_id',Input::get('id'))->select('ampher_id','name')->get();
		$dropdown = '<option value=""></option>';
		foreach($ampher as $value):
		$dropdown .= '<option value="'.$value->ampher_id.'">'.$value->name.'</option>';
		endforeach;
		return Response::make($dropdown);*/
	}
	
	
	




}








?>