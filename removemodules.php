
function removeModules($Asset, $modulesToRemove, $Module_List) {
  
  for ($i = 0; $i < count($modulesToRemove); $i++) {
      
    $Module_Name = $modulesToRemove[$i]['Module'];
    $Module_Publisher = $modulesToRemove[$i]['Publisher'];
    if ((isset($modulesToRemove[$i][$Asset]['apply'])) && ($modulesToRemove[$i][$Asset]['apply'] === FALSE)) continue;
    
    for ($j = (count($Module_List) - 1); ($j + 1) > 0; $j--) {
        
      if ($Module_List[$j]['Module'] !== $Module_Name) continue;
      if ($Module_List[$j]['Publisher'] !== $Module_Publisher) continue;
      
      unset($Module_List[$j]);
    }
    
    $Module_List = array_values($Module_List);
  }
  
  return $Module_List;
}

