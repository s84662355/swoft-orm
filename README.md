兼容laravel的orm


  

namespace App\Model;
use cjhswoftOrm\Model;

class A extends  Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'aaa';
    
    protected $primaryKey =  'id';
    
    protected $connection = 'db.pool';
      
    public $timestamps = false;
 
    /**
     * @var array
     */
    protected $fillable = ['a','b','c'];

    
}


        
        \cjhswoftOrm\ConnectionFactory:: connection( 'db.pool')->transaction (function(){
        	
        $a =  new \App\Model\A();
        $a->a=1;
        $a->b=1;
        $a->c=1;
        $a->save();
        
        
      
        
        $a =  new \App\Model\A();
        $a->a=1;
        $a->b=1;
        $a->c=1;
        $a->save();  
        
        });
 
