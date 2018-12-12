<?php

    namespace App\Http\Controllers\Admin\Store;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Admin\Store\CreateItem;
    use App\Http\Requests\Admin\Store\UpdateItem;
    use App\Store\Item;

    /**
     * Class ItemController
     *
     * @package App\Http\Controllers\Admin\Store
     */
    class ItemController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index() {
            return view('admin.store.items.index', [
                'items' => Item::with(['stock'])->get()
            ]);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create() {
            return view('admin.store.items.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param CreateItem $request
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Throwable
         */
        public function store(CreateItem $request) {
            $item       = new Item($request->all());
            $item->slug = str_slug($item->name);
            $item->saveOrFail();
            return redirect()->route('admin.store.items.show', ['item' => $item]);
        }

        /**
         * Display the specified resource.
         *
         * @param Item $item
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function show(Item $item) {
            return redirect()->route('admin.store.items.edit', ['item' => $item]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param Item $item
         *
         * @return \Illuminate\Http\Response
         */
        public function edit(Item $item) {
            return view('admin.store.items.edit', ['item' => $item]);

        }

        /**
         * Update the specified resource in storage.
         *
         * @param UpdateItem $request
         * @param Item       $item
         *
         * @return \Illuminate\Http\Response
         */
        public function update(UpdateItem $request, Item $item) {
            $item->slug = str_slug($item->name);
            $item->update($request->all());
            return redirect()->route('admin.store.items.edit', ['item' => $item]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param Item $item
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Exception
         */
        public function destroy(Item $item) {
            $item->delete();
            return redirect()->route('admin.store.items.index');
        }

        /**
         * @param Item $item
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getDeleteConfirmation(Item $item) {
            return view('admin.store.items.delete', ['item' => $item]);
        }
    }
