<?php


namespace App\Http\Controllers\Admin;

use App\Category;
use App\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check.admin');
    }

    public function index()
    {
        $data = [
            "categoryMenuHTML" => Category::getCategoriesAdmin(),
            "categories" => Category::all()
        ];
        return view("admin.categories.index")->with($data);
    }


    public function categoryTree()
    {

    }
}
