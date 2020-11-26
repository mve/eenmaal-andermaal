<?php

namespace App;


class Category extends SuperModel
{
    public static function printTree($categories, &$allCategories, $level = 0)
    {
        $i = 1;
        foreach ($categories as $category) {
            $childCategories = [];
            foreach ($allCategories as $childCat) {
                if ($childCat->parent_id === $category->id)
                    array_push($childCategories, $childCat);
            }

            $classes = 'category category-' . $level;

            if ($level == 0) {
                $classes .= ' col-sm-6 col-md-2';
            }
            if($level != 0){
                $classes .= ' d-none';
            }



            if (count($childCategories) > 0){
                echo '<div class="' . $classes . ' category-hoverable"><span class="clickable-submenu user-select-none">' . $i++. " " . $category->name. ($level!=0? " <i class='fas fa-arrow-down category-arrow'></i>" : "") ." </span>";
                self::printTree($childCategories, $allCategories, $level + 1);
                echo '</div>';
            }else{
                echo '<a href="https://google.com" class="' . $classes . ' user-select-none">'. $i++. " " . $category->name;
                echo '</a>';
            }


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

        return self::printTree($mainCategories, $allCategories);

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

                $childCategories = [];
                foreach ($items as $childCat) {
                    if ($childCat->parent_id === $item->id)
                        array_push($childCategories, $childCat);
                }

                $childrenHtml .= '<div class="' . $classes . '">' . $item->name;

                $childrenHtml .= '<a href="' . $item->id . '">' . $item->name;

//                    $childrenHtml .= '<a href="' . $item->id . '">';
                if(count($childCategories)){
                    $childrenHtml .= self::buildNavigation($items, $item->id, $level);
                }
                    $childrenHtml .= '</a>';
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
