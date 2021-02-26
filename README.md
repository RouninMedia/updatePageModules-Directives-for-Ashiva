# `updatePageModules` Directives for Da3SH
**updatePageModules Directives** are a powerful tool enabling the inclusion / removal of any installed **Da3SH Module** to or from a page simply by editing the URL  `queryString`.

Consequently, **updatePageModules Directives** give anyone browsing a **Da3SH**-powered webpage the ability to add or remove module stylesheets and scripts to or from that page in a couple of keystrokes, without leaving the browser.

_____

## `updatePageModules` Directives vs Bookmarklets / FireMarks
So far as they can bolt additional functionality on to a webpage, **updatePageModules Directives** might be regarded as similar to **Bookmarklets** (aka **FireMarks**). The differences are principally that:

 - URLs which include **updatePageModules Directives** will usually be much shorter than **Bookmarklets**
 - **updatePageModules Directives** contain *references* to already-installed **Da3SH Modules** while **Bookmarklets** are actually self-contained entities
 - a URL including **updatePageModules Directives** may reference multiple **Da3SH Modules** while a **Bookmarklet** usually represents a single script

______

## How do `updatePageModules` Directives work?
In **Da3SH**, you can add or remove modules on a given page (or stylesheet, or scriptsheet) using the **queryString Parameter**:

  `updatePageModules`


The **queryString Parameter** `updatePageModules` has a percent-encoded **JSON** value, which, when decoded, looks like:

```
{
  "replaceModules": [],   // [OPTIONAL]

  "removeModules": [],    // [OPTIONAL]

  "addModules": [],       // [OPTIONAL]

  "customOrder": {"Styles": false, "Scripts": false}  // [OPTIONAL]	// <= either value, if omitted, defaults to false
}
```

Note that:

  - A value of true for either of the `customOrder` contexts (`Styles` / `Scripts`) means the modules in that context will NOT be parsed in alphabetical order

  - The first, second and third optional parameters (`replaceModules`, `removeModules`, `addModules`) all take the following format:
 
```
[
  {
  	"Publisher": "Scotia_Beauty",      // [REQUIRED]

  	"Module": "SB_Email_Subscribers",  // [REQUIRED]

  	"Styles": {"apply": true, "insert": "last"},  // [OPTIONAL]

  	"Scripts": {"apply": true, "insert": "last"}  // [OPTIONAL]
  }                                      						
]	
```

Note that:

 - If `apply` is omitted, default value is `true`
 - If `insert` is omitted, default value is `last`
 
 - Available values for `insert` are:
   - `first`
   - `last`
   - `{"before": "Module_Name"}`
   - `{"after": "Module_Name"}`
   
 - `Module_Name` can ONLY be a module currently present in the Module List, otherwise value will revert to `last`

______

## Example of `insert` instructions:

Original Module List:

 - My_Module
 - First_Module
 - Module_2

To insert: Module_W, Module_X, Module_Y, Module_Z, Module_A, Module_B, Module_C

Resulting Edited Module List:

 - My_Module
 - Module_Z		`"insert": {"after": "My_Module"}`
 - First_Module
 - Module_Y		`"insert": {"after": "First_Module"}`
 - Module_2
 - Module_B   `"insert": {"after": "Module_2"}`
 - Module_C		`"insert": {"after": "Module_2"}` 	<= N.B. Note that for this to work, Module_C MUST be listed BEFORE Module_B
 - Module_A		`"insert": {"after": "Module_2"}`
 - Module_X		`"insert": "Last"`				          <= N.B. Note that for this to work, Module_X MUST be listed BEFORE Module_W
 - Module_W		`"insert": "Last"`

Note that:

  - The value of `insert` for any context is ONLY observed if the `customOrder` for that context is true 

And:

  - If `addModules` is present and not empty, these modules are added to the list provided by the **PageManifest**.
  - If `removeModules` is present and not empty, these modules are removed from the list provided by the **PageManifest**.
  - If `replaceModules` is present and not empty, the other values are ignored. This list replaces the one provided by the **PageManifest**.


It goes without saying that, to be applied to the page, any module will still, necessarily, be required to exist in the `/.assets/modules/` folder.
It also goes without saying that, to be applied to the page, rendered components (ie. markup / vectors) need to be explicitly called in the markup.


______

## Where can updatePageModules Directives be added?

The **updatePageModules** queryString Parameter may be added to any of three URL paths:

 1. The Page: `example.com/my-page/?updatePageModules=%7B%7D`
 2. The Module StyleSheet: `example.com/modules/styles/styles.css?updatePageModules=%7B%7D`
 3. The Module ScriptSheet: `example.com/modules/scripts/scripts.css?updatePageModules=%7B%7D`

 To add to `/my-page/` simply add the **updatePageModules** queryString Parameter to the end of a link or to the end of the URL in the browser URL bar.
 The same **updatePageModules** queryString Parameter will then, automatically, be added to the calls to both the **Module StyleSheet** and the **Module ScriptSheet**.
 
 Alternatively, in **ServerSheet**-generated pages, the **updatePageModules** queryString Parameter may be hard-coded directly into **Module StyleSheet** & **Module ScriptSheet** calls.


## Examples of `updatePageModules` Values

**updatePageModules:** *{"replaceModules":[{"Publisher":"Scotia_Beauty","Module":"SB_Email_Subscribers"}]}*
`?updatePageModules=%7B%22replaceModules%22%3A%5B%7B%22Publisher%22%3A%22Scotia_Beauty%22%2C%22Module%22%3A%22SB_Email_Subscribers%22%7D%5D%7D`

**updatePageModules:** *{"addModules":[{"Publisher":"Scotia_Beauty","Module":"SB_Email_Subscribers"}]}*
`?updatePageModules=%7B%22addModules%22%3A%5B%7B%22Publisher%22%3A%22Scotia_Beauty%22%2C%22Module%22%3A%22SB_Email_Subscribers%22%7D%5D%7D`

**updatePageModules:** *{"removeModules":[{"Publisher":"Scotia_Beauty","Module":"SB_Translations"}]}*
`?updatePageModules=%7B%22removeModules%22%3A%5B%7B%22Publisher%22%3A%22Scotia_Beauty%22%2C%22Module%22%3A%22SB_Translations%22%7D%5D%7D`

**updatePageModules:** *{"removeModules":[{"Publisher":"Scotia_Beauty","Module":"SB_Notice::Brexit"}],"addModules":[{"Publisher":"Scotia_Beauty","Module":"SB_Email_Subscribers"}]}*
`?updatePageModules=%7B%22removeModules%22%3A%5B%7B%22Publisher%22%3A%22Scotia_Beauty%22%2C%22Module%22%3A%22SB_Notice%3A%3ABrexit%22%7D%5D%2C%22addModules%22%3A%5B%7B%22Publisher%22%3A%22Scotia_Beauty%22%%2C%22Module%22%3A%22SB_Email_Subscribers%227D%5D%7D`



## Code from Core:



## Code from Module Stylesheet / Module Scriptsheet




