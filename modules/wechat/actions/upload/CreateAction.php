<?php

namespace app\modules\wechat\actions\upload;

use yii;
use yii\web\UploadedFile;
use app\components\tool\UploadModel;

/**
 * Created by PhpStorm.
 * User: liuzhen12
 * Date: 17-5-19
 * Time: 下午2:06
 */
class CreateAction extends \yii\rest\CreateAction
{

    /**
     * Name: run
     * Desc: 在调用主体逻辑之前，对request做转化
     * Creator: liuzhen<liuzhen12@lenovo.com>
     * CreatedDate: 20170523
     * Modifier:
     * ModifiedDate:
     * @return yii\db\ActiveRecordInterface
     */
    public function run()
    {
        $uploadModel = new UploadModel();
        $uploadModel->images = UploadedFile::getInstances($uploadModel, 'images');
        $uploadModel->upload();
        var_dump($uploadModel);exit;
        return parent::run();
    }


    function upload_logo( $key_name='photos', $logo_path='manage/images/nurse', $pre_name='logo', $salt='20160101',$encode = 1,$make=0 ){
        $result_arr = array();
        global $Server_Http_Path,$App_Error_Conf;
        //分文件夹保存
        $date_info = getdate();
        $year = $date_info['year'];
        $mon = $date_info['mon'];
        $day = $date_info['mday'];
        $logo_path = sprintf("%s/%s/%s/%s",$logo_path,$year,$mon,$day);
        if(!is_dir($logo_path)){
            $res=mkdir($logo_path,0777,true);
        }
        //图片上传
        //foreach($photos as $key => $photo ){
        $photo = $_FILES['photos'];
        $name = $key_name;

        $file_id = Input::file($name);
        if(!empty($file_id) && $file_id -> isValid()){
            $entension = $file_id -> getClientOriginalExtension();
            if($pre_name == 'baby'){
                $new_name = $pre_name . "_" . intval($salt) ."_" .time() . "_" . salt_rand(2,2);
            }else {
                $new_name = $pre_name . "_" . intval($salt) ."_" . salt_rand(2,2);
            }
            $path_id = $file_id -> move($logo_path,$new_name."_b.".$entension);
            if(!empty($path_id)){
                $path_name = $path_id->getPathName();
                $image_size=getimagesize($path_name);
                $weight=$image_size["0"];////获取图片的宽

                $height=$image_size["1"];///获取图片的高
                if($pre_name == "baby" || $pre_name == "video") {

                    $photo_info['url'] = $path_name;

                    $photo_info['width'] = $weight;
                    $photo_info['height'] = $height;
                    $result_arr[] = $photo_info;
                }else{
                    $result_arr[] = $path_name;
                }
                //处理图片
                if($make == 1){
                    $img = Image::make($path_name)->resize(200, $height*200/$weight);
                    $img->save($logo_path ."/".$new_name."_s.".$entension);
                    //dd($img);
                    // return $img->response('jpg');
                }
            }
            if(empty($result_arr)){
                $response['result_code'] = -1006;
                $response['result_msg'] = $App_Error_Conf[-1006];
                return response($response);
            }
            if($encode == 1){
                $result_arr = json_encode($result_arr);
            }
        }
        return $result_arr;
    }
}