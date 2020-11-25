<?php

namespace App;


class Category extends SuperModel
{
    public static function printTree($categories, &$allCategories, $level = 0)
    {

        $i = 1;
        foreach ($categories as $category) {

            $indentStr = "&nbsp;&nbsp;&nbsp;&nbsp;";
            $fullIndentStr = "";

            for ($x = 0; $x < $level; $x++) {
                $fullIndentStr .= $indentStr;
            }

            printf($fullIndentStr . $i++ . " " . $category->name . "<br/>");

            $childCategories = [];
            foreach ($allCategories as $childCat) {
                if ($childCat->parent_id === $category->id)
                    array_push($childCategories, $childCat);
            }
            if (count($childCategories) > 0)
                self::printTree($childCategories, $allCategories, $level + 1);

        }

    }

    public static function getCategories()
    {

        $allCategories = self::all();

        $mainCategories = [];
        foreach ($allCategories as $category) {
            if ($category->parent_id === null)
                array_push($mainCategories, $category);
        }

//        return ['main' => $mainCategories, 'all' => $allCategories];


//        self::printTree($mainCategories, $allCategories, 0);

        return self::buildNavigation($allCategories);

    }

    static function buildNavigation($items, $parent = NULL, $level = NULL)
    {
        $hasChildren = false;
        $outputHtml = '%s';
        $childrenHtml = '';

        $level++;

        foreach ($items as $item) {

            if ($item->parent_id === $parent) {
                $hasChildren = true;

                $classes = 'category-' . $level;

                if ($level == 1) {
                    $classes .= ' col-sm-6 col-md-3';
                }

                $childrenHtml .= '<div class="' . $classes . '">' . $item->name;

//                $childrenHtml .= '<a href="' . $item->id . '">' . $item->name;

//                    $childrenHtml .= '<a href="' . $item->id . '">';
                        $childrenHtml .= self::buildNavigation($items, $item->id, $level);
//                    $childrenHtml .= '</a>';
                $childrenHtml .= '</div>';
            }

        }

        // Without children, we do not need the <ul> tag.
        if (!$hasChildren) {
            $outputHtml = '';
        }

        // Returns the HTML
        return sprintf($outputHtml, $childrenHtml);
//        return sprintf($childrenHtml);
    }

}
