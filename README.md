laravel search package
Engine:
    elasticsearch
    
## Laravel Scout Elasticsearch Driver
This package makes is the [Elasticsearch](https://www.elastic.co/products/elasticsearch) driver for Laravel Scout.
supporting Laravel 5.6 and 5.7

Inspired by [ErickTamayo/laravel-scout-elastic](https://github.com/ErickTamayo/laravel-scout-elastic)
## Installation

You can install the package via composer:

``` bash
composer require team2/laravel-scout-elasticsearch
```

### Setting up Elasticsearch configuration

This command will publish the scout.php configuration file to your config directory:

``` bash
php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
```

This command will publish the elasticsearch.php configuration file to your config directory:

``` bash
php artisan vendor:publish --provider="Team2\Search\ElasticServiceProvider"
```

.env file example:

```bash
SCOUT_DRIVER=elasticsearch
SCOUT_PREFIX=es-
SCOUT_QUEUE=false
ES_HOSTS=http://127.0.0.1:9200,http://127.0.0.1:9200
ES_RETRIES=1
ES_INDEX=default
```

## Usage:
Now you can use Laravel Scout as described in the [official documentation](https://laravel.com/docs/5.7/scout)

###Batch Import
If you are installing Scout into an existing project, you may already have database records you need to import into your search driver. Scout provides an import Artisan command that you may use to import all of your existing records into your search indexes:

```bash
php artisan scout:import "App\Post"
```

The flush command may be used to remove all of a model's records from your search indexes:

```bash
php artisan scout:flush "App\Post"
```

```php
    //search 搜索 - 自定义搜索
        $res = PackageliastModel::search('', function ($es, string $query, array $options) {
            $options = [
                'index' => 'nwn-package',
                'type' => 'nwn-package',
                'body' => [
                    'query' => [
                        'bool' => [
                            'filter' => [
                                [
                                    'term' => [
                                            'product' => 4
                                    ]
                                ],
                                [
                                    'term' => [
                                            'id' => 3792
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];
            return $es->search($options);
        })->get();
        dd($res);
        //search 搜索 - 分页数据
        $list = PackageliastModel::search('2019')->paginate(15);
        dd($list);
        
        //search 搜索 - where条件
        $list = PackageliastModel::search('2019')->where('id', 3629)->raw();
        dd($list);
        //search 搜索 - 替换index
        $list = PackageliastModel::search('2019')->within('nwn-*')->raw();
        dd($list);
        //search 搜索 - raw数据
        $list = PackageliastModel::search('2019')->raw();
        dd($list);
        //search 搜索 - 模型数据
        $list = PackageliastModel::search('2019')->get();
        dd($list);
        //delete 删除多个 条件删除
        PackageliastModel::whereIn('id', [4153,4152,4151,4150])->unsearchable();
        //update 更新多个
        $res = PackageliastModel::whereIn('id', [4153,4152,4151,4150])->update(['template_id' => 888]);
        PackageliastModel::whereIn('id', [4153,4152,4151,4150])->searchable();
        dd($res);
        //delete 删除 - 软删除设置scout.soft_delete = true 
        $faker = Factory::create('zh_CN');
        $packageModel = PackageliastModel::find(4153);
        $res = $packageModel->delete();
        dd($res);
        //save 增加
        $faker = Factory::create('zh_CN');
        $packageModel = new PackageliastModel();
        $packageModel->pack_name = $faker->name . $faker->name . $faker->name;
        $packageModel->admin_id = $faker->randomDigitNotNull;
        $res = $packageModel->save();
        dd($res);
        //update 修改
        $faker = Factory::create('zh_CN');
        $packageModel = PackageliastModel::find(4153);
        $packageModel->pack_name = $faker->name . $faker->name . $faker->name;
        $packageModel->admin_id = $faker->randomDigitNotNull;
        $res = $packageModel->save();
        dd($res);
```
PackageliastModel.php

```php
   //add search
    use Searchable;
        
    public function searchableAs()
    {
        return 'nwn-package';
    }
    
    public function toSearchableArray()
    {
        $array = $this->toArray();
                
        return $array;
    }
    
    public function getScoutKey()
    {
        return $this->id;
    }
```