<?php
$accessToken = '7r970ybgjBYYIaDq+9T9nAV3+p+EUx1WFzAWkNf2bPQSQ3/S52KcvgDRaXCPwqFcnQeEjKVODMfwCKSLmTu9bHTcZAF4MPAa3Sp8SPs8+n3IEcbxSsvBMukG2wbfCpZMlWdXSpaE45q+nkxCW7YdXwdB04t89/1O/w1cDnyilFU=';


//繰り返し
while(1){
  //ユーザーからのメッセージ取得
  $json_string = file_get_contents('php://input');
  $json_object = json_decode($json_string);

  //取得データ
  $replyToken = $json_object->{"events"}[0]->{"replyToken"};        //返信用トークン
  $message_type = $json_object->{"events"}[0]->{"message"}->{"type"};    //メッセージタイプ
  $message_text = $json_object->{"events"}[0]->{"message"}->{"text"};    //メッセージ内容


 $return_message_text='';
  if(strpos($return_message_text,'じゃねー') !== false){
   $return_message_text="(*´ω｀)"
 }


  //メッセージタイプが「text」以外のときは何も返さず終了
  if($message_type != "text") exit;

  //返信メッセージ
  $return_message_text = "「" . $message_text . "」じゃねーｗｗ";

  //返信実行
  sending_messages($accessToken, $replyToken, $message_type, $return_message_text);

}


?>
<?php
//メッセージの送信
function sending_messages($accessToken, $replyToken, $message_type, $return_message_text){
    //レスポンスフォーマット
    $response_format_text = [
        "type" => $message_type,
        "text" => $return_message_text
    ];

    //ポストデータ
    $post_data = [
        "replyToken" => $replyToken,
        "messages" => [$response_format_text]
    ];

    //curl実行
    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
}


 ?>
