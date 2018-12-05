<?php

    namespace App\Store;

    use Illuminate\Database\Eloquent\Model;

    /**
 * App\Store\Stock
 *
 * @mixin \Eloquent
 * @property int                  $id
 * @property string|null          $name
 * @property string|null          $slug
 * @property string|null          $description
 * @property int                  $in_stock
 * @property int                  $store_item_id
 * @property \Carbon\Carbon|null  $created_at
 * @property \Carbon\Carbon|null  $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereInStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereStoreItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereUpdatedAt($value)
 * @property float                $price
 * @property-read \App\Store\Item $item
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock query()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock wherePrice($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Store\StockImage[] $images
 */
    class Stock extends Model {
        protected $table = 'store_stock';
        protected $fillable = ['name', 'description', 'price', 'in_stock'];
        protected $visible = ['name', 'description', 'id', 'price', 'in_stock'];

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function item() {
            return $this->belongsTo(Item::class);
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function images() {
            return $this->hasMany(StockImage::class, 'store_stock_id');
        }
    }
