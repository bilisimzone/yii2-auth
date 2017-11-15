<?php

/*
 * This file is part of the CoreB2C project
 * 
 * (c) CoreB2C project <http://github.com/coreb2c>
 * 
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace coreb2c\auth\widgets;

use coreb2c\auth\components\DbManager;
use coreb2c\auth\models\Assignment;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;

/**
 * This widget may be used in user update form and provides ability to assign
 * multiple auth items to the user.
 * 
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class Assignments extends Widget {

    /** @var integer ID of the user to whom auth items will be assigned. */
    public $userId;

    /** @var DbManager */
    protected $manager;

    /** @inheritdoc */
    public function init() {
        parent::init();
        $this->manager = Yii::$app->authManager;
        if ($this->userId === null) {
            throw new InvalidConfigException('You should set ' . __CLASS__ . '::$userId');
        }
    }

    /** @inheritdoc */
    public function run() {
        $model = Yii::createObject([
                    'class' => Assignment::className(),
                    'user_id' => $this->userId,
        ]);

        if ($model->load(\Yii::$app->request->post())) {
            $model->updateAssignments();
        }

        return $this->render('form', [
                    'model' => $model,
        ]);
    }

}
