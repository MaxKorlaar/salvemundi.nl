<?php

    namespace App\Http\Controllers\Admin\Store;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Admin\Store\CreateStock;
    use App\Http\Requests\Admin\Store\UpdateStock;
    use App\Store\Item;
    use App\Store\Stock;
    use App\Store\StockImage;
    use Illuminate\Http\Request;
    use Illuminate\Http\UploadedFile;

    /**
     * Class StockController
     *
     * @package App\Http\Controllers\Admin\Store
     */
    class StockController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index() {
            //
        }

        /**
         * Show the form for creating a new resource.
         *
         * @param Item $item
         *
         * @return \Illuminate\Http\Response
         */
        public function create(Item $item) {
            return view('admin.store.items.stock.create', ['item' => $item]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param CreateStock $request
         *
         * @param Item        $item
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function store(CreateStock $request, Item $item) {
            $stock = new Stock($request->all());
            $item->stock()->save($stock);
            /** @var UploadedFile $image */
            foreach ($request->file('images') as $image) {
                $filename = str_slug($item->id . '-' . $item->slug . '-' . $stock->name . '-' . $image->getClientOriginalName() . '-' . time()) . '.' . $image->extension();
                $image->storeAs('store_photos', $filename);
                $stockImage = new StockImage([
                    'image_name' => $filename
                ]);
                $stock->images()->save($stockImage);
            }
            return redirect()->route('admin.store.items.stock.show', ['item' => $item, 'stock' => $stock]);
        }

        /**
         * Display the specified resource.
         *
         * @param Item  $item
         * @param Stock $voorraad
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function show(Item $item, Stock $voorraad) {
            return redirect()->route('admin.store.items.stock.edit', ['item' => $item, 'stock' => $voorraad]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param Item  $item
         * @param Stock $voorraad
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function edit(Item $item, Stock $voorraad) {
            return view('admin.store.items.stock.edit', ['item' => $item, 'stock' => $voorraad]);
        }

        /**
         * @param Item       $item
         * @param Stock      $voorraad
         * @param StockImage $image
         *
         * @return mixed
         */
        public function getImage(Item $item, Stock $voorraad, StockImage $image) {
            return $image->getCachedImage(true)->fit(300, 300)->response();
        }

        /**
         * @param Item       $item
         * @param Stock      $voorraad
         * @param StockImage $image
         *
         * @return mixed
         */
        public function getImageFull(Item $item, Stock $voorraad, StockImage $image) {
            return $image->getCachedImage(true)->response();
        }

        /**
         * Update the specified resource in storage.
         *
         * @param UpdateStock $request
         * @param Item        $item
         * @param Stock       $voorraad
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Exception
         */
        public function update(UpdateStock $request, Item $item, Stock $voorraad) {
            $voorraad->update($request->all());

            if($request->file('images') !== null) {
                foreach ($voorraad->images as $image) {
                    $image->delete();
                }
                /** @var UploadedFile $image */
                foreach ($request->file('images') as $image) {
                    $filename = str_slug($item->id . '-' . $item->slug . '-' . $voorraad->name . '-' . $image->getClientOriginalName() . '-' . time()) . '.' . $image->extension();
                    $image->storeAs('store_photos', $filename);
                    $stockImage = new StockImage([
                        'image_name' => $filename
                    ]);
                    $voorraad->images()->save($stockImage);
                }
            }

            return redirect()->route('admin.store.items.stock.edit', ['item' => $item, 'stock' => $voorraad]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy($id) {
            //
        }
    }
