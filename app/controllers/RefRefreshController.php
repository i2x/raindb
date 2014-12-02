<?php


class RefRefreshController extends BaseController
{
	
	public function getIndex()
	{
		return View::make('refrefresh.refrefresh');
				
	}
	
	
	public function postIndex()
	{
               $refSetsModel = new xTblRefSettings();   

               $allsettings = xTblRefSettings::all();

               //$refdata = new RefData();                  
               foreach ($allsettings as $row){
                 //Log::info($row->idtbl_ref_settings);
                   $datapage = file_get_contents($row->source_url);
                   $this->import($datapage,$row->idtbl_ref_settings);
               }
		
		return View::make('refrefresh.refrefresh')
                        ->with('message','NOAA Data Updated Sucessfully');
	
	}
        public function getData(){
            
 	$data = Riverbasin::join('tbl_ref_settings',
				'tbl_ref_settings.basin_id','=','riverbasin.basin_id')
				->join('tbl_ref_data',
						'tbl_ref_data.refid','=','tbl_ref_settings.idtbl_ref_settings')
				->select(				
				DB::raw(
				'riverbasin.basin_name,
				tbl_ref_settings.reftype,
				tbl_ref_settings.varname,		
				max(tbl_ref_data.meas_year) as b,
				min(tbl_ref_data.meas_year) as c'
                                    )
		)->groupBy('riverbasin.basin_name','tbl_ref_settings.reftype','tbl_ref_settings.varname')           

->orderBy('riverbasin.basin_name','tbl_ref_settings.reftype','tbl_ref_settings.varname');
//            $sql=
//                    "select basin_name,reftype,varname,max(meas_year),min(meas_year)
//from riverbasin
//inner join tbl_ref_settings on tbl_ref_settings.basin_id=riverbasin.basin_id
//inner join tbl_ref_data on tbl_ref_data.refid=tbl_ref_settings.idtbl_ref_settings
//group by basin_name,reftype,varname
//order by basin_name,reftype,varname";
    
            return  Datatables::of($data)->make();
        }
        
        public function getPosition($data,$find)
	{                
		return strpos($data, $find)+strlen($find);
	}
        
 
        
        public function import($page,$refid){
                $strpos = $this->getPosition($page,"<pre>");
                $endpos = $this->getPosition($page,"</pre>");               
                $data = substr($page, $strpos,$endpos-$strpos);
		
		$line_data= explode("\n",$data);
                
            foreach($line_data as $row){
               
                if(strlen($row) > 100 ){
                        $rawrow = $row;
                    $row = str_replace('    ', ' ', $row);
                    $row = str_replace('   ', ' ', $row);
                    $row = str_replace('  ', ' ', $row);
                    $columns = explode(' ', $row);
                    //var_dump($columns);
                    
                    $year=$columns[0];
                        $rr = new xTblRefDataRaw();
                                $rr->refid =$refid;
                                $rr->ye=$year;
                                $rr->rawtext = $rawrow;
                                try{
                                    $rr->save();
                                }
                                catch (\Exception $e){
                                    //Log::info($e->getMessage());
                                }                    

                    for($i=1;$i<13;$i++)
                    {
                        $value = $columns[$i];
                        if($value>-999.999){
                                $m = new xTblRefData();
                                $m->refid =$refid;
                                $m->meas_year=$year;
                                $m->meas_month=$i;
                                $m->meas_value=$value;
                                try{
                                    $m->save();
                                }
                                catch (\Exception $e){
                                    //Log::info($e->getMessage());
                                }
                                
                        }
                    }
                }
            }
        }    
        
	
	
}