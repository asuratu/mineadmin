<?php
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

declare(strict_types=1);

namespace App\Api\Middleware;

use App\Api\Event\ApiAfter;
use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Inject;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\SimpleCache\InvalidArgumentException;

class ApiVerifyInterfaceMiddleware implements MiddlewareInterface
{
    /**
     * 事件调度器
     *
     * @var EventDispatcherInterface
     */
    #[Inject]
    protected EventDispatcherInterface $evDispatcher;

    /**
     * 验证检查接口
     *
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws InvalidArgumentException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->run($request, $handler);
    }

    /**
     * 运行
     *
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws InvalidArgumentException
     */
    protected function run(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {


        $result = $handler->handle($request);

        $event = new ApiAfter($this->_getApiData(), $result);
        $this->evDispatcher->dispatch($event);

        return $event->getResult();
    }

    /**
     * 获取协程上下文
     *
     * @return array
     */
    private function _getApiData(): array
    {
        return Context::get('apiData', []);
    }

    /**
     * 设置协程上下文
     *
     * @param array $data
     */
    private function _setApiData(array $data): void
    {
        Context::set('apiData', $data);
    }
}
