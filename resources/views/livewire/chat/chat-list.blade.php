<div
    x-data="{type:'all',query:@entangle('query')}"
    x-init="

    setTimeout(()=>{

        // Tìm phần tử DOM có ID là 'conversation-' cộng với giá trị của biến 'query'
        conversationElement = document.getElementById('conversation-'+query);

        // Cuộn đến phần tử này nếu nó tồn tại
        if(conversationElement)
        {
            conversationElement.scrollIntoView({'behavior':'smooth'});
        }

    },200); 

    Echo.private('users.{{Auth()->User()->id}}')
    .notification((notification)=>{
        if(notification['type']== 'App\\Notifications\\MessageRead' || notification['type']== 'App\\Notifications\\MessageSent')
        {
            window.Livewire.dispatch('refresh');
        }
    });

    "
 class="flex flex-col transition-all h-full overflow-hidden">
    <header class="px-3 z-10 bg-white sticky top-0 w-full py-2">
        <div class="border-b justify-between flex items-center pb-2">
            <div class="flex items-center gap-2">
                <h5 class="font-bold text-2xl">Đoạn chat</h5>
            </div>
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                </svg>                  
            </button>
        </div>
        {{-- Filters --}}
        <div class="flex items-center gap-3 overflow-x-scroll p-2 bg-white">
            <button @click="type='all'" :class="{'bg-blue-100 border-0 text-black':type=='all'}" class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5 border">
                Tất cả
            </button>
            <button @click="type='friend'" :class="{'bg-blue-100 border-0 text-black':type=='friend'}" class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5 border">
                Bạn bè
            </button>
        </div>
    </header>

    <main class="overflow-y-scroll overflow-hidden grow h-full relative" style="contain:content">
        {{-- Chat list --}}
        <ul class="p-2 grid w-full space-y-2">
            @if ($conversations)
                
            @foreach ($conversations as $key=> $conversation)
            <li 
            id="conversation-{{$conversation->id}}" wire:key="{{$conversation->id}}"
            class="pt-3 hover:bg-gray-50 rounded-2xl dark:hover:bg-gray-700/70 transition-colors duration-150 flex relative w-full cursor-pointer px-2 mb-1 border {{$conversation->id==$selectedConversation?->id ? 'bg-gray-200/70':''}}">
                <a href="#" class="shrink-0 w-12 h-12">
                    <img src="https://randomuser.me/api/portraits/women/{{$key}}.jpg" alt="image" class="w-10 h-10 rounded-full shadow-lg">
                </a>

                <aside class="grid grid-cols-12 w-full">
                    <a href="{{route('chat',$conversation->id)}}" class="col-span-11 border-b pb-2 border-gray-200 relative overflow-hidden truncate leading-5 w-full flex-nowrap p-1">
                        {{-- Name and date --}}
                        <div class="flex justify-between w-full items-center">

                            <h6 class="truncate font-medium tracking-wider text-gray-900">
                                {{$conversation->getReceiver()->name}}
                            </h6>

                            {{-- <small class="text-gray-700">{{$conversation?->messages?->last()?->created_at?->shortAbsoluteDiffForHumans()}}</small> --}}

                        </div>
                        {{-- Message --}}
                        <div class="flex gap-x-2 items-center">
                            @if ($conversation?->messages?->last()?->sender_id==auth()->id())



                            @if ($conversation->isLastMessageReadByUser())
                                {{-- double tick  --}}
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                        <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z"/>
                                        <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z"/>
                                    </svg>
                                </span>
                            @else

                                {{-- single tick  --}}
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                    </svg>
                                </span>
                                    
                            @endif
                            @endif

                            <p class="grow truncate text-sm font-[100]">
                                @if ($conversation->unreadMessagesCount()>0)
                                    <b class="font-bold">{{$conversation->messages?->last()?->body??' '}}</b>
                                @else
                                    {{$conversation->messages?->last()?->body??' '}}
                                @endif
                            </p>

                            @if ($conversation->unreadMessagesCount()>0)

                                <span class="font-bold p-px px-2 text-xs shrink-0 rounded-full bg-blue-500 text-white">
                                    {{$conversation->unreadMessagesCount()}}
                                </span>
                                
                            @endif
                        </div>

                    </a>

                    <div class="col-span-1 flex flex-col text-center my-auto z-30">
                        <div align="right" width="48">
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical w-5 h-5 text-gray-700" viewBox="0 0 16 16">
                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                </svg>
                            </button>
                        </div>

                    </div>
                    
                </aside>
            </li>
            @endforeach

            @else
                <li>Bạn chưa có cuộc trò chuyện nào</li>
            @endif
        </ul>
    </main>
</div>
