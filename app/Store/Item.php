<?php

    namespace App\Store;

    use Carbon\Carbon;
    use Eloquent;
    use Exception;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    /**
 * App\Store\Item
 *
 * @mixin Eloquent
 * @property int                                                              $id
 * @property string                                                           $name
 * @property string|null                                                      $slug
 * @property string|null                                                      $description
 * @property Carbon|null                                   $created_at
 * @property Carbon|null                                   $updated_at
 * @method static Builder|Item whereCreatedAt($value)
 * @method static Builder|Item whereDescription($value)
 * @method static Builder|Item whereId($value)
 * @method static Builder|Item whereName($value)
 * @method static Builder|Item whereSlug($value)
 * @method static Builder|Item whereUpdatedAt($value)
 * @property-read Collection|Stock[] $stock
 * @method static Builder|Item newModelQuery()
 * @method static Builder|Item newQuery()
 * @method static Builder|Item query()
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
         * @return HasMany
         */
        public function stock() {
            return $this->hasMany(Stock::class, 'store_item_id');
        }

        /**
         * Delete the model from the database.
         *
         * @return bool|null
         *
         * @throws Exception
         */
        public function delete() {
            $this->stock->each(
                function ($stock) {
                    /** @var Stock $stock */
                    $stock->delete();
                });
            return parent::delete();
        }

    }
