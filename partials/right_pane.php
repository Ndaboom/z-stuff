<div id="offcanvas-chat" uk-offcanvas="flip: true; overlay: true">
        <div class="uk-offcanvas-bar bg-white p-0 w-full lg:w-80">
            <div class="relative pt-5 px-4">
                <h3 class="text-2xl font-bold mb-2"> Chats </h3>
                <div class="absolute right-3 top-4 flex items-center">
                    <button class="uk-offcanvas-close  px-2 -mt-1 relative rounded-full inset-0 lg:hidden blcok" type="button" uk-close></button>
                    <a href="#" uk-toggle="target: #search;animation: uk-animation-slide-top-small">
                        <ion-icon name="search" class="text-2xl hover:bg-gray-100 p-1 rounded-full"></ion-icon>
                    </a>
                    <a href="#">
                        <ion-icon name="cog" class="text-2xl hover:bg-gray-100 p-1 rounded-full"></ion-icon>
                    </a>
                    <a href="#">
                        <ion-icon name="ellipsis-vertical" class="text-2xl hover:bg-gray-100 p-1 rounded-full"></ion-icon>
                    </a>
                </div>
            </div>
            <div class="absolute bg-white z-10 w-full -mt-5 lg:mt-0 transform translate-y-1.5 py-2 border-b items-center flex"
                id="search" hidden>
                <input type="text" placeholder="Search.." class="flex-1">
                <ion-icon name="close-outline" class="text-2xl hover:bg-gray-100 p-1 rounded-full mr-4 cursor-pointer"
                    uk-toggle="target: #search;animation: uk-animation-slide-top-small"></ion-icon>
            </div>
            <nav class="cd-secondary-nav border-b extanded mb-2">
                <ul uk-switcher="connect: #chats-tab; animation: uk-animation-fade">
                    <li class="uk-active"><a class="active" href="#0"> Friends <span> <?= friends_count($_GET['id']) ?> </span></a></li>
                </ul>
            </nav>
            <div class="contact-list px-2 uk-switcher" id="chats-tab">
                <div id="right_pane_users">
    

                </div>

            </div>

        </div>

    </div>