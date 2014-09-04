<?php

class ScheduleController extends BaseController {

    public function getIndex() {


        $file = scandir('C:\\wamp\\www' . DIRECTORY_SEPARATOR . 'schedule');
        $temp = array();
        if (isset($file[2])) {
            for ($i = 2; $i < sizeof($file); $i++) {
                array_push($temp, array('id' => $i - 1, 'file_name' => $file[$i]));
                
            }
            
        }





            return View::make('schedule.schedule')->with('files', $temp);
        }


        

        function postIndex() {
            //TODO
            //
		
		return View::make('schedule.schedule');
        }

    }