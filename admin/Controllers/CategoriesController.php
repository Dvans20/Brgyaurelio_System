<?php 
require_once '../Utilities/Database.php';
require_once '../Models/Categories.php';
require_once "../Models/Log.php";
require_once "../Models/User.php";
require_once "AppController.php";

class CategoriesController {

    public static function saveNewsCategory($type, $category)
    {
        $response = [
            'status' => 2,
            'msg' => null
        ];

        $cat = Categories::findByType($type);

        if (empty($cat->categories)) {
            $existingCategory = false;
        } else {

            $existingCategory = false;

            foreach(explode("|", $cat->categories) as $categ) {
                if ($categ == $category) {
                    $existingCategory = true;
                }
            }
        }

        if (empty($category)){
            $response['msg'] = "Category name is required.";

        } else if ($existingCategory) {
            $response['msg'] = "Category name already exist.";
        } else {


            if (empty($cat->categories)) {
                $cat->categories = $category;
            } else {
                $cat->categories .= "|" . $category;
            }

            $cat->update();

            Log::saveNewActivity("Added", "Added a new " . $type . " category.");

            $response['msg'] = "Category Saved.";
            $response['status'] = 3;
        }

        echo json_encode($response);
    }

    public static function deleteCategories($type, $categories)
    {

        $response = [
            'status' => 2,
            'msg' => "",
        ];

        if (count($categories) <= 0) {
            $response['msg'] = "You have not selected any categories.";
        } else {

            $cat = Categories::findByType($type);

            $newCategories = "";
    
            foreach (explode("|", $cat->categories) as $categ)
            {
                if (!AppController::isExist($categories, $categ)) {
                    if (empty($newCategories)) {
                        $newCategories = $categ;
                    } else {
                        $newCategories .= "|" . $categ;
                    }
                }
            }
    
            $cat->categories = $newCategories;

            $cat->update();

            $response['status'] = 3;
            $response['msg'] = "Categories Deleted.";

            Log::saveNewActivity("Deleted", "Deleted a " . $type . " category.");

        }

        echo json_encode($response);

       
    }

    public static function getCategories($type)
    {
        $categories = Categories::findByType($type);

        echo json_encode($categories);
    }
    
}