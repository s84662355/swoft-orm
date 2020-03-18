<?php declare(strict_types=1);

namespace cjhswoftOrm;


use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Co;
use Swoft\Concern\ArrayPropertyTrait;
use Swoft\Connection\Pool\Contract\ConnectionInterface;
use Illuminate\Database\Connection;
use Swoft\Db\DB;
use Swoft\Bean\BeanFactory;
use cjhswoftOrm\ConnectionManager;
use Illuminate\Database\MySqlConnection ;

/**
 * Class ConnectionFactory
 *
 * @since 2.0
 *
 *  
 */
class ConnectionFactory
{

    const default = 'db.pool';


	public static function   connection(  $pool = ConnectionFactory::default)
	{

		$conManager = BeanFactory::getBean(ConnectionManager::class);
        if(!$conManager->hasConnection(  $pool)){
            $swoft_connection = DB::connection(  $pool);
            $pdo = $swoft_connection->getPdo();
            $database = $swoft_connection->getDatabase();
            $tablePrefix = $swoft_connection->getQueryGrammar()->getTablePrefix();

            $config = $swoft_connection->getDatabase()->getConfig();

            $connection = new MySqlConnection($pdo,$database,$tablePrefix,$config);
 
       
            $conManager->setConnection(  $pool , $connection );
        }

        return  $conManager->getConnection($pool);
	}

    public static function __callStatic($name, $arguments)
    {
         $connection = static::connection();

         return call_user_func_array([$connection,$name], $arguments);
    }

}
