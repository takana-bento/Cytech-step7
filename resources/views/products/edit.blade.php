<x-app-layout>
    <x-slot name="header"></x-slot>

    <!-- ページ全体：商品情報編集画面 -->
    <div class="bg-white min-h-screen py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-24">

            <!-- ページタイトル -->
            <h2 class="font-normal text-4xl mb-12 text-gray-800 leading-tight">
            商品情報編集画面
            </h2>

            <!-- フォームコンテナ -->
            <div class="bg-white border border-black p-16 flex flex-col w-[700px] mx-auto">

                <!-- 編集フォーム -->
                <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- 商品ID（表示のみ） -->
                    <div class="flex items-center text-3xl mb-10 w-full">
                        <span class="w-48 italic">ID.</span>
                        <span>{{ $product->id }}.</span>
                    </div>

                    <!-- 商品名 -->
                    <div class="flex items-start text-3xl mb-10 w-full">
                        <label class="w-48">
                            商品名
                            <span class="text-red-500 text-lg font-mono align-super">*</span>
                        </label>
                        <input
                            type="text"
                            name="product_name"
                            value="{{ $product->product_name }}" 
                            class="border border-gray-400 rounded px-3 py-2 w-96 h-14"
                            required
                        >
                    </div>

                    <!-- 会社名 -->
                    <div class="flex items-start text-3xl mb-10 w-full">
                        <label class="w-48">
                            会社名
                            <span class="text-red-500 text-lg font-mono align-super">*</span>
                        </label>
                        <select
                            name="company_id"
                            class="border border-gray-400 rounded px-3 py-2 w-96 h-14"
                        >
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" 
                                    {{ $company->id == $product->company_id ? 'selected' : '' }}
                                >
                                    {{ $company->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 価格 -->
                    <div class="flex items-start text-3xl mb-10 w-full">
                        <label class="w-48">
                            価格
                            <span class="text-red-500 text-lg font-mono align-super">*</span>
                        </label>
                        <input
                            type="number"
                            name="price"
                            value="{{ $product->price }}" 
                            class="border border-gray-400 rounded px-3 py-2 w-96 h-14"
                            required
                        >
                    </div>

                    <!-- 在庫数 -->
                    <div class="flex items-start text-3xl mb-10 w-full">
                        <label class="w-48">
                            在庫数
                            <span class="text-red-500 text-lg font-mono align-super">*</span>
                        </label>
                        <input
                            type="number"
                            name="stock"
                            value="{{ $product->stock }}" 
                            class="border border-gray-400 rounded px-3 py-2 w-96 h-14"
                            required
                        >
                    </div>

                    <!-- コメント -->
                    <div class="flex items-start text-3xl mb-10 w-full">
                        <label class="w-48">コメント</label>
                        <textarea
                            name="comment" 
                            class="border border-gray-400 rounded px-3 py-2 w-96 min-h-[5.5rem]">{{ $product->comment }}</textarea>
                    </div>

                    <!-- 商品画像アップロード -->
                    <div class="flex items-center text-3xl mb-16">
                        <label class="w-48">商品画像</label>
                        <label class="cursor-pointer bg-gray-300 hover:bg-gray-500 text-gray-900  px-12 py-2 rounded-sm text-base">
                            ファイルを選択
                            <input type="file" name="img_path" id="imageInput" class="hidden" accept="image/*">
                        </label>
                    </div>

                    <!-- 既存画像の表示 -->
                    <div class="mt-4 relative">
                        <p class="text-xl">現在の画像</p>
                        @if($product->img_path)
                            <img
                                src="{{ asset('storage/' . $product->img_path) }}" 
                                alt="商品画像"
                                class="w-56 h-auto rounded-lg border border-gray-300 mt-2"
                            >
                        @else
                            <p class="text-gray-500">登録されている画像はありません</p>
                        @endif
                    </div>

                    <!-- 選択されたファイル名 -->
                    <div id="fileName" class="mt-4 text-lg text-gray-700"></div>

                    <!-- プレビュー表示 -->
                    <div id="previewContainer" class="mt-4 hidden">
                    <p class="text-xl">変更後の画像</p>
                        <img
                            id="previewImage"
                            src=""
                            alt="プレビュー"
                            class="w-56 h-auto rounded-lg border border-gray-300"
                        >
                    </div>

                    <!-- 更新・戻るボタン -->
                    <div class="flex gap-16 mt-6">
                        <button
                            type="submit"
                            class="bg-orange-500 hover:bg-gray-500 text-black px-6 py-1 rounded"
                        >
                            更新
                        </button>
                        <a
                            href="{{ route('products.show', ['product' => $product->id, 'page' => request()->get('page', 1)]) }}" 
                            class="bg-cyan-500 hover:bg-gray-500 text-black px-6 py-1 rounded"
                        >
                            戻る
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>