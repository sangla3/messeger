<div class="max-w-6xl mx-auto my-16">
    <h1 style="font-family: cursive" class="text-center mb-5 text-5xl text-blue-600">Mọi người</h1>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 p-2 ">

        @foreach ($users as $key=> $user)
            
        <div class="w-full bg-white border border-gray-200 rounded-lg p-5 shadow">

            <div class="flex flex-col items-center pb-10">

                <img src="https://randomuser.me/api/portraits/women/{{$key}}.jpg" alt="image" class="w-24 h-24 mb-2 5 rounded-full shadow-lg">

                <h5 class="mb-1 text-xl font-medium text-gray-900 " >
                    {{$user->name}}
                </h5>
                <span class="text-sm text-gray-500">{{$user->email}} </span>

                <div class="flex mt-4 space-x-3 md:mt-6">

                    <button class="px-3 py-1 bg-blue-500 hover:bg-blue-700  text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition duration-300 ease-in-out transform hover:scale-105">
                        Kết bạn
                    </button>

                    <button  class="px-3 py-1 bg-rose-500 hover:bg-rose-700  text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition duration-300 ease-in-out transform hover:scale-105" wire:click="message({{$user->id}})" >
                        Nhắn tin
                    </button>

                </div>

            </div>


        </div>

        @endforeach
    </div>
</div>
