<x-app-layout>
    <x-slot name="header"></x-slot>

    <!-- ページ全体：商品新規登録画面 -->
    <div class="bg-white min-h-screen py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-24">

            <!-- ページタイトル -->
            <h2 class="font-normal text-4xl mb-12 text-gray-800 leading-tight">
                商品新規登録画面
            </h2>

            <!-- フォームコンテナ -->
            <div class="bg-white border border-black p-16 flex flex-col items-center w-[700px] mx-auto">

                <!-- 商品登録フォーム -->
                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- 商品名入力 -->
                    <div class="flex items-center text-3xl mb-6">
                        <label class="w-48">
                            商品名 
                        <span class="text-red-500 text-lg font-mono align-super">*</span></label>
                        <div class="flex flex-col w-96">
                            <input 
                                type="text" name="product_name" value="{{ old('product_name', $product->product_name ?? '') }}"
                                class="border border-gray-400 rounded px-3 py-2 w-96 focus:outline-none focus:border-gray-500"
                            >
                            <div class="form__error @if($errors->has('product_name')) visible @endif">
                                @foreach ($errors->get('product_name') as $message)
                                    {{ $message }}
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 会社選択 -->
                    <div class="flex items-center text-3xl mb-6">
                        <label class="w-48">
                            メーカー名
                            <span class="text-red-500 text-lg font-mono align-super">*</span>
                        </label>
                        <div class="flex flex-col w-96 relative">
                            <select name="company_id"
                                    class="appearance-none border border-gray-400 rounded px-3 py-2 w-full focus:outline-none focus:border-gray-500 pr-8">
                                <option value="">選択してください</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>
                                        {{ $company->company_name }}
                                    </option>
                                @endforeach
                            </select>
                            <!-- ▽アイコン -->
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-xl text-gray-700">▽</span>

                            <div class="form__error @if($errors->has('company_id')) visible @endif">
                                @foreach ($errors->get('company_id') as $message)
                                    {{ $message }}
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 価格入力 -->
                    <div class="flex items-center text-3xl mb-6">
                        <label class="w-48">
                            価格 
                            <span class="text-red-500 text-lg font-mono align-super">*</span>
                        </label>
                        <div class="flex flex-col w-96">
                            <input
                                type="number" name="price" value="{{ old('price', $product->price ?? '') }}"
                                class="border border-gray-400 rounded px-3 py-2 w-96 focus:outline-none focus:border-gray-500"
                            >
                            <div class="form__error @if($errors->has('price')) visible @endif">
                                @foreach ($errors->get('price') as $message)
                                    {{ $message }}
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 在庫数入力 -->
                    <div class="flex items-center text-3xl mb-6">
                        <label class="w-48">
                            在庫数
                            <span class="text-red-500 text-lg font-mono align-super">*</span>
                        </label>
                        <div class="flex flex-col w-96">
                            <input
                                type="number" name="stock" value="{{ old('stock') }}"
                                class="border border-gray-400 rounded px-3 py-2 w-96 focus:outline-none focus:border-gray-500"
                            >
                            <div class="form__error @if($errors->has('stock')) visible @endif">
                                @foreach ($errors->get('stock') as $message)
                                    {{ $message }}
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- コメント入力 -->
                    <div class="flex items-center text-3xl mb-6">
                        <label class="w-48">
                            コメント
                        </label>
                        <textarea
                            name="comment" rows="2"
                            class="border border-gray-400 rounded px-3 py-2 w-96 focus:outline-none focus:border-gray-500">{{ old('comment') }}</textarea>
                    </div>

                    <!-- 商品画像アップロード -->
                    <div class="flex items-center text-3xl mb-24">
                        <label class="w-48">商品画像</label>
                        <label class="cursor-pointer bg-gray-300 hover:bg-gray-500 text-gray-900 px-12 py-2 rounded-sm text-base">
                            ファイルを選択
                            <input type="file" name="img_path" id="imageInput" class="hidden" accept="image/*">
                            </label>
                    </div>

                    <!-- 選択されたファイル名表示 -->
                    <div id="fileName" class="mt-4 text-lg text-gray-700"></div>

                    <!-- プレビュー表示 -->
                    <div id="previewContainer" class="mt-4 hidden">
                        <img id="previewImage" src="" alt="プレビュー" class="max-w-xs rounded-lg border border-gray-300">
                    </div>

                    <!-- 登録・戻るボタン -->
                    <div class="flex gap-12 mt-6">
                        <button type="submit" class="bg-orange-500 hover:bg-gray-500 text-gray px-2 py-1 rounded">
                            新規登録
                        </button>
                        <a href="{{ route('products.index') }}" class="bg-cyan-500 hover:bg-gray-500 text-gray px-6 py-1 rounded">
                            戻る
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>