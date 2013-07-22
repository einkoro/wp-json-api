# wp-json-api

Fork of dphiffer's JSON-API plugin for WordPress from: http://wordpress.org/plugins/json-api/

View readme.txt for the original full documentation. 

## Change notes

### Terms controller

Terms and taxonomies interface.

#### get_terms

Fetch all the terms for a taxonomy.

```
/api/terms/get_terms/?taxonomy=my_taxonomy&term_args[key]=value
```

See: http://codex.wordpress.org/Function_Reference/get_terms

Optional support for taxonomy images with ```return_images=true``` if the plugin is installed: http://wordpress.org/plugins/taxonomy-images/

This also supports the optional arguments from the taxonomy images plugin: ```cache_images``` & ```having_images```

#### get_term

Fetch the term by id.

```
/api/terms/get_term/?term_id=my_id&taxonomy=my_taxonomy
```

See: http://codex.wordpress.org/Function_Reference/get__term

#### get_the_terms

Fetch all the terms for a taxonomy attached to a post id.

```
/api/terms/get_the_terms/?post_id=my_id&taxonomy=my_taxonomy
``` 

See: http://codex.wordpress.org/Function_Reference/get_the_terms

