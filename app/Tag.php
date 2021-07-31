<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'id_tag';

    public function getAllTags()
    {
        return \DB::table('tags')->where('enable', '=', true)->get();
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
        $tag->enable = 1;
        $tag->save();
    }

    public function saveTagProduct($id_tag, $id_product)
    {
        $tag = Tag::where('id_tag', $id_tag)->firstOrFail();
        if($tag->enable == 1){
            $tag->id_product = $id_product;
            $tag->save();
        }
    }
}
