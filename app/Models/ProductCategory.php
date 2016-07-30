<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Moloquent;
use Auth;
  class ProductCategory extends Model {

    protected $table = 'productcategories';
    //public $timestamps = false;
    //protected $primaryKey = '_id';
    // protected $connection = 'mongodb';

    public function products()
    {
      return $this->belongsTo('App\Models\Product','id','category_id');
    }

    public function parent()
    {
      return $this->belongsTo('App\Models\ProductCategory', 'parent_id');
    }

    public function childs()
    {
      return $this->hasMany('App\Models\ProductCategory','parent_id');
    }

    public function listproducts($list = array())
    {
      return $listproducts = Product::whereIn('category_id', $list)->take(8)->get();
    }
    public static function get_categories_tree($parent_id, $level = 0, $syntax='&nbsp', $default='&nbsp', $type="category")
    {
      $array_categories = array();
      $root_categories = ProductCategory::where('parent_id', '=', $parent_id)->where('type', '=', $type)->orderBy('position','asc')->get();
      if ($root_categories) {
        foreach ($root_categories as $parent) {
          $parent->level = $level;
          if($level == 0) {
            $parent->syntax = '';
            $syntax = '';
          } else {
            $parent->syntax = $syntax;
          }          
          $array_categories[] = $parent;
          $child = $parent->get_categories_tree($parent->id, $level+1, $syntax.$default, $default,$type);
          if ($child) {
            $array_categories = array_merge($array_categories, $child);
          }
        }
        return $array_categories;
      } else {
        return null;
      }
    }

    public static function get_categories_tree_except($parent_id, $level = 0, $syntax='&nbsp', $default='&nbsp', $except_id='', $type='category')
    {
      $array_categories = array();
      $root_categories = ProductCategory::where('parent_id', '=', $parent_id)->where('type', '=', $type)->orderBy('position','asc')->get();
      if ($root_categories) {
        foreach ($root_categories as $parent) {
          if (''.$parent->id == $except_id) {
            continue;
          }
          $parent->level = $level;
          if($level == 0) {
            $parent->syntax = '';
            $syntax = '';
          } else {
            $parent->syntax = $syntax;
          }
          $array_categories[] = $parent;
          $child = $parent->get_categories_tree_except($parent->_id, $level+1, $syntax.$default, $default, $except_id, $type);
          if ($child) {
            $array_categories = array_merge($array_categories, $child);
          }
        }
        return $array_categories;
      } else {
        return null;
      }
    }

    public  function getArrayProduct() {
    
    }
    
  }
?>