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


    public function index(Request $request)
    {
        $limit = 15;
        $page = ($request->has("page")) ? (is_numeric($request->get("page")) ? $request->get("page") : 1) : 1;
        $offsetPage = ($page<=0)? 0 : $page-1 ;
        $offset = $offsetPage*$limit;

        $querySelectAll = "SELECT * ";
        $querySelectCount = "SELECT COUNT(*) as computed ";
        $query = "FROM categories";
        $values = [];

        if($request->has("search") && !empty($request->get("search"))){
            $query = "FROM categories WHERE name LIKE :searchq";
            $values['searchq'] = '%'.$request->get("search").'%';
        }
        //dd(DB::selectOne($querySelectCount.$query,$values));
        $eaPaginationTotalItems = DB::selectOne($querySelectCount.$query,$values)['computed'];
        $eaPaginationCurrentPage = $page;
        $eaPaginationTotalPages = ceil($eaPaginationTotalItems / $limit);

        $query .= " ORDER BY name ASC OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY";

        $categories = Category::resultArrayToClassArray(DB::select(
            $querySelectAll.$query
        ,$values));

        $data = [
            'categories' => $categories,
            'paginationData' => [
                'totalItems' => $eaPaginationTotalItems,
                'totalPages' => $eaPaginationTotalPages,
                'currentPage' => $eaPaginationCurrentPage,
            ]

        ];
        return view('admin.categories.index')->with($data);
    }


    public function categoryTree()
    {

    }
}
