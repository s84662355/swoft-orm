<?php declare(strict_types=1);

namespace cjhswoftOrm;


use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Co;
use Swoft\Concern\ArrayPropertyTrait;
use Swoft\Connection\Pool\Contract\ConnectionInterface;
use Illuminate\Database\Connection;
use Swoft\Db\DB;
use Swoft\Bean\BeanFactory;
/**
 * Class ConnectionFactory
 *
 * @since 2.0
 *
 * @Bean()
 */
class ConnectionFactory
{

	public static function   connection(string $pool)
	{

		$conManager = BeanFactory::getBean(ConnectionManager::class);
        if($conManager->hasConnection(  $pool)){
            $swoft_connection = DB::connection(  $pool);
            $pdo = $swoft_connection->getPdo();
            $database = $swoft_connection->getDatabase();
            $tablePrefix = $swoft_connection->getQueryGrammar()->getTablePrefix();

            $config = $swoft_connection->getDatabase()->getConfig();
       
            $conManager->setConnection(  $pool , new Connection($pdo,$database,$tablePrefix,$config));
        }
 
        return  $conManager->getConnection($pool);
	}

 

}