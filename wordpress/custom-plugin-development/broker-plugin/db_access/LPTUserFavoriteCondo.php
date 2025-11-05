<?php

class LPTUserFavoriteCondo extends DAO
{
    private static $instance;

    public static function getInstance() {
        if( !isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct()
    {
        global $wpdb;

        $this->_daStruct['BaseTable'] =  'user_favorite_condo';
        $this->_daStruct['PrimaryKey'] = 'fav_id';
        $this->_daStruct['FieldInfo']       =   array(
            'fav_user_id'                   =>  array(
                'title'     =>  'User Id',
                'c_type'    =>  'text',
            ),
            'fav_condo_id'                   =>  array(
                'title'     =>  'Condo Id',
                'c_type'    =>  'text',
            ),
            'fav_date_time'                  =>  array(
                'title'     =>  'DateTime',
                'c_type'    =>  'date_time_picker',
            ),
        );
    }

    public function UpdateFavoritesCondos($userId, $CondoId, $Action){

        global $objDB;

        $fav_condo_id   = $CondoId;
        $fav_user_id    = $userId;
        $fav_date_time  = date('Y-m-d H:i:s');

        if($Action == 'Add') {
            $sql = "INSERT INTO ".$this->_daStruct['BaseTable']." 
					(fav_user_id, fav_condo_id, fav_date_time) 
					VALUES ('".$fav_user_id."', '".$fav_condo_id."','".$fav_date_time."') 
					ON DUPLICATE KEY UPDATE fav_condo_id='".$fav_condo_id."',
					fav_date_time = '".$fav_date_time."'";
        }
        elseif ($Action=='Remove') {
            $sql = "DELETE FROM ".$this->_daStruct['BaseTable']." WHERE fav_user_id = '".$fav_user_id."' AND fav_condo_id = '".$fav_condo_id."'";
        }

        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        $rs = $objDB->query($sql);

        return true;
    }
    public function getUserFavoritesCondos($user_id) {
        $fieldCustomSelect = " fav_condo_id as CondoID";

        $param = " AND fav_user_id = '".$user_id."'";

        $rs = parent::getAll($param, $fieldCustomSelect);

        $arrRes = $rs->fetch_array(MYSQLI_ASSOC, 'CondoID');

        $arrRet['arrIds'] = $arrRes;
        $arrRet['strIds'] = implode(",", array_keys($arrRes));

        return $arrRet;
    }
}

?>