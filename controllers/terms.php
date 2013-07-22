<?php
/*
Controller name: Terms
Controller description: Interface to get_terms (with optional taxonomy images)
*/

class JSON_API_Terms_Controller {
    
    public function get_terms() {
        global $json_api;
        
        // See:
        // http://codex.wordpress.org/Function_Reference/get_terms
        // The only real difference here is we add rand as an option for orderby... not entirely random though.
        // We also check to make sure offset doesn't exceed total terms for the taxonomy.
        //
        // Asking for images to be returned requires the taxonomy images plugin:
        // http://wordpress.org/plugins/taxonomy-images/
        
        $taxonomy  = $json_api->query->taxonomy;    // The taxonomy to request
        $term_args = $json_api->query->term_args;   // The args for get_terms()
        
        // Taxonomy images
        $return_images = $json_api->query->return_images == 'true' ? true : false;
        $having_images = $json_api->query->having_images == 'true' ? true : false;
        $cache_images  = $json_api->query->cache_images  == 'true' ? true : false;
        
        // Make sure a taxonomy is supplied otherwise we can't fetch any terms
        if ( !$taxonomy ) {
            $json_api->error("taxonomy is required to retrieve the terms from.");
            return null;
        }
        
        // Do we need to return images? This will require the taxonomy images plugin!        
        if ( $return_images == true ) {
            // Pull in wp-admin's plugin.php include to use is_plugin_active()
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            
            // Check if the taxonomy-images plugin is installed and active
            if ( !is_plugin_active('taxonomy-images/taxonomy-images.php') ) {
                $json_api->error("return_images requires the taxonomy images plugin available from: http://wordpress.org/plugins/taxonomy-images/");
                return null;
            }
            
        }
        
        // We shouldn't let offset exceed the total terms
        $term_count = wp_count_terms($taxonomy);
        $term_max_offset;
        if ( array_key_exists('number', $term_args) ) {
            $term_max_offset = $term_count - $term_args['number'];
        }
        else {
            $term_max_offset = $term_count - 1;
        }
        
        if ( array_key_exists('offset', $term_args) && $term_args['offset'] > $term_max_offset ) {
            $json_api->error("term_args[offset] cannot exceed the total number of terms for the taxonomy.");
            return null;
        }

        // If we want random terms we need to pick a random offset... order by id seems as good as anything for our needs.
        if ( array_key_exists('orderby', $term_args) && $term_args['orderby'] == 'rand' ) {
            $term_args['orderby'] = 'id';
            $term_args['offset']  = rand(0, $term_max_offset);
        }
        
        // Fetch the terms, either with get_terms, or with the filter from the taxonomy images plugin.
        $terms;
        if ( $return_images == true ) {
            
            $terms = apply_filters( 
                'taxonomy-images-get-terms', 
                '', 
                array( 
                    'taxonomy'      => $taxonomy, 
                    'having_images' => $having_images, 
                    'cache_images'  => $cache_images,
                    'term_args'     => $term_args
                ) 
            );
            
        }
        else {
            $terms = get_terms($taxonomy, $term_args);            
        }
        
        if ($terms) {
            return array(
                'count' => count($terms),
                'terms' => $terms
            );
        }
        else {
            $json_api->error("No terms matching your request were found.");
            return null;
        }
    }
    
    public function get_term() {
        global $json_api;
        
        // See:
        // http://codex.wordpress.org/Function_Reference/get_term
        // TODO: Should probably add support for taxonomy images
        
        $term_id  = $json_api->query->term_id;    // The term's id
        $taxonomy = $json_api->query->taxonomy;   // The taxonomy
        
        // term_id and taxonomy are required
        if ( !$term_id || !$taxonomy ) {
            $json_api->error("The term_id and taxonomy are required to retrieve the term details.");
            return null;
        }
        
        $term = get_term($term_id, $taxonomy);
        
        if ($term) {
            return array('term' => $term);
        }
        else {
            $json_api->error("No term matching your request was found.");
            return null;
        }  
    }
    
    public function get_the_terms() {
        global $json_api;
        
        // See:
        // http://codex.wordpress.org/Function_Reference/get_the_terms
        // TODO: Should probably add support for taxonomy images
        
        $post_id  = $json_api->query->post_id;    // The post's id to retrieve the attached terms from
        $taxonomy = $json_api->query->taxonomy;   // The taxonomy
        
        // term_id and taxonomy are required
        if ( !$post_id || !$taxonomy ) {
            $json_api->error("The post_id and taxonomy are required to retrieve the term details.");
            return null;
        }
        
        $terms = get_the_terms($post_id, $taxonomy);
        
        if ($terms) {
            return array(
                'count' => count($terms),
                'terms' => $terms
            );
        }
        else {
            $json_api->error("No terms matching the post was found.");
            return null;
        }  
    }
}

?>