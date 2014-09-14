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
                 //  echo $row->idtbl_ref_settings."<br/>";
                   $datapage = file_get_contents($row->source_url);
                   $this->import($datapage,$row->idtbl_ref_settings);
               }
		
		return View::make('refrefresh.refrefresh')
                        ->with('message','NOAA Data Updated Sucessfully');
	
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
                    $row = str_replace('    ', ' ', $row);
                    $row = str_replace('   ', ' ', $row);
                    $row = str_replace('  ', ' ', $row);
                    $columns = explode(' ', $row);
                    //var_dump($columns);
                    
                    $year=$columns[0];
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
                                    //
                                }
                                
                        }
                    }
                }
            }
        }    
        
	
	
}