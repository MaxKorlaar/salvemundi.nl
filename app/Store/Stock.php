<?php

    namespace App\Store;

    use Carbon\Carbon;
    use Eloquent;
    use Exception;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    /**
 * App\Store\Stock
 *
 * @mixin Eloquent
 * @property int                                                                   $id
 * @property string|null                                                           $name
 * @property string|null                                                           $slug
 * @property string|null                                                           $description
 * @property int                                                                   $in_stock
 * @property int                                                                   $store_item_id
 * @property Carbon|null                                                   $created_at
 * @property Carbon|null                                                   $updated_at
 * @method static Builder|Stock whereCreatedAt($value)
 * @method static Builder|Stock whereDescription($value)
 * @method static Builder|Stock whereId($value)
 * @method static Builder|Stock whereInStock($value)
 * @method static Builder|Stock whereName($value)
 * @method static Builder|Stock whereSlug($value)
 * @method static Builder|Stock whereStoreItemId($value)
 * @method static Builder|Stock whereUpdatedAt($value)
 * @property float                        $price
 * @property-read Item                    $item
 * @method static Builder|Stock newModelQuery()
 * @method static Builder|Stock newQuery()
 * @method static Builder|Stock query()
 * @method static Builder|Stock wherePrice($value)
 * @property-read Collection|StockImage[] $images
 */
    class Stock extends Model {
        protected $table = 'store_stock';
        protected $fillable = ['name', 'description', 'price', 'in_stock'];
        protected $visible = ['name', 'description', 'id', 'price', 'in_stock'];

        /**
         * @return BelongsTo
         */
        public function item() {
            return $this->belongsTo(Item::class, 'store_item_id');
        }

        /**
         * @return HasMany
         */
        public function images() {
            return $this->hasMany(StockImage::class, 'store_stock_id');
        }

        /**
         * @return array
         */
        public function jsonSerialize() {
            $return = $this->toArray();
            foreach ($this->images as $image) {
                $return['images'][] = [
                    'name'     => $image->image_name,
                    'url'      => route('store.image', ['slug' => $this->item->slug, 'stock' => $this, 'image' => $image]),
                    'full_url' => route('store.image_full', ['slug' => $this->item->slug, 'stock' => $this, 'image' => $image])
                ];
            }

            return $return;
        }

        /**
         * Delete the model from the database.
         *
         * @return bool|null
         *
         * @throws Exception
         */
        public function delete() {
            $this->images->each(
                function ($image) {
                    $image->delete();
                });
            return parent::delete();
        }
    }
