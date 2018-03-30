<?php
/**
 *
 * 用户管理数据模
 * author Cary
 * contact QQ : 373889161($S$-memory)
 *
 */
namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%admin_user}}".
 *
 * @property integer $id
 * @property integer $username
 * @property integer $auth_key
 * @property string $password
 * @property string $email
 * @property string $add_time
 * @property string $up_time
 * @property string $login_time
 * @property string $login_ip
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    public $rememberMe = true;
    private $_user;
    public $verifyCode;

    const STATUS_ACTIVE = 0;    //状态
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['add_time','login_time','up_time'],'integer'],
            [['auth_key', 'email', 'login_ip'], 'string', 'max' => 255],
            [['email'],'email'],
            //['verifyCode', 'captcha','captchaAction'=>'index/captcha','message'=>'验证码不正确！'],
            //['password', 'validatePassword'],
        ];
    }

    public function scenarios()     //设置多个验证场景
    {
        $parent = parent::scenarios();  //没有指定场景验证时使用默认场景  使用: $model->scenarios='login';
        $parent['login'] = ['username','password'];
        $parent['reger'] = ['username','password'];
        return $parent;
    }

    public function login()
    {
        //获取用户名
        $rows = Admin::findOne(['username' => $this->username, 'status' => self::STATUS_ACTIVE]);
        if($rows != null)
        {
            if(yii::$app->security->validatePassword($this->password,$rows->password))   //密码验证
            {
                echo "<script>alert('登录成功');</script>";
                return yii::$app->user->login($rows,$this->rememberMe ? 3600 * 24 * 30 : 0);    //保存登录信息()
                //return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
                return true;

            }else{
                //密码错误弹出提示
                echo "<script>alert('用户名或密码错误！');</script>";
                Yii::$app->session->setFlash('success','用户名或密码错误@！'); //页面提示信息
            }
            return false;
        }else{
            //用户不存在,弹出提示
            echo "<script>alert('用户名或密码错误！！');</script>";
            //Yii::$app->session->setFlash('success','用户名或密码错误!!！'); //页面提示信息
            return false;
        }

    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = static::findOne(['username' => $this->username, 'status' => self::STATUS_ACTIVE]);
        }
        return $this->_user;
    }
    public static function findIdentity($id)
    {
        return Admin::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()   //返回显示数据
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => 'Goods ID',
            'password' => '密码',
            'email' => '邮箱',
            'add_time' => '添加时间',
            'up_time' => 'Shop Name',
            'login_time' => 'Goods Prices',
            'login_ip' => 'Goods Sales',
            //'verifyCode' => '验证码',
        ];
    }

    public function search($params)
    {
        $query = Admin::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        return $dataProvider;
    }
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $this->auth_key = Yii::$app->security->generateRandomString();    //
        $this->password = Yii::$app->security->generatePasswordHash($this->password);    //setPassword 给密码加密
        $this->add_time = time();
        $this->up_time = time();
        $this->login_time = time();
        return $this->save();
    }
    public function upsave($id)
    {

        $user = Admin::findOne($id);
        $pass = $this->password;
        if($user && $pass)
        {
            $user->password = Yii::$app->security->generatePasswordHash($pass);
            $user->email = $this->email;
            $user->up_time = time();
            return $user->save();
        }
        else
        {
            $user->email = $this->email;
            $user->up_time = time();
            return $user->save();
        }
    }
}
