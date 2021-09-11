<?php
/**
 * @var $db
 * @var int $isAuth
 * @var string $userName
 */

require 'bootstrap.php';
require 'model/types.php';

$formData = $_POST ?? null;
$postType = $formData['post-type'] ?? null;
$noValidateFields = [
    'post-type',
    'photo-main',
    'photo-url',
];
$errors = [];

$fieldsMap = [
    "{$postType}-heading" => 'Заголовок',
    "{$postType}-main" => 'Основное содержимое',
    "{$postType}-tags" => 'Теги записи',
];

if (isset($formData)) {
    foreach ($formData as $name => $value) {
        if (!in_array($name, $noValidateFields) && empty($value)) {
            $errors[$name]['name'] = $fieldsMap[$name] ?? null;
            $errors[$name]['title'] = 'Поле не заполнено';
            $errors[$name]['description'] = 'Это поле должно быть заполнено';
        }
    }

    if (!empty($formData[$postType . '-tags'])) {
        $tagsField = $formData[$postType . '-tags'];
        $tagsArray = explode(' ', $tagsField);

        foreach ($tagsArray as $tag) {
            if (mb_strlen($tag) > 255) {
                $errors[$postType . '-tags']['name'] = $fieldsMap[$postType . '-tags'];
                $errors[$postType . '-tags']['title'] = 'Один или больше тегов содержат 255+ символов';
                $errors[$postType . '-tags']['description'] = 'Один тег не может быть больше 255 символов';
            }
        }
    }

    $isPhoto = $_FILES['photo-main'] ?? null;

    if ($isPhoto && $isPhoto['error'] === 0) {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileName = $_FILES['photo-main']['tmp_name'];

        $acceptedMimeTypes = [
            'image/png',
            'image/jpeg',
            'image/gif',
        ];
        $mimeType = finfo_file($fileInfo, $fileName);

        if (!in_array($mimeType, $acceptedMimeTypes)) {
            $errors['photo-main']['name'] = $fieldsMap['photo-main'];
            $errors['photo-main']['title'] = 'Не верный формат изображения';
            $errors['photo-main']['description'] = 'Пожалуйста загрузите фотографию в одном из форматов - png, jpeg, gif';
        } else {
            // TODO сохранить загруженный файл в директории /uploads/
        }

    } elseif (isset($formData['photo-url'])) {

        if (empty($formData['photo-url'])) {

            $errors['photo-main']['name'] = $fieldsMap['photo-main'];
            $errors['photo-main']['title'] = 'Заполните одно из полей';
            $errors['photo-main']['description'] = 'Укажите ссылку на источник фотографии или добавьте свое фото';

        } elseif (!filter_var($formData['photo-url'], FILTER_VALIDATE_URL)) {

            $errors['photo-main']['name'] = $fieldsMap['photo-main'];
            $errors['photo-main']['title'] = 'Не корректный URL-адрес';
            $errors['photo-main']['description'] = 'Пожалуйста укажите корректный URL-адрес';

        } elseif (!file_get_contents($formData['photo-url'])) {

            $errors['photo-main']['name'] = $fieldsMap['photo-main'];
            $errors['photo-main']['title'] = 'Не удалось получить доступ к изображению';
            $errors['photo-main']['description'] = 'Пожалуйста проверьте корректен ли адрес';
        }
    }

    if ($postType === 'link' || $postType === 'video') {
        if (!empty($formData["{$postType}-main"]
            && !filter_var($formData["{$postType}-main"], FILTER_VALIDATE_URL))) {

            $errors["{$postType}-main"]['name'] = $fieldsMap["{$postType}-main"];
            $errors["{$postType}-main"]['title'] = 'Не корректный URL-адрес';
            $errors["{$postType}-main"]['description'] = 'Пожалуйста укажите корректный URL-адрес';
        } elseif ($postType === 'video' && !checkYoutubeUrl($formData["{$postType}-main"])) {

            $errors["{$postType}-main"]['name'] = $fieldsMap["{$postType}-main"];
            $errors["{$postType}-main"]['title'] = 'По указанному адресу не найдено видео на Youtube';
            $errors["{$postType}-main"]['description'] = 'Пожалуйста укажите корректный URL-адрес';
        }
    }


    if (empty($errors)) {
        // TODO сформировать sql запрос на добавление нового поста в БД
    }
}


$postTypes = getPostTypes($db);
$multipartTypes = ['photo', 'video'];

$pageMainContent = includeTemplate('add.php', [
    'postTypes' => $postTypes,
    'multipartTypes' => $multipartTypes,
    'errors' => $errors,
]);

$pageLayout = includeTemplate('layout.php', [
    'pageTitle' => 'Readme - Добавить пост',
    'isAuth' => $isAuth,
    'userName' => $userName,
    'pageMainContent' => $pageMainContent,
    'pageMainClass' => 'adding-post',
]);

print($pageLayout);
