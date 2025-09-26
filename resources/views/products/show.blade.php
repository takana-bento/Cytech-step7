<x-app-layout>
    <x-slot name="header">
    </x-slot>
    
    <!-- ページ全体：商品詳細画面 -->
    <div class="bg-white min-h-screen py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-24">

            <!-- ページタイトル -->
            <h2 class="font-normal text-4xl mb-12 text-gray-800 leading-tight">
                商品情報詳細画面
            </h2>

            <!-- 商品情報コンテナ -->
            <div class="bg-white border border-black p-16 flex flex-col w-[700px] mx-auto">

                <!-- 商品ID -->
                <div class="flex items-center text-3xl mb-6 w-full">
                    <span class="w-48 italic">ID.</span>
                    <span>{{ $product->id }}.</span>
                </div>

                <!-- 商品画像 -->
                <div class="flex items-center text-3xl mb-6 w-full">
                    <span class="w-48">商品画像</span>
                    @if($product->img_path)
                        <img
                            src="{{ asset('storage/' . $product->img_path) }}"
                            alt="商品画像"
                            class="w-56 h-auto rounded-lg"
                        >
                    @else
                        <span>画像なし</span>
                    @endif
                </div>

                <!-- 商品名 -->
                <div class="flex items-center text-3xl mb-6 w-full">
                    <span class="w-48">商品名</span>
                    <span>{{ $product->product_name }}</span>
                </div>

                <!-- 会社名 -->
                <div class="flex items-center text-3xl mb-6 w-full">
                    <span class="w-48">メーカー名</span>
                    <span>{{ $product->company->company_name ?? '-' }}</span>
                </div>

                <!-- 価格 -->
                <div class="flex items-center text-3xl mb-6 w-full">
                    <span class="w-48">価格</span>
                    <span>{{ number_format($product->price) }} 円</span>
                </div>

                <!-- 在庫数 -->
                <div class="flex items-center text-3xl mb-6 w-full">
                    <span class="w-48">在庫数</span>
                    <span>{{ $product->stock }}</span>
                </div>

                <!-- コメント -->
                <div class="flex items-start text-3xl mb-12 w-full">
                    <label class="w-48">コメント</label>
                    <div class="border border-gray-400 text-2xl rounded px-3 py-2 w-96 min-h-[5.5rem] leading-relaxed product-comment"
                    >
                        {{ $product->comment }}
                    </div>
                </div>

                <!-- 編集・戻るボタン -->
                <div class="flex gap-16 mt-6">
                    <!-- 編集ボタン -->
                    <a
                        href="{{ route('products.edit', ['product' => $product->id, 'page' => request()->get('page', 1)]) }}"
                        class="bg-orange-500 hover:bg-gray-500 text-gray px-6 py-1 rounded"
                    >
                        編集
                    </a>
                    <!-- 一覧へ戻るボタン -->
                    <a
                        href="{{ route('products.index', ['page' => request()->get('page', 1)]) }}"
                        class="bg-cyan-500 hover:bg-gray-500 text-gray px-6 py-1 rounded"
                    >
                        戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>