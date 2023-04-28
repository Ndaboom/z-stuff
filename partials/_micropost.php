<?php
                                         <div class="card my-3">
                                      <div class="card-header bg-white border-0 py-2">
                                          <div class="d-flex justify-content-between">
                                              <div class="d-flex justify-content-between">
                                                <a href="#">
                                            <img class="rounded-circle" src="https://picsum.photos/80/80/?random" width="45" alt="" />
                                        </a>
                                        <div class="ml-3">
                                            <div class="h6 m-0">
                                                <a href="#"><?= e($user->name) ?></a> <span style="color: black;"> added a sticker</span>
                                            </div>
                                            <div class="text-muted h8"><?= $micropost->created_at ?><i class="fa fa-globe" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-0 pb-2">
                                <?= nl2br(replace_links(e($micropost->legend))) ?>
                            </div>
                            <img class="card-img-top rounded-0" src="https://picsum.photos/320/250/?random" alt="Card image cap">
                            <div class="card-footer bg-white border-0 p-0">
                                <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                    <div>

                                    </div>
                                    <div class="h7"> 3279 <a href="#"> comentaires</a> 44845 veces <a href="#">compartido</a></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center my-1">
                                    <div class="col">
                                        <button type="button" class="btn btn-fbook btn-block btn-sm"> <i class="fa fa-thumbs-up"
                                                aria-hidden="true"></i>J'aime</button>
                                    </div>
                                    <div class="col">
                                        <button type="button" class="btn btn-fbook btn-block btn-sm"><i class="fa fa-comment"
                                                aria-hidden="true"></i> Comenter</button>
                                    </div>
                                    <div class="col">
                                        <button type="button" class="btn btn-fbook btn-block btn-sm"><i class="fa fa-share"
                                                aria-hidden="true"></i>Partager</button>
                                    </div>
                                </div>
                            </div>
                        </div>
