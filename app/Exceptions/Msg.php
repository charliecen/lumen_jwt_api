<?php


namespace App\Exceptions;


class Msg
{
    const   Success           =   '成功';
    const   Unauthorized      =   '未认证';
    const   Failed            =   '失败';
    const   CreateUserSuccess =   '创建用户成功';
    const   CreateUserFailed  =   '创建用户失败';
    const   LoginSuccess      =   '登录成功';
    const   LoginFailed       =   '登录失败';
    const   LoginOutSuccess   =   '退出成功';
    const   UserIsMe          =   '获取当前用户';

    const   CreatePostsSuccess  =   '创建文章成功';
    const   CreatePostsFailed   =   '创建文章失败';
    const   PostsListSuccess    =   '查询文章列表成功';
    const   PostsListFailed     =   '查询文章列表失败';
}
