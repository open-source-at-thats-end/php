<?php

class LPTUserFavoriteProperty extends DAO
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

        $this->_daStruct['BaseTable'] =  'user_favorite_property';
        $this->_daStruct['PrimaryKey'] = 'fav_id';
        $this->_daStruct['FieldInfo']       =   array(
            'fav_user_id'                   =>  array(
                'title'     =>  'User Id',
                'c_type'    =>  'text',
            ),
            'fav_mlsp_id'                   =>  array(
                'title'     =>  'MLSP Id',
                'c_type'    =>  'text',
            ),
            'fav_mls_num'                   =>  array(
                'title'     =>  'MLS NUM',
                'c_type'    =>  'text',
            ),
            'fav_date_time'                  =>  array(
                'title'     =>  'DateTime',
                'c_type'    =>  'date_time_picker',
            ),
        );
    }

    public function UpdateFavoritesHomes($userId, $MlsNum, $Action){

        global $objDB;

        $arrTemp 	= explode("-",$MlsNum);
        $fav_mls_num    = $arrTemp[0];
        $fav_mlsp_id    = $arrTemp[1];
        $fav_user_id    = $userId;
        $fav_date_time  = date('Y-m-d H:i:s');

        if($Action == 'Add') {
            $sql = "INSERT INTO ".$this->_daStruct['BaseTable']." 
					(fav_user_id, fav_mlsp_id, fav_mls_num, fav_date_time) 
					VALUES ('".$fav_user_id."', '".$fav_mlsp_id."',	'".$fav_mls_num."','".$fav_date_time."') 
					ON DUPLICATE KEY UPDATE fav_mls_num='".$fav_mls_num."',
					fav_date_time = '".$fav_date_time."'";
        }
        elseif ($Action=='Remove') {
            $sql = "DELETE FROM ".$this->_daStruct['BaseTable']." WHERE fav_user_id = '".$fav_user_id."' AND fav_mls_num = '".$fav_mls_num."'";
        }

        if (WP_DEBUG)
            echo '<br><br>'. $sql;

        $rs = $objDB->query($sql);

        return true;
    }
    public function getUserFavoritesHomes($user_id) {
        $fieldCustomSelect = " CONCAT(fav_mls_num, '-', fav_mlsp_id) AS ListingID_MLS, fav_mls_num ";

        $param = " AND fav_user_id = '".$user_id."'";

        $rs = parent::getAll($param, $fieldCustomSelect);

        $arrRes = $rs->fetch_array(MYSQLI_ASSOC, 'ListingID_MLS');

        $arrRet['arrIds'] = $arrRes;
        $arrRet['strIds'] = implode(",", array_keys($arrRes));

        return $arrRet;
    }
}
?>