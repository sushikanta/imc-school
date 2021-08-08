<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 16-01-2019
 * Time: 12:54
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{

    protected $table = 'addresses';

    public $fillable = [
		'obj_table_ref',
		'object_id',
		'is_default',
        'address1',
        'address2',
		'type',
		'zipcode',
        'city',
        'state',
        'country_id',
        'contact1',
        'contact2',
		'user_id'
    ];
	
	
	// need to test is function  getAddress
	public static function getAddress($param=array()  )
    {
		  $addresses = Addresses::leftJoin('countries','countries.id', '=', 'addresses.country_id');
		  $addresses= $addresses->select('addresses.*', 'countries.title as country_name' );
		
		  if(isset($param['user_id']))
		  {
			   $addresses= $addresses->where('addresses.user_id', $param['user_id']);
		  }
		  
		  if(isset($param['obj_table_ref']))
		  {
			  $addresses= $addresses->where('addresses.obj_table_ref', $param['obj_table_ref']);
		  }
		  
		  if(isset($param['type']))
		  {
			  $addresses= $addresses->where('addresses.type', $param['type']);
		  }
		   
		  if(isset($param['is_default']))
		  {
			  $addresses= $addresses->where('addresses.is_default', $param['is_default']);
		  }
		  
		  if(isset($param['all']))
		  {
			  $addresses= $addresses->get();
			  
			  if( $addresses)
			  {
				  $addresses=$addresses->toArray();
			  }
		  }
		  else
		  {
			  $addresses= $addresses->first();
			  
			  if( $addresses)
			  {
				  $addresses=$addresses->toArray();
			  }
		  }
		  
		  return $addresses;
    }
	
	
}