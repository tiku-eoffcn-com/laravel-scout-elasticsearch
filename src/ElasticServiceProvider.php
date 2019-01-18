<?php
namespace Team2\Search;

use Illuminate\Support\ServiceProvider;
use Elasticsearch\ClientBuilder;
use Team2\Search\Engines\ElasticEngine;
use Illuminate\Support\Facades\Config;
use Laravel\Scout\EngineManager;

class ElasticServiceProvider extends ServiceProvider
{

    public function boot()
    {
        resolve(EngineManager::class)->extend('elasticsearch', function () {
            $es_config = config::get('elasticsearch');
            return new ElasticEngine(ClientBuilder::create()->setHosts($es_config['hosts'])
                ->setRetries($es_config['retries'])
                ->build());
        });
    }
    
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/elasticsearch.php' => $this->app['path.config'].DIRECTORY_SEPARATOR.'elasticsearch.php',
            ]);
        }
    }
}
