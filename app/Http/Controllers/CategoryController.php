<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getDonationsForCategory(Request $request) {

        if ($request->has('category')) {

            $id = $request->input("category");

            $category = Category::find($id);

            //$category = DB::table("categories")->find($id);

            return $category->donationOffers;

        }


    }
}
