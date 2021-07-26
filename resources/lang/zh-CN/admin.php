<?php

return [
    'online'                => '在线',
    'login'                 => '登录',
    'logout'                => '登出',
    'setting'               => '设置',
    'name'                  => '名称',
    'username'              => '用户名',
    'password'              => '密码',
    'password_confirmation' => '确认密码',
    'remember_me'           => '记住我',
    'user_setting'          => '用户设置',
    'avatar'                => '头像',
    'list'                  => '列表',
    'new'                   => '新增',
    'create'                => '创建',
    'delete'                => '删除',
    'remove'                => '移除',
    'edit'                  => '编辑',
    'continue_editing'      => '继续编辑',
    'continue_creating'     => '继续创建',
    'view'                  => '查看',
    'detail'                => '详细',
    'browse'                => '浏览',
    'reset'                 => '重置',
    'export'                => '导出',
    'batch_delete'          => '批量删除',
    'save'                  => '保存',
    'refresh'               => '刷新',
    'order'                 => '排序',
    'expand'                => '展开',
    'collapse'              => '收起',
    'filter'                => '筛选',
    'search'                => '搜索',
    'close'                 => '关闭',
    'show'                  => '显示',
    'entries'               => '条',
    'captcha'               => '验证码',
    'action'                => '操作',
    'title'                 => '标题',
    'description'           => '简介',
    'back'                  => '返回',
    'back_to_list'          => '返回列表',
    'submit'                => '提交',
    'menu'                  => '菜单',
    'input'                 => '输入',
    'succeeded'             => '成功',
    'failed'                => '失败',
    'delete_confirm'        => '确认删除?',
    'delete_succeeded'      => '删除成功 !',
    'delete_failed'         => '删除失败 !',
    'update_succeeded'      => '更新成功 !',
    'save_succeeded'        => '保存成功 !',
    'refresh_succeeded'     => '刷新成功 !',
    'login_successful'      => '登录成功 !',
    'choose'                => '选择',
    'choose_file'           => '选择文件',
    'choose_image'          => '选择图片',
    'more'                  => '更多',
    'deny'                  => '无权访问',
    'administrator'         => '管理员',
    'roles'                 => '角色',
    'permissions'           => '权限',
    'slug'                  => '标识',
    'created_at'            => '创建时间',
    'updated_at'            => '更新时间',
    'alert'                 => '注意',
    'parent_id'             => '父级菜单',
    'icon'                  => '图标',
    'uri'                   => '路径',
    'operation_log'         => '操作日志',
    'parent_select_error'   => '父级选择错误',
    'pagination'            => [
        'range' => '从 :first 到 :last ，总共 :total 条',
    ],
    'role'                  => '角色',
    'permission'            => '权限',
    'route'                 => '路由',
    'confirm'               => '确认',
    'cancel'                => '取消',
    'http'                  => [
        'method' => 'HTTP方法',
        'path'   => 'HTTP路径',
    ],
    'all_methods_if_empty'  => '为空默认为所有方法',
    'all'                   => '全部',
    'current_page'          => '当前页',
    'selected_rows'         => '选择的行',
    'upload'                => '上传',
    'new_folder'            => '新建文件夹',
    'time'                  => '时间',
    'size'                  => '大小',
    'listbox'               => [
        'text_total'         => '总共 {0} 项',
        'text_empty'         => '空列表',
        'filtered'           => '{0} / {1}',
        'filter_clear'       => '显示全部',
        'filter_placeholder' => '过滤',
    ],
    'grid_items_selected'    => '已选择 {n} 项',
    'menu_titles'            => [],
    'prev'                   => '上一步',
    'next'                   => '下一步',
    'quick_create'           => '快速创建',
    'menu_titles' => [
        'dashboard'         => '仪表盘',
        'adminCatg'         => '管理员',
        'users'             => '用户',
        'abuses'            => '违规行为',
        'problemsCatg'      => '题库',
        'problems'          => '题目',
        'solutions'         => '题解',
        'submissions'       => '提交',
        'contests'          => '比赛',
        'groups'            => '群组',
        'judgeserver'       => '评测机',
        'judger'            => '评测代理',
        'dojoCatg'          => '训练场',
        'helpers'           => '辅助工具',
        'scaffold'          => '脚手架',
        'database'          => '数据库终端',
        'artisan'           => 'Artisan命令行工具',
        'routes'            => '路由列表',
        'logs'              => '日志查看器',
        'media'             => '媒体管理器',
        'scheduling'        => '任务调度',
        'backup'            => '备份',
        'redis'             => 'Redis管理器',
        'babelCatg'         => 'BABEL拓展包',
        'babelinstalled'    => 'BABEL管理工具',
        'babelmarketspace'  => 'BABEL应用市场',
    ],
    'home' => [
        'dashboard'         => '仪表盘',
        'general'           => '总体情况',
        'description'       => config("app.name").'的总体情况',
        'version'           => 'NOJ版本',
        'latest'            => '最新版本',
        'problems'          => '题目',
        'solutions'         => '题解',
        'submissions'       => '提交',
        'contests'          => '比赛',
        'users'             => '用户',
        'groups'            => '群组',
        'alreadylatest'     => '已经是最新版',
        'environment'       => '系统环境',
        'dependencies'      => '依赖版本',
        'envs' => [
            'php'           => 'PHP版本',
            'laravel'       => 'Laravel版本',
            'cgi'           => '通用网关接口',
            'uname'         => '操作系统信息',
            'server'        => '服务器软件',
            'cache'         => '缓存驱动',
            'session'       => '会话驱动',
            'queue'         => '队列驱动',
            'timezone'      => '时区配置',
            'locale'        => '本地化配置',
            'env'           => '环境配置',
            'url'           => 'URL',
        ],
    ],
    'users' => [
        'name'              => '用户名',
        'email'             => '邮箱',
        'basic'             => '基本信息',
        'password'          => '密码',
        'index' => [
            'header'        => '用户',
            'description'   => '所有用户列表',
        ],
        'show' => [
            'header'        => '用户详情',
            'description'   => '查看用户详情',
        ],
        'edit' => [
            'header'        => '编辑用户',
            'description'   => '编辑用户信息',
        ],
        'create' => [
            'header'        => '创建新用户',
            'description'   => '创建一个新用户',
        ],
    ],
    'judgers' => [
        'handle'            => '登录凭证',
        'password'          => '登录密码',
        'availability'      => '可用性',
        'available'         => '可用',
        'unavailable'       => '不可用',
        'password'          => '密码',
        'oj'                => 'OJ平台',
        'user_id'           => '评测代理凭证ID',
        'index' => [
            'header'        => '评测代理',
            'description'   => '所有评测代理列表',
        ],
        'show' => [
            'header'        => '评测代理详情',
            'description'   => '查看评测代理详情',
        ],
        'edit' => [
            'header'        => '编辑评测代理',
            'description'   => '编辑评测代理信息',
        ],
        'create' => [
            'header'        => '创建新评测代理',
            'description'   => '创建一个新评测代理',
        ],
        'help' => [
            'handle'        => 'BABEL拓展使用登录凭证登录。',
            'password'      => 'BABEL拓展使用登录密码登录。',
            'user_id'       => '一些BABEL拓展，例如UVa与UVaLive需要提供评测代理凭证ID，这是一个纯数字的字符串。',
        ],
    ],
    'submissions' => [
        'time'              => '时间占用',
        'timeFormat'        => ':time毫秒',
        'memory'            => '空间占用',
        'memoryFormat'      => ':memory千比特',
        'verdict'           => '结果',
        'color'             => '色彩类',
        'language'          => '编程语言',
        'submission_date'   => '提交日期',
        'user_name'         => '用户名称',
        'contest_name'      => '比赛名称',
        'readable_name'     => '题目名称',
        'judger_name'       => '评测代理',
        'share'             => '提交分享',
        'disableshare'      => '关闭',
        'enableshare'       => '开启',
        'rawscore'          => '原始得分',
        'parsed_score'      => '得分',
        'remote_id'         => '远程ID',
        'cid'               => '比赛',
        'uid'               => '用户',
        'pid'               => '题目',
        'jid'               => '评测代理',
        'coid'              => '编译器',
        'vcid'              => '虚拟比赛',
        'solution'          => '提交解答',
        'index' => [
            'header'        => '提交',
            'description'   => '所有提交列表',
        ],
        'show' => [
            'header'        => '提交详情',
            'description'   => '查看提交详情',
        ],
        'edit' => [
            'header'        => '编辑提交',
            'description'   => '编辑提交信息',
        ],
        'create' => [
            'header'        => '创建新提交',
            'description'   => '创建一个新提交',
        ],
    ],
];
