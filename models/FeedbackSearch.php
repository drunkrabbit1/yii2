<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class FeedbackForm
 * @package app\models
 */
class FeedbackSearch extends FeedbackForm
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['firstname', 'string', 'min' => 3, 'max' => 255],
            ['lastname', 'string', 'min' => 3, 'max' => 255],
            ['email', 'email'],
            ['phone', 'string'],
            ['body', 'string', 'min' => 3],
        ];
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'feedback_form';
    }

    /**
     * @return array|array[]
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $params
     * @param null $query
     * @return ActiveDataProvider
     */
    public function search($params, $query = null)
    {
        $query = $query ?? FeedbackForm::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'firstname', $this->firstname]);
        $query->andFilterWhere(['like', 'lastname', $this->lastname]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        $query->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}