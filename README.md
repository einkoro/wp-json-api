# wp-json-api

Fork of dphiffer's JSON-API plugin for WordPress from: http://wordpress.org/plugins/json-api/

This fork adds the following to v1.1.1:


* Added terms controller to interface with ```get_terms()```
    * ```/api/terms/get_terms/?taxonomy=my_taxonomy&term_args[key]=value```
    * Optional support for taxonomy images with ```return_images=true``` if the plugin is installed: http://wordpress.org/plugins/taxonomy-images/
    * This also supports the optional arguments from the taxonomy images plugin: ```cache_images``` & ```having_images```

View readme.txt for the original full documentation. 
