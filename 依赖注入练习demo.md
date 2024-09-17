```php
<?php

// 定义一个 Logger 接口
interface LoggerInterface
{
    public function log(string $message);
}

// 创建一个文件日志记录类，实现 Logger 接口
class FileLogger implements LoggerInterface
{
    public function log(string $message)
    {
        // 简单的日志输出，假设输出到文件中
        echo "Logging message to a file: " . $message . PHP_EOL;
    }
}

// 创建一个应用类，它依赖于 LoggerInterface
class Application
{
    private $logger;

    // 通过构造函数注入 LoggerInterface 的实现
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function run()
    {
        // 使用注入的 logger
        $this->logger->log("Application is running...");
    }
}

// 创建 FileLogger 实例并注入到 Application 中
$logger = new FileLogger();
$app = new Application($logger);
$app->run();

```

### 解释

1. **LoggerInterface 接口**：定义了一个 `log` 方法，用来记录日志。
2. **FileLogger 类**：实现了 `LoggerInterface`，并在 `log` 方法中将日志消息输出到文件（这里为了简化，使用 `echo`）。
3. **Application 类**：依赖于 `LoggerInterface`，通过构造函数注入方式将 `LoggerInterface` 的实现传入。
4. **依赖注入**：在应用中创建 `FileLogger` 实例，并将其注入到 `Application` 中。
