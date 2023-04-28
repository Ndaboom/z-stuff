<div class="sidebar_inner" data-simplebar>
                <ul>
                    <li <?= $page == 'feed' ? 'class="active"' : '' ?>><a href="feed.php?id=<?= get_session('user_id') ?>"> 

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-600"> 
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span> <?= $menu['feed'][$_SESSION['locale']] ?> </span> </a> 
                    </li>

                    <li><a href="forums.php?p=all_forums"> 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-600">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path>
                        </svg>
                       <span> <?= $menu['forums'][$_SESSION['locale']] ?></span> </a> 
                    </li>

                    <li <?= $page == 'online_tv' ? 'class="active"' : '' ?> ><a href="online_tv.php">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" class="feather feather-tv"><rect x="2" y="7" width="20" height="15"></rect><polyline points="17 2 12 7 7 2"></polyline></svg>

                        <span> Tv</span></a> 

                    </li> 

                    <li <?= $page == 'explorer' ? 'class="active"' : '' ?>><a href="explorer.php"> 

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-500">

                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />

                        </svg><span> <?= $long_text['explore'][$_SESSION['locale']] ?> </span></a> 

                    </li>

                    <li><a href="articles.php">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>

                        <span> <?= $menu['blogs'][$_SESSION['locale']] ?> </span></a>

                    </li> 

                    <li <?= $page == 'events_list' ? 'class="active"' : '' ?>><a href="events.php">               

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg><span>  Events </span></a> 
                    </li> 
                    <li <?= $page == 'games' ? 'class="active"' : '' ?>><a href="games.php"> 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#2563EB">
                            <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z"></path>
                        </svg>  <span>  <?= $menu['games'][$_SESSION['locale']] ?> </span></a> 
                    </li>
                </ul>
                <hr>
                <div class="footer-links">
                    <a href="blog.php">Blog </a>•
                    <a href="mailto:info@zungvi.com"><?= $menu['support'][$_SESSION['locale']] ?></a>•
                    <a href="mailto:info@zungvi.com"><?= $menu['support'][$_SESSION['locale']] ?></a>•
                    <a href="store/android-app.apk">Android app</a>•
                    <a href="terms.php"><?= $menu['terms'][$_SESSION['locale']] ?></a>• <b><?= $long_text['languages'][$_SESSION['locale']] ?></b> : <a href="index.php?lang=fr">Francais</a>,<a href="index.php?lang=en">Anglais</a>,<a href="index.php?lang=sw">Swahili</a>
                </div>
            </div>

