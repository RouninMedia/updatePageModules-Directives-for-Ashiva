
function replaceModules($Asset, $replacementModules, $Module_List) {

  $Module_List = [];
  
  for ($i = 0; $i < count($replacementModules); $i++) {
      
    if ((isset($replacementModules[$i][$Asset]['apply'])) && ($replacementModules[$i][$Asset]['apply'] === FALSE)) continue;

    $Module_List[] = $replacementModules[$i];
  }
  
  return $Module_List;
}
