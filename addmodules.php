
function addModules($Asset, $modulesToAdd, $Module_List) {
  
  for ($i = 0; $i < count($modulesToAdd); $i++) {
      
    if ((isset($modulesToAdd[$i][$Asset]['apply'])) && ($modulesToAdd[$i][$Asset]['apply'] === FALSE)) continue;

    if (isset($modulesToAdd[$i][$Asset]['insert'])) {

      if (is_string($modulesToAdd[$i][$Asset]['insert'])) {

        switch ($modulesToAdd[$i][$Asset]['insert']) {

          case ('first') : array_unshift($Module_List, $modulesToAdd[$i]); break;

          case ('last') : array_push($Module_List, $modulesToAdd[$i]); break;
        }
      }

      elseif (is_array($modulesToAdd[$i][$Asset]['insert'])) {

        $insertPosition = count($Module_List);

        for ($j = 0; $j < count($Module_List); $j++) {

          if ($Module_List[$j]['Module'] === array_values($modulesToAdd[$i][$Asset]['insert'])[0]) {

            switch (array_keys($modulesToAdd[$i][$Asset]['insert'])[0]) {

              case ('before') : $insertPosition = $j; break;

              case ('after') : $insertPosition = ($j + 1); break;
            }

            break;
          }
        }

        array_splice($Module_List, $insertPosition, 0, [$modulesToAdd[$i]]);
      }
    }

    else {
    
      $Module_List[] = $modulesToAdd[$i];
    }
  }
  
  return $Module_List;
}
