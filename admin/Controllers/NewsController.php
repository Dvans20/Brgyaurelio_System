<?php 

require_once '../Models/News.php';
require_once "../Utilities/Database.php";
require_once "../Models/Log.php";
require_once "../Models/User.php";
require_once "../Models/WebSetting.php";
require_once '../Models/Categories.php';



class NewsController {


    public static function saveNewNews($datas)
    {
        date_default_timezone_set("Asia/Manila");

        $response = [
            'status' => 2,
            'msg' => "",
            'data' => $datas
        ];

        foreach($datas as $k=>$v)
        {
            $$k = $v;
        }

        if (empty($newsTitle) || empty($newsContent)) {
            $response['msg'] = "News Title and Content is required.";
        } else {

            $imageUploadStatus = true;

            if (!empty($featureImage)) {
                $folderPath = "../Media/images/";

                try {
                    $feature_image_parts = explode(";base64,", $featureImage);
                    $feature_image_type_aux = explode("image/", $feature_image_parts[0]);
                    $feature_image_type = $feature_image_type_aux[1];
                    $feature_image_base64 = base64_decode($feature_image_parts[1]);
                    $feature_file = strtolower( str_replace(" ","-", $newsTitle)).'.'.$feature_image_type;
        
                    file_put_contents($folderPath.$feature_file, $feature_image_base64);

                    $featureImage = $feature_file;
                } catch (Exception $e)
                {
                    echo $e;
                    $imageUploadStatus = false;
                }

            }

            if (isset($categories))
            {

                $cats = "";
                foreach($categories as $category)
                {
                    $cats .= "|". $category . "|";
                }

                $categories = $cats;
            } else {
                $categories = null;
            }

            $datePublished = "";
            if ($status == 2)
            {
                $datePublished = date('Y-m-d H:i:s', time());
            }

            $news = new News();

            $news->newsTitle = $newsTitle;
            $news->newsContent = $newsContent;
            $news->featureImage = $featureImage;
            $news->categories = $categories;
            $news->status = $status;
            $news->datePublished = $datePublished;
            $news->dateSaved = date('Y-m-d H:i:s', time());
            
            $save = $news->save();

            $response['data'] = $news;

            if ($save !== "Good") {

                $response['status'] = 1;
                $response['msg'] = $save;

            } else {
                if ($news->status == 2) {
                    Log::saveNewActivity("Added", "Published a new News.");
                    $response['msg'] = "News Published successfully";
                } else {
                    Log::saveNewActivity("Added", "Drafted a new News.");
                    $response['msg'] = "News Saved successfully";
                }
                $response['status'] = 3;

            }
            
        }

        echo json_encode($response);
    }

    public static function updateNews($datas)
    {
        date_default_timezone_set("Asia/Manila");

        $response = [
            'status' => 2,
            'msg' => "",
            'data' => $datas
        ];

        foreach($datas as $k=>$v)
        {
            $$k = $v;
        }

        if (empty($newsTitle) || empty($newsContent)) {
            $response['msg'] = "News Title and Content is required.";
        } else {

            $news = News::findById($id);

            $imageUploadStatus = true;

            if (!empty($featureImage)) {
                $folderPath = "../Media/images/";

                try {
                    $feature_image_parts = explode(";base64,", $featureImage);
                    $feature_image_type_aux = explode("image/", $feature_image_parts[0]);
                    $feature_image_type = $feature_image_type_aux[1];
                    $feature_image_base64 = base64_decode($feature_image_parts[1]);
                    $feature_file = strtolower( str_replace(" ","-", $newsTitle)).'.'.$feature_image_type;
        
                    if (file_exists($folderPath.$news->featureImage)) {
                        unlink($folderPath.$news->featureImage);
                    }
                    file_put_contents($folderPath.$feature_file, $feature_image_base64);

                    $featureImage = $feature_file;
                } catch (Exception $e)
                {
                    echo $e;
                    $imageUploadStatus = false;
                }

            } else {
                $imageUploadStatus = false;
            }

            if (isset($categories))
            {

                $cats = "";
                foreach($categories as $category)
                {
                    $cats .= "|". $category . "|";
                }

                $categories = $cats;
            } else {
                $categories = null;
            }


            

            if ($news->datePublished == null && $status == 2) {
                $news->datePublished = date('Y-m-d H:i:s');
            }

            if ($imageUploadStatus) {
                $news->featureImage = $featureImage;
            }

            $news->newsTitle = $newsTitle;
            $news->newsContent = $newsContent;
           
            $news->categories = $categories;
            $news->status = $status;

            // $news->datePublished = $datePublished;
            // $news->dateSaved = date('Y-m-d H:i:s');
            
            $update = $news->update();

            $response['data'] = $news;

            if (!$update) {

                $response['status'] = 1;
                $response['msg'] = $update;

            } else {
                if ($news->status == 2) {
                    Log::saveNewActivity("Updated", "Updated & Published a News.");
                    $response['msg'] = "Updated & Published successfully";
                } else {
                    Log::saveNewActivity("Added", "Drafted a News.");
                    $response['msg'] = "Updated successfully";
                }
                $response['status'] = 3;

            }
        }

        echo json_encode($response);
    }

    public static function getNews($datas)
    {
        foreach ($datas as $k => $v)
        {
            $$k = $v;
        }

        $search = "%".$search."%";

        $respponse = [
            'datas' => $datas,
            'news' => News::get($search, $filter, $page, $limit),
            'totalPages' => ceil(News::countAll($search, $filter) / $limit)
        ];

        echo json_encode($respponse);
    }

    public static function getSingleNews($id)
    {
        $news = News::findById($id);

        echo json_encode($news);
    }

    public static function getSingleNewsWithCategories($id)
    {
        $news = News::findById($id);
        
        $response = [
            'news' => $news,
            'categories' => Categories::findByType("news")
        ];

        echo json_encode($response);
    }

    public static function deleteNews($id)
    {
        
        $news = News::findById($id);

        if ($news->featureImage != null) {
            $folderPath = "../Media/images/";
            if (file_exists($folderPath.$news->featureImage)) {
                unlink($folderPath.$news->featureImage);
            }
        }

        $news->delete();

        $response = [
            'status' => 3,
            'msg' => "News Deleted."
        ];

        Log::saveNewActivity("Deleted", "Deleted a News.");

        echo json_encode($response);
    }
}