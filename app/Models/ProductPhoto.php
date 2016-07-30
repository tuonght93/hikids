<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Moloquent;
  class ProductPhoto extends Model {

      protected $table = 'productPhotos';
      //public $timestamps = false;
      //protected $primaryKey = '_id';
      // protected $connection = 'mongodb';

      public function product()
      {
        return $this->belongsTo('App\Models\Product', 'product_id');
      }

      public function image_url()
      {
        $product = $this->product;
        return $this->image == '' ? '' : md5(date_format($product->created_at, 'm-Y')).'/'.$this->product_id.'/'.$this->image;
      }

      public  function getArrayProductPhoto() {
        $product = $this->product;
       $rels = array(
          "id"           => $this->id,
          "image"    => $this->image == '' ? '' : md5(date_format($product->created_at, 'm-Y')).'/'.$this->product_id.'/'.$this->image
        );
       return $rels;
      }      
  }
?>