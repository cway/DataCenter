<?php
/**
 * @file DWDData_ErrorCode.php
 *
 * @author caowei
 *         @date 2015-08-22 下午00:23:36
 *         @brief 系统错误号和错误消息类
 *
 *
 */
class DWDData_ErrorCode
{
    const NORMAL     = 0;
    const NORMAL_MSG = 'success';
    const NORMAL_APP_MSG = 'OK';

    // 参数错误
    const MSG_PARAMS_NOT_ARRAY = '参数不是数组';

    // 数据错误
    const MSG_NOTSAFE          = '信息不是数组';

    //未知错误
    const ERRNO_UNKNOW         = '未知错误';


    const XSS_SAFE_ERRNO       = 990001;
    const REDIS_CONNECT_FAILED = 990002;
    const SERVER_ERROR         = 990000;
    const SERVER_ERROR_MSG     = '系统错误';
    const USER_NOT_LOGIN       = 100001;


    const PARAMS_ERROR         = 800001;
    const PARAMS_ERROR_MSG     = '参数错误';
    const FORBBIDEN            = 800403;
    const FORBBIDEN_MSG        = '禁止访问';
    const INSERT_ERROR         = 300001;
    const INSERT_ERROR_MSG     = '插入失败';
    const UPDATE_ERROR         = 300002;
    const UPDATE_ERROR_MSG     = '更新失败';
 

    // 公用错误
    const TEXT_EMPTY_ERROR              = 110001;
    const TEXT_EMPTY_ERROR_MSG          = '不能为空';
    const TEXT_LONG_ERROR               = 110002;
    const TEXT_LONG_ERROR_MSG           = '不能过长';
    const TEXT_FORMAT_ERROR             = 110003;
    const TEXT_FORMAT_ERROR_MSG         = '格式不正确';
    const POST_ERROR                    = 110004;
    const POST_ERROR_MSG                = '提交方式错误';
}