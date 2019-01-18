<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Custom Elasticsearch Client Configuration
     |--------------------------------------------------------------------------
     |
     | This array will be passed to the Elasticsearch client.
     | See configuration options here:
     |
     | http://www.elasticsearch.org/guide/en/elasticsearch/client/php-api/current/_configuration.html
     */
    
    'hosts'     => explode(',', env('ES_HOSTS', 'localhost:9200')),
    
    /**
     * the client will retry n times
     */
    'retries'   => env('ES_RETRIES' , 1),
    
    /*
     |--------------------------------------------------------------------------
     | Default Index Name
     |--------------------------------------------------------------------------
     |
     | This is the index name use for all models
     */
    
    'default_index' => env('ES_INDEX', ''),
];
