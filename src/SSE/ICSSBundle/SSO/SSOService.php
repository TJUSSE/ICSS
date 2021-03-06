<?php

namespace SSE\ICSSBundle\SSO;

class SSOService
{
    protected $ssoAPIHost;

    public function __construct($ssoAPIHost)
    {
        $this->ssoAPIHost = $ssoAPIHost;
    }

    /**
     * 获取一个 SSOToken 的属性，如果 SSOToken 无效，则返回 null
     *
     * @param $token
     * @return array|null
     */
    public function getTokenAttribute($token)
    {
        $response = \Httpful\Request::get($this->ssoAPIHost.'/session/properties?sessionid='.urlencode($token))
            ->expectsJson()
            ->send();

        // 包含 msg，则代表失败
        if (!$response->body->ok) {
            return null;
        }

        return (array)$response->body->properties;
    }

    /**
     * 获取一个学生的基本信息
     *
     * @param $token
     * @return array|null
     */
    public function getStudentInfo($token)
    {
        $response = \Httpful\Request::get($this->ssoAPIHost.'/info/student?sessionid='.urlencode($token))
            ->expectsJson()
            ->send();

        // 包含 msg，则代表失败
        if (!$response->body->ok) {
            return null;
        }

        return (array)$response->body->info;
    }
}