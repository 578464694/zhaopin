<?php

namespace frontend\modules\job\models\searches;

use frontend\modules\job\models\Job;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * JobSearch represents the model behind the search form of `frontend\modules\job\models\Job`.
 */
class JobSearch extends Job
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['addr', 'city', 'company_name', 'company_url', 'degree_need',
                'job_advantage', 'job_desc', 'job_type', 'publish_time', 'release_time',
                'salary_max', 'salary_min', 'tags', 'title', 'url', 'url_object_id',
                'website', 'work_years', 'suggest'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Job::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        return $dataProvider;
    }
}
