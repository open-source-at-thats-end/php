<?php


class AWS_S3
{
    public static $Instance;

    public static function obj()
    {
        if(!is_object(self::$Instance))
            self::$Instance = new self();

        return self::$Instance;
    }
    public function __construct()
    {


    }
    #=========================================================================================================================
    #	Function Name	:   aws_s3_get_credential
    #-------------------------------------------------------------------------------------------------------------------------
    public function aws_s3_get_credential(){
        $aws_s3_credentials = new Aws\Credentials\Credentials(AWS_S3_ACCESS_KEY_ID , AWS_S3_ACCESS_SECRET_KEY);

        //Create a S3Client
        $s3 = new Aws\S3\S3Client([

            'version'	 => 	'latest',
            'region'	 => 	AWS_S3_REGION,
            'credentials' => 	$aws_s3_credentials,
        ]);
        return $s3;
    }
    #=========================================================================================================================
    #	Function Name	:   aws_s3_imgTransfer
    #-------------------------------------------------------------------------------------------------------------------------

    public function aws_s3_imgTransfer($s3,$MLS_NUM,$Physical_pic_Path,$imgName){
        if (strlen($MLS_NUM)>2)
            $folderName = substr($MLS_NUM,-2);
        else
            $folderName = $MLS_NUM;

        $aws_img_path = MLS_TRESTLE::obj()->picPath['MLS_Pic_Folder'][MLS_TRESTLE::obj()->MLSP_ID].'/'.$folderName."/";

        $response = $s3->doesObjectExist(AWS_S3_BUCKET_NAME,$aws_img_path);

        try {
            if($response === false)
            {
                $s3->putObject([
                    'Bucket'	 => AWS_S3_BUCKET_NAME,
                    'Key' 		=> $aws_img_path,
                ]);
            }
            $response = true;
        }
        catch (S3Exception $e) {

            echo $e->getMessage();
            $response = false;
        }

        $aws_img_path .= $MLS_NUM."/";

        $response = $s3->doesObjectExist(AWS_S3_BUCKET_NAME, $aws_img_path);

        try {
            if($response === false)
            {
                $s3->putObject([
                    'Bucket'	 => AWS_S3_BUCKET_NAME,
                    'Key' 		=> $aws_img_path,
                ]);
            }
            $response = true;
        }
        catch (S3Exception $e) {

            echo $e->getMessage();
            $response = false;
        }

        try {
            $s3->putObject([
                'ACL'        => 'public-read',
                'Bucket'	 => AWS_S3_BUCKET_NAME,
                'Key' 		 => $aws_img_path.$imgName,
                'SourceFile' => $Physical_pic_Path,
            ]);
        }
        catch (S3Exception $e){

            echo $e->getMessage();
            $response = false;
        }

        return $response;
    }
    #=========================================================================================================================
    #	Function Name	:   aws_s3_delete_object
    #-------------------------------------------------------------------------------------------------------------------------

    public function aws_s3_delete_object($s3,$obj_path){

        try
        {
            //$this->aws_s3_delete_object_with_objects($s3,$obj_path);
            $result = $s3->deleteObject([
                'Bucket' => AWS_S3_BUCKET_NAME,
                'Key'    => $obj_path
            ]);
            $response = true;
        }
        catch (S3Exception $e) {

            echo $e->getMessage();
            $response = false;
        }

        return $response;
    }
    #=========================================================================================================================
    #	Function Name	:   aws_s3_delete_object_with_objects (Delete Images)
    #-------------------------------------------------------------------------------------------------------------------------
    public function aws_s3_delete_object_with_objects($s3,$obj_path){

        $response = array();
        $results = $s3->listObjectsV2([
            'Bucket' => AWS_S3_BUCKET_NAME,
            'Prefix' => $obj_path
        ]);

        if (isset($results['Contents'])) {
            foreach ($results['Contents'] as $result) {
                /*$s3->deleteObject([
                    'Bucket' => AWS_S3_BUCKET_NAME,
                    'Key' => $result['Key']
                ]);*/
                $response[] = $this->aws_s3_delete_object($s3,$result['Key']);
            }
        }
        return $response;

    }

}