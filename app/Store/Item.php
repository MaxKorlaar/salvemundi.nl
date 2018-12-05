<?php

    namespace App\Store;

    use Illuminate\Database\Eloquent\Model;

    /**
 * App\Store\Item
 *
 * @mixin \Eloquent
 * @property int                                                              $id
 * @property string                                                           $name
 * @property string|null                                                      $slug
 * @property string|null                                                      $description
 * @property \Carbon\Carbon|null                                              $created_at
 * @property \Carbon\Carbon|null                                              $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Store\Stock[] $stock
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 */
    class Item extends Model {
        protected $table = 'store_items';
        protected $fillable = ['name', 'description'];
        protected $visible = ['name', 'description', 'id'];

        /**
         * @return mixed
         */
        public function getTotalStockAmount() {
            return $this->stock()->sum('in_stock');
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function stock() {
            return $this->hasMany(Stock::class, 'store_item_id');
        }

    }
