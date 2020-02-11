<?php declare(strict_types=1);


namespace cjhswoftOrm\Listener;


use ReflectionException;
use Swoft\Bean\BeanFactory;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Event\Annotation\Mapping\Subscriber;
use Swoft\Event\EventInterface;
use Swoft\Event\EventSubscriberInterface;
use Swoft\Log\Helper\CLog;
use cjhswoftRabbitmq\Pool;
use Swoft\Server\SwooleEvent;
use Swoft\SwoftEvent;
use cjhswoftOrm\ConnectionManager;
use Swoft\Bean\BeanFactory;
/**
 * Class WorkerStopAndErrorListener
 *
 * @since 2.0
 *
 * @Subscriber()
 */
class WorkerStopAndErrorListener implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            SwooleEvent::WORKER_STOP    => 'handle',
            SwoftEvent::WORKER_SHUTDOWN => 'handle',
        ];
    }

    /**
     * @param EventInterface $event
     *
     * @throws ReflectionException
     * @throws ContainerException
     */
    public function handle(EventInterface $event): void
    {
        BeanFactory::getBean(ConnectionManager::class)->clean();

        CLog::info('Close laravel connection on %s!',  $event->getName());
      
    }
}
