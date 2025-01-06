<link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
<style>
    .group:hover .group-hover\:block {
        display: block !important;
    }
</style>
<div class="flex justify-between items-center mb-5">
    <div class="flex-1 text-sm" style="color: var(--text-color);">檔案名稱</div>
    <div class="flex-1 text-sm" style="color: var(--text-color);">檔案大小</div>
    <div class="flex-1 text-sm flex items-center" style="color: var(--text-color);">
        處理狀態
        <span class="ml-2 relative group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
            </svg>
            <div class="absolute left-0 bottom-full mb-2 hidden group-hover:block w-64 p-2 rounded-md bg-gray-700 text-white text-xs shadow-lg">
                同步至語言模型的狀態，處理完成後可測試。
            </div>
        </span>
    </div>
    <div class="flex-1 text-sm flex items-center" style="color: var(--text-color);">
        處理完成時間
        <span class="ml-2 relative group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
            </svg>
            <div class="absolute left-0 bottom-full mb-2 hidden group-hover:block w-64 p-2 rounded-md bg-gray-700 text-white text-xs shadow-lg">
                系統完成同步檔案至語言模型的時間。
            </div>
        </span>
    </div>
    <div class="flex-1 text-sm" style="color: var(--text-color);">上傳者</div>
</div>
@if (!empty($files))
    @forelse ($files as $file)
        <div class="p-4 rounded-lg shadow-lg mb-4 border border-gray-200"
             style="background-color: var(--background-color);">
            <div class="flex justify-between items-center mb-5">
                <!-- 檔案名稱 -->
                <div class="flex-1 text-sm" style="color: var(--text-color);">
                    {{ $file['file_name'] }}
                </div>

                <!-- 檔案大小 -->
                <div class="flex-1 text-sm" style="color: var(--text-color);">
                    {{ number_format($file['size'] / 1024 / 1024, 2) }} MB
                </div>

                <!-- 處理狀態 -->
                <div class="flex-1 text-sm" style="color: var(--text-color);">
                    {{ $file['status_label'] }}
                </div>

                <!-- 處理完成時間 -->
                <div class="flex-1 text-sm" style="color: var(--text-color);">
                    {{ $file['processed_at'] }}
                </div>

                <!-- 上傳者 -->
                <div class="flex-1 text-sm" style="color: var(--text-color);">
                    {{ $file['admin']->name }}
                </div>
            </div>
        </div>
    @empty
        <div class="p-4 rounded-lg border border-gray-300" style="background-color: var(--background-color);">
            <p class="text-gray-500" style="color: var(--text-color);">尚未上傳檔案</p>
        </div>
    @endforelse
@endif
