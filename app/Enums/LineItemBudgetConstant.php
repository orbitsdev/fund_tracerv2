<?php
namespace App\Enums; 
class LineItemBudgetConstant{
    public const DIRECT_COST = 'Direct Cost';
    public const INDIRECT_COST = 'Indirect Cost';
    public const COST_TYPES = [
        self::DIRECT_COST => self::DIRECT_COST,
        self::INDIRECT_COST => self::INDIRECT_COST,
    ];


    public const SKSU = 'SKSU';
    public const DOST = 'DOST';
    
    public const NONE = 'None';
    public const INDIRECT_COST_TYPE = [
        self::SKSU => self::SKSU,
        self::DOST => self::DOST,
       null =>  self::NONE,
      
      
    ];



    public const MONITORING_AGENCY = 'Monitoring Agency';
    public const AGILE_BOUND = 'AgileBound Technologies Inc.';
    public const IMPLEMENTING_MONITORING_AGENCY = [
        self::MONITORING_AGENCY =>  self::MONITORING_AGENCY,
        self::AGILE_BOUND =>  self::AGILE_BOUND,
       
    ];

    
    


    public const LOCAL_GOVERMENT_UNIT = 'Local Goverment Unit of Alegria';
    public const FUNDING_AGENCY = [
        self::DOST =>  self::DOST,
        self::LOCAL_GOVERMENT_UNIT =>  self::LOCAL_GOVERMENT_UNIT,
       
    ];

  

    public const AGENCY_WHERE_DOST_FUND_WILL_BE_ALLOCATED = [
      
        self::AGILE_BOUND =>  self::AGILE_BOUND,
       
    ];
}
