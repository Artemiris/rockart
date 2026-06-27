<?php
namespace backend\models;

use common\models\User;
use yii\base\Model;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Create user form
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $status;
    public $roles;
    public $permissions;

    private $model;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass'=>'\common\models\User', 'filter' => function ($query) {
                if (!$this->getModel()->isNewRecord) {
                    $query->andWhere(['not', ['id'=>$this->getModel()->id]]);
                }
            }],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass'=> '\common\models\User', 'filter' => function ($query) {
                if (!$this->getModel()->isNewRecord) {
                    $query->andWhere(['not', ['id'=>$this->getModel()->id]]);
                }
            }],

            ['password', 'required', 'on'=>'create'],
            ['password', 'string', 'min' => 6],

            [['status'], 'boolean'],
            [['roles'], 'each',
                'rule' => ['in', 'range' => ArrayHelper::getColumn(
                    Yii::$app->authManager->getRoles(),
                    'name'
                )]
            ],
            [['permissions'], 'each',
                'rule' => ['in', 'range' => ArrayHelper::getColumn(
                    Yii::$app->authManager->getPermissions(),
                    'name'
                )]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Почта',
            'password' => 'Пароль',
            'status' => 'Статус',
            'roles' => 'Роли',
            'permissions' => 'Разрешения',
        ];
    }

    public function setModel($model)
    {
        $this->username = $model->username;
        $this->email = $model->email;
        $this->status = $model->status;
        $this->model = $model;
        $this->roles = ArrayHelper::getColumn(
            Yii::$app->authManager->getRolesByUser($model->getId()),
            'name'
        );
        $this->permissions = ArrayHelper::getColumn(
            Yii::$app->authManager->getPermissionsByUser($model->getId()),
            'name'
        );
        return $this->model;
    }

    public function getModel()
    {
        if (!$this->model) {
            $this->model = new User();
        }
        return $this->model;
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function save()
    {
        if ($this->validate()) {
            $model = $this->getModel();
            $model->username = $this->username;
            $model->email = $this->email;
            $model->status = $this->status ? 10 : 0;

            if ($this->password) {
                $model->setPassword($this->password);
                $model->generateAuthKey();
            }

            if ($model->save()) {
                $auth = Yii::$app->authManager;
                $auth->revokeAll($model->getId());

                if ($this->roles && is_array($this->roles)) {
                    foreach ($this->roles as $role) {
                        $auth->assign($auth->getRole($role), $model->getId());
                    }
                }

                if ($this->permissions && is_array($this->permissions)) {
                    foreach ($this->permissions as $permission) {
                        $auth->assign($auth->getPermission($permission), $model->getId());
                    }
                }
            }

            return !$model->hasErrors();
        }
        return null;
    }
}
