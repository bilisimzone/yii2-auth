<?php

/*
 * This file is part of the CoreB2C project.
 *
 * (c) CoreB2C project <http://github.com/coreb2c>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace coreb2c\rbac\controllers;

use coreb2c\rbac\models\Assignment;
use Yii;
use yii\web\Controller;

/**
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class AssignmentController extends Controller
{
    /**
     * Show form with auth items for user.
     * 
     * @param int $id
     */
    public function actionAssign($id)
    {
        $model = Yii::createObject([
            'class'   => Assignment::className(),
            'user_id' => $id,
        ]);
        
        if ($model->load(\Yii::$app->request->post()) && $model->updateAssignments()) {
        }

        return \coreb2c\rbac\widgets\Assignments::widget([
            'model' => $model,
        ]);
        /*$model = Yii::createObject([
            'class'   => Assignment::className(),
            'user_id' => $id,
        ]);
        
        if ($model->load(Yii::$app->request->post()) && $model->updateAssignments()) {
            
        }
        
        return $this->render('assign', [
            'model' => $model,
        ]);*/
    }
}