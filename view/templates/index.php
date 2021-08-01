<?php

/**
 * @var array $post_data
*/

?>

<div class="container">
    <h1 class="page__title page__title--popular">Популярное</h1>
</div>

<div class="popular container">

    <div class="popular__filters-wrapper">

        <div class="popular__sorting sorting">
            <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
            <ul class="popular__sorting-list sorting__list">
                <li class="sorting__item sorting__item--popular">
                    <a class="sorting__link sorting__link--active" href="#">
                        <span>Популярность</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
                <li class="sorting__item">
                    <a class="sorting__link" href="#">
                        <span>Лайки</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
                <li class="sorting__item">
                    <a class="sorting__link" href="#">
                        <span>Дата</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>

        <div class="popular__filters filters">
            <b class="popular__filters-caption filters__caption">Тип контента:</b>
            <ul class="popular__filters-list filters__list">
                <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                    <a class="filters__button filters__button--ellipse filters__button--all filters__button--active" href="#">
                        <span>Все</span>
                    </a>
                </li>
                <li class="popular__filters-item filters__item">
                    <a class="filters__button filters__button--photo button" href="#">
                        <span class="visually-hidden">Фото</span>
                        <svg class="filters__icon" width="22" height="18">
                            <use xlink:href="#icon-filter-photo"></use>
                        </svg>
                    </a>
                </li>
                <li class="popular__filters-item filters__item">
                    <a class="filters__button filters__button--video button" href="#">
                        <span class="visually-hidden">Видео</span>
                        <svg class="filters__icon" width="24" height="16">
                            <use xlink:href="#icon-filter-video"></use>
                        </svg>
                    </a>
                </li>
                <li class="popular__filters-item filters__item">
                    <a class="filters__button filters__button--text button" href="#">
                        <span class="visually-hidden">Текст</span>
                        <svg class="filters__icon" width="20" height="21">
                            <use xlink:href="#icon-filter-text"></use>
                        </svg>
                    </a>
                </li>
                <li class="popular__filters-item filters__item">
                    <a class="filters__button filters__button--quote button" href="#">
                        <span class="visually-hidden">Цитата</span>
                        <svg class="filters__icon" width="21" height="20">
                            <use xlink:href="#icon-filter-quote"></use>
                        </svg>
                    </a>
                </li>
                <li class="popular__filters-item filters__item">
                    <a class="filters__button filters__button--link button" href="#">
                        <span class="visually-hidden">Ссылка</span>
                        <svg class="filters__icon" width="21" height="18">
                            <use xlink:href="#icon-filter-link"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="popular__posts">

        <?php foreach ($post_data as $post): ?>
            <article class="popular__post post <?= esc($post['type']); ?>">
                <header class="post__header">
                    <h2><?= esc($post['header']); ?></h2>
                </header>

                <div class="post__main">
                    <!--здесь содержимое карточки-->
                    <?php if ($post['type'] === 'post-quote'): ?>
                        <blockquote>
                            <p><?= esc($post['content']); ?></p>
                            <cite><?= esc($post['cite-author']); ?></cite>
                        </blockquote>
                    <?php elseif ($post['type'] === 'post-text'): ?>
                        <p><?= $received_text = crop_text(esc($post['content'])); ?></p>
                        <?php if ($received_text !== $post['content']): ?>
                            <a class="post-text__more-link" href="#">Читать далее</a>
                        <?php endif; ?>
                    <?php elseif ($post['type'] === 'post-photo'): ?>
                        <div class="post-photo__image-wrapper">
                            <img src="img/<?= esc($post['content']); ?>" alt="Фото от пользователя <?= esc($post['user-name']); ?>" width="360" height="240">
                        </div>
                    <?php elseif ($post['type'] === 'post-link'): ?>
                        <div class="post-link__wrapper">
                            <a class="post-link__external" href="//<?= esc($post['content']); ?>" title="Перейти по ссылке <?= esc($post['content']); ?>">
                                <div class="post-link__info-wrapper">
                                    <div class="post-link__icon-wrapper">
                                        <img src="//www.google.com/s2/favicons?domain=<?= esc($post['content']); ?>" alt="Иконка <?= esc($post['content']); ?>">
                                    </div>
                                    <div class="post-link__info">
                                        <h3><?= esc($post['header']); ?></h3>
                                    </div>
                                </div>
                                <span><?= esc($post['content']); ?></span>
                            </a>
                        </div>
                    <?php elseif ($post['type'] === 'post-video'): ?>
                        <div class="post-video__block">
                            <div class="post-video__preview">
                                <?= embed_youtube_cover(esc($post['content'])); ?>
                            </div>
                            <a href="/" class="post-video__play-big button">
                                <svg class="post-video__play-big-icon" width="14" height="14">
                                    <use xlink:href="#icon-video-play-big"></use>
                                </svg>
                                <span class="visually-hidden">Запустить проигрыватель</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <footer class="post__footer">
                    <div class="post__author">
                        <a class="post__author-link" href="#" title="Автор">
                            <div class="post__avatar-wrapper">
                                <!--укажите путь к файлу аватара-->
                                <img class="post__author-avatar" src="img/<?= esc($post['avatar']); ?>" alt="Аватар пользователя <?= esc($post['user-name']); ?>">
                            </div>
                            <div class="post__info">
                                <b class="post__author-name"><?= esc($post['user-name']); ?></b>
                                <time class="post__time" datetime="">дата</time>
                            </div>
                        </a>
                    </div>
                    <div class="post__indicators">
                        <div class="post__buttons">
                            <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                <svg class="post__indicator-icon" width="20" height="17">
                                    <use xlink:href="#icon-heart"></use>
                                </svg>
                                <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                    <use xlink:href="#icon-heart-active"></use>
                                </svg>
                                <span>0</span>
                                <span class="visually-hidden">количество лайков</span>
                            </a>
                            <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                <svg class="post__indicator-icon" width="19" height="17">
                                    <use xlink:href="#icon-comment"></use>
                                </svg>
                                <span>0</span>
                                <span class="visually-hidden">количество комментариев</span>
                            </a>
                        </div>
                    </div>
                </footer>
            </article>
        <?php endforeach; ?>

    </div>
</div>
