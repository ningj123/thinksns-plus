<?php


// 应用启动配置
Route::get('/bootstrappers', 'BootstrappersController@show');

// 用户登录
Route::post('/login', 'LoginController@store');

// 创建注册验证码
Route::post('/verifycodes/register', 'VerifyCodeController@storeByRegister');
// 已存在用户发送验证码
Route::post('/verifycodes', 'VerifyCodeController@store');

// 当前用户资料接口
Route::prefix('/user')
->middleware('auth:api')
->group(function () {
    // 当前用户资料
    Route::get('/', 'CurrentUserController@show');

    // 用户通知
    Route::get('/notifications', 'UserNotificationController@index');
    Route::get('/notifications/{notification}', 'UserNotificationController@show');
    Route::patch('/notifications/{notification?}', 'UserNotificationController@markAsRead');

    // 用户收到的评论
    Route::get('/comments', 'UserCommentController@index');

    // 用户收到赞
    Route::get('/likes', 'UserLikeController@index');
});

// 用户相关
Route::prefix('/users')
->group(function () {
    // 获取用户列表
    Route::get('/', 'UserController@show');
    // 获取单用户
    Route::get('/{user}', 'UserController@user');

    Route::post('/', 'UserController@store');
});

// 钱包相关接口
Route::prefix('/wallet')
->middleware('auth:api')
->group(function () {
    // 获取钱包配置信息
    Route::get('/', 'WalletConfigController@show');

    // 提现申请
    Route::post('/cashes', 'WalletCashController@store');
    // 获取提现记录
    Route::get('/cashes', 'WalletCashController@show');

    // 充值
    Route::post('/recharge', 'WalletRechargeController@store');

    //  凭据
    Route::get('/charges/{charge}', 'WalletChargeController@show');
    // 用户凭据列表
    Route::get('/charges', 'WalletChargeController@list');
});

// 文件相关接口
Route::get('/files/{fileWith}', 'FilesController@show');
Route::prefix('/files')->middleware('auth:api')->group(function () {
    Route::post('/', 'FilesController@store');
    Route::get('/uploaded/{hash}', 'FilesController@uploaded');
});

// 付费购买
Route::prefix('/purchases')
->middleware('auth:api')
->group(function () {
    Route::get('/{node}', 'PurchaseController@show');
    Route::post('/{node}', 'PurchaseController@pay');
});
