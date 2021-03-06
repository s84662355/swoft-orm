<?php declare(strict_types=1);

namespace cjhswoftOrm;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Co;
use Swoft\Concern\ArrayPropertyTrait;
use Swoft\Connection\Pool\Contract\ConnectionInterface;
use Illuminate\Database\Connection;

/**
 * Class ConnectionManager
 *
 * @since 2.0
 *
 * @Bean()
 */
class ConnectionManager
{
    /**
     * @example
     * [
     *     'tid' => [
     *         'cid' => [
     *             'connectionId' => Connection
     *         ]
     *     ]
     * ]
     */
    use ArrayPropertyTrait;

    /**
     * @param Connection $connection
     */
    public function setConnection(  $pool,Connection $connection): void
    {
        $key = sprintf('%d.%d.%d', Co::tid(), Co::id(),  $pool);
        $this->set($key, $connection);

      ///  var_dump(  $this->get($key ));
    }

    public function hasConnection( $pool) 
    {
        $key = sprintf('%d.%d.%d', Co::tid(), Co::id(),  $pool);
        return $this->has($key);
    }

    /**
     * @param string $pool
     */
    public function getConnection(  $pool)  
    {
         $key = sprintf('%d.%d.%d', Co::tid(), Co::id(),  $pool);
         return $this->get($key);
    }

    /**
     * @param  string $pool
     */
    public function releaseConnection(  $pool): void
    {
        $key = sprintf('%d.%d.%d', Co::tid(), Co::id(), $pool);
        $connection = $this->getConnection($key);
        if($connection){
            $connection->rollBack();
            $this->unset($key);
        }   
    }

    /**
     * @param bool $final
     */
    public function release(bool $final = false): void
    {
        $this->release_id( Co::id() );
        $finalKey = sprintf('%d', Co::tid());
        $this->unset($finalKey);
        
        
    }

    public function release_id($id) :void
    {
        $key = sprintf('%d.%d', Co::tid(), Co::id());
        $connections = $this->get($key,[]);

     

        foreach ($connections as $k =>  $connection) {
            $connection->rollBack();
        }

        $this->unset($key);
 
    }

    public function clean()
    {
        $key = sprintf('%d', Co::tid() );

        $ids = $this->get($key,[]);

        foreach ( $ids  as $k =>   $id) {
             $this->release_id( $k );
        }

        $this->data=[];
    }

}