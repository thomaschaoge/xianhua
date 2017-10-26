<?php
//����������
/**
 *�Զ���һ��ͼƬ�ȱ����ź���
 *@param string $picname ������ͼƬ��
 *@param string $path ������ͼƬ·��
 *@param int $maxWidth ͼƬ�����ź�������
 *@param int $maxHeight ͼƬ�����ź�����߶�
 *@param string $pre ���ź��ͼƬ��ǰ׺��Ĭ��Ϊ"s_"
 *@return boolen ���ز���ֵ��ʾ�ɹ����
 */
function imageResize($picname,$path,$maxWidth,$maxHeight,$pre="s_"){
    $path = rtrim($path,"/")."/";
    //1��ȡ�����ŵ�ͼƬ��Ϣ
    $info = getimagesize($path.$picname);
    //��ȡͼƬ�Ŀ�͸�
    $width = $info[0];
    $height = $info[1];
    
    //2����ͼƬ���ͣ�ʹ�ö�Ӧ�ĺ�����������Դ��
    switch($info[2]){
        case 1: //gif��ʽ
            $srcim = imagecreatefromgif($path.$picname);
            break;
        case 2: //jpeg��ʽ
            $srcim = imagecreatefromjpeg($path.$picname);
            break;
        case 3: //png��ʽ
            $srcim = imagecreatefrompng($path.$picname);
            break;
       default:
            return false;
            //die("��Ч��ͼƬ��ʽ");
            break;
    }
    //3. �������ź��ͼƬ�ߴ�
    if($maxWidth/$width<$maxHeight/$height){
        $w = $maxWidth;
        $h = ($maxWidth/$width)*$height;
    }else{
        $w = ($maxHeight/$height)*$width;
        $h = $maxHeight;
    }
    //4. ����Ŀ�껭��
    $dstim = imagecreatetruecolor($w,$h); 

    //5. ��ʼ�滭(����ͼƬ����)
    imagecopyresampled($dstim,$srcim,0,0,0,0,$w,$h,$width,$height);

    //6. ���ͼ�����Ϊ
    switch($info[2]){
        case 1: //gif��ʽ
            imagegif($dstim,$path.$pre.$picname);
            break;
        case 2: //jpeg��ʽ
            imagejpeg($dstim,$path.$pre.$picname);
            break;
        case 3: //png��ʽ
            imagepng($dstim,$path.$pre.$picname);
            break;
    }
    

    //7. �ͷ���Դ
    imagedestroy($dstim);
    imagedestroy($srcim);
    
    return true;
}