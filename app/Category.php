<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id_category';


    public function getCategories(){
        return Category::all();
    }

    public function exist($name){
        $count = Category::where('name', $name)->count();
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    public function existId($category_id){
        $count = Category::where('id_category', $category_id)->count();
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    public function searchCategory($name) {
        return Category::where('name', $name)->firstOrFail();
    }

    public function searchCategoryById($category_id) {
        return Category::where('id_category', $category_id)->firstOrFail();
    }

    public function createCategory($name){
        $category = new Category();
        $category->name = $name;
        $category->save();
    }

    public function updateCategory($category_id, $name) {
        $category = Category::where('id_category', $category_id)->firstOrFail();
        $category->name = $name;
        $category->save();
    }

    public function deleteCategory($name) {
        $category = Category::where('name', $name)->firstOrFail();
        $category->delete();
    }



}
