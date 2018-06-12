<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/5/4
 * Time: 22:00
 */

namespace common\models;


use yii\elasticsearch\ActiveRecord;

/**
 * Job model
 * @property string $url
 * @package common\models
 */
class Job extends ActiveRecord
{
    // Other class attributes and methods go here
    // ...

    /**
     * @return array the list of attributes for this record
     */
    public function attributes()
    {
        // path mapping for '_id' is setup to field 'id'
        return ['_id', 'addr', 'city', 'company_name', 'company_short_name', 'company_url', 'company_img',
            'degree_need', 'job_advantage', 'job_desc', 'job_type',
            'publish_time', 'release_time', 'salary_max', 'salary_min', 'tags', 'title',
            'url', 'url_object_id', 'website', 'work_years', 'suggest'];
    }


    public static function index()
    {
        return 'zhaopin';
    }

    public static function type()
    {
        return 'job';
    }

    /**
     * @return array This model's mapping
     */
    public static function mapping()
    {
        return [
            static::type() => [
                'properties' => [
                    'addr'          => ['type' => 'text', "analyzer" => "ik_max_word"],
                    'city'          => ['type' => 'keyword'],
                    'company_name'  => ['type' => 'text', "analyzer" => "ik_max_word"],
                    'company_short_name'  => ['type' => 'text', "analyzer" => "ik_smart"],
                    'company_url'   => ['type' => 'keyword'],
                    'company_img'   => ['type' => 'keyword'],
                    'degree_need'   => ['type' => 'keyword'],
                    'job_advantage' => ['type' => 'text', "analyzer" => "ik_max_word"],
                    'job_desc'      => ['type' => 'text', "analyzer" => "ik_max_word"],
                    'job_type'      => ['type' => 'keyword'],
                    'publish_time'  => ['type' => 'keyword'],
                    'release_time'  => ['type' => 'date'],
                    'salary_max'    => ['type' => 'integer'],
                    'salary_min'    => ['type' => 'integer'],
                    'tags'          => ['type' => 'text', "analyzer" => "ik_max_word"],
                    'title'         => ['type' => 'text', "analyzer" => "ik_max_word"],
                    'url'           => ['type' => 'keyword'],
                    'url_object_id' => ['type' => 'keyword'],
                    'website'       => ['type' => 'keyword'],
                    'work_years'    => ['type' => 'keyword'],
                    'suggest' => [
                        'type'     => 'completion',
                        "analyzer" => "ik_max_word",
                    ],

                ]
            ],
        ];
    }

    /**
     * Set (update) mappings for this model
     */
    public static function updateMapping()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->setMapping(static::index(), static::type(), static::mapping());
    }

    /**
     * Create this model's index
     */
//    public static function createIndex()
//    {
//        $db = static::getDb();
//        $command = $db->createCommand();
//        $command->createIndex(static::index(), [
//            'settings' => [ /* ... */],
//            'mappings' => static::mapping(),
//            //'warmers' => [ /* ... */ ],
//            //'aliases' => [ /* ... */ ],
//            //'creation_date' => '...'
//        ]);
//    }

    /**
     * Delete this model's index
     */
    public static function deleteIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->deleteIndex(static::index());
    }

    public function attributeLabels()
    {
        return [
            'addr' => '地址',
            'city' => '城市',
            'company_name' => '公司',
            'degree_need' => '学历',
            'job_advantage' => '职位诱惑',
            'job_desc' => '职位描述',
            'title' => '名称',
        ];
    }
}