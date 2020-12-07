<?php


namespace App;


class Breadcrumbs
{
    /**
     * Create and print the breadcrumbs
     * @param $var
     * @param int $max
     */
    static function createAndPrint(&$var, $max = 0)
    {
        self::printBreadcrumbs(self::create($var, $max));
    }

    /**
     * Print the breadcrumbs
     * @param $html
     */
    static function printBreadcrumbs($html)
    {
        print($html);
    }

    /**
     * Create the HTML and call the correct function
     * @param $var
     * @param int $max
     * @return string
     */
    static function create(&$var, $max = 0)
    {
        $type = "array";
        if(!is_array($var))
            $type = get_class($var);
        $breadcrumbsHTML = "
            <div id=\"breadcrumbs-container\">
                <div class=\"container\">
                    <div class=\"row\">
                        <div class=\"col\">
                        ";

        $breadcrumbsArray = ["<a href='" . route("home") . "'>Home</a>"];

        switch ($type) {
            case "App\Auction":
                $breadcrumbsArray = array_merge($breadcrumbsArray, self::createForAuction($var));
                break;
            case "App\Category":
                $breadcrumbsArray = array_merge($breadcrumbsArray, self::createForCategory($var));
                break;
            case "array":
            default:
                $breadcrumbsArray = array_merge($breadcrumbsArray, $var);
                break;
        }

        $breadcrumbsHTML .= self::arrayToHTML($breadcrumbsArray, $max);

        $breadcrumbsHTML .= "
                        </div>
                    </div>
                </div>
            </div>
            ";
        return $breadcrumbsHTML;
    }

    /**
     * Create breadcrumbs array for auction
     * @param $var
     * @return array
     */
    private static function createForAuction(&$var)
    {
        $breadcrumbsArray = [];
        $aucCatPivot = DB::selectOne("SELECT TOP 1 * FROM auction_categories WHERE auction_id=:auction_id", [
            "auction_id" => $var->id
        ]);
        if ($aucCatPivot !== false) {
            $category = Category::oneWhere("id", $aucCatPivot["category_id"]);
            $breadcrumbsArray = array_merge($breadcrumbsArray, self::createForCategory($category, true));
        }
        array_push($breadcrumbsArray, $var->title);
        return $breadcrumbsArray;
    }

    /**
     * Create breadcrumbs array for a category
     * @param $var
     * @param bool $link
     * @return array
     */
    private static function createForCategory(&$var, $link = false)
    {
        $breadcrumbsArray = [];

        $allCategories = Category::all();
        $categoriesArray = [];
        self::categoryParent($categoriesArray, $allCategories, $var->parent_id);
        $categoriesArray = array_reverse($categoriesArray);
        $breadcrumbsArray = array_merge($breadcrumbsArray, $categoriesArray);

        if ($link) {
            array_push($breadcrumbsArray, "<a href='" . route('auctionsInCategory', $var->id) . "'>$var->name</a>");
        } else {
            array_push($breadcrumbsArray, "$var->name");
        }
        return $breadcrumbsArray;
    }

    /**
     * Recursive function to get the parent of category of $parentId
     * @param $categoriesArray
     * @param $allCategories
     * @param $parentId
     */
    private static function categoryParent(&$categoriesArray, $allCategories, $parentId)
    {
        foreach ($allCategories as $category) {
            if ($category->id === $parentId) {
                array_push($categoriesArray, "<a href='" . route('auctionsInCategory', $category->id) . "'>$category->name</a>");
                self::categoryParent($categoriesArray, $allCategories, $category->parent_id);
                break;
            }
        }
    }

    /**
     * Breadcrumbs array to proper HTML
     * @param $array
     * @param int $max
     * @return string
     */
    private static function arrayToHTML($array, $max = 0)
    {
        $arrayTooBig = false;
        if($max >= 3 && count($array) > $max)
            $arrayTooBig = true;
        while ($max >= 3 && count($array) > $max){
            $i = round(count($array)/2) - 1;
            $keys = array_keys($array);
            unset ($array[$keys[$i]]);
        }
        if($arrayTooBig)
            array_splice($array, round(count($array)/2) - 1, 0,"...");

        $breadcrumbsStr = "";
        $lastElement = end($array);
        foreach ($array as $item) {
            $breadcrumbsStr .= "<span>" . $item;
            if ($item !== $lastElement)
                $breadcrumbsStr .= " > ";
            $breadcrumbsStr .= "</span>";
        }
        return $breadcrumbsStr;
    }
}
