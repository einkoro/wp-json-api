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

Optional support for taxonomy images with ```return_images=true``` which requires ```image_size=my_image_size``` if the plugin is installed/activated: http://wordpress.org/plugins/taxonomy-images/

This also supports the optional boolean arguments from the taxonomy images plugin: ```cache_images``` & ```having_images```

```
{
    "status": "ok",
    "count": int,
    "terms": [
        {
            "term_id": int,
            "name": string,
            "slug": string,
            "term_group": int,
            "term_taxonomy_id": int,
            "taxonomy": string,
            "description": string,
            "parent": int,
            "count": int,
            "image_id": int,
            "image_url": string,
            "image_width": int,
            "image_height": int,
            "image_resized": bool
        },
        {
            ...
        }
    ]
}
```

#### get_term

Fetch the term by id.

```
/api/terms/get_term/?term_id=my_id&taxonomy=my_taxonomy
```

See: http://codex.wordpress.org/Function_Reference/get_term

```
{
    "status": "ok",
    "term": {
        "term_id": int,
        "name": string,
        "slug": string",
        "term_group": int,
        "term_taxonomy_id": int,
        "taxonomy": string,
        "description": string,
        "parent": int,
        "count": int,
    }
}
```

#### get_the_terms

Fetch all the terms for a taxonomy attached to a post id.

```
/api/terms/get_the_terms/?post_id=my_id&taxonomy=my_taxonomy
``` 

See: http://codex.wordpress.org/Function_Reference/get_the_terms

```
{
    "status": "ok",
    "count": int,
    "terms": {
        "int term_id": {
            {
                "term_id": int,
                "name": string,
                "slug": string,
                "term_group": int,
                "term_taxonomy_id": int,
                "taxonomy": string,
                "description": string,
                "parent": int,
                "count": int,
                "object_id": int
            }
        },
        ...
    ]
}
```

## Todo

* Add taxonomy images support to ```get_term``` and ```get_the_terms```
* Do something about inconsistent array of term objects between ```get_terms```'s array of objects by index vs ```get_the_term```'s array of objects with term_id as keys?


