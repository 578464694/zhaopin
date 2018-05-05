<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/5/4
 * Time: 22:00
 */

namespace common\models;


use yii\elasticsearch\ActiveRecord;

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
        return ['addr', 'city', 'company_name', 'company_url',
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
                    'company_url'   => ['type' => 'keyword'],
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
}