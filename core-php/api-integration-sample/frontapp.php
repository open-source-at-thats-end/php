<?php
/*
This is a background script which run automatically to import message data in to Front APP account.
Data is exported in form of .csv files with attachments which is separate folder from another Front APP account
*/
$inbox_id = 'inb_bq2mu';
//$channel_id = 'cha_ey6ty';
set_time_limit(2000);

$a = glob("Marketing/*");
$result = [];
//$thread_ref = 350;

foreach ($a as $key) {

    $result[$key]=[];

    $b = glob("$key/*");

    if(is_array($b) && count($b)>1){
        $c= glob("$b[0]/*");
    }

    if (($handle = fopen("$key/messages.csv", "r")) !== FALSE) {
        $i=0;
        $row = 0;
        $start_from = 2;

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

            $row++;
            //skip if value less than $start_from row value
            if($row < $start_from){
                continue;
            }
            else{

                $str = str_replace("\n","<br>",$data[10]);
                $result[$key][$i]= ['id'=>$data[0],'public_id'=>$data[1],'date'=>$data[11]];
                if(isset($c)){
                    foreach ($c as $public_ID) {
                        $ans = explode("/", $public_ID);
                        if (isset($ans[3]) && $ans[3] == $data[1]) {
                            $d = glob("$public_ID/*");
                            $attachment_index = 1;
                            $atta = array();
                            foreach ($d as $k) {

                                $bsize = filesize($k);
                                $filesize = number_format($bsize / 1024);
                                $filesize = (int)$filesize;

                                $file_ext = pathinfo($k, PATHINFO_EXTENSION);

                                // $result[$key][$i] += ['attachments' => $k];
                                if($filesize >= 300 || $file_ext == 'pdf' ){
                                    $rename_attachement = $public_ID . '/' . $ans[3].'_'.$attachment_index. '.' . $file_ext;
                                    $attachment_name = rename($k, $rename_attachement);


                                    array_push($atta, $k);


                                }

                                $attachment_index++;
                            }
                            $result[$key][$i] += ['attachments' => $atta];

                        }
                    }

                }
                if(filter_var($data[8], FILTER_VALIDATE_EMAIL)){
                    //$result[$key][$i] += ['to'=>'test.thatsend@gmail.com'];
                   $result[$key][$i] += ['to'=>$data[8]];
                }
                else{
                    //$result[$key][$i] += ['to'=>'test.thatsend@gmail.com'];
                    $result[$key][$i] += ['to'=>'eoleafgreenerhealth@gmail.com'];
                }
                if(isset($data[10]) && $data[10] !=''){
                    $text = $str;
                    //$date = "Last Message - ".Date('d M Y, G:i:s',strtotime($data[11]));
                    //$text = $str ."<br><br>". $date;
                    $result[$key][$i] += ['text' => $text];
                }
                else{
                    $text = $str;
                    //$text = "Last Message - ".Date('d M Y, G:i:s',strtotime($data[11]));
                    $result[$key][$i] += ['text' => $text];
                }

                if(isset($data[9]) && $data[9] !=''){
                    $result[$key][$i] += ['subject'=>$data[9]];
                }
                else{
                    $result[$key][$i] += ['subject'=>''];
                }
                if(isset($data[11]) && $data[11] !=''){

                    $date = strtotime($data[11]);
                    $result[$key][$i] += ['created_at' => $date];
                }
                else{

                    $result[$key][$i] += ['created_at' => ''];
                }
                if(filter_var($data[7], FILTER_VALIDATE_EMAIL)){
                    //$result[$key][$i] += ['from'=>'test.thatsend@gmail.com'];
                    $result[$key][$i] += ['from'=>$data[7]];
                }
                else{
                    //$result[$key][$i] += ['from'=>'test.thatsend@gmail.com'];
                    $result[$key][$i] += ['from'=>'eoleafgreenerhealth@gmail.com'];
                }
                if(isset($data[4]) && $data[4] !=''){
                    $result[$key][$i] += ['type'=>$data[4]];
                }
                else{
                    $result[$key][$i] += ['type'=>'email'];
                }
                $i++;

            }

        }
    }

    usort($result[$key], 'date_compare');

    if(isset($key) && is_array($result[$key])){
        $arr_thread_ref = explode('/', $key);
        $thread_ref = $arr_thread_ref[1];

        $external_index = 1;
        foreach ($result[$key] as $key=>$res){
            //echo"<pre>";print_r($res);die;
            $post_data = array();
            //$attachment=array();
            //$attachment_value=[];

            $post_data = array(
                'sender[handle]' => $res['from'],
                'body_format' => 'html',
                'type' => 'email',
                'metadata[is_inbound]' => 'true',
                'metadata[thread_ref]' => 'conv'.$thread_ref.'1001',
                //'metadata[thread_ref]' => 'conv3',
                'metadata[should_skip_rules]' => 'true',
                'body' => $res["text"],
                'external_id' => $res["public_id"].$thread_ref.'1001',
                'created_at' => $res['created_at'],
                'to[0]' =>  $res['to'],
                'subject' => $res["subject"],
                // 'attachments[]'=> new CURLFILE($attch_file)
            );

            if(isset($res['attachments']) && is_array($res['attachments']) && count($res['attachments']) > 0){
                foreach($res['attachments'] as $key1=>$value){

                    $post_data['attachments['.$key1.']'] = new CURLFILE( __DIR__.'/'.$value);
                }
                //$post_data['attachments[]'] = new CURLFILE($res['attachments']);
            }

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api2.frontapp.com/inboxes/'.$inbox_id.'/imported_messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 500,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                //CURLOPT_POSTFIELDS => array('sender[handle]' => 'test.thatsend@gmail.com','body_format' => 'html','type' => 'email','metadata[is_inbound]' => 'true','metadata[thread_ref]' => 'conv18','metadata[should_skip_rules]' => 'true','body' => 'New imported message with attachment','external_id' => '19','created_at' => '1700496662','to[0]' => 'test1.thatsend@gmail.com','subject' => 'New Test Subject'),
                //CURLOPT_POSTFIELDS => array('sender[handle]' => 'test.thatsend@gmail.com','body_format' => 'html','type' => 'email','metadata[is_inbound]' => 'true','metadata[thread_ref]' => 'conv18','metadata[should_skip_rules]' => 'true','body' => 'New imported message with attachment','external_id' => '22','created_at' => '1700496662','to[0]' => 'test1.thatsend@gmail.com','subject' => 'Test Subject with attachment','attachments[]'=> new CURLFILE($attch_file)),
                CURLOPT_POSTFIELDS => $post_data,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: multipart/form-data',
                    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzY29wZXMiOlsic2hhcmVkOioiXSwiaWF0IjoxNzAyNDc0ODg5LCJpc3MiOiJmcm9udCIsInN1YiI6IjRhMDJjMDI2MTA1OWNhZDBmODBhIiwianRpIjoiY2E1YTdjNDA0NjQxOTVjNCJ9.ruUwqpnyTUTqQYUGGVwHfblaxeNk3X48BRMnuctuNlA'
                ),
            ));
            //echo 3535;die;
            $response = curl_exec($curl);
            echo '<pre>';print_r(curl_error($curl));
            curl_close($curl);
            echo $response;

            echo "<pre>4323";print_r($response);
            $response_array=json_decode($response);

        }
    }

    //$thread_ref += 1;

}

function date_compare($element1, $element2) {
    $datetime1 = strtotime($element1['date']);
    $datetime2 = strtotime($element2['date']);
    return $datetime1 - $datetime2;
}

?>