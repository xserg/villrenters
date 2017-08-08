<?php
/**
 * Table Definition for transactions
 */
require_once 'DB/DataObject.php';

class DBO_Transactions extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'transactions';                    // table name
    public $_database = 'villa';                    // database name (used with database_{*} config)
    public $id;                              // int(4)  
    public $pay_date;                        // date()  
    public $payment_in_id;                   // int(4)  
    public $balance;                         // float()  
    public $advertiser_id;                   // int(4)  
    public $credit;                          // float()  
    public $debit;                           // float()  
    public $campaign_id;                     // int(4)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DBO_Transactions',$k,$v); }

    function table()
    {
         return array(
             'id' =>  DB_DATAOBJECT_INT,
             'pay_date' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE,
             'payment_in_id' =>  DB_DATAOBJECT_INT,
             'balance' =>  DB_DATAOBJECT_INT,
             'advertiser_id' =>  DB_DATAOBJECT_INT,
             'credit' =>  DB_DATAOBJECT_INT,
             'debit' =>  DB_DATAOBJECT_INT,
             'campaign_id' =>  DB_DATAOBJECT_INT,
         );
    }

    function keys()
    {
         return array();
    }

    function sequenceKey() // keyname, use native, native name
    {
         return array(false, false, false);
    }

    function defaults() // column default values 
    {
         return array(
             '' => null,
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
