<?php

require 'helpers.php';

$is_auth = rand(0, 1);
$user_name = 'Мое имя'; // укажите здесь ваше имя

$post_data = [
    [
        'header' => 'Цитата',
        'type' => 'post-quote',
        'content' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
        'cite-author' => 'Неизвестный Автор',
        'user-name' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg',
    ],
    [
        'header' => 'Игра престолов',
        'type' => 'post-text',
        'content' => 'Не могу дождаться начала финального сезона своего любимого сериала!',
        'user-name' => 'Владик',
        'avatar' => 'userpic.jpg',
    ],
    [
        'header' => 'Наконец, обработал фотки!',
        'type' => 'post-photo',
        'content' => 'rock-medium.jpg',
        'user-name' => 'Виктор',
        'avatar' => 'userpic-mark.jpg',
    ],
    [
        'header' => 'Моя мечта',
        'type' => 'post-photo',
        'content' => 'coast-medium.jpg',
        'user-name' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg',
    ],
    [
        'header' => 'Лучшие курсы',
        'type' => 'post-link',
        'content' => 'www.htmlacademy.ru',
        'user-name' => 'Владик',
        'avatar' => 'userpic.jpg',
    ],
    [
        'header' => 'PHP жив? 5 причин учиться бэкенд-разработке в 2021',
        'type' => 'post-video',
        'content' => 'https://www.youtube.com/watch?v=mfozVdjyyRs',
        'user-name' => 'Владик',
        'avatar' => 'userpic.jpg',
    ],
    [
        'header' => 'Пример большого кол-ва символов',
        'type' => 'post-text',
        'content' => 'С другой стороны начало повседневной работы по формированию позиции позволяет выполнять важные задания по разработке направлений прогрессивного развития. Идейные соображения высшего порядка, а также постоянное информационно-пропагандистское обеспечение нашей деятельности представляет собой интересный эксперимент проверки модели развития. Не следует, однако забывать, что дальнейшее развитие различных форм деятельности требуют от нас анализа форм развития. Задача организации, в особенности же постоянное информационно-пропагандистское обеспечение нашей деятельности требуют от нас анализа системы обучения кадров, соответствует насущным потребностям. Идейные соображения высшего порядка, а также сложившаяся структура организации играет важную роль в формировании соответствующий условий активизации. Не следует, однако забывать, что постоянный количественный рост и сфера нашей активности представляет собой интересный эксперимент проверки модели развития. С другой стороны дальнейшее развитие различных форм деятельности играет важную роль в формировании направлений прогрессивного развития. Идейные соображения высшего порядка, а также укрепление и развитие структуры влечет за собой процесс внедрения и модернизации направлений прогрессивного развития. Задача организации, в особенности же постоянное информационно-пропагандистское обеспечение нашей деятельности играет важную роль в формировании форм развития. Не следует, однако забывать, что постоянное информационно-пропагандистское обеспечение нашей деятельности позволяет оценить значение систем массового участия. Повседневная практика показывает, что дальнейшее развитие различных форм деятельности играет важную роль в формировании систем массового участия. Задача организации, в особенности же постоянный количественный рост и сфера нашей активности позволяет выполнять важные задания по разработке существенных финансовых и административных условий. Равным образом дальнейшее развитие различных форм деятельности в значительной степени обуславливает создание системы обучения кадров, соответствует насущным потребностям. Товарищи! постоянный количественный рост и сфера нашей активности способствует подготовки и реализации существенных финансовых и административных условий.',
        'user-name' => 'Владик',
        'avatar' => 'userpic.jpg',
    ],
];

foreach ($post_data as $id => &$post) {
    $post_date = generate_random_date($id);
    $post['date'] = $post_date;
}

$page_main_content = include_template('index.php', ['post_data' => $post_data]);

$page_layout = include_template('layout.php', [
    'page_title' => 'Readme - популярное',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'page_main_content' => $page_main_content,
    'page_main_class' => 'popular',
]);

print($page_layout);
