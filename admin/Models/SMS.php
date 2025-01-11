<?php 

    use Infobip\Configuration;
    use Infobip\Api\SmsApi;
    use Infobip\Model\SmsDestination;
    use Infobip\Model\SmsTextualMessage;
    use Infobip\Model\SmsAdvancedTextualRequest;

    require_once "../../vendor/autoload.php";



class SMS {


    public $recipient;
    public $msg;
    private $baseUrl = "https://9k1gwd.api.infobip.com";
    private $apiKey = "149c75b5e5389f4d104d74b672bd66a1-f6b59a68-7890-4859-8dcd-6ae50226c942";



    public function send()
    {
        $return = false;

        $web = WebSetting::get();

        $from = "BRGY. " . strtotime($web->brgy);

        try {

            $configuration = new Configuration($this->baseUrl, $this->apiKey);

            $api = new SmsApi($configuration);

            $destination = new SmsDestination($this->recipient);

            $message = new SmsTextualMessage(
                destinations: [$destination],
                text: $this->msg,
                from: $from
            );

            $request = new SmsAdvancedTextualRequest(messages: [$message]);

            $response = $api->sendSmsMessage($request);

            $return = $response;

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

}