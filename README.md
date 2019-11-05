SignRequest
===========
simple way to sign request and check sign

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist sillydong/yii2-signrequest "*"
```

or add

```
"sillydong/yii2-signrequest": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

#### Send request
```php
$secret='qwerty';
$postdata = [
    'a'=>'b',
    'c'=>'d'
];
$postdata['nonce']=Sign::nonce(32);
$postdata['sign']=Sign::sign($postdata,$secret);
//do post
```

#### Check request
```php
$secret='qwerty';
$postdata = Yii::$app->request->post();
if(Sign::check($postdata,'sign',$secret){
    echo "success";
}else{
    echo "fail";
}
$getdata = Yii::$app->request->get();
if(Sign::check($getdata,'sign',$secret){
    echo "success";
}else{
    echo "fail";
}
```
