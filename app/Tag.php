<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'id_tag';

    public function getTagsProds()
    {
        return \DB::table('tags')->where('enable', '=', true)
            ->join('product', 'product.id_product', '=', 'tags.id_product')
            ->select('tags.id_tag', 'tags.enable', 'tags.id_product', 'product.name as product_name')->get();
    }

    public function getTags()
    {
        return \DB::table('tags')->where('enable', '=', false)
            ->select('tags.id_tag', 'tags.enable')->get();
    }

    public function exist($id_tag)
    {
        $count = Tag::where('id_tag', $id_tag)->count();
        if ($count == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function createTag($id_tag)
    {
        $tag = new Tag();
        $tag->id_tag = $id_tag;
        $tag->enable = 0;
        $tag->save();
    }

    public function saveTagProduct($id_tag, $id_product)
    {
        $tag = Tag::where('id_tag', $id_tag)->firstOrFail();
        $tag->id_product = $id_product;
        $tag->enable = 1;
        $tag->save();
    }

    public function removeProdTag($id_tag)
    {
        $tag = Tag::where('id_tag', $id_tag)->firstOrFail();
        if($tag->enable){
            $tag->id_product = NULL;
            $tag->enable = 0;
            $tag->save();
        }
    }
    
}
