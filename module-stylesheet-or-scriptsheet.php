
$Module_List = $PageManifest['Ashiva_Page_Build']['Modules'];

// echo '/*'."\n\n".'PAGE MODULE LIST:'."\n\n".json_encode($Module_List, JSON_PRETTY_PRINT)."\n\n";

if (isset($_GET['updatePageModules'])) {
  
  parse_str(parse_url($_SERVER['REQUEST_URI'])['query'], $Query_String_Array);
  $updatePageModules = $Query_String_Array['updatePageModules'];
  $updatePageModulesArray = json_decode($updatePageModules, TRUE);


  $Update_Page_Modules_Directives = ['replaceModules', 'addModules', 'removeModules'];

  for ($i = 0; $i < count($Update_Page_Modules_Directives); $i++) {

    $Directive = $Update_Page_Modules_Directives[$i];
    $Directive_Data = $updatePageModulesArray[$Directive];

    if (isset($Directive_Data)) {

      $Module_List = $Directive('Scripts', $Directive_Data, $Module_List);

      if ($Directive === 'replaceModules') break;
    }
  }

  if ((isset($updatePageModulesArray['customOrder']['Scripts'])) && ($updatePageModulesArray['customOrder']['Scripts'] === TRUE)) {

    $Module_List = array_values($Module_List);
  }

  else {

    foreach ($Module_List as $Index => $Module_Data) {
    
      $Publisher_Order[$Index]  = $Module_Data['Publisher'];
      $Module_Order[$Index] = $Module_Data['Module'];
    }

    array_multisort($Publisher_Order, SORT_ASC, $Module_Order, SORT_ASC, $Module_List);
  }
}

// echo 'FINAL MODULE LIST:'."\n\n".json_encode($Module_List, JSON_PRETTY_PRINT)."\n\n".'*/'."\n\n";


${$Page.'::Modules'} = getModules($Module_List);
