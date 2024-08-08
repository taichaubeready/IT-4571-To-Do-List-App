<?php

namespace app\controllers;

use app\models\UserPhotos;
use app\models\UserPhotosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use app\models\User;
use WebPConvert\WebPConvert;

/**
 * UserPhotosController implements the CRUD actions for UserPhotos model.
 */
class UserPhotosController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all UserPhotos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        // Initialize Variables
        $action = "List User Photos";
        $user_id = Yii::$app->user->id;
        $status = "Active";
        $count_action = 1;
        $is_deleted = 0;
        $created_at = time();
        $updated_at = time();

        // Check user_id exits in job table migrate?
        $sql_searchJobByAction = Yii::$app->db->createCommand("SELECT * FROM job WHERE action='{$action}'")->queryAll();

        if (count($sql_searchJobByAction) == null) {
            $sql_insertJob = Yii::$app->db->createCommand()->insert('job', [
                'action' => $action,
                'user_id' => $user_id,
                'status' => $status,
                'count_action' => $count_action,
                'is_deleted' => $is_deleted,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ])->execute();
        } else {
            $sql_updateJob = Yii::$app->db->createCommand("UPDATE job SET count_action=count_action+1  WHERE action='{$action}'")->execute();
        }

        $searchModel = new UserPhotosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserPhotos model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // Initialize Variables
        $action = "View Detail User Photos With UserPhoto_Id: " . $id;
        $user_id = Yii::$app->user->id;
        $status = "Active";
        $count_action = 1;
        $is_deleted = 0;
        $created_at = time();
        $updated_at = time();

        // Check user_id exits in job table migrate?
        $sql_searchJobByAction = Yii::$app->db->createCommand("SELECT * FROM job WHERE action='{$action}'")->queryAll();

        if (count($sql_searchJobByAction) == null) {
            $sql_insertJob = Yii::$app->db->createCommand()->insert('job', [
                'action' => $action,
                'user_id' => $user_id,
                'status' => $status,
                'count_action' => $count_action,
                'is_deleted' => $is_deleted,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ])->execute();
        } else {
            $sql_updateJob = Yii::$app->db->createCommand("UPDATE job SET count_action=count_action+1  WHERE action='{$action}'")->execute();
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserPhotos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        $model = new UserPhotos();

        if ($this->request->isPost) {
            if (
                $model->load($this->request->post())
            ) {

                // Initialize Variables
                $action = "Created User Photos";
                $user_id = Yii::$app->user->id;
                $status = "Active";
                $count_action = 1;
                $is_deleted = 0;
                $created_at = time();
                $updated_at = time();

                // Check user_id exits in job table migrate?
                $sql_searchJobByAction = Yii::$app->db->createCommand("SELECT * FROM job WHERE action='{$action}'")->queryAll();

                if (count($sql_searchJobByAction) == null) {
                    $sql_insertJob = Yii::$app->db->createCommand()->insert('job', [
                        'action' => $action,
                        'user_id' => $user_id,
                        'status' => $status,
                        'count_action' => $count_action,
                        'is_deleted' => $is_deleted,
                        'created_at' => $created_at,
                        'updated_at' => $updated_at,
                    ])->execute();
                } else {
                    $sql_updateJob = Yii::$app->db->createCommand("UPDATE job SET count_action=count_action+1  WHERE action='{$action}'")->execute();
                }

                $sql = Yii::$app->db->createCommand("SELECT * FROM user_photos where user_id='{$model->user_id}'")->queryAll();

                // Check if user_id haved in user_photos table
                if (count($sql) == null) {
                    # code...
                    $user_id = $model->user_id;
                    $user_name = User::find()->where(['id' => $user_id])->one()->username;

                    $data_files = []; // Array Data Files

                    // Using File Helper to create folder
                    $path = Yii::getAlias('@webroot/user_photos/') . $user_name . '/uploads';
                    FileHelper::createDirectory($path);

                    $model->photos = UploadedFile::getInstances($model, 'photos');

                    // Multiple files use foreach
                    foreach ($model->photos as $key => $files) {
                        # code...
                        $files_name = Yii::$app->security->generateRandomString(16);
                        $files->saveAs($path . '/' . $files_name . '.' . $files->extension); // Save in folder uploads
                        $data_files[$key] = $files_name . '.' . $files->extension;

                        // Convert JPG, PNG to Webp
                        $source = $path . '/' . $files_name . '.' . $files->extension;
                        $destination = $path . '/' . 'webp/' . $files_name . '.webp';
                        $options = [];
                        WebPConvert::convert($source, $destination, $options);
                    }

                    $model->photos = json_encode($data_files); // Save in DB

                    $model->save();

                    Yii::$app->session->setFlash('success', "User Photos created successfully.");

                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', "This User_id saved in DB - Please use another User_id");
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserPhotos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {

            // Initialize Variables
            $action = "Updated User Photos With UserPhotos_Id: " . $id;
            $user_id = Yii::$app->user->id;
            $status = "Active";
            $count_action = 1;
            $is_deleted = 0;
            $created_at = time();
            $updated_at = time();

            // Check user_id exits in job table migrate?
            $sql_searchJobByAction = Yii::$app->db->createCommand("SELECT * FROM job WHERE action='{$action}'")->queryAll();

            if (count($sql_searchJobByAction) == null) {
                $sql_insertJob = Yii::$app->db->createCommand()->insert('job', [
                    'action' => $action,
                    'user_id' => $user_id,
                    'status' => $status,
                    'count_action' => $count_action,
                    'is_deleted' => $is_deleted,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ])->execute();
            } else {
                $sql_updateJob = Yii::$app->db->createCommand("UPDATE job SET count_action=count_action+1  WHERE action='{$action}'")->execute();
            }


            $sql = Yii::$app->db->createCommand("SELECT * FROM user_photos where user_id='{$model->user_id}'")->queryAll();

            // Check if user_id haved in user_photos table
            if (count($sql) > 0) {
                # code...
                $user_id = $model->user_id;
                $user_name = User::find()->where(['id' => $user_id])->one()->username;

                $data_files = []; // Array Data Files

                // Using File Helper to create folder
                $path = Yii::getAlias('@webroot/user_photos/') . $user_name . '/uploads';
                FileHelper::createDirectory($path);

                $model->photos = UploadedFile::getInstances($model, 'photos');

                // Multiple files use foreach
                foreach ($model->photos as $key => $files) {
                    # code...
                    $files_name = Yii::$app->security->generateRandomString(16);
                    $files->saveAs($path . '/' . $files_name . '.' . $files->extension); // Save in folder uploads
                    $data_files[$key] = $files_name . '.' . $files->extension;

                    // Convert JPG, PNG to Webp
                    $source = $path . '/' . $files_name . '.' . $files->extension;
                    $destination = $path . '/' . 'webp/' . $files_name . '.webp';
                    $options = [];
                    WebPConvert::convert($source, $destination, $options);
                }

                $model->photos = json_encode($data_files); // Save in DB

                $model->save();

                Yii::$app->session->setFlash('success', "User Photos saved successfully.");

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', "This User_id not correct!");
            }
        } else {
            $model->loadDefaultValues();
        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserPhotos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // Initialize Variables
        $action = "Deleted User Photos With UserPhotos_Id: " . $id;
        $user_id = Yii::$app->user->id;
        $status = "Active";
        $count_action = 1;
        $is_deleted = 0;
        $created_at = time();
        $updated_at = time();

        // Check user_id exits in job table migrate?
        $sql_searchJobByAction = Yii::$app->db->createCommand("SELECT * FROM job WHERE action='{$action}'")->queryAll();

        if (count($sql_searchJobByAction) == null) {
            $sql_insertJob = Yii::$app->db->createCommand()->insert('job', [
                'action' => $action,
                'user_id' => $user_id,
                'status' => $status,
                'count_action' => $count_action,
                'is_deleted' => $is_deleted,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ])->execute();
        } else {
            $sql_updateJob = Yii::$app->db->createCommand("UPDATE job SET count_action=count_action+1  WHERE action='{$action}'")->execute();
        }

        // $this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->is_deleted = 1;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserPhotos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UserPhotos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserPhotos::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
