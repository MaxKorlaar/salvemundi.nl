<?php

    namespace App\Http\Controllers\Admin\Store;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Admin\Store\CreateItem;
    use App\Store\Item;
    use Illuminate\Http\Request;

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
         * @param  \Illuminate\Http\Request $request
         * @param  int                      $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id) {
            //
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
