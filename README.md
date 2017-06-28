Windwork 日志组件
========================
实现日志保存功能，保存各种类型的应用级日志。常用于需要保存日志的逻辑中。比如错误日志、调试日志等。

## 初始化
使用日志组件之前，需要先初始化，否则无法正常使用。
```
$cfg = array(
    'class'    => 'File',     // 日志处理（\wf\logger\strategy\中）实现的类
    'dir'      => 'data/log', // 日志保存路径，支持wrapper，如新浪公有云可使用  saekv://data/log或saemc://data/cache
    'level'    => 7,          // 启用日志级别，可为0-7，记录小于或等于该级别的日志。日志等级：0)emergency，1)alert，2)critical，3)error，4)warning，5)notice，6)info，7)debug
);

$class = "\wf\\logger\\strategy\\{$cfg['class']}";
$logging = new $class($cfg);

```

## 通过logging()函数记录日志

```
$level = 'debug'; // 日志级别，可以是 emergency|alert|critical|error|warning|notice|info|debug
$message = 'dgb message'; // 日志内容，如果是非标量则使用var_export成字符串保存
logging($level, $message);
```

## 通过日志对象方法记录日志

```

// 通用日志记录方法
$logging->log('日志级别', '日志内容'); // 参数同 logging($level, $message)函数

// 系统不可用
$logging->emergency('日志内容');

// 必须立刻采取行动
$logging->alert('日志内容');

// 紧急情况
$logging->critical('日志内容');

// 运行时出现的错误，不需要立刻采取行动，但必须记录下来以备检测。
$logging->error('日志内容');

// 出现非错误性的异常。
$logging->warning('日志内容');

// 一般性重要的事件
$logging->notice('日志内容');

// 重要事件
$logging->info('日志内容');

// 调试信息
$logging->debug('日志内容');

```

## 日志级别
```
  0）emergency 系统不可用
  1）alert     必须立刻采取行动
  2）critical  紧急情况
  3）error     运行时出现的错误，不需要立刻采取行动，但必须记录下来以备检测。
  4）warning   出现非错误性的异常（Exception等）。 例如：使用了被弃用的API、错误地使用了API或者非预想的不必要错误。
  5）notice    一般性重要的事件。
  6）info      重要事件，例如：用户登录和SQL记录。
  7）debug     调试信息
```


<br />
<br />
> ### 要了解更多？
> - [官方完整文档首页](http://docs.windwork.org/manual/)
> - [官方源码首页](https://github.com/windwork

 