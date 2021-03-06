<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-11 09:53
 */

namespace backend\models;

use yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class Article extends \common\models\Article
{

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->flag_headline == null) {
            $this->flag_headline = 0;
        }
        if ($this->flag_recommend == null) {
            $this->flag_recommend = 0;
        }
        if ($this->flag_slide_show == null) {
            $this->flag_slide_show = 0;
        }
        if ($this->flag_special_recommend == null) {
            $this->flag_special_recommend = 0;
        }
        if ($this->flag_roll == null) {
            $this->flag_roll = 0;
        }
        if ($this->flag_bold == null) {
            $this->flag_bold = 0;
        }
        if ($this->flag_picture == null) {
            $this->flag_picture = 0;
        }
        $this->tag = str_replace('，', ',', $this->tag);
        $this->seo_keywords = str_replace('，', ',', $this->seo_keywords);
        if ($insert) {
            $this->author_id = yii::$app->getUser()->getIdentity()->id;
            $this->author_name = yii::$app->getUser()->getIdentity()->username;

        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $contentModel = new ArticleContent();
            $contentModel->aid = $this->id;
        } else {
            if ($this->content === null) {
                return;
            }
            $contentModel = ArticleContent::findOne(['aid' => $this->id]);
            if ($contentModel == null) {
                $contentModel = new ArticleContent();
                $contentModel->aid = $this->id;
            }
        }
        $contentModel->content = $this->content;
        $contentModel->save();
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        Comment::deleteAll(['aid' => $this->id]);
        if (($articleContentModel = ArticleContent::find()->where(['aid' => $this->id])->one()) != null) {
            $articleContentModel->delete();
        }
        return true;
    }


}