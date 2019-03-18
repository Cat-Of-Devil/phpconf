<?php
namespace app\controllers;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Console;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class Post
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property bool $is_published
 */
class Post extends ActiveRecord
{

}

// https://www.yiiframework.com/doc/guide/2.0/en/structure-controllers
class PostController extends Controller
{
    public function actionView($id)
    {
        $model = Post::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException;
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Post;

        $model->is_published = false;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateConsole($title, $content)
    {
        $model = new Post;

        $model->title = $title;
        $model->content = $content;
        $model->is_published = false;
        if ($model->save()) {
            Console::output(sprintf('Post %d created', $model->id));
        } else {
            Console::error(sprintf('Post not created'));
        }
    }
}
