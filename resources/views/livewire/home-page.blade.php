<div class="flex justify-center">
    @guest
        <main class="container mx-auto mt-8 p-4">
            <section class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-3xl font-semibold mb-4">Chào mừng đến với Messeger</h2>
                <p class="text-gray-700 mb-4">
                    Trang web của chúng tôi sử dụng Livewire và Tailwind CSS. Livewire giúp tạo ứng dụng tương tác mà không cần nhiều JavaScript, giữ mã nguồn gọn gàng. Tailwind CSS mang lại giao diện đẹp và tương thích trên mọi thiết bị, cho phép người dùng gửi và nhận tin nhắn tức thì một cách thuận tiện.
                </p>
                <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-500 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/login">
                    Bắt đầu
                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="m9 18 6-6-6-6" />
                    </svg>
                  </a>
            </section>
        </main>
    @endguest

    @auth
        <div>
            <img src="https://randomuser.me/api/portraits/women/{{ auth()->id() }}.jpg" alt="image" class="w-60 h-60 mb-2 5 rounded-full shadow-lg">
            <p class="text-center text-3xl font-bold">{{ auth()->user()->name }}</p>
        </div>
    @endauth
</div>