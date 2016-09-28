<?php
class DataStructures extends BaseController{ 

	public function getStructure($path){
		$filelist = DataStruct::where('path','=',$path)->get();
    if (count($filelist) === 0){
      $content = View::make('files.error', array('path' => $path))->render();
    }else{
      $bread = $this->getFancyPath($filelist);
		  $content = View::make('files.list', array('bread' => $bread, 'filelist' => $filelist, 'path' => $path))->render();      
    }
    return View::make('files.filestable', array('content' => $content));
	}
  
  
    public function openFile($path) {
        $filelist = DataStruct::where('path','=',$path)->get();
        if (count($filelist) === 0){
        $content = View::make('files.error', array('path' => $path))->render();
        }else{
          $bread = $this->getFancyPath($filelist);
          $projFiles = array();
          for($i = 0 ; $i < (count($filelist)); $i++){
              $projObj = new stdClass;
              $projObj->name = $filelist[$i]->dispname;
              $projObj->content = file_get_contents($filelist[$i]->name);
              array_push($projFiles, $projObj);              
          }
          $content = View::make('files.code', array('projObj' => $projFiles, 'bread' => $bread, 'filelist' => $filelist, 'path' => $path))->render();
        }        
        return View::make('files.filestable', array('content' => $content));
  }
    
    
 public function getFancyPath($filelist) {
        $actpath = $filelist[0]->disppath;
        $dispPathList = explode("/",$actpath);
        $bread = array();
        for($i = 0 ; $i < (count($dispPathList)); $i++){
          $breadObj = new stdClass;
          $temp = "";
          $breadObj->name = $dispPathList[$i];
          for($z = 0; $z <= $i; $z++){
            $temp = $temp . "/" . $dispPathList[$z];
          }
        $tempDb = DataStruct::where('disppath','=',substr($temp,((count($temp)-2) * (-1))))->get();
        $breadObj->path = $tempDb[0]->path;
        array_push($bread, $breadObj);
        }
        return $bread;
    }
}